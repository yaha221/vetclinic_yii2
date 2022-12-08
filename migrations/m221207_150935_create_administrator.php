<?php

use yii\db\Migration;

/**
 * Class m221207_150935_create_administrator
 */
class m221207_150935_create_administrator extends Migration
{
    const TABLE_NAME = 'administrator';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'fio' => $this->string(50)->notNull(),
            'age' => $this->integer()->notNull(),
            'wage' => $this->integer()->notNull(),
            'experience' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
        
        $this->insert(self::TABLE_NAME,[
            'fio' => 'Путин В.В.',
            'age' => 20,
            'wage' => 25000,
            'experience' => 24,
            'user_id' => 3,
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
        echo "m221207_150935_create_administrator cannot be reverted.\n";

        return false;
    }
    */
}
