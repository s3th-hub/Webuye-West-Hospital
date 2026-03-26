<?php if ( ! defined( 'ABSPATH' ) ) exit;

$app_type = get_post_meta( $post->ID, '_jam_application_type', true ) ?: 'standard';

function jam_meta_row( $label, $value ) {
    if ( $value === '' || $value === null ) return;
    echo '<tr>';
    echo '<th>' . esc_html( $label ) . '</th>';
    echo '<td>' . nl2br( esc_html( $value ) ) . '</td>';
    echo '</tr>';
}
?>

<div class="jam-meta-details">

    <!-- ── Application type badge ────────────────────────────────────── -->
    <div style="margin-bottom:16px;">
        <?php if ( 'intern' === $app_type ) : ?>
        <span class="jam-status-badge" style="background:#fef3c7;color:#92400e;">
            📋 <?php esc_html_e( 'Internship / Attachment Application', 'jam' ); ?>
        </span>
        <?php else : ?>
        <span class="jam-status-badge" style="background:#eef1fb;color:#2e4592;">
            💼 <?php esc_html_e( 'Standard Job Application', 'jam' ); ?>
        </span>
        <?php endif; ?>
    </div>

    <!-- ── Personal Information (shared by both types) ─────────────── -->
    <div class="jam-meta-section">
        <h4 class="jam-meta-section-title"><?php esc_html_e( 'Personal Information', 'jam' ); ?></h4>
        <table class="jam-meta-table">
            <?php
            jam_meta_row( __( 'Full Names', 'jam' ),       $meta['_jam_full_names'] );
            jam_meta_row( __( 'Phone Number', 'jam' ),     $meta['_jam_phone'] );
            jam_meta_row( __( 'Email Address', 'jam' ),    $meta['_jam_email'] );
            jam_meta_row( __( 'National ID / Passport', 'jam' ), $meta['_jam_national_id'] );

            $submitted = $meta['_jam_submitted_date'] ?? '';
            if ( $submitted ) {
                echo '<tr><th>' . esc_html__( 'Submitted', 'jam' ) . '</th>';
                echo '<td>' . esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $submitted ) ) ) . '</td></tr>';
            }
            ?>
        </table>
    </div>

    <?php if ( 'standard' === $app_type ) : ?>

    <!-- ── Standard: Education ─────────────────────────────────────── -->
    <div class="jam-meta-section">
        <h4 class="jam-meta-section-title"><?php esc_html_e( 'Education', 'jam' ); ?></h4>
        <table class="jam-meta-table">
            <?php
            jam_meta_row( __( 'Highest Level of Education', 'jam' ), $meta['_jam_education_level'] ?? '' );
            jam_meta_row( __( 'Professional Qualifications', 'jam' ), get_post_meta( $post->ID, '_jam_prof_qualifications', true ) );
            jam_meta_row( __( 'Years of Experience', 'jam' ), get_post_meta( $post->ID, '_jam_years_experience', true ) );
            jam_meta_row( __( 'Availability Date', 'jam' ), get_post_meta( $post->ID, '_jam_availability_date', true ) );
            jam_meta_row( __( 'Cover Letter', 'jam' ), get_post_meta( $post->ID, '_jam_cover_letter', true ) );
            ?>
        </table>
    </div>

    <!-- ── Standard: Regulatory ────────────────────────────────────── -->
    <div class="jam-meta-section">
        <h4 class="jam-meta-section-title"><?php esc_html_e( 'Regulatory Information', 'jam' ); ?></h4>
        <table class="jam-meta-table">
            <?php
            jam_meta_row( __( 'Regulatory Body', 'jam' ),          $meta['_jam_regulatory_body'] ?? '' );
            jam_meta_row( __( 'Registration Number', 'jam' ),       $meta['_jam_reg_number'] ?? '' );
            jam_meta_row( __( 'License / Practice Number', 'jam' ), $meta['_jam_license_number'] ?? '' );
            jam_meta_row( __( 'Physical Address', 'jam' ),          get_post_meta( $post->ID, '_jam_physical_address', true ) );
            jam_meta_row( __( 'Department', 'jam' ),                get_post_meta( $post->ID, '_jam_department', true ) );
            ?>
        </table>
    </div>

    <?php else : // ── Intern / Attaché ──────────────────────────────── ?>

    <!-- ── Intern: Academic Details ────────────────────────────────── -->
    <div class="jam-meta-section">
        <h4 class="jam-meta-section-title"><?php esc_html_e( 'Academic Details', 'jam' ); ?></h4>
        <table class="jam-meta-table">
            <?php
            jam_meta_row( __( 'Institution Name', 'jam' ),  get_post_meta( $post->ID, '_jam_institution_name', true ) );
            jam_meta_row( __( 'Course / Program', 'jam' ),  get_post_meta( $post->ID, '_jam_course_program', true ) );
            jam_meta_row( __( 'Year of Study', 'jam' ),     get_post_meta( $post->ID, '_jam_year_of_study', true ) );
            jam_meta_row( __( 'Student ID Number', 'jam' ), get_post_meta( $post->ID, '_jam_student_id', true ) );
            ?>
        </table>
    </div>

    <!-- ── Intern: Attachment Details ──────────────────────────────── -->
    <div class="jam-meta-section">
        <h4 class="jam-meta-section-title"><?php esc_html_e( 'Attachment / Internship Details', 'jam' ); ?></h4>
        <table class="jam-meta-table">
            <?php
            jam_meta_row( __( 'Type', 'jam' ),                     get_post_meta( $post->ID, '_jam_intern_type', true ) );
            jam_meta_row( __( 'Department of Interest', 'jam' ),    get_post_meta( $post->ID, '_jam_intern_department', true ) );
            jam_meta_row( __( 'Preferred Start Date', 'jam' ),      get_post_meta( $post->ID, '_jam_preferred_start_date', true ) );
            jam_meta_row( __( 'Duration of Attachment', 'jam' ),    get_post_meta( $post->ID, '_jam_attachment_duration', true ) );
            ?>
        </table>
    </div>

    <!-- ── Intern: Additional Information ──────────────────────────── -->
    <div class="jam-meta-section">
        <h4 class="jam-meta-section-title"><?php esc_html_e( 'Additional Information', 'jam' ); ?></h4>
        <table class="jam-meta-table">
            <?php
            jam_meta_row( __( 'Why Webuye West Hospital?', 'jam' ), get_post_meta( $post->ID, '_jam_motivation', true ) );
            jam_meta_row( __( 'Relevant Skills / Experience', 'jam' ), get_post_meta( $post->ID, '_jam_relevant_skills', true ) );
            ?>
        </table>
    </div>

    <?php endif; ?>

</div>
