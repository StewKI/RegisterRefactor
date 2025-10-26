<?php

declare(strict_types=1);


namespace App\Services\Mail;

use App\Contracts\Services\Mail\MailSenderServiceInterface;
use App\DTOs\MailData;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class PhpMailerMailSenderService implements MailSenderServiceInterface
{
    public function __construct(
        private readonly array $config
    )
    {}

    /**
     * @throws Exception
     */
    public function send(MailData $mailData): void
    {
        $mail = $this->getPHPMailer();

        $mail->addAddress($mailData->to);
        $mail->Subject = $mailData->subject;
        $mail->Body = $mailData->message;
        $mail->setFrom($mailData->from, $mailData->fromName);

        $mail->send();
    }

    private function getPHPMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $this->config['host'];
        $mail->SMTPAuth   = $this->config['smtp_auth'];
        $mail->Username   = $this->config['username'];
        $mail->Password   = $this->config['password'];
        $mail->SMTPSecure = $this->config['smtp_secure'];
        $mail->Port       = $this->config['port'];

        return $mail;
    }
}