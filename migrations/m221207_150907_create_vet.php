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
            'phone' => $this->string(11)->notNull(),
            'experience' => $this->integer()->notNull(),
            'education' => $this->string(100)->notNull(),
            'wage' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
        
        $this->insert(self::TABLE_NAME,[
            'fio' => 'Пупкин В.В.',
            'age' => 25,
            'phone' => '89005553535',
            'experience' => 12,
            'education' => 'ВИВТ',
            'wage' => 40000,
            'user_id' => 2,
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
