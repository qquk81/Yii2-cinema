<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tickets}}`.
 */
class m190926_175617_create_tickets_table extends Migration
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

        $this->createTable('{{%tickets}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'seance_id' => $this->integer(),
            'place_id' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(0)
        ], $tableOptions);

        $this->db->createCommand("INSERT INTO `demo-db`.tickets (id, created_at, seance_id, place_id, status) VALUES (1, '2019-09-28 18:27:28', 1, 1, 0)")->execute();
        $this->db->createCommand("INSERT INTO `demo-db`.tickets (id, created_at, seance_id, place_id, status) VALUES (2, '2019-09-28 18:27:59', 1, 2, 0);")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tickets}}');
    }
}
