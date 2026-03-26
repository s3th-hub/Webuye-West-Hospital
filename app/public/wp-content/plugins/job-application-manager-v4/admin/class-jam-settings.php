<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * JAM_Settings
 * Manages: Email · reCAPTCHA · Positions · Intern Positions · Departments · Optional fields
 */
class JAM_Settings {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_menu',            [ $this, 'add_settings_page' ] );
        add_action( 'admin_init',            [ $this, 'register_settings' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_settings_assets' ] );
    }

    // ── Menu ──────────────────────────────────────────────────────────────────
    public function add_settings_page() {
        add_submenu_page(
            'edit.php?post_type=job_application',
            __( 'JAM Settings', 'jam' ),
            __( 'Settings', 'jam' ),
            'manage_options',
            'jam-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function enqueue_settings_assets( $hook ) {
        if ( 'job_application_page_jam-settings' !== $hook ) return;
        wp_enqueue_style( 'jam-admin', JAM_PLUGIN_URL . 'assets/css/admin.css', [], JAM_VERSION );
    }

    // ── Register ──────────────────────────────────────────────────────────────
    public function register_settings() {
        register_setting( 'jam_settings_group', 'jam_settings', [
            'sanitize_callback' => [ $this, 'sanitize_settings' ],
        ] );
    }

    // ── Sanitize ──────────────────────────────────────────────────────────────
    public function sanitize_settings( $input ) {
        $out = [];

        // Email
        $out['admin_email']     = isset( $input['admin_email'] )     ? sanitize_email( $input['admin_email'] ) : '';
        $out['admin_subject']   = isset( $input['admin_subject'] )   ? sanitize_text_field( $input['admin_subject'] ) : '';
        $out['confirm_subject'] = isset( $input['confirm_subject'] ) ? sanitize_text_field( $input['confirm_subject'] ) : '';

        // reCAPTCHA
        $out['recaptcha_enabled']     = ! empty( $input['recaptcha_enabled'] ) ? '1' : '0';
        $out['recaptcha_site_key']    = isset( $input['recaptcha_site_key'] )    ? sanitize_text_field( $input['recaptcha_site_key'] ) : '';
        $out['recaptcha_secret_key']  = isset( $input['recaptcha_secret_key'] )  ? sanitize_text_field( $input['recaptcha_secret_key'] ) : '';

        // Positions (all positions)
        $out['positions'] = self::sanitize_textarea_lines( $input['positions'] ?? '' );

        // Intern positions — positions that trigger the intern form
        $out['intern_positions'] = self::sanitize_textarea_lines( $input['intern_positions'] ?? '' );

        // Non-regulatory positions — positions that hide the regulatory section
        $out['non_regulatory_positions'] = self::sanitize_textarea_lines( $input['non_regulatory_positions'] ?? '' );

        // Departments
        $out['departments'] = self::sanitize_textarea_lines( $input['departments'] ?? '' );

        // Optional fields
        $all_keys = array_keys( self::get_optional_fields() );
        $enabled  = [];
        foreach ( $all_keys as $key ) {
            if ( ! empty( $input['optional_fields'][ $key ] ) ) {
                $enabled[] = $key;
            }
        }
        $out['optional_fields'] = $enabled;

        return $out;
    }

    private static function sanitize_textarea_lines( $raw ) {
        $lines = array_filter( array_map( 'sanitize_text_field', array_map( 'trim', explode( "\n", $raw ) ) ) );
        return implode( "\n", $lines );
    }

    // ── Render page ───────────────────────────────────────────────────────────
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) return;
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        ?>
        <div class="wrap jam-settings-page">
            <h1><?php esc_html_e( 'Job Application Manager – Settings', 'jam' ); ?></h1>
            <?php settings_errors( 'jam_settings_group' ); ?>

            <form method="post" action="options.php">
                <?php settings_fields( 'jam_settings_group' ); ?>

                <!-- ══ 1. EMAIL ═════════════════════════════════════════════ -->
                <div class="jam-settings-card">
                    <h2 class="jam-settings-section-title">
                        <span class="dashicons dashicons-email-alt"></span>
                        <?php esc_html_e( 'Email Notifications', 'jam' ); ?>
                    </h2>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th><label for="jam_admin_email"><?php esc_html_e( 'Admin Recipient Email', 'jam' ); ?></label></th>
                            <td>
                                <input type="email" id="jam_admin_email" name="jam_settings[admin_email]"
                                       value="<?php echo esc_attr( $s['admin_email'] ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'New application notifications are sent here.', 'jam' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="jam_admin_subject"><?php esc_html_e( 'Admin Email Subject', 'jam' ); ?></label></th>
                            <td><input type="text" id="jam_admin_subject" name="jam_settings[admin_subject]"
                                       value="<?php echo esc_attr( $s['admin_subject'] ); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="jam_confirm_subject"><?php esc_html_e( 'Applicant Confirmation Subject', 'jam' ); ?></label></th>
                            <td><input type="text" id="jam_confirm_subject" name="jam_settings[confirm_subject]"
                                       value="<?php echo esc_attr( $s['confirm_subject'] ); ?>" class="regular-text"></td>
                        </tr>
                    </table>
                </div>

                <!-- ══ 2. RECAPTCHA ══════════════════════════════════════════ -->
                <div class="jam-settings-card">
                    <h2 class="jam-settings-section-title">
                        <span class="dashicons dashicons-shield"></span>
                        <?php esc_html_e( 'Google reCAPTCHA v2', 'jam' ); ?>
                    </h2>
                    <p class="jam-settings-desc">
                        <?php printf(
                            wp_kses( __( 'Get your free keys from the <a href="%s" target="_blank" rel="noopener">Google reCAPTCHA Admin Console</a>. Select <strong>reCAPTCHA v2 → "I\'m not a robot" Checkbox</strong>.', 'jam' ),
                                [ 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ], 'strong' => [] ] ),
                            'https://www.google.com/recaptcha/admin/create'
                        ); ?>
                    </p>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th><?php esc_html_e( 'Enable reCAPTCHA', 'jam' ); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="jam_settings[recaptcha_enabled]" value="1"
                                           <?php checked( $s['recaptcha_enabled'], '1' ); ?>>
                                    <strong><?php esc_html_e( 'Enable reCAPTCHA on the form', 'jam' ); ?></strong>
                                </label>
                                <p class="description"><?php esc_html_e( 'Both keys must be filled in for reCAPTCHA to activate.', 'jam' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="jam_recaptcha_site_key"><?php esc_html_e( 'Site Key', 'jam' ); ?></label></th>
                            <td><input type="text" id="jam_recaptcha_site_key" name="jam_settings[recaptcha_site_key]"
                                       value="<?php echo esc_attr( $s['recaptcha_site_key'] ); ?>"
                                       class="regular-text" placeholder="6LeXXXXXXXXXXXXXXXX"></td>
                        </tr>
                        <tr>
                            <th><label for="jam_recaptcha_secret_key"><?php esc_html_e( 'Secret Key', 'jam' ); ?></label></th>
                            <td>
                                <input type="password" id="jam_recaptcha_secret_key" name="jam_settings[recaptcha_secret_key]"
                                       value="<?php echo esc_attr( $s['recaptcha_secret_key'] ); ?>"
                                       class="regular-text" autocomplete="off" placeholder="6LeXXXXXXXXXXXXXXXX">
                                <p class="description"><?php esc_html_e( 'Never exposed to users. Used for server-side verification only.', 'jam' ); ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php if ( self::recaptcha_is_active() ) : ?>
                        <span class="jam-status-badge jam-status--accepted" style="display:inline-block;margin-top:8px;">✓ <?php esc_html_e( 'reCAPTCHA is active', 'jam' ); ?></span>
                    <?php elseif ( '1' === $s['recaptcha_enabled'] ) : ?>
                        <span class="jam-status-badge jam-status--pending" style="display:inline-block;margin-top:8px;">⚠ <?php esc_html_e( 'Enabled but keys are missing', 'jam' ); ?></span>
                    <?php endif; ?>
                </div>

                <!-- ══ 3. POSITIONS & INTERN POSITIONS ══════════════════════ -->
                <div class="jam-settings-card">
                    <h2 class="jam-settings-section-title">
                        <span class="dashicons dashicons-list-view"></span>
                        <?php esc_html_e( 'Positions &amp; Departments', 'jam' ); ?>
                    </h2>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th><label for="jam_positions"><?php esc_html_e( 'Available Positions', 'jam' ); ?></label></th>
                            <td>
                                <textarea id="jam_positions" name="jam_settings[positions]"
                                          rows="12" class="large-text jam-settings-textarea"><?php echo esc_textarea( $s['positions'] ); ?></textarea>
                                <p class="description"><?php esc_html_e( 'One position per line. Shown in the "Position Applied For" dropdown.', 'jam' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="jam_intern_positions"><?php esc_html_e( 'Intern / Attachment Positions', 'jam' ); ?></label></th>
                            <td>
                                <textarea id="jam_intern_positions" name="jam_settings[intern_positions]"
                                          rows="5" class="large-text jam-settings-textarea"><?php echo esc_textarea( $s['intern_positions'] ); ?></textarea>
                                <p class="description">
                                    <?php esc_html_e( 'One position name per line — must exactly match a name from the "Available Positions" list above. When an applicant selects one of these, the form automatically switches to the Internship / Attachment form.', 'jam' ); ?>
                                </p>
                                <p class="description" style="margin-top:6px;">
                                    <strong><?php esc_html_e( 'Example:', 'jam' ); ?></strong>
                                    <code style="background:#f0f3fb;padding:3px 8px;border-radius:4px;font-size:12px;">Intern / Attaché</code>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="jam_non_regulatory_positions"><?php esc_html_e( 'Non-Regulatory Positions', 'jam' ); ?></label></th>
                            <td>
                                <textarea id="jam_non_regulatory_positions" name="jam_settings[non_regulatory_positions]"
                                          rows="6" class="large-text jam-settings-textarea"><?php echo esc_textarea( $s['non_regulatory_positions'] ); ?></textarea>
                                <p class="description">
                                    <?php esc_html_e( 'One position name per line. When an applicant selects one of these positions, the entire Regulatory Information section (Regulatory Body, Registration Number, Registration Certificate, License Number, License Certificate) will be hidden and will not be required.', 'jam' ); ?>
                                </p>
                                <p class="description" style="margin-top:6px; color:#856404; background:#fff3cd; border:1px solid #ffc107; padding:8px 12px; border-radius:4px;">
                                    <strong><?php esc_html_e( 'Tip:', 'jam' ); ?></strong>
                                    <?php esc_html_e( 'Positions like Driver, ICT Officer, Finance Officer, Human Resource Officer and Support Staff typically do not require regulatory body registration. Add them here so those fields are hidden when selected.', 'jam' ); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="jam_departments"><?php esc_html_e( 'Departments', 'jam' ); ?></label></th>
                            <td>
                                <textarea id="jam_departments" name="jam_settings[departments]"
                                          rows="8" class="large-text jam-settings-textarea"><?php echo esc_textarea( $s['departments'] ); ?></textarea>
                                <p class="description"><?php esc_html_e( 'One department per line. Used in both the standard and intern forms.', 'jam' ); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- ══ 4. OPTIONAL FIELDS ════════════════════════════════════ -->
                <div class="jam-settings-card">
                    <h2 class="jam-settings-section-title">
                        <span class="dashicons dashicons-forms"></span>
                        <?php esc_html_e( 'Optional Form Fields', 'jam' ); ?>
                    </h2>
                    <p class="jam-settings-desc"><?php esc_html_e( 'These apply to the standard applicant form. Uncheck to hide from the public form.', 'jam' ); ?></p>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th><?php esc_html_e( 'Optional Form Fields', 'jam' ); ?></th>
                            <td>
                                <fieldset>
                                    <?php
                                    $opt_fields     = self::get_optional_fields();
                                    $enabled_fields = (array) $s['optional_fields'];
                                    foreach ( $opt_fields as $key => $label ) :
                                        $checked = in_array( $key, $enabled_fields, true );
                                    ?>
                                    <label class="jam-checkbox-label">
                                        <input type="checkbox"
                                               name="jam_settings[optional_fields][<?php echo esc_attr( $key ); ?>]"
                                               value="1" <?php checked( $checked ); ?>>
                                        <?php echo esc_html( $label ); ?>
                                    </label><br>
                                    <?php endforeach; ?>
                                </fieldset>
                                <p class="description"><?php esc_html_e( 'Uncheck to hide that field from the public application form.', 'jam' ); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php submit_button( __( 'Save Settings', 'jam' ), 'primary large' ); ?>
            </form>

            <!-- Shortcode reference -->
            <div class="jam-settings-card jam-settings-info" style="margin-top:32px;">
                <h2 class="jam-settings-section-title">
                    <span class="dashicons dashicons-shortcode"></span>
                    <?php esc_html_e( 'Shortcode Usage', 'jam' ); ?>
                </h2>
                <p><?php esc_html_e( 'Embed the form on any page or Elementor Shortcode widget:', 'jam' ); ?></p>
                <code>[job_application_form]</code>
                &nbsp;
                <code>[job_application_form title="Apply Now"]</code>
                <h2 class="jam-settings-section-title" style="margin-top:24px;">
                    <span class="dashicons dashicons-download"></span>
                    <?php esc_html_e( 'Export Applications', 'jam' ); ?>
                </h2>
                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'jam_export_csv', '1', admin_url( 'admin.php' ) ), 'jam_export_csv' ) ); ?>"
                   class="button button-primary"><?php esc_html_e( 'Download CSV Export', 'jam' ); ?></a>
            </div>
        </div>
        <?php
    }

    // ── Static helpers ────────────────────────────────────────────────────────

    public static function get_optional_fields() {
        return [
            'national_id'         => __( 'National ID / Passport Number', 'jam' ),
            'physical_address'    => __( 'Physical Address', 'jam' ),
            'department'          => __( 'Department (dropdown)', 'jam' ),
            'prof_qualifications' => __( 'Professional Qualifications', 'jam' ),
            'years_experience'    => __( 'Years of Experience', 'jam' ),
            'cover_letter'        => __( 'Cover Letter', 'jam' ),
            'additional_docs'     => __( 'Additional Documents Upload', 'jam' ),
            'availability_date'   => __( 'Availability Date', 'jam' ),
        ];
    }

    public static function get_defaults() {
        return [
            'admin_email'          => get_option( 'admin_email' ),
            'admin_subject'        => 'New Job Application Received',
            'confirm_subject'      => 'Your Application Has Been Received',
            'recaptcha_enabled'    => '0',
            'recaptcha_site_key'   => '',
            'recaptcha_secret_key' => '',
            'positions'            => implode( "\n", [
                'Medical Officer', 'Nurse (KRCHN)', 'Clinical Officer', 'Pharmacist',
                'Laboratory Technologist', 'Radiographer', 'Nutritionist / Dietitian',
                'Health Records Officer', 'Medical Social Worker', 'Community Health Officer',
                'Finance Officer', 'Human Resource Officer', 'ICT Officer', 'Driver',
                'Support Staff', 'Intern / Attaché',
            ] ),
            'intern_positions'     => 'Intern / Attaché',
            'non_regulatory_positions' => implode( "\n", [
                'Finance Officer',
                'Human Resource Officer',
                'ICT Officer',
                'Driver',
                'Support Staff',
            ] ),
            'departments'          => implode( "\n", [
                'Outpatient Department (OPD)', 'Inpatient Department (IPD)', 'Maternity',
                'Paediatrics', 'Surgery', 'Laboratory', 'Pharmacy', 'Radiology',
                'Nutrition', 'Administration',
            ] ),
            'optional_fields'      => array_keys( self::get_optional_fields() ),
        ];
    }

    public static function get_positions() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return array_values( array_filter( array_map( 'trim', explode( "\n", $s['positions'] ?? '' ) ) ) );
    }

    public static function get_intern_positions() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return array_values( array_filter( array_map( 'trim', explode( "\n", $s['intern_positions'] ?? '' ) ) ) );
    }

    public static function get_non_regulatory_positions() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return array_values( array_filter( array_map( 'trim', explode( "\n", $s['non_regulatory_positions'] ?? '' ) ) ) );
    }

    /**
     * Returns true when the given position requires regulatory information.
     * A position is non-regulatory when it appears in the non_regulatory_positions list.
     * Intern positions are neither — they use a completely different form.
     */
    public static function position_requires_regulatory( $position ) {
        $non_reg = self::get_non_regulatory_positions();
        foreach ( $non_reg as $p ) {
            if ( strtolower( trim( $p ) ) === strtolower( trim( $position ) ) ) {
                return false;
            }
        }
        return true; // Default: regulatory required
    }

    public static function get_departments() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return array_values( array_filter( array_map( 'trim', explode( "\n", $s['departments'] ?? '' ) ) ) );
    }

    public static function field_is_enabled( $key ) {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return in_array( $key, (array) $s['optional_fields'], true );
    }

    public static function recaptcha_is_active() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return '1' === $s['recaptcha_enabled'] && ! empty( $s['recaptcha_site_key'] ) && ! empty( $s['recaptcha_secret_key'] );
    }

    public static function get_recaptcha_site_key() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return $s['recaptcha_site_key'] ?? '';
    }

    public static function get_recaptcha_secret_key() {
        $s = wp_parse_args( get_option( 'jam_settings', [] ), self::get_defaults() );
        return $s['recaptcha_secret_key'] ?? '';
    }
}
