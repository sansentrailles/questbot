<?php

declare(strict_types=1);

namespace app\modules\main\controllers\frontend;

use app\modules\main\controllers\common\RestController;
use app\modules\tyres\models\Category;
use app\modules\seo\models\Seo;
use Yii;
use yii\web\Response;


class MainController extends RestController
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $category = $this->categoryService->getDefault();
        $categories = $this->categoryService->getVisible();
        if ($category === null || $category->is_visible == Category::STATUS_INVISIBLE) {
            if (count($categories) == 0) {
                throw new \yii\web\NotFoundHttpException('Category not found');
            } else {
                $category = $categories[0];
            }
        }

        $prev = $this->categoryService->getPrev($category);
        $next = $this->categoryService->getNext($category);

        $first = $categories[0];
        $last = $categories[count($categories) - 1];

        return [
            'truckScene' => $category->url === 'gruzovie-siny',
            'category' => $category,
            'prev' => $prev !== null ? $prev->url : $last->url,
            'next' => $next !== null ? $next->url : $first->url,
            'contacts' => [
                'contacts_title' => $category->contacts_title,
                'managers' => $category->managerList,
                'phones' => $category->phonesList,
                'emails' => $category->emailsList,
                'coop_emails' => $category->coopEmailsList,
                'review_email' => $category->review_email,
                'review_phone' => $category->review_phone,
                'address' => $category->address,
            ],
        ];

        // if (count($categories) > 0) {
        //     return [
        //         'category' => $categories[0],
        //         'contacts' => [
        //             'contacts_title' => $category->contacts_title,
        //             'managers' => $category->managerList,
        //             'phones' => $category->phonesList,
        //             'emails' => $category->emailsList,
        //             'coop_emails' => $category->coopEmailsList,
        //             'review_email' => $category->review_email,
        //             'review_phone' => $category->review_phone,
        //             'address' => $category->address,
        //         ],
        //     ];
        // } else {
            
        // }
    }

    public function actionSeo()
    {
        $category = $this->categoryService->getDefault();
        $categories = $this->categoryService->getVisible();
        if ($category === null || $category->is_visible == Category::STATUS_INVISIBLE) {
            if (count($categories) == 0) {
                throw new \yii\web\NotFoundHttpException('Category not found');
            } else {
                $category = $categories[0];
            }
        }

        $request = Yii::$app->request;
        $cityCode = $request->get('city', '');
        $city = $this->cityService->getByCode($cityCode);
        $mask = [];
        if ($city) {
            $mask = $city->maskList;
        }

        $seo = $this->seoService->getSeo('category', $category->id);
        $ogImage = Yii::$app->setting->get('og.image');
        if (!$seo) {
            $seo = new Seo();
        }
        $seo->setImage($ogImage);
// return $seo;
        $seo = $this->seoService->prepareSeo($seo, $mask);

        return $seo;
    }

    public function actionMenu()
    {
        $categories = $this->categoryService->getVisible();
        $pages = $this->pageService->getVisible();

        $menu = [];
        foreach ($categories as $category) {
            $menu[] = [
                'url' => "/tires/".$category->url,
                'title' => $category->title,
                'isFile' => false,
            ];
        }

        foreach ($pages as $page) {
            $menu[] = [
                'url' => "/".$page->url,
                'title' => $page->title,
                'isFile' => false,
            ];
        }

        $setting = Yii::$app->setting;
        $menuFile = $setting->get('menu.file');
        $menuTitle = $setting->get('menu.title');

        if ($menuFile && $menuTitle) {
            $menu[] = [
                'url' => $menuFile,
                'title' => $menuTitle,
                'isFile' => true,
            ];
        }

        return $menu;
    }

    public function actionOgImage()
    {
        return Yii::$app->setting->get('og.image');
    }
}
