<?php

namespace app\controllers;

use app\models\MotherboardSearch;
use app\repositories\ChipsetLegacyRepository;
use app\repositories\ChipsetModernRepository;
use app\repositories\FormFactorLegacyRepository;
use app\repositories\FormFactorModernRepository;
use app\repositories\ManufacturerLegacyRepository;
use app\repositories\ManufacturerModernRepository;
use app\repositories\MotherboardLegacyRepository;
use app\repositories\MotherboardModernRepository;
use app\repositories\RamTypeLegacyRepository;
use app\repositories\RamTypeModernRepository;
use app\repositories\SocketLegacyRepository;
use app\repositories\SocketModernRepository;
use Yii;
use app\models\Motherboard;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MotherboardController implements the CRUD actions for Motherboard model.
 */
class MotherboardController extends Controller
{
    /**
     * @var
     */
    protected $motherboardRepository;

    /**
     * @var
     */
    protected $manufacturerRepository;

    /**
     * @var
     */
    protected $formFactorRepository;

    /**
     * @var
     */
    protected $chipsetRepository;

    /**
     * @var
     */
    protected $socketRepository;

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
            $this->motherboardRepository = new MotherboardLegacyRepository();
            $this->manufacturerRepository = new ManufacturerLegacyRepository();
            $this->formFactorRepository = new FormFactorLegacyRepository();
            $this->chipsetRepository = new ChipsetLegacyRepository();
            $this->socketRepository = new SocketLegacyRepository();
            $this->ramTypeRepository = new RamTypeLegacyRepository();
        } else {
            $this->motherboardRepository = new MotherboardModernRepository();
            $this->manufacturerRepository = new ManufacturerModernRepository();
            $this->formFactorRepository = new FormFactorModernRepository();
            $this->chipsetRepository = new ChipsetModernRepository();
            $this->socketRepository = new SocketModernRepository();
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
        $this->view->params['activeMenuItem'] = 'motherboard';
        return parent::beforeAction($action);
    }

    /**
     * Lists all Motherboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MotherboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Displays a single Motherboard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $manufacturerName = $this->manufacturerRepository->find($model->manufacturer_id)->name;
        $formFactorName = $this->formFactorRepository->find($model->form_factor_id)->name;
        $chipsetName = $this->chipsetRepository->find($model->chipset_id)->name;
        $socketName = $this->socketRepository->find($model->socket_id)->name;
        $ramTypeName = $this->ramTypeRepository->find($model->ram_type_id)->name;

        return $this->render('view', [
            'model'            => $model,
            'manufacturerName' => $manufacturerName,
            'formFactorName'   => $formFactorName,
            'chipsetName'      => $chipsetName,
            'socketName'       => $socketName,
            'ramTypeName'      => $ramTypeName,
        ]);
    }

    /**
     * Creates a new Motherboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Motherboard();
        $manufacturerDictionary = $this->getManufacturerDictionary();
        $formFactorDictionary = $this->getFormFactorDictionary();
        $chipsetDictionary = $this->getChipsetDictionary();

        $socketDictionary = [];

        if ($chipsetDictionary) {
            $socketDictionary = $this->getSocketDictionary(key($chipsetDictionary));
        }

        $ramTypeDictionary = $this->getRamTypeDictionary();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->motherboardRepository->create($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model'                  => $model,
                    'manufacturerDictionary' => $manufacturerDictionary,
                    'formFactorDictionary'   => $formFactorDictionary,
                    'chipsetDictionary'      => $chipsetDictionary,
                    'socketDictionary'       => $socketDictionary,
                    'ramTypeDictionary'      => $ramTypeDictionary,
                ]);
            }

        }

        return $this->render('create', [
            'model'                  => $model,
            'manufacturerDictionary' => $manufacturerDictionary,
            'formFactorDictionary'   => $formFactorDictionary,
            'chipsetDictionary'      => $chipsetDictionary,
            'socketDictionary'       => $socketDictionary,
            'ramTypeDictionary'      => $ramTypeDictionary,
        ]);
    }

    /**
     * Updates an existing Motherboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $manufacturerDictionary = $this->getManufacturerDictionary();
        $formFactorDictionary = $this->getFormFactorDictionary();
        $chipsetDictionary = $this->getChipsetDictionary();

        $socketDictionary = [];

        if ($chipsetDictionary) {
            $socketDictionary = $this->getSocketDictionary($model->chipset_id);
        }

        $ramTypeDictionary = $this->getRamTypeDictionary();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->motherboardRepository->update($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'                  => $model,
                    'manufacturerDictionary' => $manufacturerDictionary,
                    'formFactorDictionary'   => $formFactorDictionary,
                    'chipsetDictionary'      => $chipsetDictionary,
                    'socketDictionary'       => $socketDictionary,
                    'ramTypeDictionary'      => $ramTypeDictionary,
                ]);
            }

        }

        return $this->render('update', [
            'model'                  => $model,
            'manufacturerDictionary' => $manufacturerDictionary,
            'formFactorDictionary'   => $formFactorDictionary,
            'chipsetDictionary'      => $chipsetDictionary,
            'socketDictionary'       => $socketDictionary,
            'ramTypeDictionary'      => $ramTypeDictionary,
        ]);
    }

    /**
     * Deletes an existing Motherboard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->motherboardRepository->delete($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Motherboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Motherboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->motherboardRepository->find($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return array
     */
    protected function getManufacturerDictionary()
    {
        return ArrayHelper::map($this->manufacturerRepository->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getFormFactorDictionary()
    {
        return ArrayHelper::map($this->formFactorRepository->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getChipsetDictionary()
    {
        return ArrayHelper::map($this->chipsetRepository->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getSocketDictionary($id)
    {
        $chipset = $this->chipsetRepository->find($id);
        return ArrayHelper::map($this->socketRepository->findByChipset($chipset), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getRamTypeDictionary()
    {
        return ArrayHelper::map($this->ramTypeRepository->all(), 'id', 'name');
    }
}
