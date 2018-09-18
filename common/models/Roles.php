<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property int $id
 * @property string $role
 * @property string $user_id
 * @property int $status
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'role'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role' => 'Role',
        ];
    }
}