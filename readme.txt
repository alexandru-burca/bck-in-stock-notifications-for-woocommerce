=== Back in stock notifications for WooCommerce ===
Contributors: getinnovationdev, wpsimplesolutions
Tags: woocommerce, back in stock, out of stock, woocommerce notifications, back in stock notifications
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 8.3
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Let customers subscribe for back in stock alerts on out-of-stock WooCommerce products — customisable form, personalised emails, and live preview.

== Description ==
**Back in Stock Notifications for WooCommerce** adds a Subscribe button to out-of-stock products. When a customer clicks it, a customisable modal form collects their email (and optionally their name). When the product is back in stock, the plugin sends them a personalised notification email automatically — or you can trigger it manually.

Supports simple and variable products.

= Main Features =
✔️ Subscribe button on out-of-stock product pages (simple & variable)
✔️ **Subscribe button on shop & listing pages** — appears on product tiles in shop, category, search, and related product sections
✔️ **Button Visibility control** — show on both, single product page only, shop/listing pages only, or disable entirely
✔️ Customisable modal form — title, button text, before/after text
✔️ **Live form preview** — see the button and modal exactly as customers will, before going live
✔️ Personalised confirmation and back-in-stock notification emails
✔️ **Send Test Email** — preview any email template with real product data before sending to customers
✔️ Default email templates included (ready to use out of the box)
✔️ Merge tags for dynamic content (name, email, product title, price, URL, quantity)
✔️ Automatically mode — notifications sent when WooCommerce stock status changes
✔️ Manually mode — trigger notifications from the product page when you're ready
✔️ Pause notifications for specific products
✔️ Filter and search subscriptions by product or email
✔️ Bulk export subscribers to CSV
✔️ Customisable button colours (background & text)
✔️ First & Last Name fields (optional — enable or disable per your preference)
✔️ Duplicate subscription prevention
✔️ reCAPTCHA v2 to block spam subscriptions
✔️ HubSpot integration — auto-create or update contacts on every subscription

= Subscription Form Preview =
Click the **Preview** button on the Subscription Form settings page to open a dedicated preview page. It shows the exact Subscribe button (with your saved colours and text) on a clean canvas — click it to open the modal and inspect the layout, title, fields, and before/after text. Submission is disabled so it's completely safe to test.

= Send Test Email =
Each email template (Confirmation and Back in Stock Notification) has a **Send Test Email** button. Click it to open a dedicated test page where you can:

* Search for any product (or select a specific variation)
* Enter any recipient email (pre-filled with your admin email)
* Send the email immediately — merge tags are replaced with real product data

The subject is prefixed with `[TEST]` so you can distinguish it from live emails. Subscriber name tags (`[wsnm-first-name]`, `[wsnm-last-name]`) are substituted with sample values (John / Doe).

= Subscriptions =
Each subscription stores:

* First Name (optional)
* Last Name (optional)
* Email
* Status (Waiting, Sent, Paused)
* Product (Simple or Variable)

Duplicate subscriptions are prevented. If someone with the same email tries to subscribe to the same product again, a warning message is shown instead.

Subscriptions can be filtered by product, searched by email, and exported in CSV format from the WordPress admin.

= Merge Tags =
Use these tags in email subject lines and body content:

* `[wsnm-first-name]` – Subscriber's first name
* `[wsnm-last-name]` – Subscriber's last name
* `[wsnm-email]` – Subscriber's email address
* `[wsnm-product-title]` – Product name (including variation name if applicable)
* `[wsnm-product-price]` – Product price with currency symbol
* `[wsnm-product-quantity]` – Available stock quantity, or "unlimited" if unmanaged
* `[wsnm-product-url]` – Direct link to the product (variation pre-selected for variable products)

= Integrations =

**reCAPTCHA v2**

Add a "I'm not a robot" checkbox to the subscribe form to block automated spam submissions. Requires a free Google reCAPTCHA v2 account. Configure your Site Key and Secret Key under Settings → Integrations.

**HubSpot**

Connect to your HubSpot account to automatically create or update a contact every time someone subscribes:

* Each subscriber is created as a HubSpot contact (email, first name, last name)
* If a contact with the same email already exists, it is found and reused — no duplicates
* A note is attached to the contact with the name of the subscribed product
* The sync result (contact link or error) is visible on each subscription's detail page in the WordPress admin

To connect: go to Settings → Integrations, enable HubSpot, paste your Private App token (requires the `crm.objects.contacts.write` scope), and click **Check connection** to verify.

= Developer Filters =
The plugin exposes the following filters:

* `wsnm-text-cta` – Override the subscribe button text shown on the product page
* `wsnm-modal-title` – Override the modal header text
* `wsnm-modal-form-button` – Override the submit button text inside the modal

= External Services =
This plugin optionally connects to the following third-party services. These connections are only made when you explicitly enable the corresponding integration in **Settings → Integrations**.

**Google reCAPTCHA v2** (optional)
Used to verify that subscription form submissions are made by a human. When enabled, the reCAPTCHA script is loaded from Google's servers and the form response is verified against Google's API.

