<?php

declare(strict_types=1);

namespace app\custom\services\files;

class FileService
{
    public function removeOldFiles(string $path, $expire)
    {
        // echo $expire.' '.date('d.m.Y H:i:s', $expire);
        if (!file_exists($path)) {
            return 0;
        }

        $files = scandir($path);

        $count = 0;
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $time = filemtime($path . '/' . $file);
            if ($expire > $time && $this->removeFile($path . '/' . $file)) {
                ++$count;
            }
        }

        return $count;
    }

    public function removeFile($file)
    {
        if (file_exists($file)) {
            return unlink($file);
        }

        return false;
    }
}
