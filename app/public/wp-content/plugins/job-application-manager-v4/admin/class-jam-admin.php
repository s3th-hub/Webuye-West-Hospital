<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Admin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_enqueue_scripts',                    [ $this, 'enqueue_admin_assets' ] );
        add_filter( 'manage_job_application_posts_columns',     [ $this, 'set_columns' ] );
        add_action( 'manage_job_application_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
        add_filter( 'manage_edit-job_application_sortable_columns', [ $this, 'sortable_columns' ] );
        add_action( 'add_meta_boxes',                           [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post_job_application',                [ $this, 'save_status_meta' ] );
        add_action( 'restrict_manage_posts',                    [ $this, 'add_status_filter' ] );
        add_filter( 'parse_query',                              [ $this, 'filter_by_status' ] );
        add_filter( 'post_row_actions',                         [ $this, 'remove_row_actions' ], 10, 2 );
        add_action( 'admin_notices',                            [ $this, 'export_button_notice' ] );
        add_filter( 'enter_title_here',                         [ $this, 'change_title_placeholder' ] );
    }

    public function enqueue_admin_assets( $hook ) {
        $screen = get_current_screen();
        if ( ! $screen || 'job_application' !== $screen->post_type ) return;

        wp_enqueue_style(
            'jam-admin',
            JAM_PLUGIN_URL . 'assets/css/admin.css',
            [],
            JAM_VERSION
        );
    }

    public function set_columns( $columns ) {
        return [
            'cb'              => $columns['cb'],
            'title'           => __( 'Applicant', 'jam' ),
            'jam_email'       => __( 'Email', 'jam' ),
            'jam_phone'       => __( 'Phone', 'jam' ),
            'jam_reg_body'    => __( 'Reg. Body / Type', 'jam' ),
            'jam_job'         => __( 'Position', 'jam' ),
            'jam_status'      => __( 'Status', 'jam' ),
            'jam_submitted'   => __( 'Submitted', 'jam' ),
        ];
    }

    public function render_column( $column, $post_id ) {
        switch ( $column ) {
            case 'jam_email':
                $email = get_post_meta( $post_id, '_jam_email', true );
                echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
                break;
            case 'jam_phone':
                echo esc_html( get_post_meta( $post_id, '_jam_phone', true ) );
                break;
            case 'jam_reg_body':
                $app_type = get_post_meta( $post_id, '_jam_application_type', true ) ?: 'standard';
                if ( 'intern' === $app_type ) {
                    $intern_type = get_post_meta( $post_id, '_jam_intern_type', true );
                    echo '<span class="jam-status-badge" style="background:#fef3c7;color:#92400e;">'
                         . esc_html( $intern_type ?: __( 'Intern', 'jam' ) ) . '</span>';
                } else {
                    echo esc_html( get_post_meta( $post_id, '_jam_regulatory_body', true ) ?: '—' );
                }
                break;
            case 'jam_job':
                $job      = get_post_meta( $post_id, '_jam_job_listing', true );
                $app_type = get_post_meta( $post_id, '_jam_application_type', true ) ?: 'standard';
                $label    = $job ?: '—';
                if ( 'intern' === $app_type ) {
                    $label = '<span class="jam-status-badge" style="background:#eef1fb;color:#2e4592;font-size:11px;">📋 Intern</span> ' . esc_html( $job );
                    echo wp_kses_post( $label );
                } else {
                    echo esc_html( $label );
                }
                break;
            case 'jam_status':
                $status   = get_post_meta( $post_id, '_jam_status', true ) ?: 'pending';
                $statuses = JAM_Post_Type::get_statuses();
                $label    = $statuses[ $status ] ?? ucfirst( $status );
                echo '<span class="jam-status-badge jam-status--' . esc_attr( $status ) . '">' . esc_html( $label ) . '</span>';
                break;
            case 'jam_submitted':
                $date = get_post_meta( $post_id, '_jam_submitted_date', true );
                echo esc_html( $date ? date_i18n( get_option( 'date_format' ), strtotime( $date ) ) : get_the_date() );
                break;
        }
    }

    public function sortable_columns( $columns ) {
        $columns['jam_status']    = 'jam_status';
        $columns['jam_submitted'] = 'jam_submitted';
        return $columns;
    }

    public function add_meta_boxes() {
        add_meta_box(
            'jam_application_details',
            __( 'Application Details', 'jam' ),
            [ $this, 'render_details_meta_box' ],
            'job_application',
            'normal',
            'high'
        );
        add_meta_box(
            'jam_application_status',
            __( 'Application Status', 'jam' ),
            [ $this, 'render_status_meta_box' ],
            'job_application',
            'side',
            'high'
        );
        add_meta_box(
            'jam_application_docs',
            __( 'Uploaded Documents', 'jam' ),
            [ $this, 'render_docs_meta_box' ],
            'job_application',
            'normal',
            'low'
        );
    }

    public function render_details_meta_box( $post ) {
        $meta = $this->get_all_meta( $post->ID );
        include JAM_PLUGIN_DIR . 'admin/views/meta-box-details.php';
    }

    public function render_status_meta_box( $post ) {
        $status   = get_post_meta( $post->ID, '_jam_status', true ) ?: 'pending';
        $statuses = JAM_Post_Type::get_statuses();
        $job      = get_post_meta( $post->ID, '_jam_job_listing', true );
        wp_nonce_field( 'jam_save_status', 'jam_status_nonce' );
        include JAM_PLUGIN_DIR . 'admin/views/meta-box-status.php';
    }

    public function render_docs_meta_box( $post ) {
        $id_doc_id    = get_post_meta( $post->ID, '_jam_id_doc_id', true );
        $reg_cert_id  = get_post_meta( $post->ID, '_jam_reg_cert_id', true );
        $lic_cert_id  = get_post_meta( $post->ID, '_jam_license_cert_id', true );
        $cert_ids     = json_decode( get_post_meta( $post->ID, '_jam_certificates_ids', true ), true );
        include JAM_PLUGIN_DIR . 'admin/views/meta-box-docs.php';
    }

    public function save_status_meta( $post_id ) {
        if ( ! isset( $_POST['jam_status_nonce'] ) ) return;
        if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['jam_status_nonce'] ) ), 'jam_save_status' ) ) return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        if ( isset( $_POST['jam_status'] ) ) {
            $allowed = array_keys( JAM_Post_Type::get_statuses() );
            $status  = sanitize_text_field( wp_unslash( $_POST['jam_status'] ) );
            if ( in_array( $status, $allowed, true ) ) {
                update_post_meta( $post_id, '_jam_status', $status );
            }
        }

        if ( isset( $_POST['jam_job_listing'] ) ) {
            update_post_meta( $post_id, '_jam_job_listing', sanitize_text_field( wp_unslash( $_POST['jam_job_listing'] ) ) );
        }
    }

    public function add_status_filter( $post_type ) {
        if ( 'job_application' !== $post_type ) return;

        $current  = isset( $_GET['jam_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['jam_status_filter'] ) ) : '';
        $statuses = JAM_Post_Type::get_statuses();
        echo '<select name="jam_status_filter">';
        echo '<option value="">' . esc_html__( 'All Statuses', 'jam' ) . '</option>';
        foreach ( $statuses as $value => $label ) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr( $value ),
                selected( $current, $value, false ),
                esc_html( $label )
            );
        }
        echo '</select>';
    }

    public function filter_by_status( $query ) {
        global $pagenow;
        if ( ! is_admin() || 'edit.php' !== $pagenow ) return;
        if ( ! isset( $_GET['post_type'] ) || 'job_application' !== $_GET['post_type'] ) return;
        if ( empty( $_GET['jam_status_filter'] ) ) return;

        $status = sanitize_text_field( wp_unslash( $_GET['jam_status_filter'] ) );
        $query->query_vars['meta_key']   = '_jam_status';
        $query->query_vars['meta_value'] = $status;
    }

    public function remove_row_actions( $actions, $post ) {
        if ( 'job_application' === $post->post_type ) {
            unset( $actions['inline hide-if-no-js'] );
        }
        return $actions;
    }

    public function export_button_notice() {
        $screen = get_current_screen();
        if ( ! $screen || 'edit-job_application' !== $screen->id ) return;

        $url = wp_nonce_url( add_query_arg( 'jam_export_csv', '1', admin_url( 'admin.php' ) ), 'jam_export_csv' );
        echo '<div class="jam-admin-toolbar">';
        echo '<a href="' . esc_url( $url ) . '" class="button button-secondary jam-export-btn">';
        echo '<span class="dashicons dashicons-download"></span> ';
        esc_html_e( 'Export as CSV', 'jam' );
        echo '</a></div>';
    }

    public function change_title_placeholder( $input ) {
        $screen = get_current_screen();
        if ( $screen && 'job_application' === $screen->post_type ) {
            return __( 'Applicant Name', 'jam' );
        }
        return $input;
    }

    private function get_all_meta( $post_id ) {
        $keys = [
            '_jam_full_names', '_jam_phone', '_jam_email', '_jam_national_id',
            '_jam_education_level', '_jam_regulatory_body', '_jam_reg_number',
            '_jam_license_number', '_jam_status', '_jam_job_listing', '_jam_submitted_date',
        ];
        $meta = [];
        foreach ( $keys as $key ) {
            $meta[ $key ] = get_post_meta( $post_id, $key, true );
        }
        return $meta;
    }
}
