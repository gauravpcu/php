<?php

namespace app\modules\api\controllers;

use app\components\services\UserService;
use Exception;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Fetch users list
     * Pass "limit" param to get x number of users
     *
     */
    public function actionIndex()
    {
        try {
            $params = Yii::$app->request->get();
            $params['limit'] = $params['limit']??1;
            $userSvcObj = new UserService();
            $data = $userSvcObj->getUsers($params);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;
        } catch (Exception $e) {
            return $this->asJson(['Message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Fetch users list by manipulating (combined first and last names to "name" key, adding 100 to age)
     * Pass "limit" param to get x number of users
     *
     */
    public function actionManipulated()
    {
        try {
            $params = Yii::$app->request->get();
            $params['limit'] = $params['limit']??1;
            $userSvcObj = new UserService();
            $data = $userSvcObj->getUsersManipulated($params);
            return $this->asJson($data);
        } catch (Exception $e) {
            return $this->asJson(['Message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Creates the users based on id provided with user data
     */
    public function actionCreate()
    {
        try {
            $data = Yii::$app->request->post();
            $data = array_filter($data);
            if (empty($data)) {
                return $this->asJson(['message' => "Please Check Data provided for process"]);
            }
            $userSvcObj = new UserService();
            $data = $userSvcObj->createUsers($data);
            return $this->asJson($data);
        } catch (Exception $e) {
            return $this->asJson(['Message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Updates the users based on id provided with user data
     */
    public function actionUpdate()
    {
        try {
            $data = Yii::$app->request->post();
            $data = array_filter($data);
            if (empty($data)) {
                return $this->asJson(['message' => "Please Check Data provided for process"]);
            }
            $userSvcObj = new UserService();
            $data = $userSvcObj->updateUsers($data);
            return $this->asJson($data);
        } catch (Exception $e) {
            return $this->asJson(['Message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
