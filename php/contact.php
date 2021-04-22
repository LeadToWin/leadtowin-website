<?php
$response = new stdClass();
if($_POST) {
    $name = "";
    $email = "";
    $subject = "";
    $concerned_department = "";
    $comments = "";
    $email_body = "<div>";
      
    if(isset($_POST['name'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Visitor Name:</b></label>&nbsp;<span>".$name."</span>
                        </div>";
    }
 
    if(isset($_POST['email'])) {
        $email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
                           <label><b>Visitor Email:</b></label>&nbsp;<span>".$email."</span>
                        </div>";
    }
      
    if(isset($_POST['subject'])) {
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Reason For Contacting Us:</b></label>&nbsp;<span>".$subject."</span>
                        </div>";
    }
      
    if(isset($_POST['comments'])) {
        $comments = htmlspecialchars($_POST['comments']);
        $email_body .= "<div>
                           <label><b>Visitor Message:</b></label>
                           <div>".$comments."</div>
                        </div>";
    }
      

    $recipient = "leadtowin@globalsers.org";
    $from = "web@leadtowin.ca";
      
    $email_body .= "</div>";
 
    $headers  = 'MIME-Version: 1.0' . "\r\n"
    .'Content-type: text/html; charset=utf-8' . "\r\n"
    .'From: ' . $from . "\r\n";

      
    if(mail($recipient, $subject, $email_body, $headers)) {
        $response->success = "Thank you for contacting us, <strong>$name</strong>. We will get back to you shortly.";
    } else {
        $response->error = 'We are sorry but the email did not go through. You can email us directly at <strong>community@leadtowin.ca<strong>';
    }
      
} else {
    $response->error = 'We are sorry but something went wrong. You can email us directly at <strong>community@leadtowin.ca</strong>';
}
echo json_encode($response);
?>