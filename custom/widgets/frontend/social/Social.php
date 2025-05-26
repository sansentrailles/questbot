<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\social;

use app\modules\contacts\services\social_media\SocialMediaService;
use yii\base\Widget;

/**
 * Displays social media icons.
 *
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class Social extends Widget
{
    public $template;
    private $socialMediaService;

    public function __construct(SocialMediaService $socialMediaService, $config = [])
    {
        $this->socialMediaService = $socialMediaService;
        parent::__construct($config);
    }

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        if ($this->template === null) {
            $this->template = 'default';
        }

        $socialLinks = $this->socialMediaService->getActiveSocialMedias();

        return $this->render($this->template, [
            'socialLinks' => $socialLinks,
        ]);
    }
}
