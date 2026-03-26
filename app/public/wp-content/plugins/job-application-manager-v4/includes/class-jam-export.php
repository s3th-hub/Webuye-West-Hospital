<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Export {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_init', [ $this, 'maybe_export' ] );
    }

    public function maybe_export() {
        if ( ! isset( $_GET['jam_export_csv'] ) ) return;
        if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'Unauthorized', 'jam' ) );
        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'jam_export_csv' ) ) {
            wp_die( esc_html__( 'Security check failed.', 'jam' ) );
        }
        $this->output_csv();
    }

    private function output_csv() {
        $filename = 'job-applications-' . gmdate( 'Y-m-d' ) . '.csv';

        nocache_headers();
        header( 'Content-Type: text/csv; charset=UTF-8' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Pragma: no-cache' );
        header( 'Expires: 0' );

        $output = fopen( 'php://output', 'w' );

        // UTF-8 BOM for Excel
        fwrite( $output, "\xEF\xBB\xBF" );

        // Header row covers all fields — blanks for non-applicable columns
        fputcsv( $output, [
            'ID', 'Date Submitted', 'Application Type', 'Status', 'Position',
            // Shared personal
            'Full Names', 'Phone', 'Email', 'National ID / Passport',
            // Standard only
            'Education Level', 'Regulatory Body', 'Reg. Number', 'License Number',
            'Physical Address', 'Department', 'Professional Qualifications',
            'Years Experience', 'Availability Date',
            // Intern only
            'Intern / Attaché Type', 'Institution Name', 'Course / Program',
            'Year of Study', 'Student ID', 'Department of Interest',
            'Preferred Start Date', 'Attachment Duration',
            'Why Webuye West Hospital?', 'Relevant Skills',
            // Document URLs
            'ID Doc URL', 'Reg. Cert URL', 'License Cert URL', 'Certificate URLs',
            'CV URL', 'Intro Letter URL', 'Transcript URL',
        ] );

        $applications = get_posts( [
            'post_type'      => 'job_application',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );

        foreach ( $applications as $post ) {
            $id       = $post->ID;
            $app_type = get_post_meta( $id, '_jam_application_type', true ) ?: 'standard';

            // Cert URLs
            $cert_ids  = json_decode( get_post_meta( $id, '_jam_certificates_ids', true ), true );
            $cert_urls = [];
            if ( is_array( $cert_ids ) ) {
                foreach ( $cert_ids as $cid ) {
                    $u = wp_get_attachment_url( $cid );
                    if ( $u ) $cert_urls[] = $u;
                }
            }

            fputcsv( $output, [
                $id,
                get_post_meta( $id, '_jam_submitted_date', true ),
                $app_type,
                get_post_meta( $id, '_jam_status', true ),
                get_post_meta( $id, '_jam_job_listing', true ),
                // Shared personal
                get_post_meta( $id, '_jam_full_names', true ),
                get_post_meta( $id, '_jam_phone', true ),
                get_post_meta( $id, '_jam_email', true ),
                get_post_meta( $id, '_jam_national_id', true ),
                // Standard
                get_post_meta( $id, '_jam_education_level', true ),
                get_post_meta( $id, '_jam_regulatory_body', true ),
                get_post_meta( $id, '_jam_reg_number', true ),
                get_post_meta( $id, '_jam_license_number', true ),
                get_post_meta( $id, '_jam_physical_address', true ),
                get_post_meta( $id, '_jam_department', true ),
                get_post_meta( $id, '_jam_prof_qualifications', true ),
                get_post_meta( $id, '_jam_years_experience', true ),
                get_post_meta( $id, '_jam_availability_date', true ),
                // Intern
                get_post_meta( $id, '_jam_intern_type', true ),
                get_post_meta( $id, '_jam_institution_name', true ),
                get_post_meta( $id, '_jam_course_program', true ),
                get_post_meta( $id, '_jam_year_of_study', true ),
                get_post_meta( $id, '_jam_student_id', true ),
                get_post_meta( $id, '_jam_intern_department', true ),
                get_post_meta( $id, '_jam_preferred_start_date', true ),
                get_post_meta( $id, '_jam_attachment_duration', true ),
                get_post_meta( $id, '_jam_motivation', true ),
                get_post_meta( $id, '_jam_relevant_skills', true ),
                // Document URLs
                wp_get_attachment_url( get_post_meta( $id, '_jam_id_doc_id', true ) ),
                wp_get_attachment_url( get_post_meta( $id, '_jam_reg_cert_id', true ) ),
                wp_get_attachment_url( get_post_meta( $id, '_jam_license_cert_id', true ) ),
                implode( ' | ', $cert_urls ),
                wp_get_attachment_url( get_post_meta( $id, '_jam_cv_id', true ) ),
                wp_get_attachment_url( get_post_meta( $id, '_jam_intro_letter_id', true ) ),
                wp_get_attachment_url( get_post_meta( $id, '_jam_transcript_id', true ) ),
            ] );
        }

        fclose( $output );
        exit;
    }
}
