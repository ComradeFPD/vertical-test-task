<?php

use yii\db\Migration;

/**
 * Handles adding activation_key to table `user`.
 */
class m180305_085414_add_activation_key_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'activation_key', $this->string()->unique()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('user', 'activation_key');
    }
}
