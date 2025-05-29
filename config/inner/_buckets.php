<?php

declare(strict_types=1);

return [
    'taskImage' => [
        'baseSubPath' => 'images/quests/tasks',
        'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
    ],

    'questImage' => [
        'baseSubPath' => 'images/quests/image',
        'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
    ],

    'settingFile' => [
        'baseSubPath' => 'settings',
        'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
    ],
/**
 * Template config for upload files.
 *
 * 'templateIcon' => [
 *    'baseSubPath' => 'images/template/image',
 *    'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
 *],
 *
 *'templateFile' => [
 *    'baseSubPath' => 'files/template/file',
 *    'fileSubDirTemplate' => '{^name}{^^name}/{^^^name}{^^^^name}',
 *],
 */
];
