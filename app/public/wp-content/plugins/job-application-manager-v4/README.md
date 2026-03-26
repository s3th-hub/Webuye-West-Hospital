# Job Application Manager – WordPress Plugin

**Version:** 1.0.0  
**Requires WordPress:** 5.8+  
**Requires PHP:** 7.4+  
**Compatible with:** Hello Elementor theme, Elementor page builder

---

## Overview

A fully self-contained WordPress plugin that lets users submit job applications via a styled frontend form. All submissions are stored as a custom post type in the WordPress backend, with email notifications, status tracking, and CSV export.

---

## Installation

1. **Upload the plugin folder**  
   Copy the entire `job-application-manager/` folder into your WordPress plugins directory:
   ```
   wp-content/plugins/job-application-manager/
   ```

2. **Activate the plugin**  
   Go to **WordPress Admin → Plugins → Installed Plugins** and activate **Job Application Manager**.

3. **Configure email settings**  
   Go to **Job Applications → Settings** and set:
   - Admin recipient email
   - Admin email subject line
   - Applicant confirmation subject line

---

## Usage

### Embedding the Form

Use the shortcode on any WordPress page or inside an **Elementor Shortcode widget**:

```
[job_application_form]
```

**With a pre-filled job title:**
```
[job_application_form job_listing="Senior Registered Nurse" title="Apply – Senior Registered Nurse"]
```

**Shortcode attributes:**

| Attribute      | Default                   | Description                          |
|----------------|---------------------------|--------------------------------------|
| `job_listing`  | *(empty)*                 | Pre-fills (and hides) the position field |
| `title`        | `Job Application Form`    | Heading shown above the form         |

### Inside Elementor

1. Edit your page with Elementor
2. Search for the **Shortcode** widget
3. Paste `[job_application_form]` into the widget
4. Save and preview — the form inherits your theme's container width

---

## Admin Features

### Viewing Applications

Go to **Job Applications** in the WordPress admin sidebar. You'll see:

- Applicant name, email, phone
- Regulatory body
- Position applied for
- Status badge (Pending / Reviewed / Accepted / Rejected)
- Submission date

**Filter** applications by status using the dropdown above the list.

### Viewing an Individual Application

Click any application to open its detail view. You'll see three meta boxes:

| Meta Box              | Contents                                           |
|-----------------------|----------------------------------------------------|
| Application Details   | All text fields (name, phone, email, ID, education, regulatory info) |
| Application Status    | Status dropdown + position field (editable)        |
| Uploaded Documents    | Clickable download links for all uploaded PDFs      |

### Changing Application Status

In the **Application Status** sidebar meta box, select a status and click **Update**:
- Pending
- Reviewed
- Accepted
- Rejected

### Exporting to CSV

Click **Export as CSV** button on the applications list page, or go to **Job Applications → Settings → Download CSV Export**.

The CSV includes all text fields plus direct URLs to uploaded documents.

---

## Form Fields

| # | Field | Required | Notes |
|---|-------|----------|-------|
| 1 | Full Names (According to ID) | ✅ | |
| 2 | Phone Number | ✅ | |
| 3 | Email Address | ✅ | Validated format |
| 4 | National ID / Passport Number | ✅ | |
| 5 | Upload ID/Passport | ✅ | PDF only, max 10MB, front & back combined |
| 6 | Highest Level of Education | ✅ | |
| 7 | Upload Academic Certificates | ✅ | Up to 5 PDFs, max 10MB each |
| 8 | Regulatory Body | ✅ | Dropdown: NCK, COC, KMLTTB, PPB, KASNEB, HRIMB |
| 9 | Regulatory Registration Number | ✅ | |
| 10 | Upload Regulatory Registration Certificate | ✅ | PDF only, max 10MB |
| 11 | Current License/Practice Number | ✅ | |
| 12 | Upload Current License/Practice Certificate | ✅ | PDF only, max 10MB |

---

## Security

