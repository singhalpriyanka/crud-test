<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property int $status
 */
class User extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = "create";
    const SCENARIO_UPDATE = "update";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username','last_name','first_name']; 
        $scenarios['update'] = ['id','username']; 
        return $scenarios; 
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name'], 'required','on'=>['create']],
            ['id', 'required','on'=>['update']],
            [['status','id'], 'integer'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['username'], 'unique', 'on' => 'update','targetClass' => '\common\models\User',
                'filter' => function ($query) {
                        $query->andWhere(['not', ['id' => $this->id]]);
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'status' => 'Status',
        ];
    }
}
