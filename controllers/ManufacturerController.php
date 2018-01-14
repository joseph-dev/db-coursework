<?php

namespace app\controllers;

use app\repositories\ManufacturerLegacyRepository;
use app\repositories\ManufacturerModernRepository;
use Yii;
use app\models\Manufacturer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ManufacturerController implements the CRUD actions for Manufacturer model.
 */
class ManufacturerController extends Controller
{
    /**
     * @var
     */
    protected $manufacturerRepository;

    /**
     * ManufacturerController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, array $config = [])
    {
        /**
         * Check mode and use proper repository
         */
        if (APP_MODE === 'legacy') {
            $this->manufacturerRepository = new ManufacturerLegacyRepository();
        } else {
            $this->manufacturerRepository = new ManufacturerModernRepository();
        }

        parent::__construct($id, $module, $config);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['activeMenuItem'] = 'manufacturer';
        return parent::beforeAction($action);
    }

    /**
     * Lists all Manufacturer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->manufacturerRepository->dataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Manufacturer model.
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
     * Creates a new Manufacturer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufacturer();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->manufacturerRepository->create($model)) {
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
     * Updates an existing Manufacturer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->manufacturerRepository->update($model)) {
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
     * Deletes an existing Manufacturer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->manufacturerRepository->delete($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Manufacturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manufacturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->manufacturerRepository->find($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