- **Nonce verification** on every form submission
- **Honeypot field** for basic spam protection
- **MIME type validation** using `finfo` – files must be genuine PDFs (not just renamed)
- **File size enforcement** (10MB per file)
- **Extension check** (.pdf only)
- All inputs are **sanitized** (`sanitize_text_field`, `sanitize_email`, `absint`)
- All outputs are **escaped** (`esc_html`, `esc_attr`, `esc_url`)
- File uploads stored in `/wp-content/uploads/job-applications/`

---

## Email Notifications

On each successful submission:

1. **Admin notification** – sent to the configured admin email with full applicant details and links to uploaded documents, plus a link to the application in the backend.

2. **Applicant confirmation** – sent to the applicant's email with a summary of their submission.

Both emails use WordPress `wp_mail()` and are fully compatible with SMTP plugins (WP Mail SMTP, FluentSMTP, Postman, etc.).

---

## Plugin Folder Structure

```
job-application-manager/
├── job-application-manager.php      ← Main plugin file
├── README.md
│
├── includes/
│   ├── class-jam-post-type.php      ← Custom post type & meta registration
│   ├── class-jam-form-handler.php   ← AJAX handler: validation, upload, save
│   ├── class-jam-email.php          ← Admin & applicant email notifications
│   ├── class-jam-shortcode.php      ← [job_application_form] shortcode
│   └── class-jam-export.php         ← CSV export
│
├── admin/
│   ├── class-jam-admin.php          ← Admin list columns, meta boxes, filters
│   ├── class-jam-settings.php       ← Settings page
│   └── views/
│       ├── meta-box-details.php     ← Application details meta box view
│       ├── meta-box-status.php      ← Status sidebar view
│       └── meta-box-docs.php        ← Documents meta box view
│
├── frontend/
│   ├── class-jam-frontend.php       ← Enqueue frontend assets
│   └── views/
│       └── form.php                 ← HTML form template
│
└── assets/
    ├── css/
    │   ├── frontend.css             ← Form styles (Manrope + Inter, #2e4592)
    │   └── admin.css                ← Admin styles
    └── js/
        └── frontend.js              ← AJAX submit, file validation, drag-and-drop
```

---

## Compatibility

| Environment | Status |
|-------------|--------|
| WordPress 5.8+ | ✅ |
| WordPress 6.x | ✅ |
| PHP 7.4+ | ✅ |
| PHP 8.x | ✅ |
| Hello Elementor theme | ✅ |
| Elementor page builder | ✅ |
| Classic Editor | ✅ |
| WooCommerce | ✅ (no conflict) |
| SMTP plugins | ✅ (uses wp_mail) |
| Multisite | ⚠️ Not tested |

---

## Extending the Plugin

### Adding More Regulatory Bodies

Open `includes/class-jam-post-type.php` and edit the `get_regulatory_bodies()` method:

```php
public static function get_regulatory_bodies() {
    return [ 'NCK', 'COC', 'KMLTTB', 'PPB', 'KASNEB', 'HRIMB', 'YOUR_BODY' ];
}
```

### Customising Email Templates

Edit `includes/class-jam-email.php`. The email templates use plain inline-CSS HTML for maximum mail client compatibility.

### Customising the Form

Edit `frontend/views/form.php`. All field wrappers use the class `jam-field-group`. Add new sections following the existing pattern with the `.jam-section` wrapper.

---

## Frequently Asked Questions

**Q: Where are uploaded files stored?**  
A: In `/wp-content/uploads/job-applications/`. They are also registered in the WordPress Media Library and attached to the application post.

**Q: Can I use this with Contact Form 7 or WPForms installed?**  
A: Yes. This plugin is completely independent and does not conflict with other form plugins.

**Q: Why do I need to install the plugin manually?**  
A: This plugin is not in the WordPress.org plugin directory. Upload it via Plugins → Add New → Upload Plugin, or via FTP/SFTP.

**Q: How do I enable SMTP for email delivery?**  
A: Install any SMTP plugin (e.g. WP Mail SMTP). This plugin uses the standard `wp_mail()` function which SMTP plugins automatically override.
