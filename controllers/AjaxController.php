<?php

namespace app\controllers;


use app\repositories\ChipsetLegacyRepository;
use app\repositories\ChipsetModernRepository;
use app\repositories\SocketLegacyRepository;
use app\repositories\SocketModernRepository;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

class AjaxController extends BaseController
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
     * AjaxController constructor.
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
        $this->view->params['activeMenuItem'] = 'home';
        return parent::beforeAction($action);
    }

    /**
     * @param $id
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionGetSocketsByChipset($id)
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $chipset = $this->chipsetRepository->find($id);

            if ($chipset) {
                $sockets = $this->socketRepository->findByChipset($chipset);
            } else {
                $sockets = [];
            }

            if (count($sockets)) {
                $data = [
                    'status' => 200,
                    'data'   => ArrayHelper::map($sockets, 'id', 'name')
                ];
            } else {
                $data = [
                    'status' => 404,
                    'data'   => []
                ];
            }

            return $data;
        } else {
            throw new BadRequestHttpException();
        }
    }
}
