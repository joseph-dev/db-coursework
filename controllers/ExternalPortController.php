<?php

namespace app\controllers;

use app\repositories\ExternalPortLegacyRepository;
use app\repositories\ExternalPortModernRepository;
use Yii;
use app\models\ExternalPort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ExternalPortController implements the CRUD actions for ExternalPort model.
 */
class ExternalPortController extends Controller
{
    /**
     * @var
     */
    protected $externalPortRepository;

    /**
     * FormFactorController constructor.
     * @param string $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, array $config = [])
    {
        /**
         * Check mode and use proper repository
         */
        if (APP_MODE === 'legacy') {
            $this->externalPortRepository = new ExternalPortLegacyRepository();
        } else {
            $this->externalPortRepository = new ExternalPortModernRepository();
        }

        parent::__construct($id, $module, $config);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['activeMenuItem'] = 'external-port';
        return parent::beforeAction($action);
    }

    /**
     * Lists all ExternalPort models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->externalPortRepository->dataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExternalPort model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExternalPort model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExternalPort();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->externalPortRepository->create($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExternalPort model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->externalPortRepository->update($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExternalPort model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->externalPortRepository->delete($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExternalPort model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExternalPort the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->externalPortRepository->find($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
