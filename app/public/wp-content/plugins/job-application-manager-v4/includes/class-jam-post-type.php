<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Post_Type {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', [ __CLASS__, 'register_post_type' ] );
        add_action( 'init', [ $this, 'register_meta_fields' ] );
    }

    public static function register_post_type() {
        $labels = [
            'name'               => __( 'Job Applications', 'jam' ),
            'singular_name'      => __( 'Job Application', 'jam' ),
            'menu_name'          => __( 'Job Applications', 'jam' ),
            'add_new'            => __( 'Add New', 'jam' ),
            'add_new_item'       => __( 'Add New Application', 'jam' ),
            'edit_item'          => __( 'Edit Application', 'jam' ),
            'new_item'           => __( 'New Application', 'jam' ),
            'view_item'          => __( 'View Application', 'jam' ),
            'search_items'       => __( 'Search Applications', 'jam' ),
            'not_found'          => __( 'No applications found', 'jam' ),
            'not_found_in_trash' => __( 'No applications found in Trash', 'jam' ),
        ];

        register_post_type( 'job_application', [
            'labels'          => $labels,
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => true,
            'menu_position'   => 30,
            'menu_icon'       => 'dashicons-id-alt',
            'capability_type' => 'post',
            'hierarchical'    => false,
            'supports'        => [ 'title', 'custom-fields' ],
            'has_archive'     => false,
            'rewrite'         => false,
            'query_var'       => false,
            'show_in_rest'    => false,
        ] );
    }

    public function register_meta_fields() {
        foreach ( self::get_meta_fields() as $key => $args ) {
            register_post_meta( 'job_application', $key, $args );
        }
    }

    public static function get_meta_fields() {
        return [
            // ── Shared ────────────────────────────────────────────────────
            '_jam_application_type'      => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ], // 'standard' | 'intern'
            '_jam_full_names'            => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_phone'                 => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_email'                 => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_email' ],
            '_jam_national_id'           => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_id_doc_id'             => [ 'type' => 'integer', 'single' => true, 'sanitize_callback' => 'absint' ],
            '_jam_status'                => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_job_listing'           => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_submitted_date'        => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            // ── Standard applicant ────────────────────────────────────────
            '_jam_education_level'       => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_certificates_ids'      => [ 'type' => 'string',  'single' => true ],
            '_jam_regulatory_body'       => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_reg_number'            => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_reg_cert_id'           => [ 'type' => 'integer', 'single' => true, 'sanitize_callback' => 'absint' ],
            '_jam_license_number'        => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_license_cert_id'       => [ 'type' => 'integer', 'single' => true, 'sanitize_callback' => 'absint' ],
            // optional standard fields
            '_jam_physical_address'      => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_textarea_field' ],
            '_jam_department'            => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_prof_qualifications'   => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_textarea_field' ],
            '_jam_years_experience'      => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_cover_letter'          => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_textarea_field' ],
            '_jam_availability_date'     => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_additional_docs_ids'   => [ 'type' => 'string',  'single' => true ],
            // ── Intern / Attaché ──────────────────────────────────────────
            '_jam_intern_type'           => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ], // 'Intern' | 'Attaché'
            '_jam_institution_name'      => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_course_program'        => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_year_of_study'         => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_student_id'            => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_intern_department'     => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_preferred_start_date'  => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_attachment_duration'   => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field' ],
            '_jam_motivation'            => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_textarea_field' ],
            '_jam_relevant_skills'       => [ 'type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_textarea_field' ],
            '_jam_cv_id'                 => [ 'type' => 'integer', 'single' => true, 'sanitize_callback' => 'absint' ],
            '_jam_intro_letter_id'       => [ 'type' => 'integer', 'single' => true, 'sanitize_callback' => 'absint' ],
            '_jam_transcript_id'         => [ 'type' => 'integer', 'single' => true, 'sanitize_callback' => 'absint' ],
        ];
    }

    public static function get_statuses() {
        return [
            'pending'  => __( 'Pending', 'jam' ),
            'reviewed' => __( 'Reviewed', 'jam' ),
            'accepted' => __( 'Accepted', 'jam' ),
            'rejected' => __( 'Rejected', 'jam' ),
        ];
    }

    public static function get_regulatory_bodies() {
        return [ 'NCK', 'COC', 'KMLTTB', 'PPB', 'KASNEB', 'HRIMB' ];
    }

    /**
     * Returns 'intern' if the position name is tagged as intern/attachment
     * in plugin settings, otherwise 'standard'.
     */
    public static function get_application_type_for_position( $position ) {
        $intern_positions = JAM_Settings::get_intern_positions();
        foreach ( $intern_positions as $p ) {
            if ( strtolower( trim( $p ) ) === strtolower( trim( $position ) ) ) {
                return 'intern';
            }
        }
        return 'standard';
    }
}
