<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class JAM_Email {

    public static function send_admin_notification( $post_id, $data, $uploads ) {
        $settings = get_option( 'jam_settings', [] );
        $to       = ! empty( $settings['admin_email'] ) ? $settings['admin_email'] : get_option( 'admin_email' );
        $subject  = ! empty( $settings['admin_subject'] ) ? $settings['admin_subject'] : 'New Job Application Received';
        $headers  = [ 'Content-Type: text/html; charset=UTF-8' ];

        // Adjust subject for intern applications
        if ( isset( $data['application_type'] ) && 'intern' === $data['application_type'] ) {
            $intern_type = isset( $data['intern_type'] ) ? $data['intern_type'] : 'Internship';
            $subject     = str_replace( 'Job Application', $intern_type . ' Application', $subject );
        }

        $body = 'intern' === ( $data['application_type'] ?? 'standard' )
            ? self::get_intern_admin_body( $post_id, $data, $uploads )
            : self::get_standard_admin_body( $post_id, $data, $uploads );

        wp_mail( $to, $subject, $body, $headers );
    }

    public static function send_applicant_confirmation( $post_id, $data ) {
        $settings = get_option( 'jam_settings', [] );
        $subject  = ! empty( $settings['confirm_subject'] ) ? $settings['confirm_subject'] : 'Your Application Has Been Received';
        $to       = $data['email'];
        $headers  = [ 'Content-Type: text/html; charset=UTF-8' ];

        $body = 'intern' === ( $data['application_type'] ?? 'standard' )
            ? self::get_intern_confirm_body( $post_id, $data )
            : self::get_standard_confirm_body( $post_id, $data );

        wp_mail( $to, $subject, $body, $headers );
    }

    // ── Standard admin email ──────────────────────────────────────────────────
    private static function get_standard_admin_body( $post_id, $data, $uploads ) {
        $site_name  = get_bloginfo( 'name' );
        $admin_url  = admin_url( 'post.php?post=' . $post_id . '&action=edit' );
        $date       = current_time( 'F j, Y \a\t g:i A' );

        $id_doc_link   = self::file_link( get_post_meta( $post_id, '_jam_id_doc_id', true ) );
        $reg_cert_link = self::file_link( get_post_meta( $post_id, '_jam_reg_cert_id', true ) );
        $lic_cert_link = self::file_link( get_post_meta( $post_id, '_jam_license_cert_id', true ) );
        $cert_links    = self::multi_file_links( get_post_meta( $post_id, '_jam_certificates_ids', true ) );

        ob_start(); ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}
.ew{max-width:620px;margin:0 auto;background:#f5f7fb;padding:20px}
.eh{background:#2e4592;color:#fff;padding:28px 32px;border-radius:6px 6px 0 0}
.eh h1{margin:0;font-size:22px}.eh p{margin:4px 0 0;font-size:13px;opacity:.85}
.eb{background:#fff;padding:28px 32px;border:1px solid #e0e4ef}
.st{font-size:12px;font-weight:700;text-transform:uppercase;color:#2e4592;letter-spacing:.5px;border-bottom:2px solid #2e4592;padding-bottom:6px;margin:24px 0 12px}
.fr{display:flex;margin-bottom:10px}.fl{width:220px;font-weight:700;color:#555;font-size:13px;flex-shrink:0}.fv{color:#111;font-size:14px}
a.btn{display:inline-block;background:#2e4592;color:#fff;text-decoration:none;padding:12px 24px;border-radius:4px;font-weight:700;margin-top:16px}
a.fl-lnk{color:#2e4592;text-decoration:none}
.ef{text-align:center;padding:16px;color:#888;font-size:12px}
</style></head><body>
<div class="ew">
  <div class="eh"><h1>New Job Application</h1><p><?php echo esc_html( $site_name ); ?> &middot; <?php echo esc_html( $date ); ?></p></div>
  <div class="eb">
    <div class="st">Personal Information</div>
    <?php echo self::fr( 'Full Names', $data['full_names'] ); ?>
    <?php echo self::fr( 'Phone', $data['phone'] ); ?>
    <?php echo self::fr( 'Email', $data['email'] ); ?>
    <?php echo self::fr( 'National ID', $data['national_id'] ); ?>
    <?php echo self::fr( 'Position', $data['job_listing'] ); ?>
    <?php if ( $id_doc_link ) echo self::fr_link( 'ID Document', $id_doc_link ); ?>

    <div class="st">Education</div>
    <?php echo self::fr( 'Education Level', $data['education_level'] ); ?>
    <?php if ( ! empty( $cert_links ) ) : ?>
    <div class="fr"><div class="fl">Certificates</div><div class="fv"><?php foreach ( $cert_links as $i => $lk ) echo '<a href="' . esc_url( $lk['url'] ) . '" class="fl-lnk">Certificate ' . ( $i + 1 ) . '</a><br>'; ?></div></div>
    <?php endif; ?>

    <div class="st">Regulatory Information</div>
    <?php echo self::fr( 'Regulatory Body', $data['regulatory_body'] ); ?>
    <?php echo self::fr( 'Registration Number', $data['reg_number'] ); ?>
    <?php if ( $reg_cert_link ) echo self::fr_link( 'Registration Certificate', $reg_cert_link ); ?>
    <?php echo self::fr( 'License Number', $data['license_number'] ); ?>
    <?php if ( $lic_cert_link ) echo self::fr_link( 'License Certificate', $lic_cert_link ); ?>

    <a href="<?php echo esc_url( $admin_url ); ?>" class="btn">View Full Application &rarr;</a>
  </div>
  <div class="ef">&copy; <?php echo esc_html( $site_name ); ?> &mdash; Automated notification</div>
</div>
</body></html>
        <?php return ob_get_clean();
    }

    // ── Intern admin email ────────────────────────────────────────────────────
    private static function get_intern_admin_body( $post_id, $data, $uploads ) {
        $site_name = get_bloginfo( 'name' );
        $admin_url = admin_url( 'post.php?post=' . $post_id . '&action=edit' );
        $date      = current_time( 'F j, Y \a\t g:i A' );

        $cv_link     = self::file_link( get_post_meta( $post_id, '_jam_cv_id', true ) );
        $letter_link = self::file_link( get_post_meta( $post_id, '_jam_intro_letter_id', true ) );
        $tr_link     = self::file_link( get_post_meta( $post_id, '_jam_transcript_id', true ) );

        ob_start(); ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}
.ew{max-width:620px;margin:0 auto;background:#f5f7fb;padding:20px}
.eh{background:#d97706;color:#fff;padding:28px 32px;border-radius:6px 6px 0 0}
.eh h1{margin:0;font-size:22px}.eh p{margin:4px 0 0;font-size:13px;opacity:.85}
.eb{background:#fff;padding:28px 32px;border:1px solid #e0e4ef}
.st{font-size:12px;font-weight:700;text-transform:uppercase;color:#92400e;letter-spacing:.5px;border-bottom:2px solid #fde68a;padding-bottom:6px;margin:24px 0 12px}
.fr{display:flex;margin-bottom:10px}.fl{width:220px;font-weight:700;color:#555;font-size:13px;flex-shrink:0}.fv{color:#111;font-size:14px}
a.btn{display:inline-block;background:#d97706;color:#fff;text-decoration:none;padding:12px 24px;border-radius:4px;font-weight:700;margin-top:16px}
a.fl-lnk{color:#d97706;text-decoration:none}
.ef{text-align:center;padding:16px;color:#888;font-size:12px}
</style></head><body>
<div class="ew">
  <div class="eh"><h1>New <?php echo esc_html( $data['intern_type'] ?? 'Intern' ); ?> Application</h1><p><?php echo esc_html( $site_name ); ?> &middot; <?php echo esc_html( $date ); ?></p></div>
  <div class="eb">
    <div class="st">Personal Information</div>
    <?php echo self::fr( 'Full Name', $data['full_names'] ); ?>
    <?php echo self::fr( 'Phone', $data['phone'] ); ?>
    <?php echo self::fr( 'Email', $data['email'] ); ?>
    <?php echo self::fr( 'ID / Passport', $data['national_id'] ); ?>
    <?php echo self::fr( 'Position', $data['job_listing'] ); ?>

    <div class="st">Academic Details</div>
    <?php echo self::fr( 'Institution', $data['institution_name'] ); ?>
    <?php echo self::fr( 'Course / Program', $data['course_program'] ); ?>
    <?php echo self::fr( 'Year of Study', $data['year_of_study'] ); ?>
    <?php echo self::fr( 'Student ID', $data['student_id'] ); ?>

    <div class="st">Attachment / Internship</div>
    <?php echo self::fr( 'Type', $data['intern_type'] ); ?>
    <?php echo self::fr( 'Department', $data['intern_department'] ); ?>
    <?php echo self::fr( 'Start Date', $data['preferred_start_date'] ); ?>
    <?php echo self::fr( 'Duration', $data['attachment_duration'] ); ?>

    <div class="st">Documents</div>
    <?php if ( $cv_link )     echo self::fr_link( 'CV / Resume', $cv_link ); ?>
    <?php if ( $letter_link ) echo self::fr_link( 'Introduction Letter', $letter_link ); ?>
    <?php if ( $tr_link )     echo self::fr_link( 'Academic Transcript', $tr_link ); ?>

    <div class="st">Additional Information</div>
    <?php echo self::fr( 'Why Webuye West Hospital?', $data['motivation'] ); ?>
    <?php if ( ! empty( $data['relevant_skills'] ) ) echo self::fr( 'Relevant Skills', $data['relevant_skills'] ); ?>

    <a href="<?php echo esc_url( $admin_url ); ?>" class="btn">View Full Application &rarr;</a>
  </div>
  <div class="ef">&copy; <?php echo esc_html( $site_name ); ?> &mdash; Automated notification</div>
</div>
</body></html>
        <?php return ob_get_clean();
    }

    // ── Standard applicant confirmation ──────────────────────────────────────
    private static function get_standard_confirm_body( $post_id, $data ) {
        $site_name = get_bloginfo( 'name' );
        ob_start(); ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}
.ew{max-width:620px;margin:0 auto;background:#f5f7fb;padding:20px}
.eh{background:#2e4592;color:#fff;padding:28px 32px;border-radius:6px 6px 0 0}
.eh h1{margin:0;font-size:22px}
.eb{background:#fff;padding:28px 32px;border:1px solid #e0e4ef}
.sb{background:#f0f3fb;border-left:4px solid #2e4592;padding:16px;border-radius:4px;margin:16px 0}
.ef{text-align:center;padding:16px;color:#888;font-size:12px}
</style></head><body>
<div class="ew">
  <div class="eh"><h1>Application Received &#10003;</h1></div>
  <div class="eb">
    <p>Dear <strong><?php echo esc_html( $data['full_names'] ); ?></strong>,</p>
    <p>Thank you for submitting your job application to <strong><?php echo esc_html( $site_name ); ?></strong>. We have successfully received your application and it is currently under review.</p>
    <div class="sb">
      <strong>Application Summary</strong><br>
      Name: <?php echo esc_html( $data['full_names'] ); ?><br>
      Position: <?php echo esc_html( $data['job_listing'] ); ?><br>
      Email: <?php echo esc_html( $data['email'] ); ?><br>
      Submitted: <?php echo esc_html( current_time( 'F j, Y \a\t g:i A' ) ); ?>
    </div>
    <p>Our team will review your application and get back to you within a few business days.</p>
    <p>Kind regards,<br><strong><?php echo esc_html( $site_name ); ?> Recruitment Team</strong></p>
  </div>
  <div class="ef">&copy; <?php echo esc_html( $site_name ); ?></div>
</div>
</body></html>
        <?php return ob_get_clean();
    }

    // ── Intern applicant confirmation ─────────────────────────────────────────
    private static function get_intern_confirm_body( $post_id, $data ) {
        $site_name   = get_bloginfo( 'name' );
        $intern_type = $data['intern_type'] ?? 'Internship';
        ob_start(); ?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}
.ew{max-width:620px;margin:0 auto;background:#f5f7fb;padding:20px}
.eh{background:#d97706;color:#fff;padding:28px 32px;border-radius:6px 6px 0 0}
.eh h1{margin:0;font-size:22px}
.eb{background:#fff;padding:28px 32px;border:1px solid #e0e4ef}
.sb{background:#fef3c7;border-left:4px solid #d97706;padding:16px;border-radius:4px;margin:16px 0}
.ef{text-align:center;padding:16px;color:#888;font-size:12px}
</style></head><body>
<div class="ew">
  <div class="eh"><h1><?php echo esc_html( $intern_type ); ?> Application Received &#10003;</h1></div>
  <div class="eb">
    <p>Dear <strong><?php echo esc_html( $data['full_names'] ); ?></strong>,</p>
    <p>Thank you for applying for an <?php echo esc_html( strtolower( $intern_type ) ); ?> placement at <strong><?php echo esc_html( $site_name ); ?></strong>. We have successfully received your application and our team will review it shortly.</p>
    <div class="sb">
      <strong>Application Summary</strong><br>
      Name: <?php echo esc_html( $data['full_names'] ); ?><br>
      Type: <?php echo esc_html( $intern_type ); ?><br>
      Institution: <?php echo esc_html( $data['institution_name'] ?? '' ); ?><br>
      Department: <?php echo esc_html( $data['intern_department'] ?? '' ); ?><br>
      Preferred Start: <?php echo esc_html( $data['preferred_start_date'] ?? '' ); ?><br>
      Duration: <?php echo esc_html( $data['attachment_duration'] ?? '' ); ?><br>
      Submitted: <?php echo esc_html( current_time( 'F j, Y \a\t g:i A' ) ); ?>
    </div>
    <p>We will get in touch with you soon. If you have any questions please contact us directly.</p>
    <p>Kind regards,<br><strong><?php echo esc_html( $site_name ); ?> Recruitment Team</strong></p>
  </div>
  <div class="ef">&copy; <?php echo esc_html( $site_name ); ?></div>
</div>
</body></html>
        <?php return ob_get_clean();
    }

    // ── Email field helpers ───────────────────────────────────────────────────
    private static function fr( $label, $value ) {
        if ( $value === '' || $value === null ) return '';
        return '<div class="fr"><div class="fl">' . esc_html( $label ) . '</div><div class="fv">' . nl2br( esc_html( $value ) ) . '</div></div>';
    }

    private static function fr_link( $label, $file ) {
        $html = '<div class="fr"><div class="fl">' . esc_html( $label ) . '</div><div class="fv">';
        if ( $file ) {
            $html .= '<a href="' . esc_url( $file['url'] ) . '" class="fl-lnk">' . esc_html( $file['name'] ) . '</a>';
        } else {
            $html .= '—';
        }
        $html .= '</div></div>';
        return $html;
    }

    private static function file_link( $attach_id ) {
        if ( ! $attach_id ) return null;
        $url = wp_get_attachment_url( $attach_id );
        return $url ? [ 'url' => $url, 'name' => get_the_title( $attach_id ) ] : null;
    }

    private static function multi_file_links( $cert_ids_json ) {
        if ( empty( $cert_ids_json ) ) return [];
        $ids   = json_decode( $cert_ids_json, true );
        $links = [];
        if ( is_array( $ids ) ) {
            foreach ( $ids as $id ) {
                $url = wp_get_attachment_url( $id );
                if ( $url ) $links[] = [ 'url' => $url, 'name' => get_the_title( $id ) ];
            }
        }
        return $links;
    }
}
