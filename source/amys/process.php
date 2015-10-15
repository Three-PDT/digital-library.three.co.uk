<?php
// kill everything if the honeypot is filled in.
if ($_POST['poohbear'] != "") {
  die();
}


// Some config shite.
date_default_timezone_set('Europe/London');
$this_award_date = date('Y-m-d H:i:s');
$admin_email = "Angela.Shaw@three.co.uk";
$admin_name = "Angela Shaw";
$slack_email = "v6g0k6r8y7i0p8h3@three-digital.slack.com";


// Get all the form fields.
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


// Validate fields on this side too;
require "inc/gump/gump.class.php";


  // Have to do these first, manually, can't figure out validation of arrays
  $amy_value_1 = false;
  $amy_value_2 = false;
  $amy_value_3 = false;

  if ( is_numeric($_POST["amy_value_id"][0]) ) {
    $amy_value_1 = $_POST["amy_value_id"][0];
  }
  if ( is_numeric($_POST["amy_value_id"][1]) ) {
    $amy_value_2 = $_POST["amy_value_id"][1];
  }
  if ( is_numeric($_POST["amy_value_id"][2]) ) {
    $amy_value_3 = $_POST["amy_value_id"][2];
  }


$gump = new GUMP();
$_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

$gump->validation_rules(array(
  'amy_giver'           => 'required|alpha_space|max_len,256|min_len,3',
  'amy_giver_email'     => 'required|valid_email',
  'amy_recipient'       => 'required|alpha_space|max_len,256|min_len,3',
  'amy_recipient_email' => 'required|valid_email',
  //'amy_value_id'        => 'numeric',
  'explanation'         => 'required|max_len,256'
));

$gump->filter_rules(array(
  'amy_giver'           => 'trim|sanitize_string',
  'amy_giver_email'     => 'trim|sanitize_email',
  'amy_recipient'       => 'trim|sanitize_string',
  'amy_recipient_email' => 'trim|sanitize_email',
  //'amy_value_id'        => 'trim',
  'explanation'         => 'trim|sanitize_string'
));

$validated_data = $gump->run($_POST);

// If fields have been validated
if($validated_data === false) {
  
  // FIXME, probably!
  echo $gump->get_readable_errors(true);
  die();

} else {
  // Validation successful
  // print_r($validated_data);
  // Let's put some stuff in the database and send some emails

  $valid_fields = true;

  $giver_name = $validated_data['amy_giver'];
  $giver_email = $validated_data['amy_giver_email'];
  $recipient_name = $validated_data['amy_recipient'];
    // http://stackoverflow.com/a/13637513/2504405
    $parts = explode(" ", $recipient_name);
    $recipient_surname = array_pop($parts);
    $recipient_firstname = implode(" ", $parts);
  $recipient_email = $validated_data['amy_recipient_email'];
  $explanation = $validated_data['explanation'];


  // The database wrapper
  require_once ('inc/db/MysqliDb.php');
  
  // environment settings
  require_once ('inc/env_set.php');

  // COnnect to the DB
  $db = new MysqliDb ($db_location, $db_user, $db_pass, $db_data);


  // Store stuff in the database.
  $data = Array (  
    'award_date' => $award_date,
    'giver_name' => $giver_name,
    'giver_email' => $giver_email,
    'recipient_name' => $recipient_name,
    'recipient_email' => $recipient_email,
    'amy_value_1' => $amy_value_1,
    'amy_value_2' => $amy_value_2,
    'amy_value_3' => $amy_value_3,
    'explanation' => $explanation
  );

  $id = $db->insert ('awards', $data);
}

