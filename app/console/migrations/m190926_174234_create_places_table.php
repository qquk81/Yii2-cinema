<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%places}}`.
 */
class m190926_174234_create_places_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%places}}', [
            'id' => $this->primaryKey(),
            'hall_id' => $this->integer(),
            'raw' => $this->smallInteger(),
            'number' => $this->smallInteger()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-cinema_places-hall_id}}', '{{%places}}', 'hall_id', '{{%halls}}', 'id', 'CASCADE', 'RESTRICT');

        $this->db->createCommand("INSERT INTO `demo-db`.places (id, hall_id, raw, number) VALUES (1, 1, 1, 1)")->execute();
        $this->db->createCommand("INSERT INTO `demo-db`.places (id, hall_id, raw, number) VALUES (2, 1, 20, 15);")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%places}}');
    }
}
