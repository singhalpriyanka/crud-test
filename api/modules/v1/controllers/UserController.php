<?php

namespace api\modules\v1\controllers;

use common\models\User;

class UserController extends BaseController
{
    public $modelClass = 'common\models\User';

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'],$actions['delete']);
        return $actions;
    }
    
     protected function verbs()
    {
       return [
           'add' => ['POST'],
           'edit' => ['PUT'],
           'index' => ['GET'],
           'roles' => ['GET'],
           'delete' => ['DELETE'],
       ];
    }
    
    /*
     * GET API to fetch User data
     */
    public function actionIndex($id="")
    {
        try {
                \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
		
                if($id != ""){
                    $newModel = new User();
                    $newModel->setAttribute('id', $id);
                    if($newModel->validate()){
                        $model = $this->loadModel($id);
                        $this->getHeader(200);
                        return ['success' => 1, 'data' => $model->attributes];
                    }else{
                        $this->getHeader(400);
                        return ['success' => 0, 'data'=> $newModel->getErrors()];
                    }
		}else{
		    $model = User::find()->asArray()->all();
                    $this->getHeader(200);
		    return ['success' => 1, 'data' => $model];
		}

        } catch (\Exception $ex) {
            throw $ex;
        }
    }
    
    /*
     * POST Request to add new User
     */
    public function actionAdd() {
        try{
        
            \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

            $user = new User();
            $user->scenario = User:: SCENARIO_CREATE;
            $user->attributes = \yii::$app->request->post();
            
            if($user->validate())
            {
                $user->save();
                return array('success' => 1, 'data'=> 'User record is successfully saved');
            }
            else
            {
                return array('success' => 0,'data'=>$user->getErrors());    
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /*
     * PUT Request to edit existing User
     */
    public function actionEdit($id) {
        
        try{
        
            \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
            
            $user = $this->loadModel($id);
            $user->scenario = User:: SCENARIO_UPDATE;
            $user->attributes = \yii::$app->request->post();
            if($user->validate())
            {
                $user->save(false);
                return array('success' => 1, 'data'=> 'User record is successfully saved');
            }
            else
            {
                return array('success' => 0,'data'=>$user->getErrors());    
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
 
    }
    
    /*
     * DELETE API to delete User data
     */
    public function actionDelete($id)
    {
        try {
                \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
		
                $model = $this->loadModel($id);
                $model->deleteAll(['id'=>$id]);
                $this->getHeader(200);
                return ['success' => 1, 'data' => 'User has been deleted successfully'];

        } catch (\Exception $ex) {
            throw $ex;
        }
    }
    
    /*
     * GET API to fetch User Roles
     */
    public function actionRoles($id)
    {
        try {
                \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
		
                $model = $this->loadModel($id);
                $roles = $model->roles;
                if(count($roles) > 0){
                    $this->getHeader(200);
                    return ['success' => 1, 'data' => $roles];
                }else{
                    $this->getHeader(400);
                    return ['success' => 0, 'error_code' => 400, 'message' => "This user has no role assigned yet!"];
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
