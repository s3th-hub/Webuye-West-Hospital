<?php
/**
 * JAM Frontend Form Template
 * Both form modes live in this single file.
 * JS controls visibility; PHP renders both sections.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$show = function( $key ) { return JAM_Settings::field_is_enabled( $key ); };

// Build JSON arrays for JS consumption
$intern_positions_json       = wp_json_encode( array_values( JAM_Settings::get_intern_positions() ) );
$non_regulatory_positions_json = wp_json_encode( array_values( JAM_Settings::get_non_regulatory_positions() ) );
?>

<div class="jam-form-wrapper" id="jam-application-form-wrapper">

    <?php if ( ! empty( $atts['title'] ) ) : ?>
    <div class="jam-form-header">
        <h2 class="jam-form-title" id="jam-form-main-title"><?php echo esc_html( $atts['title'] ); ?></h2>
        <p class="jam-form-subtitle" id="jam-form-subtitle">
            <?php esc_html_e( 'Please fill in all required fields and upload your documents as PDF files (max 10MB each).', 'jam' ); ?>
        </p>
    </div>
    <?php endif; ?>

    <div class="jam-notice jam-notice--success" id="jam-success-message" style="display:none;"></div>
    <div class="jam-notice jam-notice--error"   id="jam-error-message"   style="display:none;"></div>

    <form id="jam-application-form" class="jam-form" novalidate enctype="multipart/form-data"
          data-intern-positions="<?php echo esc_attr( $intern_positions_json ); ?>"
          data-non-regulatory-positions="<?php echo esc_attr( $non_regulatory_positions_json ); ?>">

        <?php wp_nonce_field( 'jam_form_nonce', 'jam_nonce' ); ?>

        <!-- Honeypot -->
        <div aria-hidden="true" style="position:absolute;left:-9999px;opacity:0;height:0;overflow:hidden;pointer-events:none;">
            <input type="text" name="jam_honeypot" tabindex="-1" autocomplete="off">
        </div>

        <!-- ══════════════════════════════════════════════════════════════
             POSITION SELECTOR  (always shown)
        ══════════════════════════════════════════════════════════════ -->
        <div class="jam-section">
            <div class="jam-section-header">
                <span class="jam-section-number">00</span>
                <h3 class="jam-section-title"><?php esc_html_e( 'Position Applied For', 'jam' ); ?></h3>
            </div>
            <div class="jam-fields-grid">
                <div class="jam-field-group jam-span-full">
                    <label for="jam_job_listing" class="jam-label">
                        <?php esc_html_e( 'Position Applied For', 'jam' ); ?>
                        <span class="jam-required">*</span>
                    </label>
                    <?php if ( ! empty( $positions ) ) : ?>
                    <select id="jam_job_listing" name="jam_job_listing" class="jam-select" required>
                        <option value=""><?php esc_html_e( '— Select a Position —', 'jam' ); ?></option>
                        <?php foreach ( $positions as $position ) : ?>
                        <option value="<?php echo esc_attr( $position ); ?>"><?php echo esc_html( $position ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php else : ?>
                    <input type="text" id="jam_job_listing" name="jam_job_listing" class="jam-input" required
                           placeholder="<?php esc_attr_e( 'Enter the position you are applying for', 'jam' ); ?>">
                    <?php endif; ?>
                    <span class="jam-error-msg" data-for="jam_job_listing"></span>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════════════
             FORM TYPE BADGE  (shows after position is selected)
        ══════════════════════════════════════════════════════════════ -->
        <div id="jam-type-indicator" style="display:none;">
            <div class="jam-type-badge" id="jam-type-badge"></div>
        </div>

        <!-- ══════════════════════════════════════════════════════════════
             ██████████████  STANDARD FORM SECTIONS  ██████████████████
        ══════════════════════════════════════════════════════════════ -->
        <div id="jam-standard-sections" class="jam-conditional-section" style="display:none;">

            <!-- §1 Personal Information -->
            <div class="jam-section">
                <div class="jam-section-header">
                    <span class="jam-section-number">01</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Personal Information', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_full_names" class="jam-label">
                            <?php esc_html_e( 'Full Names', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(According to ID)', 'jam' ); ?></em>
                        </label>
                        <input type="text" id="jam_full_names" name="jam_full_names" class="jam-input"
                               placeholder="<?php esc_attr_e( 'As it appears on your National ID or Passport', 'jam' ); ?>" autocomplete="name">
                        <span class="jam-error-msg" data-for="jam_full_names"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_phone" class="jam-label"><?php esc_html_e( 'Phone Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="tel" id="jam_phone" name="jam_phone" class="jam-input"
                               placeholder="+254 700 000 000" autocomplete="tel">
                        <span class="jam-error-msg" data-for="jam_phone"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_email" class="jam-label"><?php esc_html_e( 'Email Address', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="email" id="jam_email" name="jam_email" class="jam-input"
                               placeholder="yourname@email.com" autocomplete="email">
                        <span class="jam-error-msg" data-for="jam_email"></span>
                    </div>

                    <?php if ( $show( 'national_id' ) ) : ?>
                    <div class="jam-field-group">
                        <label for="jam_national_id" class="jam-label"><?php esc_html_e( 'National ID / Passport Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_national_id" name="jam_national_id" class="jam-input"
                               placeholder="e.g. 12345678">
                        <span class="jam-error-msg" data-for="jam_national_id"></span>
                    </div>
                    <?php endif; ?>

                    <?php if ( $show( 'physical_address' ) ) : ?>
                    <div class="jam-field-group jam-span-full">
                        <label for="jam_physical_address" class="jam-label"><?php esc_html_e( 'Physical Address', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <textarea id="jam_physical_address" name="jam_physical_address" class="jam-textarea" rows="2"
                                  placeholder="<?php esc_attr_e( 'Street, Town / City, County', 'jam' ); ?>"></textarea>
                        <span class="jam-error-msg" data-for="jam_physical_address"></span>
                    </div>
                    <?php endif; ?>

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_id_doc" class="jam-label">
                            <?php esc_html_e( 'Upload ID / Passport', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(PDF · max 10MB · front &amp; back combined)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_id_doc', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_id_doc"></span>
                    </div>

                </div>
            </div>

            <!-- §2 Education -->
            <div class="jam-section">
                <div class="jam-section-header">
                    <span class="jam-section-number">02</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Education', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_education_level" class="jam-label"><?php esc_html_e( 'Highest Level of Education', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_education_level" name="jam_education_level" class="jam-input"
                               placeholder="<?php esc_attr_e( 'e.g. Bachelor of Science in Nursing', 'jam' ); ?>">
                        <span class="jam-error-msg" data-for="jam_education_level"></span>
                    </div>

                    <?php if ( $show( 'prof_qualifications' ) ) : ?>
                    <div class="jam-field-group jam-span-full">
                        <label for="jam_prof_qualifications" class="jam-label"><?php esc_html_e( 'Professional Qualifications', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <textarea id="jam_prof_qualifications" name="jam_prof_qualifications" class="jam-textarea" rows="3"
                                  placeholder="<?php esc_attr_e( 'List your professional qualifications and certifications', 'jam' ); ?>"></textarea>
                        <span class="jam-error-msg" data-for="jam_prof_qualifications"></span>
                    </div>
                    <?php endif; ?>

                    <?php if ( $show( 'years_experience' ) ) : ?>
                    <div class="jam-field-group">
                        <label for="jam_years_experience" class="jam-label"><?php esc_html_e( 'Years of Experience', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="number" id="jam_years_experience" name="jam_years_experience" class="jam-input"
                               min="0" max="50" placeholder="e.g. 5">
                        <span class="jam-error-msg" data-for="jam_years_experience"></span>
                    </div>
                    <?php endif; ?>

                    <?php if ( $show( 'availability_date' ) ) : ?>
                    <div class="jam-field-group">
                        <label for="jam_availability_date" class="jam-label"><?php esc_html_e( 'Availability Date', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="date" id="jam_availability_date" name="jam_availability_date" class="jam-input">
                        <span class="jam-error-msg" data-for="jam_availability_date"></span>
                    </div>
                    <?php endif; ?>

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_certificates" class="jam-label">
                            <?php esc_html_e( 'Upload Academic Certificates', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(Up to 5 PDFs · max 10MB each)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_certificates', true, 'jam_certificates[]' ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_certificates"></span>
                    </div>

                    <?php if ( $show( 'cover_letter' ) ) : ?>
                    <div class="jam-field-group jam-span-full">
                        <label for="jam_cover_letter" class="jam-label"><?php esc_html_e( 'Cover Letter', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <textarea id="jam_cover_letter" name="jam_cover_letter" class="jam-textarea" rows="6"
                                  placeholder="<?php esc_attr_e( 'Tell us why you are the right candidate for this position…', 'jam' ); ?>"></textarea>
                        <span class="jam-error-msg" data-for="jam_cover_letter"></span>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- §3 Regulatory -->
            <div id="jam-regulatory-section">
            <div class="jam-section">
                <div class="jam-section-header">
                    <span class="jam-section-number">03</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Regulatory Information', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group">
                        <label for="jam_regulatory_body" class="jam-label"><?php esc_html_e( 'Regulatory Body', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <select id="jam_regulatory_body" name="jam_regulatory_body" class="jam-select">
                            <option value=""><?php esc_html_e( '— Select Regulatory Body —', 'jam' ); ?></option>
                            <?php foreach ( $regulatory_bodies as $body ) : ?>
                            <option value="<?php echo esc_attr( $body ); ?>"><?php echo esc_html( $body ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="jam-error-msg" data-for="jam_regulatory_body"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_reg_number" class="jam-label"><?php esc_html_e( 'Registration Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_reg_number" name="jam_reg_number" class="jam-input"
                               placeholder="e.g. NCK/RN/12345">
                        <span class="jam-error-msg" data-for="jam_reg_number"></span>
                    </div>

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_reg_cert" class="jam-label">
                            <?php esc_html_e( 'Upload Registration Certificate', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(PDF · max 10MB)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_reg_cert', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_reg_cert"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_license_number" class="jam-label"><?php esc_html_e( 'Current License / Practice Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_license_number" name="jam_license_number" class="jam-input"
                               placeholder="e.g. LIC-2025-00001">
                        <span class="jam-error-msg" data-for="jam_license_number"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_license_cert" class="jam-label">
                            <?php esc_html_e( 'Upload License Certificate', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(PDF · max 10MB)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_license_cert', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_license_cert"></span>
                    </div>

                    <?php if ( $show( 'department' ) && ! empty( $departments ) ) : ?>
                    <div class="jam-field-group jam-span-full">
                        <label for="jam_department" class="jam-label"><?php esc_html_e( 'Department', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <select id="jam_department" name="jam_department" class="jam-select">
                            <option value=""><?php esc_html_e( '— Select Department —', 'jam' ); ?></option>
                            <?php foreach ( $departments as $dept ) : ?>
                            <option value="<?php echo esc_attr( $dept ); ?>"><?php echo esc_html( $dept ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="jam-error-msg" data-for="jam_department"></span>
                    </div>
                    <?php endif; ?>

                    <?php if ( $show( 'additional_docs' ) ) : ?>
                    <div class="jam-field-group jam-span-full">
                        <label for="jam_additional_docs" class="jam-label">
                            <?php esc_html_e( 'Additional Documents', 'jam' ); ?>
                            <span class="jam-optional"><?php esc_html_e( 'optional', 'jam' ); ?></span>
                            <em class="jam-hint"><?php esc_html_e( '(Up to 5 PDFs · max 10MB each)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_additional_docs', true, 'jam_additional_docs[]', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_additional_docs"></span>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            </div><!-- /#jam-regulatory-section -->

        </div><!-- /#jam-standard-sections -->

        <!-- ══════════════════════════════════════════════════════════════
             ██████████████  INTERN / ATTACHÉ SECTIONS  ████████████████
        ══════════════════════════════════════════════════════════════ -->
        <div id="jam-intern-sections" class="jam-conditional-section" style="display:none;">

            <!-- §1 Personal Information (intern) -->
            <div class="jam-section jam-section--intern">
                <div class="jam-section-header">
                    <span class="jam-section-number jam-intern-num">01</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Personal Information', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_intern_full_names" class="jam-label"><?php esc_html_e( 'Full Name', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_intern_full_names" name="jam_full_names" class="jam-input jam-intern-field"
                               placeholder="<?php esc_attr_e( 'As it appears on your ID', 'jam' ); ?>" autocomplete="name">
                        <span class="jam-error-msg" data-for="jam_full_names"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_intern_phone" class="jam-label"><?php esc_html_e( 'Phone Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="tel" id="jam_intern_phone" name="jam_phone" class="jam-input jam-intern-field"
                               placeholder="+254 700 000 000" autocomplete="tel">
                        <span class="jam-error-msg" data-for="jam_phone"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_intern_email" class="jam-label"><?php esc_html_e( 'Email Address', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="email" id="jam_intern_email" name="jam_email" class="jam-input jam-intern-field"
                               placeholder="yourname@email.com" autocomplete="email">
                        <span class="jam-error-msg" data-for="jam_email"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_intern_national_id" class="jam-label"><?php esc_html_e( 'ID / Passport Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_intern_national_id" name="jam_national_id" class="jam-input jam-intern-field"
                               placeholder="e.g. 12345678">
                        <span class="jam-error-msg" data-for="jam_national_id"></span>
                    </div>

                </div>
            </div>

            <!-- §2 Academic Details (intern) -->
            <div class="jam-section jam-section--intern">
                <div class="jam-section-header">
                    <span class="jam-section-number jam-intern-num">02</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Academic Details', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_institution_name" class="jam-label"><?php esc_html_e( 'Institution Name', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_institution_name" name="jam_institution_name" class="jam-input jam-intern-field"
                               placeholder="<?php esc_attr_e( 'e.g. University of Nairobi, Kenya Medical Training College', 'jam' ); ?>">
                        <span class="jam-error-msg" data-for="jam_institution_name"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_course_program" class="jam-label"><?php esc_html_e( 'Course / Program', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_course_program" name="jam_course_program" class="jam-input jam-intern-field"
                               placeholder="<?php esc_attr_e( 'e.g. Nursing, Lab Technology, Administration', 'jam' ); ?>">
                        <span class="jam-error-msg" data-for="jam_course_program"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_year_of_study" class="jam-label"><?php esc_html_e( 'Year of Study', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <select id="jam_year_of_study" name="jam_year_of_study" class="jam-select jam-intern-field">
                            <option value=""><?php esc_html_e( '— Select Year —', 'jam' ); ?></option>
                            <?php foreach ( [ '1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year', 'Final Year', 'Graduated' ] as $yr ) : ?>
                            <option value="<?php echo esc_attr( $yr ); ?>"><?php echo esc_html( $yr ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="jam-error-msg" data-for="jam_year_of_study"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_student_id" class="jam-label"><?php esc_html_e( 'Student ID Number', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_student_id" name="jam_student_id" class="jam-input jam-intern-field"
                               placeholder="<?php esc_attr_e( 'e.g. KMTC/2023/001', 'jam' ); ?>">
                        <span class="jam-error-msg" data-for="jam_student_id"></span>
                    </div>

                </div>
            </div>

            <!-- §3 Attachment / Internship Details -->
            <div class="jam-section jam-section--intern">
                <div class="jam-section-header">
                    <span class="jam-section-number jam-intern-num">03</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Attachment / Internship Details', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group">
                        <label for="jam_intern_type" class="jam-label"><?php esc_html_e( 'Type of Application', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <select id="jam_intern_type" name="jam_intern_type" class="jam-select jam-intern-field">
                            <option value=""><?php esc_html_e( '— Select Type —', 'jam' ); ?></option>
                            <option value="Intern"><?php esc_html_e( 'Intern', 'jam' ); ?></option>
                            <option value="Attaché"><?php esc_html_e( 'Attaché', 'jam' ); ?></option>
                        </select>
                        <span class="jam-error-msg" data-for="jam_intern_type"></span>
                    </div>

                    <?php if ( ! empty( $departments ) ) : ?>
                    <div class="jam-field-group">
                        <label for="jam_intern_department" class="jam-label"><?php esc_html_e( 'Department of Interest', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <select id="jam_intern_department" name="jam_intern_department" class="jam-select jam-intern-field">
                            <option value=""><?php esc_html_e( '— Select Department —', 'jam' ); ?></option>
                            <?php foreach ( $departments as $dept ) : ?>
                            <option value="<?php echo esc_attr( $dept ); ?>"><?php echo esc_html( $dept ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="jam-error-msg" data-for="jam_intern_department"></span>
                    </div>
                    <?php else : ?>
                    <div class="jam-field-group">
                        <label for="jam_intern_department" class="jam-label"><?php esc_html_e( 'Department of Interest', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="text" id="jam_intern_department" name="jam_intern_department" class="jam-input jam-intern-field"
                               placeholder="<?php esc_attr_e( 'e.g. Nursing, Laboratory, Administration', 'jam' ); ?>">
                        <span class="jam-error-msg" data-for="jam_intern_department"></span>
                    </div>
                    <?php endif; ?>

                    <div class="jam-field-group">
                        <label for="jam_preferred_start_date" class="jam-label"><?php esc_html_e( 'Preferred Start Date', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <input type="date" id="jam_preferred_start_date" name="jam_preferred_start_date" class="jam-input jam-intern-field">
                        <span class="jam-error-msg" data-for="jam_preferred_start_date"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_attachment_duration" class="jam-label"><?php esc_html_e( 'Duration of Attachment', 'jam' ); ?> <span class="jam-required">*</span></label>
                        <select id="jam_attachment_duration" name="jam_attachment_duration" class="jam-select jam-intern-field">
                            <option value=""><?php esc_html_e( '— Select Duration —', 'jam' ); ?></option>
                            <?php foreach ( [ '1 Month', '2 Months', '3 Months', '4 Months', '5 Months', '6 Months', 'Other' ] as $dur ) : ?>
                            <option value="<?php echo esc_attr( $dur ); ?>"><?php echo esc_html( $dur ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="jam-error-msg" data-for="jam_attachment_duration"></span>
                    </div>

                </div>
            </div>

            <!-- §4 Documents (intern) -->
            <div class="jam-section jam-section--intern">
                <div class="jam-section-header">
                    <span class="jam-section-number jam-intern-num">04</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Documents Upload', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group">
                        <label for="jam_cv" class="jam-label">
                            <?php esc_html_e( 'CV / Resume', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(PDF · max 10MB)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_cv', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_cv"></span>
                    </div>

                    <div class="jam-field-group">
                        <label for="jam_intro_letter" class="jam-label">
                            <?php esc_html_e( 'Introduction Letter from School', 'jam' ); ?> <span class="jam-required">*</span>
                            <em class="jam-hint"><?php esc_html_e( '(PDF · max 10MB)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_intro_letter', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_intro_letter"></span>
                    </div>

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_transcript" class="jam-label">
                            <?php esc_html_e( 'Academic Transcript', 'jam' ); ?>
                            <span class="jam-optional"><?php esc_html_e( 'optional', 'jam' ); ?></span>
                            <em class="jam-hint"><?php esc_html_e( '(PDF · max 10MB)', 'jam' ); ?></em>
                        </label>
                        <?php echo jam_file_drop( 'jam_transcript', false, 'jam_transcript', false ); // phpcs:ignore ?>
                        <span class="jam-error-msg" data-for="jam_transcript"></span>
                    </div>

                </div>
            </div>

            <!-- §5 Additional Information -->
            <div class="jam-section jam-section--intern">
                <div class="jam-section-header">
                    <span class="jam-section-number jam-intern-num">05</span>
                    <h3 class="jam-section-title"><?php esc_html_e( 'Additional Information', 'jam' ); ?></h3>
                </div>
                <div class="jam-fields-grid">

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_motivation" class="jam-label">
                            <?php esc_html_e( 'Why do you want to join Webuye West Hospital?', 'jam' ); ?> <span class="jam-required">*</span>
                        </label>
                        <textarea id="jam_motivation" name="jam_motivation" class="jam-textarea jam-intern-field" rows="5"
                                  placeholder="<?php esc_attr_e( 'Tell us what motivates you to apply for this opportunity at Webuye West Hospital…', 'jam' ); ?>"></textarea>
                        <span class="jam-error-msg" data-for="jam_motivation"></span>
                    </div>

                    <div class="jam-field-group jam-span-full">
                        <label for="jam_relevant_skills" class="jam-label">
                            <?php esc_html_e( 'Relevant Skills or Experience', 'jam' ); ?>
                            <span class="jam-optional"><?php esc_html_e( 'optional', 'jam' ); ?></span>
                        </label>
                        <textarea id="jam_relevant_skills" name="jam_relevant_skills" class="jam-textarea jam-intern-field" rows="4"
                                  placeholder="<?php esc_attr_e( 'Any clinical, administrative or other relevant skills or prior experience…', 'jam' ); ?>"></textarea>
                    </div>

                </div>
            </div>

        </div><!-- /#jam-intern-sections -->

        <!-- ══════════════════════════════════════════════════════════════
             reCAPTCHA  (shown when form sections are visible)
        ══════════════════════════════════════════════════════════════ -->
        <?php if ( $recaptcha_active ) : ?>
        <div class="jam-recaptcha-wrapper" id="jam-recaptcha-block" style="display:none;">
            <div class="g-recaptcha" data-sitekey="<?php echo esc_attr( $recaptcha_site_key ); ?>"></div>
            <span class="jam-error-msg" id="jam-recaptcha-error" data-for="recaptcha"></span>
        </div>
        <?php endif; ?>

        <!-- ══════════════════════════════════════════════════════════════
             CONSENT + SUBMIT  (shown when form sections are visible)
        ══════════════════════════════════════════════════════════════ -->
        <div class="jam-submit-section" id="jam-submit-block" style="display:none;">

            <div class="jam-consent-row">
                <label class="jam-consent-label" for="jam_consent">
                    <input type="checkbox" id="jam_consent" name="jam_consent" value="1" class="jam-consent-input">
                    <span class="jam-consent-box"></span>
                    <span class="jam-consent-text">
                        <?php esc_html_e( 'I consent to Webuye West Hospital collecting and storing my personal data for recruitment purposes.', 'jam' ); ?>
                        <span class="jam-required">*</span>
                    </span>
                </label>
                <span class="jam-error-msg" id="jam-consent-error" data-for="jam_consent"></span>
            </div>

            <div class="jam-submit-row">
                <p class="jam-required-note"><span class="jam-required">*</span> <?php esc_html_e( 'Required fields', 'jam' ); ?></p>
                <button type="submit" class="jam-btn-submit" id="jam-submit-btn">
                    <span class="jam-btn-text"><?php esc_html_e( 'Submit Application', 'jam' ); ?></span>
                    <span class="jam-btn-spinner" aria-hidden="true"></span>
                </button>
            </div>

        </div><!-- /#jam-submit-block -->

    </form>
</div>

<?php
/* ── Reusable file drop zone HTML helper ───────────────────────────────────
 * @param string  $id       – input id and data-target
 * @param bool    $multiple – allow multiple files
 * @param string  $name     – input name (defaults to $id)
 * @param bool    $required – add required attribute
 */
function jam_file_drop( $id, $multiple = false, $name = '', $required = true ) {
    if ( ! $name ) $name = $id;
    $multi_attr = $multiple ? 'multiple' : '';
    $req_attr   = $required ? 'required' : '';
    $icon = $multiple
        ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>';
    $hint = $multiple
        ? esc_html__( 'PDF files only · Up to 5 files · Max 10MB each', 'jam' )
        : esc_html__( 'PDF files only · Max 10MB', 'jam' );
    ob_start();
    ?>
    <div class="jam-file-drop" data-target="<?php echo esc_attr( $id ); ?>" data-multiple="<?php echo $multiple ? 'true' : 'false'; ?>">
        <input type="file" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>"
               class="jam-file-input" accept="application/pdf,.pdf"
               <?php echo $multi_attr; ?> <?php echo $req_attr; ?>>
        <div class="jam-file-ui">
            <div class="jam-file-icon"><?php echo $icon; // phpcs:ignore ?></div>
            <p class="jam-file-label"><?php esc_html_e( 'Click to upload or drag &amp; drop', 'jam' ); ?></p>
            <p class="jam-file-formats"><?php echo $hint; // phpcs:ignore ?></p>
            <div class="jam-file-preview"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
