<?php

declare(strict_types=1);

namespace app\modules\seo\widgets\backend\seo;

use app\modules\seo\services\SeoService;
use Yii;
use yii\base\Widget;

/**
 * Displays SEO button.
 *
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class SeoWidget extends Widget
{
    public $refId = 0;
    public $section = '';
    public $redirectUrl;
    private $seoService;

    public function __construct(SeoService $seoService, $config = [])
    {
        $this->seoService = $seoService;
        parent::__construct($config);
    }

    public function init(): void
    {
        parent::init();

        if (!$this->redirectUrl) {
            $this->redirectUrl = Yii::$app->request->url;
        }
    }

    public function run()
    {
        return $this->render('button', [
            'refId' => $this->refId,
            'section' => $this->section,
            'redirectUrl' => $this->redirectUrl,
            'isNew' => $this->seoService->getSeo($this->section, $this->refId) ? false : true,
        ]);
    }
}
