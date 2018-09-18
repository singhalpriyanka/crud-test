<?php

use yii\db\Migration;

/**
 * Class m180918_123722_user_role
 */
class m180918_123722_user_role extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_role}}');
    }
    
}
