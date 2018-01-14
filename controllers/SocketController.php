<?php

namespace app\controllers;

use app\repositories\ChipsetLegacyRepository;
use app\repositories\ChipsetModernRepository;
use app\repositories\SocketLegacyRepository;
use app\repositories\SocketModernRepository;
use Yii;
use app\models\Socket;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SocketController implements the CRUD actions for Socket model.
 */
class SocketController extends Controller
{
    /**
     * @var
     */
    protected $socketRepository;

    /**
     * @var
     */
    protected $chipsetRepository;

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
            $this->socketRepository = new SocketLegacyRepository();
            $this->chipsetRepository = new ChipsetLegacyRepository();
        } else {
            $this->socketRepository = new SocketModernRepository();
            $this->chipsetRepository = new ChipsetModernRepository();
        }

        parent::__construct($id, $module, $config);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['activeMenuItem'] = 'socket';
        return parent::beforeAction($action);
    }

    /**
     * Lists all Socket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->socketRepository->dataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Socket model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $chipsets = $this->chipsetRepository->findBySocket($model);

        return $this->render('view', [
            'model'    => $model,
            'chipsets' => $chipsets
        ]);
    }

    /**
     * Creates a new Socket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Socket();
        $chipsetDictionary = $this->getChipsetDictionary();
        $activeChipsets = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $chipsets = Yii::$app->request->post('Socket')['chipsets'];

            if ($this->socketRepository->createWith($model, ['chipsets' => $chipsets])) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model'             => $model,
                    'chipsetDictionary' => $chipsetDictionary,
                    'activeChipsets'    => $activeChipsets,
                ]);
            }

        }

        return $this->render('create', [
            'model'             => $model,
            'chipsetDictionary' => $chipsetDictionary,
            'activeChipsets'    => $activeChipsets,
        ]);
    }

    /**
     * Updates an existing Socket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $chipsetDictionary = $this->getChipsetDictionary();
        $activeChipsets = ArrayHelper::getColumn($this->chipsetRepository->findBySocket($model), 'id');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $chipsets = Yii::$app->request->post('Socket')['chipsets'];

            if ($this->socketRepository->updateWith($model, ['chipsets' => $chipsets])) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'             => $model,
                    'chipsetDictionary' => $chipsetDictionary,
                    'activeChipsets'    => $activeChipsets,
                ]);
            }

        }

        return $this->render('update', [
            'model'             => $model,
            'chipsetDictionary' => $chipsetDictionary,
            'activeChipsets'    => $activeChipsets,
        ]);
    }

    /**
     * Deletes an existing Socket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->socketRepository->delete($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Socket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Socket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->socketRepository->find($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return array
     */
    protected function getChipsetDictionary()
    {
        return ArrayHelper::map($this->chipsetRepository->all(), 'id', 'name');
    }
}
