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
            'client_id' => $this->integer(),
            'compaint_id' => $this->integer(),
            'medication_id' => $this->integer(),
            'course_of_treatment_id' => $this->integer(),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Жора',
            'vet_id' => 2,
            'client_id' => 1,
            'compaint_id' => 1,
            'medication_id' => 2,
            'course_of_treatment_id' => 1,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Петя',
            'vet_id' => 2,
            'client_id' => 1,
            'compaint_id' => 3,
            'medication_id' => 3,
            'course_of_treatment_id' => 2,
        ]);

        $this->insert(self::TABLE_NAME,[
            'name' => 'Валера',
            'vet_id' => 2,
            'client_id' => 2,
            'compaint_id' => 2,
            'medication_id' => 1,
            'course_of_treatment_id' => 3,
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
