<?php

declare(strict_types=1);

return array_merge(
    require __DIR__ . '/general.php',
    // require __DIR__ . '/profile.php',
    require __DIR__ . '/role.php',
    require __DIR__ . '/permission.php',
    require __DIR__ . '/errors.php',
    require __DIR__ . '/user.php'
);
