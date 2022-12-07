<?php

use yii\db\Migration;

/**
 * Class m221207_144926_create_pet
 */
class m221207_144926_create_pet extends Migration
{
    const TABLE_NAME = 'pet';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'vet_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'compaint_id' => $this->integer()->notNull(),
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
        echo "m221207_144926_create_pet cannot be reverted.\n";

        return false;
    }
    */
}