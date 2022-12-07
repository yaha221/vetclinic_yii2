<?php

use yii\db\Migration;

/**
 * Class m221207_150907_create_vet
 */
class m221207_150907_create_vet extends Migration
{
    const TABLE_NAME = 'vet';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'fio' => $this->string(50)->notNull(),
            'age' => $this->integer()->notNull(),
            'phone' => $this->integer()->notNull(),
            'education' => $this->string(200)->notNull(),
            'wage' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
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
        echo "m221207_150907_create_vet cannot be reverted.\n";

        return false;
    }
    */
}
