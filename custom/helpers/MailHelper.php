<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;

class MailHelper
{
    public function getDsn($username, $password, $host, $port): string
    {
        return "smtp://{$username}:{$password}@{$host}:{$port}";
    }

    public function setTransport(string $dsn): void
    {
        Yii::$app->mailer->setTransport([
            'dsn' => $dsn,
        ]);
    }

    public function send($from, $to, $subject, $message, $files = null)
    {
        $mail = Yii::$app->mailer->compose()
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
                    'fileName' => $filename,
                ]);
            }
        }

        return $mail->send();
    }

    public function sendTemplated($from, $to, $subject, $template, $params)
    {
        if (!$template) {
            return false;
        }

        $mail = Yii::$app->mailer
            ->compose($template, $params)
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject);

        return $mail->send();
    }
}
