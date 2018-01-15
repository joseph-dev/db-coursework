<?php

namespace app\controllers;

use app\models\MotherboardSearch;
use app\repositories\ChipsetLegacyRepository;
use app\repositories\ChipsetModernRepository;
use app\repositories\ExternalPortLegacyRepository;
use app\repositories\ExternalPortModernRepository;
use app\repositories\FormFactorLegacyRepository;
use app\repositories\FormFactorModernRepository;
use app\repositories\ManufacturerLegacyRepository;
use app\repositories\ManufacturerModernRepository;
use app\repositories\MotherboardLegacyRepository;
use app\repositories\MotherboardModernRepository;
use app\repositories\RamTypeLegacyRepository;
use app\repositories\RamTypeModernRepository;
use app\repositories\SlotLegacyRepository;
use app\repositories\SlotModernRepository;
use app\repositories\SocketLegacyRepository;
use app\repositories\SocketModernRepository;
use app\repositories\StoragePortLegacyRepository;
use app\repositories\StoragePortModernRepository;
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
     * @var
     */
    protected $slotRepository;

    /**
     * @var
     */
    protected $storagePortRepository;

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
            $this->motherboardRepository = new MotherboardLegacyRepository();
            $this->manufacturerRepository = new ManufacturerLegacyRepository();
            $this->formFactorRepository = new FormFactorLegacyRepository();
            $this->chipsetRepository = new ChipsetLegacyRepository();
            $this->socketRepository = new SocketLegacyRepository();
            $this->ramTypeRepository = new RamTypeLegacyRepository();
            $this->slotRepository = new SlotLegacyRepository();
            $this->storagePortRepository = new StoragePortLegacyRepository();
            $this->externalPortRepository = new ExternalPortLegacyRepository();
        } else {
            $this->motherboardRepository = new MotherboardModernRepository();
            $this->manufacturerRepository = new ManufacturerModernRepository();
            $this->formFactorRepository = new FormFactorModernRepository();
            $this->chipsetRepository = new ChipsetModernRepository();
            $this->socketRepository = new SocketModernRepository();
            $this->ramTypeRepository = new RamTypeModernRepository();
            $this->slotRepository = new SlotModernRepository();
            $this->storagePortRepository = new StoragePortModernRepository();
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

        $slots = $this->motherboardRepository->findSlotsWithQuantitiesByMotherboard($model);
        $storagePorts = $this->motherboardRepository->findStoragePortsWithQuantitiesByMotherboard($model);
        $externalPorts = $this->motherboardRepository->findExternalPortsWithQuantitiesByMotherboard($model);

        return $this->render('view', [
            'model'            => $model,
            'manufacturerName' => $manufacturerName,
            'formFactorName'   => $formFactorName,
            'chipsetName'      => $chipsetName,
            'socketName'       => $socketName,
            'ramTypeName'      => $ramTypeName,
            'slots'            => $slots,
            'storagePorts'     => $storagePorts,
            'externalPorts'    => $externalPorts,
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

        $slotDictionary = $this->getSlotDictionary();
        $storagePortDictionary = $this->getStoragePortDictionary();
        $externalPortDictionary = $this->getExternalPortDictionary();

        $slotQuantities = [];
        $storagePortQuantities = [];
        $externalPortQuantities = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $data['slots'] = $this->prepareQuantities(
                Yii::$app->request->post('Motherboard')['slotTypes'],
                Yii::$app->request->post('Motherboard')['slotQuantities']
            );

            $data['storagePorts'] = $this->prepareQuantities(
                Yii::$app->request->post('Motherboard')['storagePortTypes'],
                Yii::$app->request->post('Motherboard')['storagePortQuantities']
            );

            $data['externalPorts'] = $this->prepareQuantities(
                Yii::$app->request->post('Motherboard')['externalPortTypes'],
                Yii::$app->request->post('Motherboard')['externalPortQuantities']
            );

            if ($this->motherboardRepository->createWith($model, $data)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model'                  => $model,
                    'manufacturerDictionary' => $manufacturerDictionary,
                    'formFactorDictionary'   => $formFactorDictionary,
                    'chipsetDictionary'      => $chipsetDictionary,
                    'socketDictionary'       => $socketDictionary,
                    'ramTypeDictionary'      => $ramTypeDictionary,
                    'slotDictionary'         => $slotDictionary,
                    'storagePortDictionary'  => $storagePortDictionary,
                    'externalPortDictionary' => $externalPortDictionary,
                    'slotQuantities'         => $slotQuantities,
                    'storagePortQuantities'  => $storagePortQuantities,
                    'externalPortQuantities' => $externalPortQuantities,
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
            'slotDictionary'         => $slotDictionary,
            'storagePortDictionary'  => $storagePortDictionary,
            'externalPortDictionary' => $externalPortDictionary,
            'slotQuantities'         => $slotQuantities,
            'storagePortQuantities'  => $storagePortQuantities,
            'externalPortQuantities' => $externalPortQuantities,
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

        $slotDictionary = $this->getSlotDictionary();
        $storagePortDictionary = $this->getStoragePortDictionary();
        $externalPortDictionary = $this->getExternalPortDictionary();

        $slotQuantities = $this->motherboardRepository->getSlotQuantitiesByMotherboard($model);
        $storagePortQuantities = $this->motherboardRepository->getStoragePortQuantitiesByMotherboard($model);
        $externalPortQuantities = $this->motherboardRepository->getExternalPortQuantitiesByMotherboard($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $data['slots'] = $this->prepareQuantities(
                Yii::$app->request->post('Motherboard')['slotTypes'],
                Yii::$app->request->post('Motherboard')['slotQuantities']
            );

            $data['storagePorts'] = $this->prepareQuantities(
                Yii::$app->request->post('Motherboard')['storagePortTypes'],
                Yii::$app->request->post('Motherboard')['storagePortQuantities']
            );

            $data['externalPorts'] = $this->prepareQuantities(
                Yii::$app->request->post('Motherboard')['externalPortTypes'],
                Yii::$app->request->post('Motherboard')['externalPortQuantities']
            );

            if ($this->motherboardRepository->updateWith($model, $data)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'                  => $model,
                    'manufacturerDictionary' => $manufacturerDictionary,
                    'formFactorDictionary'   => $formFactorDictionary,
                    'chipsetDictionary'      => $chipsetDictionary,
                    'socketDictionary'       => $socketDictionary,
                    'ramTypeDictionary'      => $ramTypeDictionary,
                    'slotDictionary'         => $slotDictionary,
                    'storagePortDictionary'  => $storagePortDictionary,
                    'externalPortDictionary' => $externalPortDictionary,
                    'slotQuantities'         => $slotQuantities,
                    'storagePortQuantities'  => $storagePortQuantities,
                    'externalPortQuantities' => $externalPortQuantities,
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
            'slotDictionary'         => $slotDictionary,
            'storagePortDictionary'  => $storagePortDictionary,
            'externalPortDictionary' => $externalPortDictionary,
            'slotQuantities'         => $slotQuantities,
            'storagePortQuantities'  => $storagePortQuantities,
            'externalPortQuantities' => $externalPortQuantities,
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

    /**
     * @return array
     */
    protected function getSlotDictionary()
    {
        return ArrayHelper::map($this->slotRepository->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getStoragePortDictionary()
    {
        return ArrayHelper::map($this->storagePortRepository->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getExternalPortDictionary()
    {
        return ArrayHelper::map($this->externalPortRepository->all(), 'id', 'name');
    }

    /**
     * @param $types
     * @param $quantities
     * @return array
     */
    protected function prepareQuantities($types, $quantities)
    {
        $result = [];

        for ($i = 0; $i < count($types); $i++) {

            if ((int)$quantities[$i] <= 0) {
                continue;
            }

            if (isset($result[$types[$i]])) {
                $result[$types[$i]] += (int)$quantities[$i];
            } else {
                $result[$types[$i]] = (int)$quantities[$i];
            }

        }

        return $result;
    }
}
