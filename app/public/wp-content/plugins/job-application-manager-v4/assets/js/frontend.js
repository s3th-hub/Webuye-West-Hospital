/**
 * Job Application Manager – Frontend JS v3
 *
 * Key additions over v2:
 *  - Reads intern-positions JSON from form data attribute
 *  - On position change: switches between standard and intern form sections
 *  - Animates section appearance with slideDown / slideUp
 *  - Separate validation paths for each form type
 *  - Required attributes are toggled with the active form type so
 *    hidden fields never block submission
 */

(function ($) {
    'use strict';

    const JAM_MAX_SIZE  = 10 * 1024 * 1024; // 10 MB
    const JAM_MAX_CERTS = 5;

    let currentFormType = null; // 'standard' | 'intern' | null

    // ── Bootstrap ─────────────────────────────────────────────────────────
    $(function () {
        initFileDropZones();
        initPositionSwitch();
        initFormSubmit();
        initConsentHighlight();
    });

    // ══════════════════════════════════════════════════════════════════════
    // POSITION SWITCH — the heart of conditional logic
    // ══════════════════════════════════════════════════════════════════════
    function initPositionSwitch() {
        var $form     = $('#jam-application-form');
        var $posField = $('#jam_job_listing');

        if (!$posField.length) return;

        // Read both position lists from data attributes (PHP-rendered JSON)
        var internPositions = [];
        var nonRegulatoryPositions = [];
        try {
            internPositions          = JSON.parse($form.attr('data-intern-positions') || '[]');
            nonRegulatoryPositions   = JSON.parse($form.attr('data-non-regulatory-positions') || '[]');
        } catch (e) {
            internPositions = [];
            nonRegulatoryPositions = [];
        }

        // Also sync from JAM global (set by wp_localize_script as fallback)
        if (!nonRegulatoryPositions.length && JAM.non_regulatory_positions) {
            nonRegulatoryPositions = JAM.non_regulatory_positions;
        }

        $posField.on('change', function () {
            var selected = $.trim($(this).val());
            if (!selected) {
                hideAllSections();
                return;
            }
            var isIntern = isInternPosition(selected, internPositions);
            switchToFormType(isIntern ? 'intern' : 'standard', selected, nonRegulatoryPositions);
        });
    }

    function isInternPosition(position, internList) {
        var normalized = position.toLowerCase();
        for (var i = 0; i < internList.length; i++) {
            if (internList[i].toLowerCase() === normalized) return true;
        }
        return false;
    }

    function hideAllSections() {
        currentFormType = null;
        $('#jam-standard-sections').slideUp(250);
        $('#jam-intern-sections').slideUp(250);
        $('#jam-submit-block').slideUp(200);
        $('#jam-recaptcha-block').slideUp(200);
        $('#jam-type-indicator').slideUp(150);
        // Also hide and reset regulatory section
        $('#jam-regulatory-section').find('input, select').removeAttr('required');
        // Clear all required attrs to prevent hidden fields blocking submission
        setRequiredAttrs('standard', false);
        setRequiredAttrs('intern', false);
    }

    function switchToFormType(type, position, nonRegList) {
        currentFormType = type;

        clearFormErrors();

        if (type === 'standard') {
            $('#jam-intern-sections').slideUp(200, function () {
                setRequiredAttrs('intern', false);
            });
            $('#jam-standard-sections').slideDown(350);
            setRequiredAttrs('standard', true);
            showBadge('standard');
            updateFormTitle('standard');

            // Handle regulatory section visibility
            var needsRegulatory = !isNonRegulatoryPosition(position, nonRegList || []);
            toggleRegulatorySection(needsRegulatory);

        } else {
            $('#jam-standard-sections').slideUp(200, function () {
                setRequiredAttrs('standard', false);
            });
            // Always hide regulatory when showing intern form
            toggleRegulatorySection(false);
            $('#jam-intern-sections').slideDown(350);
            setRequiredAttrs('intern', true);
            showBadge('intern');
            updateFormTitle('intern');
        }

        // Show consent + submit and reCAPTCHA
        $('#jam-submit-block').slideDown(250);
        if ($('#jam-recaptcha-block').length) {
            $('#jam-recaptcha-block').slideDown(250);
        }
        $('#jam-type-indicator').slideDown(200);

        // Scroll to first revealed section
        setTimeout(function () {
            var $target = type === 'standard'
                ? $('#jam-standard-sections .jam-section:first')
                : $('#jam-intern-sections .jam-section:first');
            if ($target.length) {
                $('html,body').animate({ scrollTop: $target.offset().top - 120 }, 400);
            }
        }, 360);
    }

    /**
     * Show or hide the regulatory section and toggle required on its fields.
     */
    function toggleRegulatorySection(show) {
        var $section = $('#jam-regulatory-section');
        if (!$section.length) return;

        var $fields = $section.find('input, select');

        if (show) {
            $section.slideDown(300);
            // Re-apply required to the fields that have a * label
            $section.find('input:not([type="file"]), select').each(function () {
                var $label = $('label[for="' + $(this).attr('id') + '"]');
                if ($label.find('.jam-required').length) {
                    $(this).attr('required', 'required');
                }
            });
            $section.find('input[type="file"]').each(function () {
                var $label = $('label[for="' + $(this).attr('id') + '"]');
                if ($label.find('.jam-required').length) {
                    $(this).attr('required', 'required');
                }
            });
        } else {
            $section.slideUp(250, function () {
                // Strip required so hidden fields never block submit
                $fields.removeAttr('required');
                // Also clear any values to avoid accidental stale data
                $section.find('select').val('');
                $section.find('input:not([type="file"])').val('');
            });
        }
    }

    function isNonRegulatoryPosition(position, list) {
        var norm = position.toLowerCase();
        for (var i = 0; i < list.length; i++) {
            if (list[i].toLowerCase() === norm) return true;
        }
        return false;
    }

    /**
     * Toggle the `required` attribute on fields belonging to each form type.
     * Standard fields: inside #jam-standard-sections
     * Intern fields:   have class .jam-intern-field, plus file inputs inside #jam-intern-sections
     */
    function setRequiredAttrs(type, enable) {
        var $container = type === 'standard'
            ? $('#jam-standard-sections')
            : $('#jam-intern-sections');

        // Text / select / textarea / email / tel / number / date inputs
        $container.find('input:not([type="file"]):not([type="checkbox"]), select, textarea').each(function () {
            var $el = $(this);
            // Never touch optional fields (those without jam-required label)
            var fieldName = $el.attr('name') || '';
            // Skip fields we know are optional (no required label)
            var $label = $('label[for="' + $el.attr('id') + '"]');
            var hasRequiredMark = $label.find('.jam-required').length > 0;
            if (hasRequiredMark || $el.attr('data-required') === 'true') {
                if (enable) {
                    $el.attr('required', 'required');
                } else {
                    $el.removeAttr('required');
                }
            }
        });

        // File inputs with required class
        $container.find('input[type="file"]').each(function () {
            var $el    = $(this);
            var $label = $('label[for="' + $el.attr('id') + '"]');
            if ($label.find('.jam-required').length > 0) {
                if (enable) { $el.attr('required', 'required'); }
                else         { $el.removeAttr('required'); }
            }
        });
    }

    function showBadge(type) {
        var $badge = $('#jam-type-badge');
        if (type === 'intern') {
            $badge.removeClass('jam-badge--standard').addClass('jam-badge--intern')
                  .html('<span>📋</span> ' + escHtml(JAM.i18n.intern_form_label));
        } else {
            $badge.removeClass('jam-badge--intern').addClass('jam-badge--standard')
                  .html('<span>💼</span> ' + escHtml(JAM.i18n.standard_form_label));
        }
    }

    function updateFormTitle(type) {
        var $subtitle = $('#jam-form-subtitle');
        if (type === 'intern') {
            $subtitle.text(JAM.i18n.intern_subtitle);
        } else {
            $subtitle.text(JAM.i18n.standard_subtitle);
        }
    }

    // ══════════════════════════════════════════════════════════════════════
    // FILE DROP ZONES
    // ══════════════════════════════════════════════════════════════════════
    function initFileDropZones() {
        $(document).on('dragover dragenter', '.jam-file-drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('jam-drag-over');
        });
        $(document).on('dragleave dragend', '.jam-file-drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('jam-drag-over');
        });
        $(document).on('drop', '.jam-file-drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $drop   = $(this);
            $drop.removeClass('jam-drag-over');
            var files   = e.originalEvent.dataTransfer.files;
            var $input  = $drop.find('.jam-file-input');
            var isMulti = $drop.data('multiple') === true || $drop.data('multiple') === 'true';
            if (files.length) {
                setInputFiles($input[0], files);
                handleFileChange($drop, $input, files, isMulti);
            }
        });
        $(document).on('change', '.jam-file-input', function () {
            var $input  = $(this);
            var $drop   = $input.closest('.jam-file-drop');
            var isMulti = $drop.data('multiple') === true || $drop.data('multiple') === 'true';
            handleFileChange($drop, $input, this.files, isMulti);
        });
    }

    function handleFileChange($drop, $input, files, isMulti) {
        var $preview  = $drop.find('.jam-file-preview');
        var fieldName = $drop.data('target');
        var $errMsg   = $('[data-for="' + fieldName + '"]');

        $preview.empty();
        $drop.removeClass('jam-has-files jam-field-error');
        $errMsg.text('').hide();

        if (!files || files.length === 0) return;
        if (isMulti && files.length > JAM_MAX_CERTS) {
            showDropError($drop, $errMsg, JAM.i18n.max_certs);
            return;
        }

        var allValid = true;
        Array.from(files).forEach(function (file) {
            if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                showDropError($drop, $errMsg, JAM.i18n.file_wrong_type);
                allValid = false;
                return;
            }
            if (file.size > JAM_MAX_SIZE) {
                showDropError($drop, $errMsg, JAM.i18n.file_too_large + ' (' + file.name + ')');
                allValid = false;
                return;
            }
            $preview.append(buildPreviewItem(file));
        });

        if (allValid) $drop.addClass('jam-has-files');
    }

    function showDropError($drop, $errMsg, msg) {
        $drop.addClass('jam-field-error');
        $errMsg.text(msg).show();
    }

    function buildPreviewItem(file) {
        return $(
            '<div class="jam-file-preview-item">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>' +
            '<span class="jam-file-preview-name">' + escHtml(file.name) + '</span>' +
            '<span class="jam-file-preview-size">' + fmtBytes(file.size) + '</span>' +
            '</div>'
        );
    }

    function setInputFiles(inputEl, files) {
        try {
            var dt = new DataTransfer();
            Array.from(files).forEach(function (f) { dt.items.add(f); });
            inputEl.files = dt.files;
        } catch (e) { /* fallback */ }
    }

    // ══════════════════════════════════════════════════════════════════════
    // CONSENT CHECKBOX
    // ══════════════════════════════════════════════════════════════════════
    function initConsentHighlight() {
        $(document).on('change', '#jam_consent', function () {
            if ($(this).is(':checked')) {
                $(this).closest('.jam-consent-label').removeClass('jam-consent-error');
                $('#jam-consent-error').text('').hide();
            }
        });
    }

    // ══════════════════════════════════════════════════════════════════════
    // FORM SUBMISSION
    // ══════════════════════════════════════════════════════════════════════
    function initFormSubmit() {
        $(document).on('submit', '#jam-application-form', function (e) {
            e.preventDefault();

            if (!currentFormType) {
                return; // Position not selected yet
            }

            var $form   = $(this);
            var $btn    = $('#jam-submit-btn');
            var $btnTxt = $btn.find('.jam-btn-text');
            var $errBox = $('#jam-error-message');
            var $sucBox = $('#jam-success-message');

            if (!clientValidate($form)) return;

            // reCAPTCHA check
            if (JAM.recaptcha_active === '1') {
                var token = typeof grecaptcha !== 'undefined' ? grecaptcha.getResponse() : '';
                if (!token) {
                    $('#jam-recaptcha-error').text(JAM.i18n.recaptcha_required).show();
                    scrollTo($('#jam-recaptcha-error'));
                    return;
                }
                $('#jam-recaptcha-error').text('').hide();
            }

            $btn.addClass('jam-loading').prop('disabled', true);
            $btnTxt.text(JAM.i18n.submitting);
            $errBox.hide().html('');
            $sucBox.hide().html('');

            var formData = new FormData($form[0]);
            formData.append('action', 'jam_submit_application');

            $.ajax({
                url:         JAM.ajaxurl,
                type:        'POST',
                data:        formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        $form.slideUp(300, function () {
                            $sucBox.html(successCard(res.data.message)).slideDown(300);
                        });
                        scrollTo($('#jam-application-form-wrapper'));
                    } else {
                        var msg = (res.data && res.data.message) ? res.data.message : JAM.i18n.error_generic;
                        $errBox.html(msg).slideDown(200);

                        if (res.data && res.data.fields) {
                            res.data.fields.forEach(function (field) {
                                if (field === 'jam_consent') {
                                    $('#jam_consent').closest('.jam-consent-label').addClass('jam-consent-error');
                                    $('#jam-consent-error').text(JAM.i18n.consent_required).show();
                                } else {
                                    $('#' + field).addClass('jam-field-error');
                                }
                            });
                        }
                        scrollTo($errBox);
                    }
                },
                error: function () {
                    $errBox.text(JAM.i18n.error_generic).slideDown(200);
                    scrollTo($errBox);
                },
                complete: function () {
                    $btn.removeClass('jam-loading').prop('disabled', false);
                    $btnTxt.text(JAM.i18n.submit);
                },
            });
        });

        $(document).on('input change', '.jam-field-error', function () {
            $(this).removeClass('jam-field-error');
        });
    }

    // ── Client-side validation ────────────────────────────────────────────
    function clientValidate($form) {
        var valid = true;

        clearFormErrors();

        // Only validate fields within the active container
        var $container = currentFormType === 'intern'
            ? $('#jam-intern-sections')
            : $('#jam-standard-sections');

        // Required text/select/textarea/date inputs in active container
        $container.find('input[required], select[required], textarea[required]')
            .not('[type="file"]').not('[type="checkbox"]').each(function () {
                var $el = $(this);
                if (!$.trim($el.val())) {
                    $el.addClass('jam-field-error');
                    var $err = $('[data-for="' + ($el.attr('name') || $el.attr('id')) + '"]').first();
                    if ($err.length) $err.text('This field is required.').show();
                    valid = false;
                }
            });

        // Email format (check whichever email field is visible)
        var $emailField = $container.find('input[type="email"]').first();
        if ($emailField.val() && !isEmail($emailField.val())) {
            $emailField.addClass('jam-field-error');
            $('[data-for="jam_email"]').text('Please enter a valid email address.').show();
            valid = false;
        }

        // Required file inputs in active container — skip hidden regulatory section
        $container.find('input[type="file"][required]').each(function () {
            var $input = $(this);
            // Skip if inside a hidden parent
            if ($input.closest('#jam-regulatory-section').length &&
                !$input.closest('#jam-regulatory-section').is(':visible')) {
                return;
            }
            if (!$input[0].files || $input[0].files.length === 0) {
                var $drop = $input.closest('.jam-file-drop');
                $drop.addClass('jam-field-error');
                $('[data-for="' + $drop.data('target') + '"]').text('Please upload the required document.').show();
                valid = false;
            }
        });

        // Position always required
        var $pos = $('#jam_job_listing');
        if (!$pos.val()) {
            $pos.addClass('jam-field-error');
            $('[data-for="jam_job_listing"]').text('Please select a position.').show();
            valid = false;
        }

        // Consent
        if (!$('#jam_consent').is(':checked')) {
            $('#jam_consent').closest('.jam-consent-label').addClass('jam-consent-error');
            $('#jam-consent-error').text(JAM.i18n.consent_required).show();
            valid = false;
        }

        if (!valid) {
            var $first = $form.find('.jam-field-error, .jam-error-msg:visible, .jam-consent-error').first();
            if ($first.length) scrollTo($first, -80);
        }

        return valid;
    }

    function clearFormErrors() {
        $('#jam-application-form').find('.jam-field-error').removeClass('jam-field-error');
        $('#jam-application-form').find('.jam-error-msg').text('').hide();
        $('.jam-consent-label').removeClass('jam-consent-error');
    }

    // ── Helpers ───────────────────────────────────────────────────────────
    function successCard(message) {
        return '<div class="jam-success-card">' +
            '<div class="jam-success-icon">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>' +
            '</div>' +
            '<p style="font-size:16px;color:#1a1f3c;margin:0;">' + escHtml(message) + '</p>' +
            '</div>';
    }

    function isEmail(v)   { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }

    function fmtBytes(b) {
        if (!b) return '0 B';
        var k = 1024, s = ['B','KB','MB'];
        var i = Math.floor(Math.log(b) / Math.log(k));
        return parseFloat((b / Math.pow(k, i)).toFixed(1)) + ' ' + s[i];
    }

    function escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function scrollTo($el, offset) {
        if (!$el || !$el.length) return;
        $('html,body').animate({ scrollTop: $el.offset().top + (offset || -100) }, 400);
    }

}(jQuery));
