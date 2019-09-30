<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sectors}}`.
 */
class m190926_172723_create_sectors_table extends Migration
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

        $this->createTable('{{%sectors}}', [
            'id' => $this->primaryKey(),
            'hall_id' => $this->integer(),
            'name' => $this->string(),
            'start_raw' => $this->smallInteger(),
            'end_raw' => $this->smallInteger()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-cinema_sectors-hall_id}}', '{{%seances}}', 'hall_id', '{{%halls}}', 'id', 'CASCADE', 'RESTRICT');

        $this->db->createCommand("INSERT INTO `demo-db`.sectors (id, hall_id, name, start_raw, end_raw) VALUES (1, 1, 'Start', 1, 19)")->execute();
        $this->db->createCommand("INSERT INTO `demo-db`.sectors (id, hall_id, name, start_raw, end_raw) VALUES (2, 1, 'Vip', 20, 20)")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sectors}}');
    }
}
