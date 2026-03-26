<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Form_Handler {

    private static $instance = null;
    const MAX_FILE_SIZE = 10485760; // 10 MB

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'wp_ajax_jam_submit_application',        [ $this, 'handle_submission' ] );
        add_action( 'wp_ajax_nopriv_jam_submit_application', [ $this, 'handle_submission' ] );
    }

    // ── Main handler ──────────────────────────────────────────────────────────
    public function handle_submission() {

        // 1. Nonce
        if ( ! isset( $_POST['jam_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['jam_nonce'] ) ), 'jam_form_nonce' ) ) {
            wp_send_json_error( [ 'message' => __( 'Security check failed. Please refresh and try again.', 'jam' ) ] );
        }

        // 2. Honeypot
        if ( ! empty( $_POST['jam_honeypot'] ) ) {
            wp_send_json_error( [ 'message' => __( 'Spam detected.', 'jam' ) ] );
        }

        // 3. reCAPTCHA
        if ( JAM_Settings::recaptcha_is_active() ) {
            $rc = $this->verify_recaptcha();
            if ( is_wp_error( $rc ) ) {
                wp_send_json_error( [ 'message' => $rc->get_error_message() ] );
            }
        }

        // 4. Consent
        if ( empty( $_POST['jam_consent'] ) || '1' !== $_POST['jam_consent'] ) {
            wp_send_json_error( [ 'message' => __( 'You must agree to the privacy & consent statement.', 'jam' ), 'fields' => [ 'jam_consent' ] ] );
        }

        // 5. Determine application type from submitted position
        $position = isset( $_POST['jam_job_listing'] ) ? sanitize_text_field( wp_unslash( $_POST['jam_job_listing'] ) ) : '';
        $app_type = JAM_Post_Type::get_application_type_for_position( $position );

        // 6. Collect, validate, upload, save — branched by type
        if ( 'intern' === $app_type ) {
            $this->process_intern( $position );
        } else {
            $this->process_standard( $position );
        }
    }

    // ════════════════════════════════════════════════════════════════════════
    // STANDARD APPLICATION
    // ════════════════════════════════════════════════════════════════════════
    private function process_standard( $position ) {

        $data   = $this->collect_standard_fields( $position );
        $errors = $this->validate_standard( $data );

        if ( ! empty( $errors ) ) {
            wp_send_json_error( [ 'message' => implode( '<br>', $errors ), 'fields' => array_keys( $errors ) ] );
        }

        // Pass whether regulatory uploads are required to the upload handler
        $needs_regulatory = JAM_Settings::position_requires_regulatory( $position );
        $uploads = $this->handle_standard_uploads( $needs_regulatory );
        if ( is_wp_error( $uploads ) ) {
            wp_send_json_error( [ 'message' => $uploads->get_error_message() ] );
        }

        $post_id = $this->save_standard( $data, $uploads );
        if ( is_wp_error( $post_id ) ) {
            wp_send_json_error( [ 'message' => __( 'Failed to save application. Please try again.', 'jam' ) ] );
        }

        $this->attach_standard_files( $post_id, $uploads );
        JAM_Email::send_admin_notification( $post_id, $data, $uploads );
        JAM_Email::send_applicant_confirmation( $post_id, $data );

        wp_send_json_success( [ 'message' => __( 'Your application has been submitted successfully! You will receive a confirmation email shortly.', 'jam' ) ] );
    }

    private function collect_standard_fields( $position ) {
        $p = $_POST; // phpcs:ignore
        return [
            'application_type'    => 'standard',
            'job_listing'         => $position,
            'full_names'          => isset( $p['jam_full_names'] )          ? sanitize_text_field( wp_unslash( $p['jam_full_names'] ) ) : '',
            'phone'               => isset( $p['jam_phone'] )               ? sanitize_text_field( wp_unslash( $p['jam_phone'] ) ) : '',
            'email'               => isset( $p['jam_email'] )               ? sanitize_email( wp_unslash( $p['jam_email'] ) ) : '',
            'national_id'         => isset( $p['jam_national_id'] )         ? sanitize_text_field( wp_unslash( $p['jam_national_id'] ) ) : '',
            'education_level'     => isset( $p['jam_education_level'] )     ? sanitize_text_field( wp_unslash( $p['jam_education_level'] ) ) : '',
            'regulatory_body'     => isset( $p['jam_regulatory_body'] )     ? sanitize_text_field( wp_unslash( $p['jam_regulatory_body'] ) ) : '',
            'reg_number'          => isset( $p['jam_reg_number'] )          ? sanitize_text_field( wp_unslash( $p['jam_reg_number'] ) ) : '',
            'license_number'      => isset( $p['jam_license_number'] )      ? sanitize_text_field( wp_unslash( $p['jam_license_number'] ) ) : '',
            'physical_address'    => isset( $p['jam_physical_address'] )    ? sanitize_textarea_field( wp_unslash( $p['jam_physical_address'] ) ) : '',
            'department'          => isset( $p['jam_department'] )          ? sanitize_text_field( wp_unslash( $p['jam_department'] ) ) : '',
            'prof_qualifications' => isset( $p['jam_prof_qualifications'] ) ? sanitize_textarea_field( wp_unslash( $p['jam_prof_qualifications'] ) ) : '',
            'years_experience'    => isset( $p['jam_years_experience'] )    ? sanitize_text_field( wp_unslash( $p['jam_years_experience'] ) ) : '',
            'cover_letter'        => isset( $p['jam_cover_letter'] )        ? sanitize_textarea_field( wp_unslash( $p['jam_cover_letter'] ) ) : '',
            'availability_date'   => isset( $p['jam_availability_date'] )   ? sanitize_text_field( wp_unslash( $p['jam_availability_date'] ) ) : '',
        ];
    }

    private function validate_standard( $data ) {
        $errors = [];

        // Position
        $allowed = JAM_Settings::get_positions();
        if ( empty( $data['job_listing'] ) ) {
            $errors['jam_job_listing'] = __( 'Please select a position.', 'jam' );
        } elseif ( ! empty( $allowed ) && ! in_array( $data['job_listing'], $allowed, true ) ) {
            $errors['jam_job_listing'] = __( 'Please select a valid position.', 'jam' );
        }

        if ( empty( $data['full_names'] ) )    $errors['jam_full_names']      = __( 'Full Names are required.', 'jam' );
        if ( empty( $data['phone'] ) )          $errors['jam_phone']           = __( 'Phone Number is required.', 'jam' );
        if ( empty( $data['email'] ) || ! is_email( $data['email'] ) ) {
            $errors['jam_email'] = __( 'A valid Email Address is required.', 'jam' );
        }
        if ( empty( $data['education_level'] ) ) $errors['jam_education_level'] = __( 'Highest Level of Education is required.', 'jam' );

        // Only validate regulatory fields when this position requires them
        $needs_regulatory = JAM_Settings::position_requires_regulatory( $data['job_listing'] );
        if ( $needs_regulatory ) {
            $allowed_bodies = JAM_Post_Type::get_regulatory_bodies();
            if ( empty( $data['regulatory_body'] ) || ! in_array( $data['regulatory_body'], $allowed_bodies, true ) ) {
                $errors['jam_regulatory_body'] = __( 'Please select a valid Regulatory Body.', 'jam' );
            }
            if ( empty( $data['reg_number'] ) )     $errors['jam_reg_number']     = __( 'Registration Number is required.', 'jam' );
            if ( empty( $data['license_number'] ) ) $errors['jam_license_number'] = __( 'License/Practice Number is required.', 'jam' );
        }

        if ( JAM_Settings::field_is_enabled( 'national_id' ) && empty( $data['national_id'] ) ) {
            $errors['jam_national_id'] = __( 'National ID / Passport Number is required.', 'jam' );
        }

        return $errors;
    }

    private function handle_standard_uploads( $needs_regulatory = true ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $results = [];

        // ID document — always required for standard applicants
        if ( empty( $_FILES['jam_id_doc']['name'] ) ) {
            return new WP_Error( 'missing_file', __( 'ID/Passport Document is required.', 'jam' ) );
        }
        $id_doc = $this->upload_single_file( 'jam_id_doc', 'ID/Passport Document' );
        if ( is_wp_error( $id_doc ) ) return $id_doc;
        $results['jam_id_doc'] = $id_doc;

        // Regulatory files — only required when position needs them
        if ( $needs_regulatory ) {
            foreach ( [ 'jam_reg_cert' => 'Registration Certificate', 'jam_license_cert' => 'License Certificate' ] as $field => $label ) {
                if ( empty( $_FILES[ $field ]['name'] ) ) {
                    return new WP_Error( 'missing_file', sprintf( __( '%s is required.', 'jam' ), $label ) );
                }
                $r = $this->upload_single_file( $field, $label );
                if ( is_wp_error( $r ) ) return $r;
                $results[ $field ] = $r;
            }
        }

        // Academic certificates — always required
        if ( empty( $_FILES['jam_certificates']['name'][0] ) ) {
            return new WP_Error( 'missing_file', __( 'At least one Academic Certificate is required.', 'jam' ) );
        }
        $certs = $this->upload_multiple_files( 'jam_certificates', 'Academic Certificate', 5 );
        if ( is_wp_error( $certs ) ) return $certs;
        $results['jam_certificates'] = $certs;

        // Optional additional docs
        if ( JAM_Settings::field_is_enabled( 'additional_docs' ) && ! empty( $_FILES['jam_additional_docs']['name'][0] ) ) {
            $add = $this->upload_multiple_files( 'jam_additional_docs', 'Additional Document', 5 );
            if ( ! is_wp_error( $add ) ) $results['jam_additional_docs'] = $add;
        }

        return $results;
    }

    private function save_standard( $data, $uploads ) {
        $post_id = wp_insert_post( [
            'post_title'  => sanitize_text_field( $data['full_names'] ) . ' — ' . current_time( 'mysql' ),
            'post_type'   => 'job_application',
            'post_status' => 'publish',
        ], true );

        if ( is_wp_error( $post_id ) ) return $post_id;

        $meta = [
            '_jam_application_type' => 'standard',
            '_jam_job_listing'      => $data['job_listing'],
            '_jam_full_names'       => $data['full_names'],
            '_jam_phone'            => $data['phone'],
            '_jam_email'            => $data['email'],
            '_jam_national_id'      => $data['national_id'],
            '_jam_education_level'  => $data['education_level'],
            '_jam_regulatory_body'  => $data['regulatory_body'],
            '_jam_reg_number'       => $data['reg_number'],
            '_jam_license_number'   => $data['license_number'],
            '_jam_physical_address' => $data['physical_address'],
            '_jam_department'       => $data['department'],
            '_jam_prof_qualifications' => $data['prof_qualifications'],
            '_jam_years_experience' => $data['years_experience'],
            '_jam_cover_letter'     => $data['cover_letter'],
            '_jam_availability_date'=> $data['availability_date'],
            '_jam_status'           => 'pending',
            '_jam_submitted_date'   => current_time( 'mysql' ),
        ];

        foreach ( $meta as $key => $value ) {
            update_post_meta( $post_id, $key, $value );
        }

        return $post_id;
    }

    private function attach_standard_files( $post_id, $uploads ) {
        $map = [
            'jam_id_doc'       => '_jam_id_doc_id',
            'jam_reg_cert'     => '_jam_reg_cert_id',
            'jam_license_cert' => '_jam_license_cert_id',
        ];
        foreach ( $map as $uk => $mk ) {
            if ( ! empty( $uploads[ $uk ] ) ) {
                update_post_meta( $post_id, $mk, $this->create_attachment( $uploads[ $uk ], $post_id ) );
            }
        }
        if ( ! empty( $uploads['jam_certificates'] ) ) {
            $ids = [];
            foreach ( $uploads['jam_certificates'] as $c ) { $ids[] = $this->create_attachment( $c, $post_id ); }
            update_post_meta( $post_id, '_jam_certificates_ids', wp_json_encode( $ids ) );
        }
        if ( ! empty( $uploads['jam_additional_docs'] ) ) {
            $ids = [];
            foreach ( $uploads['jam_additional_docs'] as $d ) { $ids[] = $this->create_attachment( $d, $post_id ); }
            update_post_meta( $post_id, '_jam_additional_docs_ids', wp_json_encode( $ids ) );
        }
    }

    // ════════════════════════════════════════════════════════════════════════
    // INTERN / ATTACHÉ APPLICATION
    // ════════════════════════════════════════════════════════════════════════
    private function process_intern( $position ) {

        $data   = $this->collect_intern_fields( $position );
        $errors = $this->validate_intern( $data );

        if ( ! empty( $errors ) ) {
            wp_send_json_error( [ 'message' => implode( '<br>', $errors ), 'fields' => array_keys( $errors ) ] );
        }

        $uploads = $this->handle_intern_uploads();
        if ( is_wp_error( $uploads ) ) {
            wp_send_json_error( [ 'message' => $uploads->get_error_message() ] );
        }

        $post_id = $this->save_intern( $data, $uploads );
        if ( is_wp_error( $post_id ) ) {
            wp_send_json_error( [ 'message' => __( 'Failed to save application. Please try again.', 'jam' ) ] );
        }

        $this->attach_intern_files( $post_id, $uploads );
        JAM_Email::send_admin_notification( $post_id, $data, $uploads );
        JAM_Email::send_applicant_confirmation( $post_id, $data );

        wp_send_json_success( [ 'message' => __( 'Your internship/attachment application has been submitted successfully! You will receive a confirmation email shortly.', 'jam' ) ] );
    }

    private function collect_intern_fields( $position ) {
        $p = $_POST; // phpcs:ignore
        return [
            'application_type'      => 'intern',
            'job_listing'           => $position,
            'full_names'            => isset( $p['jam_full_names'] )            ? sanitize_text_field( wp_unslash( $p['jam_full_names'] ) ) : '',
            'phone'                 => isset( $p['jam_phone'] )                 ? sanitize_text_field( wp_unslash( $p['jam_phone'] ) ) : '',
            'email'                 => isset( $p['jam_email'] )                 ? sanitize_email( wp_unslash( $p['jam_email'] ) ) : '',
            'national_id'           => isset( $p['jam_national_id'] )           ? sanitize_text_field( wp_unslash( $p['jam_national_id'] ) ) : '',
            'intern_type'           => isset( $p['jam_intern_type'] )           ? sanitize_text_field( wp_unslash( $p['jam_intern_type'] ) ) : '',
            'institution_name'      => isset( $p['jam_institution_name'] )      ? sanitize_text_field( wp_unslash( $p['jam_institution_name'] ) ) : '',
            'course_program'        => isset( $p['jam_course_program'] )        ? sanitize_text_field( wp_unslash( $p['jam_course_program'] ) ) : '',
            'year_of_study'         => isset( $p['jam_year_of_study'] )         ? sanitize_text_field( wp_unslash( $p['jam_year_of_study'] ) ) : '',
            'student_id'            => isset( $p['jam_student_id'] )            ? sanitize_text_field( wp_unslash( $p['jam_student_id'] ) ) : '',
            'intern_department'     => isset( $p['jam_intern_department'] )     ? sanitize_text_field( wp_unslash( $p['jam_intern_department'] ) ) : '',
            'preferred_start_date'  => isset( $p['jam_preferred_start_date'] )  ? sanitize_text_field( wp_unslash( $p['jam_preferred_start_date'] ) ) : '',
            'attachment_duration'   => isset( $p['jam_attachment_duration'] )   ? sanitize_text_field( wp_unslash( $p['jam_attachment_duration'] ) ) : '',
            'motivation'            => isset( $p['jam_motivation'] )            ? sanitize_textarea_field( wp_unslash( $p['jam_motivation'] ) ) : '',
            'relevant_skills'       => isset( $p['jam_relevant_skills'] )       ? sanitize_textarea_field( wp_unslash( $p['jam_relevant_skills'] ) ) : '',
        ];
    }

    private function validate_intern( $data ) {
        $errors = [];

        if ( empty( $data['full_names'] ) )           $errors['jam_full_names']           = __( 'Full Name is required.', 'jam' );
        if ( empty( $data['phone'] ) )                 $errors['jam_phone']                = __( 'Phone Number is required.', 'jam' );
        if ( empty( $data['email'] ) || ! is_email( $data['email'] ) ) {
            $errors['jam_email'] = __( 'A valid Email Address is required.', 'jam' );
        }
        if ( empty( $data['national_id'] ) )           $errors['jam_national_id']          = __( 'ID / Passport Number is required.', 'jam' );
        if ( empty( $data['intern_type'] ) )           $errors['jam_intern_type']          = __( 'Please select Intern or Attaché.', 'jam' );
        if ( empty( $data['institution_name'] ) )      $errors['jam_institution_name']     = __( 'Institution Name is required.', 'jam' );
        if ( empty( $data['course_program'] ) )        $errors['jam_course_program']       = __( 'Course / Program is required.', 'jam' );
        if ( empty( $data['year_of_study'] ) )         $errors['jam_year_of_study']        = __( 'Year of Study is required.', 'jam' );
        if ( empty( $data['student_id'] ) )            $errors['jam_student_id']           = __( 'Student ID Number is required.', 'jam' );
        if ( empty( $data['intern_department'] ) )     $errors['jam_intern_department']    = __( 'Department of Interest is required.', 'jam' );
        if ( empty( $data['preferred_start_date'] ) )  $errors['jam_preferred_start_date'] = __( 'Preferred Start Date is required.', 'jam' );
        if ( empty( $data['attachment_duration'] ) )   $errors['jam_attachment_duration']  = __( 'Duration of Attachment is required.', 'jam' );
        if ( empty( $data['motivation'] ) )            $errors['jam_motivation']           = __( 'Please tell us why you want to join Webuye West Hospital.', 'jam' );

        return $errors;
    }

    private function handle_intern_uploads() {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $results = [];

        // CV / Resume — required
        if ( empty( $_FILES['jam_cv']['name'] ) ) {
            return new WP_Error( 'missing_file', __( 'CV / Resume is required.', 'jam' ) );
        }
        $cv = $this->upload_single_file( 'jam_cv', 'CV / Resume' );
        if ( is_wp_error( $cv ) ) return $cv;
        $results['jam_cv'] = $cv;

        // Introduction Letter — required
        if ( empty( $_FILES['jam_intro_letter']['name'] ) ) {
            return new WP_Error( 'missing_file', __( 'Introduction Letter from School is required.', 'jam' ) );
        }
        $letter = $this->upload_single_file( 'jam_intro_letter', 'Introduction Letter' );
        if ( is_wp_error( $letter ) ) return $letter;
        $results['jam_intro_letter'] = $letter;

        // Academic Transcript — optional
        if ( ! empty( $_FILES['jam_transcript']['name'] ) ) {
            $tr = $this->upload_single_file( 'jam_transcript', 'Academic Transcript' );
            if ( ! is_wp_error( $tr ) ) $results['jam_transcript'] = $tr;
        }

        return $results;
    }

    private function save_intern( $data, $uploads ) {
        $post_id = wp_insert_post( [
            'post_title'  => sanitize_text_field( $data['full_names'] ) . ' (Intern) — ' . current_time( 'mysql' ),
            'post_type'   => 'job_application',
            'post_status' => 'publish',
        ], true );

        if ( is_wp_error( $post_id ) ) return $post_id;

        $meta = [
            '_jam_application_type'     => 'intern',
            '_jam_job_listing'          => $data['job_listing'],
            '_jam_full_names'           => $data['full_names'],
            '_jam_phone'                => $data['phone'],
            '_jam_email'                => $data['email'],
            '_jam_national_id'          => $data['national_id'],
            '_jam_intern_type'          => $data['intern_type'],
            '_jam_institution_name'     => $data['institution_name'],
            '_jam_course_program'       => $data['course_program'],
            '_jam_year_of_study'        => $data['year_of_study'],
            '_jam_student_id'           => $data['student_id'],
            '_jam_intern_department'    => $data['intern_department'],
            '_jam_preferred_start_date' => $data['preferred_start_date'],
            '_jam_attachment_duration'  => $data['attachment_duration'],
            '_jam_motivation'           => $data['motivation'],
            '_jam_relevant_skills'      => $data['relevant_skills'],
            '_jam_status'               => 'pending',
            '_jam_submitted_date'       => current_time( 'mysql' ),
        ];

        foreach ( $meta as $key => $value ) {
            update_post_meta( $post_id, $key, $value );
        }

        return $post_id;
    }

    private function attach_intern_files( $post_id, $uploads ) {
        $map = [
            'jam_cv'           => '_jam_cv_id',
            'jam_intro_letter' => '_jam_intro_letter_id',
            'jam_transcript'   => '_jam_transcript_id',
        ];
        foreach ( $map as $uk => $mk ) {
            if ( ! empty( $uploads[ $uk ] ) ) {
                update_post_meta( $post_id, $mk, $this->create_attachment( $uploads[ $uk ], $post_id ) );
            }
        }
    }

    // ════════════════════════════════════════════════════════════════════════
    // SHARED UPLOAD HELPERS
    // ════════════════════════════════════════════════════════════════════════
    private function upload_single_file( $field_name, $label ) {
        $file = $_FILES[ $field_name ]; // phpcs:ignore

        if ( $file['error'] !== UPLOAD_ERR_OK ) {
            return new WP_Error( 'upload_error', sprintf( __( 'Upload failed for %s.', 'jam' ), $label ) );
        }
        if ( $file['size'] > self::MAX_FILE_SIZE ) {
            return new WP_Error( 'file_too_large', sprintf( __( '%s exceeds the 10MB size limit.', 'jam' ), $label ) );
        }

        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mime  = finfo_file( $finfo, $file['tmp_name'] );
        finfo_close( $finfo );

        if ( 'application/pdf' !== $mime ) {
            return new WP_Error( 'invalid_type', sprintf( __( '%s must be a PDF file.', 'jam' ), $label ) );
        }
        if ( 'pdf' !== strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) ) {
            return new WP_Error( 'invalid_ext', sprintf( __( '%s must have a .pdf extension.', 'jam' ), $label ) );
        }

        add_filter( 'upload_dir', [ $this, 'custom_upload_dir' ] );
        $upload = wp_handle_upload( $file, [ 'test_form' => false, 'mimes' => [ 'pdf' => 'application/pdf' ] ] );
        remove_filter( 'upload_dir', [ $this, 'custom_upload_dir' ] );

        if ( isset( $upload['error'] ) ) {
            return new WP_Error( 'wp_upload_error', $upload['error'] );
        }

        return $upload;
    }

    private function upload_multiple_files( $field_name, $label, $max = 5 ) {
        $files   = $_FILES[ $field_name ]; // phpcs:ignore
        $results = [];
        $count   = count( $files['name'] );

        if ( $count > $max ) {
            return new WP_Error( 'too_many_files', sprintf( __( 'Maximum %d files allowed for %s.', 'jam' ), $max, $label ) );
        }
        for ( $i = 0; $i < $count; $i++ ) {
            if ( empty( $files['name'][ $i ] ) ) continue;
            $_FILES[ $field_name . '_s' ] = [
                'name' => $files['name'][ $i ], 'type' => $files['type'][ $i ],
                'tmp_name' => $files['tmp_name'][ $i ], 'error' => $files['error'][ $i ], 'size' => $files['size'][ $i ],
            ];
            $r = $this->upload_single_file( $field_name . '_s', $label . ' ' . ( $i + 1 ) );
            unset( $_FILES[ $field_name . '_s' ] );
            if ( is_wp_error( $r ) ) return $r;
            $results[] = $r;
        }
        return $results;
    }

    public function custom_upload_dir( $dirs ) {
        $dirs['subdir'] = '/job-applications';
        $dirs['path']   = $dirs['basedir'] . '/job-applications';
        $dirs['url']    = $dirs['baseurl'] . '/job-applications';
        return $dirs;
    }

    private function create_attachment( $upload_data, $post_id ) {
        $id = wp_insert_attachment( [
            'post_mime_type' => 'application/pdf',
            'post_title'     => sanitize_file_name( basename( $upload_data['file'] ) ),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'post_parent'    => $post_id,
        ], $upload_data['file'], $post_id );
        wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload_data['file'] ) );
        return $id;
    }

    // reCAPTCHA
    private function verify_recaptcha() {
        $token = isset( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';
        if ( empty( $token ) ) {
            return new WP_Error( 'recaptcha_missing', __( 'Please complete the reCAPTCHA verification.', 'jam' ) );
        }
        $response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', [
            'timeout' => 10,
            'body'    => [
                'secret'   => JAM_Settings::get_recaptcha_secret_key(),
                'response' => $token,
                'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
            ],
        ] );
        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'recaptcha_error', __( 'reCAPTCHA verification failed. Please try again.', 'jam' ) );
        }
        $result = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( empty( $result['success'] ) ) {
            return new WP_Error( 'recaptcha_failed', __( 'reCAPTCHA verification failed. Please try again.', 'jam' ) );
        }
        return true;
    }
}
