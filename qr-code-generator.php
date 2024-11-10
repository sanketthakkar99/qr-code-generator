<?php
/**
 * Plugin Name: QR Code Generator
 * Description: A simple WordPress plugin to generate QR codes dynamically using user input.
 * Version: 1.0
 * Author: Sanket Thakkar
 * Text Domain: qr-code-generator
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Autoload the QR code library.
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Enqueue Bootstrap CSS for the form styling.
function qr_code_generator_enqueue_assets() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', [], '5.0.2');
}
add_action('wp_enqueue_scripts', 'qr_code_generator_enqueue_assets');

// Handle QR code generation and display the form.
function qr_code_generator_form() {
    $image_code = '';

    // Handle form submission.
    if (isset($_POST['qr_create']) && !empty($_POST['qr_content'])) {
        $temporary_directory = wp_upload_dir()['basedir'] . '/qr-codes/';
        $file_name = md5(uniqid()) . '.png';
        $file_path = $temporary_directory . $file_name;

        // Create the QR code directory if it doesn't exist.
        if (!file_exists($temporary_directory)) {
            wp_mkdir_p($temporary_directory);
        }

        // Generate the QR code.
        $qr_code = new QrCode(trim(sanitize_text_field($_POST['qr_content'])));
        $qr_code->setSize(300);

        // Write the QR code to a PNG file.
        $writer = new PngWriter();
        $result = $writer->write($qr_code);
        $result->saveToFile($file_path);

        // Get the URL of the generated QR code image.
        $file_url = wp_upload_dir()['baseurl'] . '/qr-codes/' . $file_name;
        $image_code = '<div class="text-center mt-3"><img src="' . esc_url($file_url) . '" alt="QR Code" /></div>';
    }

    // Display the form.
    ob_start();
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">QR Code Generator</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="qr_content">Enter Content</label>
                                <input type="text" id="qr_content" name="qr_content" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="qr_create" class="btn btn-primary" value="Generate QR Code" />
                            </div>
                            <?php echo $image_code; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Register the shortcode.
function qr_code_generator_register_shortcode() {
    add_shortcode('generate_qr_code_form', 'qr_code_generator_form');
}
add_action('init', 'qr_code_generator_register_shortcode');
