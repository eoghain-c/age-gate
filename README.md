# Cannabis Age Gate Plugin

The **Cannabis Age Gate** plugin adds a Canadian-compliant age verification gate to your WordPress website. This plugin ensures that visitors must confirm their age and location before accessing the site, adhering to Canadian laws regarding the sale of cannabis products online.

## Features

- **Custom Age Gate Page**: A dedicated age gate page that users must pass through to enter the website.
- **Province-Specific Legal Age**: Automatically calculates legal age based on the selected province (19 by default, 18 for Alberta, 21 for Quebec).
- **Session and Cookie Management**: Users who pass the age gate will have their session extended via cookies, allowing them to browse the site without repeated verifications.
- **Admin Options**: Configurable settings using Advanced Custom Fields (ACF) in the WordPress admin dashboard.

## Installation

1.  **Upload the Plugin Files**:

    - Download the plugin files.
    - Upload the `cannabis-age-gate` folder to the `/wp-content/plugins/` directory of your WordPress installation.

2.  **Activate the Plugin**:

    - Go to the `Plugins` page in your WordPress dashboard.
    - Find the "Cannabis Age Gate" plugin in the list and click "Activate."

3.  **Configure the Plugin**:

    - Make sure that the [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/) plugin is installed and activated.
    - Navigate to `Age Gate` under the `Settings` menu in your WordPress dashboard to configure the plugin options.

## Usage

Once activated, the plugin will automatically redirect users to the age gate page (`/age-gate`) when they first visit the site. The age gate page requires users to select their province and enter their date of birth to confirm that they are of legal age to access the site.

### Customization

You can customize the content of the age gate page using the ACF options provided:

- **Logo**: Upload a custom logo to be displayed on the age gate page.
- **Heading**: Customize the heading text.
- **Message**: Customize the message that users see on the age gate page.
- **Error Message**: Customize the error message shown to users who do not meet the legal age requirement.

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Advanced Custom Fields (ACF) plugin

## FAQ

### How does the plugin determine the legal age for different provinces?

The plugin automatically sets the legal age based on the province selected by the user:

- **Alberta (AB)**: 18 years
- **Quebec (QC)**: 21 years
- **All other provinces**: 19 years

### Can I customize the design of the age gate page?

Yes, you can customize the CSS for the age gate page by adding custom styles to your theme’s stylesheet or using the `wp_head` hook in the plugin's template file.

### What happens if a user doesn't meet the age requirement?

If a user doesn’t meet the legal age requirement, they will be redirected back to the age gate page and shown an error message. They will not be allowed to proceed to the main website.
