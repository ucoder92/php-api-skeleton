<?php

use Libs\Mailer;
use Libs\Parser;
use Libs\Validation;

$email = input_post('email');
$phone = input_post('phone');
$fullname = input_post('fullname');

$rules = array(
    array(
        'label' => 'Name',
        'value' => $fullname,
        'rules' => 'required',
        'message' => 'Please enter your name',
    ),
    array(
        'label' => 'Email address',
        'value' => $email,
        'rules' => 'required|valid_email',
        'message' => array(
            'Please enter your email address',
            'Please enter the valid email address'
        ),
    ),
    array(
        'label' => 'Phone number',
        'value' => $phone,
        'rules' => 'required',
        'message' => 'Please enter your phone number',
    ),
);

$validation = new Validation($rules);

if ($validation->run()) {
    $vars = array(
        'email' => $email,
        'fullname' => $fullname,
        'phone_number' => $phone,
        'title' => 'Contact form message',
    );

    $html = Parser::parseIncFile('html/contact-form-message.html', $vars);

    $mailer = new Mailer();
    $mailer->addTo('info@gtlbroker.com');
    $mailer->addSubject('Contact form message');
    $mailer->addMessage($html);
    $mailer->send_smtp();
    $error = $mailer->getError();

    if ($error) {
        $output = json_output(false, $error);
    } else {
        $output = json_output(true, 'Your message was sent successfully. Thank you!');
    }
} else {
    $output = json_output(false, $validation->getError());
}

return json_response($output);
