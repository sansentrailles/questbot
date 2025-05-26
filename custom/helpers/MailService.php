<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;

class MailService
{
    private $mailer;
    private $mail;

    public function __construct()
    {
        $this->mailer = Yii::$app->mailer;
    }

    public function addFiles(array $files): void
    {
    }

    public function send($from, $to, $subject, $message, $files = null)
    {
        $mail = $this->mailer
            ->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($message);

        if (\is_array($files) && \count($files) > 0) {
            foreach ($files as $file => $filename) {
                if (!file_exists($file)) {
                    continue;
                }

                $mail->attach($file, [
                    'fileName' => $this->getFilename($file),
                ]);
            }
        }

        return $mail->send();
    }

    public function sendWithTemplate($from, $to, $subject, $message, $template, $params, $files = null)
    {
        $mail = $this->mailer
            ->compose($template, $params)
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($message);

        if (\is_array($files) && \count($files) > 0) {
            foreach ($files as $file => $filename) {
                if (!file_exists($file)) {
                    continue;
                }

                $mail->attach($file, [
                    'fileName' => $this->getFilename($file),
                ]);
            }
        }

        return $mail->send();
    }

    private function getFilename($file)
    {
        $parts = explode(\DIRECTORY_SEPARATOR, $file);

        return end($parts);
    }
}
