<?php

declare(strict_types=1);

namespace app\custom\interfaces;

interface FileInterface
{
    /**
     * Get file by section.
     *
     * @param string $section
     * @return string|null
     */
    public function getFileBySection($section);
}
