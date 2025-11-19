<?php
/**
 * Template Name: Event Ticket
 * Version: 1.0
 * Description: A custom ticket for the Event Registration Form.
 * Author: Samuel Turay
 * Author URI: https://gravitypdf.com
 * Group: Custom Sam
 * License: GPLv2
 * Required PDF Version: 4.0-alpha
 * Tags: custom, wordpress, simplifyBiz
 */

/* Prevent direct access to the template */
if (!class_exists('GFForms')) {
    return;
}
/**
 * -----------------------------------------------------------------
 * GLOBAL VARIABLES
 * @var array $form Access the Gravity Forms 'form' object
 * @var array $entry Access the Gravity Forms 'entry' object
 * @var array $form_data A 'friendly' array containing all the
 * form field data and their values
 * @var array $settings Access the PDF settings for this feed
 * * -----------------------------------------------------------------
 */

$first_name = $entry['1.3'];
$last_name = $entry['1.6'];
$event_name = $form_data['field']['20_name'];
$event_attendee = $form_data['field'][21];
$add_ons = $form_data['field']['22_name'];

?>

<style>
    .ticket-wrapper {
        background: #D8E2FE;
        background: linear-gradient(90deg, rgba(216, 226, 254, 1) 0%,
        rgba(235, 255, 236, 1) 50%, rgba(255, 249, 235, 1) 100%);

        border: 1px solid #ccc;
        padding: 30px;
        font-family: Arial, sans-serif;
        color: #333;
    }
    .ticket-header {
        border-bottom: 2px dashed #aaa;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }
    .ticket-header img {
        width: 150px;
        display: block;
        margin: 0 auto 20px;
    }
    .ticket-header h1 {
        margin: 0;
        font-size: 32px;
    }
    .ticket-details {
        font-size: 16px;
        line-height: 1.8;
    }
    .ticket-details strong {
        display: inline-block;
        width: 130px;
    }
    .qr-code {
        text-align: center;
        margin-top: 30px;
        border-top: 2px dashed #aaa;
        padding-top: 25px;
    }
</style>

<div class="ticket-wrapper">

    <div class="ticket-header">
        <img src="https://samuel-turay.sblik.com/wp-content/uploads/2025/11/simplify-logo.png" alt="Company Logo"/>

        <h1>🎟️ Event Ticket</h1>
    </div>

    <div class="ticket-details">
        <p>
            <strong>Registrant:</strong> <?php echo esc_html($first_name . ' ' . $last_name); ?>
        </p>

        <p>
            <strong>Event:</strong> <?php echo esc_html($event_name); ?>
        </p>

        <p>
            <strong>Attendees:</strong> <?php echo esc_html($event_attendee); ?>
        </p>

        <?php
        if (!empty($add_ons)) :
            ?>
            <p>
                <strong>Add-ons:</strong> <?php echo esc_html(implode(', ', $add_ons)); ?>
            </p>
        <?php endif; ?>

    </div>

    <div class="qr-code">
        <barcode code="<?php echo $entry['id']; ?>" type="QR" size="0.9" error="M"></barcode>
        <p style="font-size: 12px; margin-top: 10px;">Scan this at the door</p>
    </div>

</div>

