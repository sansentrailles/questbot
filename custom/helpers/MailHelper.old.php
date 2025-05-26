<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;

class MailHelper
{
    public static function send($from, $to, $subject, $message, $attachmentAttribute = null)
    {
        $mail = Yii::$app->mailer->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($message);

        if ($attachmentAttribute) {
            $attaches = static::getAttachments($attachmentAttribute);

            foreach ($attaches as $file => $filename) {
                if (!$file) {
                    continue;
                }

                $mail->attach($file, [
                    'fileName' => $filename,
                ]);
            }
        }

        return $mail->send();
    }

    private static function getAttachments($attachmentAttribute)
    {
        $attachments = [];

        if ($attachmentAttribute === null || !isset($_FILES[$attachmentAttribute]['tmp_name'])) {
            return $attachments;
        }

        if (\count($_FILES[$attachmentAttribute]['tmp_name']) > 1) {
            foreach ($_FILES[$attachmentAttribute]['tmp_name'] as $k => $file) {
                if (file_exists($file)) {
                    $attachments[$file] = $_FILES[$attachmentAttribute]['name'][$k];
                }
            }
        } else {
            if (isset($_FILES[$attachmentAttribute]['tmp_name'])) {
                $attachments[$_FILES[$attachmentAttribute]['tmp_name']] = $_FILES[$attachmentAttribute]['name'];
            }
        }

        return $attachments;
    }
}
