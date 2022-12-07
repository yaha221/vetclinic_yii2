<?php

use yii\db\Migration;

/**
 * Class m221207_145037_create_complaint
 */
class m221207_145037_create_complaint extends Migration
{
    const TABLE_NAME = 'compaint';
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
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Плохо ест',
            'description' => 'В последнее время стал плохо кушать',
            'pet_id' => 1,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Постоянна лежит',
            'description' => 'В последнее время стал совсем ленивым',
            'pet_id' => 2,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Растолстел',
            'description' => 'В последнее время слишком много кушает',
            'pet_id' => 3,
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
        echo "m221207_145037_create_complaint cannot be reverted.\n";

        return false;
    }
    */
}
