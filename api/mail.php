<?php
error_reporting(0);
ini_set('display_errors', 0);

// Determine form type
$form_type = isset($_POST['form_type']) ? $_POST['form_type'] : 'booking';

// Include PHPMailer
require_once '../PHPMailer/PHPMailer-6.8.0/src/PHPMailer.php';
require_once '../PHPMailer/PHPMailer-6.8.0/src/SMTP.php';
require_once '../PHPMailer/PHPMailer-6.8.0/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// SMTP Configuration
$gmail_email = 'indiadaytrip@gmail.com';
$gmail_password = 'jdte txgv xgpq bfbh';
$admin_email = 'shivam.it1311@gmail.com';
$company_name = 'India Day Trip';

// Function to send email
function sendEmail($to, $subject, $body, $reply_to = null)
{
    global $gmail_email, $gmail_password, $company_name;

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $gmail_email;
        $mail->Password = $gmail_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($gmail_email, $company_name);
        $mail->addAddress($to);

        if ($reply_to) {
            $mail->addReplyTo($reply_to);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// ============ HANDLE BOOKING FORMS ============
if ($form_type === 'booking' || isset($_POST['first_name'])) {

    // Get booking form data
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $tour_name = isset($_POST['tour_name']) ? trim($_POST['tour_name']) : '';
    $tour_type = isset($_POST['tour_type']) ? trim($_POST['tour_type']) : '';
    $travel_date = isset($_POST['travel_date']) ? trim($_POST['travel_date']) : '';
    $adults = isset($_POST['adults']) ? trim($_POST['adults']) : '';
    $children = isset($_POST['children']) ? trim($_POST['children']) : '0';
    $special_requests = isset($_POST['special_requests']) ? trim($_POST['special_requests']) : '';

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        echo 'Please fill in all required fields.';
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Please enter a valid email address.';
        exit;
    }

    $full_name = $first_name . ' ' . $last_name;
    $tour_info = !empty($tour_name) ? $tour_name : $tour_type;
    $subject = "New Tour Booking - " . $tour_info;

    // ============ SEND EMAIL TO ADMIN ============
    $admin_message = "
    <html>
    <head>
        <title>New Tour Booking</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #113D48; border-bottom: 2px solid #1CA8CB; padding-bottom: 10px;'>New Tour Booking Request</h2>
            
            <table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; width: 40%;'>Tour Name:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($tour_info) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Travel Date:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($travel_date) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Number of Adults:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($adults) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Number of Children:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($children) . "</td>
                </tr>
            </table>
            
            <h3 style='color: #113D48; margin-top: 25px;'>Customer Details</h3>
            <table style='border-collapse: collapse; width: 100%;'>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; width: 40%;'>Full Name:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($full_name) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Email:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($email) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Phone:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($phone) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; vertical-align: top;'>Special Requests:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . (empty($special_requests) ? 'None' : htmlspecialchars($special_requests)) . "</td>
                </tr>
            </table>
            
            <p style='margin-top: 20px; color: #666; font-size: 12px;'>This is an automated booking notification from India Day Trip website.</p>
        </div>
    </body>
    </html>
    ";

    $admin_mail_sent = sendEmail($admin_email, $subject, $admin_message, $email);

    // ============ SEND CONFIRMATION EMAIL TO USER ============
    $user_subject = "Booking Confirmed - " . $tour_info;

    $user_message = "
    <html>
    <head>
        <title>Booking Confirmation</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #113D48; border-bottom: 2px solid #1CA8CB; padding-bottom: 10px;'>Thank You for Your Booking!</h2>
            
            <p>Dear " . htmlspecialchars($first_name) . ",</p>
            
            <p>We have received your booking request for <strong>" . htmlspecialchars($tour_info) . "</strong>.</p>
            
            <h3 style='color: #113D48; margin-top: 25px;'>Your Booking Details:</h3>
            <table style='border-collapse: collapse; width: 100%;'>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; width: 40%;'>Tour:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($tour_info) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Travel Date:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($travel_date) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Adults:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($adults) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Children:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($children) . "</td>
                </tr>
            </table>
            
            <div style='background-color: #f0f8ff; padding: 15px; border-radius: 8px; margin-top: 20px;'>
                <h4 style='margin: 0 0 10px 0; color: #113D48;'>What's Next?</h4>
                <p style='margin: 5px 0;'>Our team will contact you within 24 hours to confirm your booking and provide further details.</p>
                <p style='margin: 5px 0;'>If you have any urgent inquiries, please contact us at <strong>booking@indiadaytrip.com</strong> or call us directly.</p>
            </div>
            
            <p style='margin-top: 25px; color: #666; font-size: 12px;'>Thank you for choosing India Day Trip!</p>
            
            <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
            <p style='color: #999; font-size: 11px; text-align: center;'>
                " . htmlspecialchars($company_name) . "<br>
                Website: www.indiadaytrip.com
            </p>
        </div>
    </body>
    </html>
    ";

    $user_mail_sent = sendEmail($email, $user_subject, $user_message);

    // ============ RETURN RESPONSE ============
    if ($admin_mail_sent && $user_mail_sent) {
        echo 'Thank you! Your booking request has been submitted. We have sent a confirmation email to ' . htmlspecialchars($email) . '. We will contact you within 24 hours.';
    } elseif ($admin_mail_sent) {
        echo 'Your booking request has been submitted. However, we could not send confirmation email. We will contact you within 24 hours.';
    } else {
        echo 'Sorry, there was an error sending your message. Please try again or contact us directly at booking@indiadaytrip.com';
    }

    exit;
}

// ============ HANDLE CONTACT FORM ============
if ($form_type === 'contact' || isset($_POST['name'])) {

    // Get contact form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Contact Form Submission';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        echo 'Please fill in all required fields.';
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Please enter a valid email address.';
        exit;
    }

    $subject_line = "Contact Form: " . $subject;

    // ============ SEND EMAIL TO ADMIN ============
    $admin_message = "
    <html>
    <head>
        <title>New Contact Form Submission</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #113D48; border-bottom: 2px solid #1CA8CB; padding-bottom: 10px;'>New Contact Form Submission</h2>
            
            <table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; width: 40%;'>Name:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($name) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Email:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($email) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Phone:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . (empty($phone) ? 'Not provided' : htmlspecialchars($phone)) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;'>Subject:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($subject) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; vertical-align: top;'>Message:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . nl2br(htmlspecialchars($message)) . "</td>
                </tr>
            </table>
            
            <p style='margin-top: 20px; color: #666; font-size: 12px;'>This is an automated notification from India Day Trip website contact form.</p>
        </div>
    </body>
    </html>
    ";

    $admin_mail_sent = sendEmail($admin_email, $subject_line, $admin_message, $email);

    // ============ SEND CONFIRMATION EMAIL TO USER ============
    $user_subject = "Thank you for contacting us - India Day Trip";

    $user_message = "
    <html>
    <head>
        <title>Contact Confirmation</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #113D48; border-bottom: 2px solid #1CA8CB; padding-bottom: 10px;'>Thank You for Contacting Us!</h2>
            
            <p>Dear " . htmlspecialchars($name) . ",</p>
            
            <p>We have received your message and we will get back to you as soon as possible.</p>
            
            <h3 style='color: #113D48; margin-top: 25px;'>Your Message Details:</h3>
            <table style='border-collapse: collapse; width: 100%;'>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; width: 40%;'>Subject:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($subject) . "</td>
                </tr>
                <tr>
                    <td style='padding: 12px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; vertical-align: top;'>Your Message:</td>
                    <td style='padding: 12px; border: 1px solid #ddd;'>" . nl2br(htmlspecialchars($message)) . "</td>
                </tr>
            </table>
            
            <div style='background-color: #f0f8ff; padding: 15px; border-radius: 8px; margin-top: 20px;'>
                <h4 style='margin: 0 0 10px 0; color: #113D48;'>What's Next?</h4>
                <p style='margin: 5px 0;'>Our team will review your message and get back to you within 24-48 hours.</p>
                <p style='margin: 5px 0;'>If you have any urgent inquiries, please contact us at <strong>info@indiadaytrip.com</strong> or call us directly.</p>
            </div>
            
            <p style='margin-top: 25px; color: #666; font-size: 12px;'>Thank you for choosing India Day Trip!</p>
            
            <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
            <p style='color: #999; font-size: 11px; text-align: center;'>
                " . htmlspecialchars($company_name) . "<br>
                Website: www.indiadaytrip.com
            </p>
        </div>
    </body>
    </html>
    ";

    $user_mail_sent = sendEmail($email, $user_subject, $user_message);

    // ============ RETURN RESPONSE ============
    if ($admin_mail_sent && $user_mail_sent) {
        echo 'Thank you for contacting us! We have sent a confirmation email to ' . htmlspecialchars($email) . '. We will get back to you soon.';
    } elseif ($admin_mail_sent) {
        echo 'Your message has been received. However, we could not send confirmation email. We will get back to you soon.';
    } else {
        echo 'Sorry, there was an error sending your message. Please try again or contact us directly at info@indiadaytrip.com';
    }

    exit;
}

// Default response
echo 'Invalid form submission.';
?>