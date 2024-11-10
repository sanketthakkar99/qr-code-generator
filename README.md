# QR Code Generator Plugin for WordPress

**QR Code Generator** is a simple WordPress plugin that allows users to generate QR codes dynamically using a shortcode. It uses the `endroid/qr-code` PHP library to generate QR codes based on user input.

## Features

- Easily generate QR codes from text input.
- Includes a simple form with Bootstrap styling.
- Uses the `endroid/qr-code` library for generating QR codes.
- Stores generated QR codes in the WordPress uploads directory.
- Provides a shortcode for easy integration on any page or post.

## Requirements

- WordPress 6.0 or higher.
- PHP 8.0 or higher.

## Installation

1. **Upload the Plugin:**
   - Download the plugin and upload it to your WordPress site's `wp-content/plugins/` directory.

2. **Activate the Plugin:**
   - Go to the **Plugins** section in your WordPress admin panel and activate the **QR Code Generator** plugin.

## Usage

To use the QR code generator form on any page or post, simply add the following shortcode:

```plaintext
[generate_qr_code_form]
