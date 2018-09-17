<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;

/**
 * User Controller API
 */
class BaseController extends ActiveController {

    public $modelClass = 'common\models\User';

    public function behaviors() {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => yii\filters\auth\HttpBearerAuth::className(),
//        ];
        return $behaviors;
    }

}
