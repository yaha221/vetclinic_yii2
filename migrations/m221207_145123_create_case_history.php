<?php

use yii\db\Migration;

/**
 * Class m221207_145123_create_case_history
 */
class m221207_145123_create_case_history extends Migration
{
    const TABLE_NAME = 'case_history';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'case' => $this->string(50)->notNull(),
            'description' => $this->string(150)->notNull(),
            'pet_id' => $this->integer()->notNull(),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221207_145123_create_case_history cannot be reverted.\n";

        return false;
    }
    */
}
