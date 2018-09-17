<?php

namespace api\modules\v1\controllers;

use common\models\User;

class UserController extends BaseController
{
    public $modelClass = 'common\models\User';

    public function actions() {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }
    
     protected function verbs()
    {
       return [
           'add' => ['POST'],
           'index' => ['GET'],
       ];
    }
    
    public function actionIndex($id="")
    {
        try {
		$this->getHeader(200);
                if($id != ""){
                    $newModel = new User();
                    $newModel->setAttribute('id', $id);
                    if($newModel->validate()){
                        $model = $this->loadModel($id);
                        return json_encode(['success' => 1, 'data' => $model->attributes], JSON_PRETTY_PRINT);
                    }else{
                        $this->getHeader(400);
                        return json_encode(['success' => 0, 'msg'=> "Invalid Id"]);
                    }
		}else{
		    $model = User::find()->asArray()->all();
		    return json_encode(['success' => 1, 'data' => $model], JSON_PRETTY_PRINT);
		}

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

     /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function loadModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            $this->getHeader(400);
            echo json_encode(['success' => 0, 'error_code' => 400, 'message' => 'Bad request'], JSON_PRETTY_PRINT);
            exit;
            // throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getHeader($status)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('SecretKey: ' . "xxxxx");
    }

    private function getStatusCodeMessage($status)
    {
        $codes = [
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}
