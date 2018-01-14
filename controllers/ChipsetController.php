<?php

namespace app\controllers;

use app\repositories\ChipsetLegacyRepository;
use app\repositories\ChipsetModernRepository;
use app\repositories\SocketLegacyRepository;
use app\repositories\SocketModernRepository;
use Yii;
use app\models\Chipset;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ChipsetController implements the CRUD actions for Chipset model.
 */
class ChipsetController extends Controller
{
    /**
     * @var
     */
    protected $chipsetRepository;

    /**
     * @var
     */
    protected $socketRepository;

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
            $this->chipsetRepository = new ChipsetLegacyRepository();
            $this->socketRepository = new SocketLegacyRepository();
        } else {
            $this->chipsetRepository = new ChipsetModernRepository();
            $this->socketRepository = new SocketModernRepository();
        }

        parent::__construct($id, $module, $config);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['activeMenuItem'] = 'chipset';
        return parent::beforeAction($action);
    }

    /**
     * Lists all Chipset models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->chipsetRepository->dataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chipset model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $sockets = $this->socketRepository->findByChipset($model);

        return $this->render('view', [
            'model'   => $model,
            'sockets' => $sockets
        ]);
    }

    /**
     * Creates a new Chipset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chipset();
        $socketDictionary = $this->getSocketDictionary();
        $activeSockets = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $sockets = Yii::$app->request->post('Chipset')['sockets'];

            if ($this->chipsetRepository->createWith($model, ['sockets' => $sockets])) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model'            => $model,
                    'socketDictionary' => $socketDictionary,
                    'activeSockets'    => $activeSockets,
                ]);
            }

        }

        return $this->render('create', [
            'model'            => $model,
            'socketDictionary' => $socketDictionary,
            'activeSockets'    => $activeSockets,
        ]);
    }

    /**
     * Updates an existing Chipset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $socketDictionary = $this->getSocketDictionary();
        $activeSockets = ArrayHelper::getColumn($this->socketRepository->findByChipset($model), 'id');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $sockets = Yii::$app->request->post('Chipset')['sockets'];

            if ($this->chipsetRepository->updateWith($model, ['sockets' => $sockets])) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'            => $model,
                    'socketDictionary' => $socketDictionary,
                    'activeSockets'    => $activeSockets,
                ]);
            }

        }

        return $this->render('update', [
            'model'            => $model,
            'socketDictionary' => $socketDictionary,
            'activeSockets'    => $activeSockets,
        ]);
    }

    /**
     * Deletes an existing Chipset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->chipsetRepository->delete($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chipset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chipset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->chipsetRepository->find($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return array
     */
    protected function getSocketDictionary()
    {
        return ArrayHelper::map($this->socketRepository->all(), 'id', 'name');
    }
}
