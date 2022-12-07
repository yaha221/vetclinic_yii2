<?php

use yii\db\Migration;

/**
 * Class m221207_145100_create_medication
 */
class m221207_145100_create_medication extends Migration
{
    const TABLE_NAME = 'medication';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'description' => $this->string(150)->notNull(),
            'pet_id' => $this->integer()->notNull(),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Похудин',
            'description' => 'Помогает животному снизить вес',
            'pet_id' => 3,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Растолстин',
            'description' => 'Помогает животному набрать вес',
            'pet_id' => 1,
        ]);
        
        $this->insert(self::TABLE_NAME,[
            'name' => 'Неленин',
            'description' => 'Помогает животному набраться энергии',
            'pet_id' => 2,
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
        echo "m221207_145100_create_medication cannot be reverted.\n";

        return false;
    }
    */
}
