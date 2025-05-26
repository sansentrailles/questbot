<?php

declare(strict_types=1);

namespace app\custom\files;

class FileManager
{
    public function exists($file): bool
    {
        return file_exists($file);
    }

    public function createDirectory($path, $permission = 0777): bool
    {
        return mkdir($path, $permission, $recursive = true);
    }

    public function delete($file): bool
    {
        if ($this->exists($file)) {
            return unlink($file);
        }

        return false;
    }

    public function put($file, mixed $content)
    {
        return file_put_contents($file, $content);
    }

    public function get($file)
    {
        if ($this->exists($file)) {
            return file_get_contents($file);
        }

        return false;
    }
}
