<?php
// Checks if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LeHuaYUAAAAABaLBsLz23bepx6mzA0qbXf7_D9o',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        echo '<script type="text/javascript">
        alert("Please go back and make sure you check the security CAPTCHA box.");
    </script>';
    } else {
        // If CAPTCHA is successfully completed...

        // Paste mail function or whatever else you want to happen here!
        
    $to = 'support@isomatric.com';
    $subject = 'Isomatric.com Form';
    $message = 'NAME : ' . $_POST['name'] . "\r\n\r\n";
    $message .= 'PHONE : ' . $_POST['phone'] . "\r\n\r\n";
    $message .= 'E-MAIL : ' . $_POST['email'] . "\r\n\r\n";
    $message .= 'SUBJECT : ' . $_POST['subject'] . "\r\n\r\n";
    $message .= 'MESSAGE : ' . $_POST['message'] . "\r\n\r\n";
    $from = "Isomatric Website Form";
    $headers = "From:" . $from;
    $success = mail($to, $subject, $message, $headers);

   echo '<script type="text/javascript">
      var x = confirm("Your message has been successfully sent!");
      if(x){
        window.location.href = "index.html";
      }
      else{
        window.location.href = "index.html";
      }

    </script>';
    }
}