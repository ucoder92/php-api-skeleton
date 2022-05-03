<?php

/**
 * Mailer
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

namespace Libs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    private $to;
    private $cc;
    private $bcc;
    private $subject;
    private $message;
    private $attachments;
    private $errors;

    /**
     * Send smtp mail
     *
     * @return mixed
     */
    public function send_smtp()
    {
        $config = get_config('smtp');
        $username = array_value($config, 'email');
        $password = array_value($config, 'password');
        $senderName = array_value($config, 'senderName', 'My website');

        $this->validation();
        $this->check_config('host', 'SMTP host not found.');
        $this->check_config('port', 'SMTP port not found.');
        $this->check_config('email', 'SMTP email not found.');
        $this->check_config('password', 'SMTP password not found.');

        // Check error
        if ($this->errors) {
            return $this->errors[0];
        }

        // PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = array_value($config, 'host');
        $mail->Port = array_value($config, 'port');
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->Subject = $this->subject;
        $mail->SMTPSecure = 'ssl';

        $mail->isHTML(true);
        $mail->msgHTML($this->message);
        $mail->setFrom($username, $senderName);

        if (is_array($this->to) && $this->to) {
            foreach ($this->to as $to) {
                $mail->addAddress($to['email'], $to['name']);
            }
        }

        if (is_array($this->cc) && $this->cc) {
            foreach ($this->cc as $cc) {
                $mail->addCC($cc['email'], $cc['name']);
            }
        }

        if (is_array($this->bcc) && $this->bcc) {
            foreach ($this->bcc as $bcc) {
                $mail->addBCC($bcc['email'], $bcc['name']);
            }
        }

        if (is_array($this->attachments) && $this->attachments) {
            foreach ($this->attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        if ($mail->send()) {
            return true;
        } else {
            $this->errors[] = 'Error on sending mail: ' . $mail->ErrorInfo;
        }

        return false;
    }

    /**
     * Add "to" address
     *
     * @param string $email
     * @param string $name
     * @return void
     */
    public function addTo($email, $name = '')
    {
        $this->to[] = ['email' => $email, 'name' => $name];
    }

    /**
     * Add "cc" address
     *
     * @param string $email
     * @param string $name
     * @return void
     */
    public function addCC($email, $name = '')
    {
        $this->cc[] = ['email' => $email, 'name' => $name];
    }

    /**
     * Add "bcc" address
     *
     * @param string $email
     * @param string $name
     * @return void
     */
    public function addBCC($email, $name = '')
    {
        $this->bcc[] = ['email' => $email, 'name' => $name];
    }

    /**
     * Add attachment
     *
     * @param string $attachment
     * @return void
     */
    public function addAttachment($attachment)
    {
        $this->attachments[] = $attachment;
    }

    /**
     * Add subject
     *
     * @param string $subject
     * @return void
     */
    public function addSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Add message
     *
     * @param string $message
     * @return void
     */
    public function addMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get error
     *
     * @return string
     */
    public function getError()
    {
        return $this->errors ? $this->errors[0] : '';
    }

    /**
     * Validation
     *
     * @return void
     */
    private function validation()
    {
        $validation = array(
            ['field' => $this->to, 'message' => 'The variable "to" is empty.'],
            ['field' => $this->subject, 'message' => 'The variable "subject" is empty.'],
            ['field' => $this->message, 'message' => 'The variable "message" is empty.'],
        );

        foreach ($validation as $item) {
            $field = array_value($item, 'field');

            if (empty($field)) {
                $this->errors[] = array_value($item, 'message');
            }
        }
    }

    /**
     * Check configuration
     *
     * @param string $key
     * @param string $message
     * @return void
     */
    private function check_config($key, $message)
    {
        $config = get_config('smtp');
        $value = array_value($config, $key);

        if (empty($value) || is_null($value)) {
            $this->errors[] = $message;
        }
    }
}