* Service: [Google reCAPTCHA](https://www.google.com/recaptcha/)
* Data sent: user's reCAPTCHA response token and IP address
* Privacy Policy: [https://policies.google.com/privacy](https://policies.google.com/privacy)
* Terms of Service: [https://policies.google.com/terms](https://policies.google.com/terms)

**HubSpot** (optional)
Used to automatically create or update a CRM contact when someone subscribes. Subscriber name, email, and the subscribed product name are sent to HubSpot.

* Service: [HubSpot CRM API](https://developers.hubspot.com/)
* Data sent: subscriber email address, first name, last name, subscribed product name
* Privacy Policy: [https://legal.hubspot.com/privacy-policy](https://legal.hubspot.com/privacy-policy)
* Terms of Service: [https://legal.hubspot.com/terms-of-service](https://legal.hubspot.com/terms-of-service)

== Installation ==
1. Upload `back-in-stock-notifications-for-woocommerce` to the `/wp-content/plugins/` directory
2. Activate the plugin through the **Plugins** menu in WordPress
3. Go to **Back in Stock → Settings** to configure the plugin

== Frequently Asked Questions ==

= Which product types are supported? =
Simple and variable products.

= What is manually mode? =
Manually mode gives you full control. Notifications are triggered by an administrator directly from the WooCommerce product edit page. This is the default mode.

= What is automatically mode? =
In automatically mode, notifications are sent as soon as a product's stock status changes to "in stock" in WooCommerce. You can still pause specific products if needed.

= Can I preview the subscribe form before it goes live? =
Yes. Go to **Settings → Subscription Form** and click the **Preview** button. A dedicated preview page shows the exact button and modal using your current settings. Submission is disabled so it's completely safe to use.

= Can I test my email templates? =
Yes. On the **Settings → Email Templates** page, each email section has a **Send Test Email** button. Select a product, confirm the recipient address, and click send — the email is delivered using real product data with a `[TEST]` prefix in the subject.

= Can I control where the subscribe button appears? =
Yes. Go to **Settings → General** and find the **Button Visibility** option under Button Style. Choose from: show on both (default), single product page only, shop/listing pages only, or disabled.

= How do I connect HubSpot? =
Go to **Settings → Integrations**, enable the HubSpot toggle, paste your Private App token (with the `crm.objects.contacts.write` scope), and click **Check connection** to verify.

= I've still got questions. Where can I find answers? =
Check out our [documentation](https://www.getinnovation.dev/wordpres-plugins/woocommerce-stock-notify-me/documentation/) or visit the [support forum](https://wordpress.org/support/plugin/back-in-stock-notifications-for-woocommerce/).

== Screenshots ==
1. Settings - General
2. Settings - Subscription Form with Preview button
3. Subscription Form Preview page
4. Settings - Email Templates with Send Test Email buttons
5. Send Test Email page
6. Settings - Integrations (reCAPTCHA & HubSpot)
7. Subscribe button on an out-of-stock product page
8. Subscribe modal form
9. All Subscriptions list
10. Subscription detail page (with HubSpot sync status)
11. Manually Mode - Send Notifications from product page
12. Automatically Mode - Notification status

== Changelog ==
= 1.0.2 =
* Subscribe button now appears on shop, category, search, and related product tiles (in addition to the single product page)
* Added **Button Visibility** setting — choose to show the button on both pages, single product only, shop/listing pages only, or disable it entirely
* HubSpot: a note is now attached to existing contacts on re-subscription (previously only attached to newly created contacts)
* Fixed: confirmation email now respects the Enable/Disable toggle in Email Templates settings
* Fixed: subscribe button no longer duplicates when themes show availability text in product loops
* Added subscription form **Preview** page — see the button and modal with your saved settings before going live
* Added **Send Test Email** for both email templates — pick a product, enter an address, and send a real test with merge tags replaced
* Dedicated admin pages for Preview and Test Email
* Improved settings UI: responsive two-column layout with contextual help sidebar on all settings pages
* Added direct submenu links: Subscription Form, Email Templates, Integrations
* Moved reCAPTCHA settings from Subscription Form tab to Integrations tab
* Added Support link in settings navigation
* Compatibility with WordPress 6.7 and WooCommerce 9.4
* Minimum PHP version raised to 8.3
* Declared WooCommerce HPOS (High-Performance Order Storage) compatibility
* Fixed unprepared SQL query in background action handler
* Replaced file_get_contents() with wp_remote_post() for reCAPTCHA verification
* Fixed reCAPTCHA script loaded via proper wp_enqueue_script()
* Fixed MySQL 8 strict mode incompatibility in database schema defaults
* Automatic database schema migration for existing installations
* Added HubSpot integration: automatically creates contacts and attaches a product note on each new subscription

= 1.0.1 =
* Manage button text and modal title
* Tested with the latest WP and WC versions

= 1.0.0 =
* First release

== Upgrade Notice ==
= 1.0.2 =
New: subscribe button on shop/listing pages with visibility control, HubSpot note on re-subscription, subscription form Preview, Send Test Email, improved settings UI. Fixes: confirmation email toggle, duplicate button in loops, and several security hardening items.