// If a database entry has been made;
if ($id) {
  // echo 'award was created. Id=' . $id;

  // Get the culture values
  $cols = Array ("id", "full_name", "shortened_name", "description");
  $amy_values = $db->get ("amy_values", null, $cols);
  
  // PHPmailer
  require_once ('inc/phpmailer/PHPMailerAutoload.php');

  // *************** Send email to recipient.
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    // Set the character encoding
    $mail->CharSet = 'utf-8';
    //Set who the message is to be sent from
    $mail->setFrom('amy@three-digital.co.uk', 'Amy');
    //Set who the message is to be sent to
    //$mail->addAddress('luc.pestille@three.co.uk', 'Luc Pestille');
    $mail->addAddress($recipient_email, $recipient_name);
    //Set the subject line
    $mail->Subject = "You've won an Amy!";
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body

      $htmlemail = file_get_contents('winner_email.html', dirname(__FILE__));
      $htmlemail = str_replace("[[amy_giver]]", $giver_name, $htmlemail);
      $htmlemail = str_replace("[[explanation]]", $explanation, $htmlemail);

      // get awarded values, compare to list, and build table contents
      $awarded_amy_values = array($amy_value_1, $amy_value_2, $amy_value_3);
      $awarded_amy_values_num = count($awarded_amy_values);
      $htmlemail_values = "";
      if ( $awarded_amy_values_num > 0 ) {

        switch ( $awarded_amy_values_num ) {
          case 1:
            $cell_width = "500";
            break;
          case 2:
            $cell_width = "240"; // 240 + 20 + 240
            break;
          case 3:
            $cell_width = "150"; // 150 + 25 + 150 + 25 + 150
            break;
        }
        
        foreach ($amy_values as $amy_value) {

          if (in_array($amy_value['id'], $awarded_amy_values)) {
            $htmlemail_values .= "<td valign='top' width='".$cell_width."''><b>".$amy_value['shortened_name']."</b><br>".$amy_value['description']."</td>";
          }

        }
        $htmlemail = str_replace("[[amy_values]]", $htmlemail_values, $htmlemail);
      }
    
    $mail->msgHTML( $htmlemail );
    //Replace the plain text body with one created manually
    $mail->AltBody = "Lovely! You've been awarded an Amy! 2,000 WOW Points (£20) are being processed and will be added to your account in the next 6-8 weeks.";

    //send the message, check for errors
    if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
      die();
    }
  // *************** recipient end

  // *************** Send email to giver.
    $giver_mail = new PHPMailer;
    $giver_mail->CharSet = 'utf-8';
    $giver_mail->setFrom('amy@three-digital.co.uk', 'Amy');
    //$giver_mail->addAddress('luc.pestille@three.co.uk', 'Luc Pestille');
    $giver_mail->addAddress($giver_email, $giver_name);
    $giver_mail->Subject = "Amy awarded";

    $giver_mail_body  = "Hi there ".$giver_name ."\r\n\r\n";
    $giver_mail_body .= "We're just confirming that you awarded an Amy to ".$recipient_name." because, in your words: ".$explanation;
    $giver_mail_body .= "\r\n\r\n";
    $giver_mail_body .= "Awarded on ".$this_award_date;

    $giver_mail->Body = $giver_mail_body;
    if (!$giver_mail->send()) {
      echo "Mailer Error: " . $giver_mail->ErrorInfo;
      die();
    }
  // *************** giver end

  // *************** Send email to admin.
    $admin_mail = new PHPMailer;
    $giver_mail->CharSet = 'utf-8';
    $admin_mail->setFrom('amy@three-digital.co.uk', 'Amy');
    $admin_mail->addAddress($admin_email, $admin_name);
    $admin_mail->Subject = "Amy awarded";
      $admin_body  = "An Amy has been awarded to ".$recipient_name." by ".$giver_name." on ".$this_award_date;
      $admin_body .= "\r\n\r\n";
      $admin_body .= "To make the process easy, copy and paste the below in to a cell in Excel, then choose Data > Text to Columns, then Delimited, and select Comma in the second stage.";
      $admin_body .= "\r\n\r\n";
      $admin_body .= ",\"".$recipient_firstname."\",\"".$recipient_surname."\",UK3014,\"".$explanation."\",\"Amy\",2000,\"".$giver_name."\"";
    $admin_mail->Body = $admin_body;
    if (!$admin_mail->send()) {
      echo "Mailer Error: " . $admin_mail->ErrorInfo;
      die();
    }
  // *************** admin end

  // *************** Send email to Amybot.
    $amybot_mail = new PHPMailer;
    $amybot_mail->setFrom('amy@three-digital.co.uk', 'Amy');
    $amybot_mail->addAddress($slack_email, 'Amy');
    $amybot_mail->Subject = "An Amy has been awarded!";
    $amybot_mail->Body = "Congratulations to ".$recipient_name." who has been awarded an Amy by ".$giver_name." because: ".$explanation;
    if (!$amybot_mail->send()) {
      echo "Mailer Error: " . $amybot_mail->ErrorInfo;
      die();
    }
  // *************** Amybot end

  // Redirect to success page.
  header("Location: success.php");

} else {
  echo 'Insert failed: ' . $db->getLastError();
}
?>