<?php

namespace app\controllers;

use app\repositories\RamTypeLegacyRepository;
use app\repositories\RamTypeModernRepository;
use Yii;
use app\models\RamType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RamTypeController implements the CRUD actions for RamType model.
 */
class RamTypeController extends Controller
{
    /**
     * @var
     */
    protected $ramTypeRepository;

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
            $this->ramTypeRepository = new RamTypeLegacyRepository();
        } else {
            $this->ramTypeRepository = new RamTypeModernRepository();
        }

        parent::__construct($id, $module, $config);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['activeMenuItem'] = 'ram-type';
        return parent::beforeAction($action);
    }

    /**
     * Lists all RamType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->ramTypeRepository->dataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RamType model.
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
     * Creates a new RamType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RamType();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->ramTypeRepository->create($model)) {
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
     * Updates an existing RamType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->ramTypeRepository->update($model)) {
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
     * Deletes an existing RamType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->ramTypeRepository->delete($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the RamType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RamType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->ramTypeRepository->find($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
