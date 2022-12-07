<?php

use yii\db\Migration;

/**
 * Class m221207_145012_create_course_of_treatment
 */
class m221207_145012_create_course_of_treatment extends Migration
{
    const TABLE_NAME = 'course_of_treatment';
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
            'name' => 'Назначен растолстин',
            'description' => 'В ходе осмотра выяснилось что у животного просто прекраснейший метаболизм',
            'pet_id' => 1,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Назначен нелинин',
            'description' => 'В ходе осмотра выяснилось что животное просто ленивое',
            'pet_id' => 2,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Назначен похудин',
            'description' => 'В ходе осмотра выяснилось что у животного просто ужаснейший метаболизм',
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
        echo "m221207_145012_create_course_of_treatment cannot be reverted.\n";

        return false;
    }
    */
}
