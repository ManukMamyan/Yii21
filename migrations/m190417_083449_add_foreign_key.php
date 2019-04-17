<?php

use yii\db\Migration;

/**
 * Class m190417_083449_add_foreign_key
 */
class m190417_083449_add_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_taskuser_user', 'task_user', ['user_id'], 'user', ['id']);
        $this->addForeignKey('fx_taskuser_task', 'task_user', ['task_id'], 'task', ['id']);
        $this->addForeignKey('fx_task_user1', 'task', ['creator_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_user2', 'task', ['updater_id'], 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_taskuser_user', 'task_user');
        $this->dropForeignKey('fx_taskuser_task', 'task_user');
        $this->dropForeignKey('fx_task_user1', 'task');
        $this->dropForeignKey('fx_task_user2', 'task');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190417_083449_add_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
