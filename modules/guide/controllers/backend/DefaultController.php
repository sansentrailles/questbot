<?php

declare(strict_types=1);

namespace app\modules\guide\controllers\backend;

use app\modules\guide\controllers\common\Controller;
use app\modules\guide\forms\backend\GuideChapterForm;
use app\modules\guide\forms\backend\search\GuideChapterSearch;
use app\modules\guide\Module;
use Yii;
use yii\filters\VerbFilter;

/**
 * Default controller for the `guide` module.
 */
class DefaultController extends Controller
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
                    'sort' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new GuideChapterSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $model = new GuideChapterForm();

        if ($model->load($post) && $model->validate()) {
            $guideChapter = $this->guideChapterService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $guideChapter = $this->guideChapterService->find($id);
        $model = new GuideChapterForm($guideChapter);

        if ($model->load($post) && $model->validate()) {
            $this->guideChapterService->save($model);

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $guideChapter = $this->guideChapterService->findOrFail($id);
        $this->guideChapterService->delete($guideChapter->id);

        return $this->redirect(['index']);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->guideChapterService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested guide chapter has been switched successfully',
        ];
    }

    public function actionSort()
    {
        $request = Yii::$app->request;
        $ords = $request->post('guideChapterOrders');

        if (empty($ords)) {
            return $this->redirect($request->referrer);
        }

        $this->guideChapterService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }

    public function actionView($id = null)
    {
        $chapter = null;
        if ($id) {
            $chapter = $this->guideChapterService->find($id);
        }
        $chapters = $this->guideChapterService->getAll();

        return $this->render('view', [
            'chapters' => $chapters,
            'chapter' => $chapter,
            'id' => $id,
        ]);
    }
}
