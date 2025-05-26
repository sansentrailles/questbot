<?php

declare(strict_types=1);

namespace app\modules\seo\controllers\backend;

use app\modules\seo\controllers\common\Controller;
use app\modules\seo\forms\backend\SeoForm as Form;
use Yii;
use yii\filters\VerbFilter;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Crates or updates Seo model.
     * @param mixed $redirectUrl
     * @param mixed $section
     * @param mixed $refId
     * @return mixed
     */
    public function actionIndex($redirectUrl = '', $section = '', $refId = 0)
    {
        $seo = $this->seoService->getSeo($section, (int)$refId);
        // Это костыль, надо что-то придумать
        if (!isset($seo->id)) {
            $seo = null;
        }
        $model = new Form($seo);
        $model->setIdentifiers($section, $refId);

        if (!$seo) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $this->seoService->create($model);

                return $this->redirect($redirectUrl);
            }

            $model->setIdentifiers($section, $refId);
            return $this->render('create', [
                'model' => $model,
                'section' => $section,
                'redirectUrl' => $redirectUrl,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->seoService->edit($model);

            return $this->redirect($redirectUrl);
        }

        return $this->render('update', [
            'model' => $model,
            'section' => $section,
            'redirectUrl' => $redirectUrl,
        ]);
    }

    public function actionDelete($id, $section = '', $redirectUrl = '')
    {
        $this->seoService->findOrFail((int)$id);
        $this->seoService->delete($id);
        return $this->redirect(['/admin/seo/seo', 'section' => $section, 'redirectUrl' => $redirectUrl]);
    }
}
