<?php
	header('Content-type: application/json');
	$status = array(
		'type'=>'success',
		'message'=>'Email sent!'
	);

    $name = @trim(stripslashes($_POST['name'])); 
    $email = @trim(stripslashes($_POST['email'])); 
    $message = @trim(stripslashes($_POST['message'])); 
    $subject = "Enquiry";
    $email_from = $email;
    $email_to = 'hemanth@prosperconsulting.in';

    $body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

    $success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');

//    echo json_encode($status);
      header("location:index.html");
//    die;