<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sances}}`.
 */
class m190926_165946_create_sances_table extends Migration
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
        $this->createTable('{{%seances}}', [
            'id' => $this->primaryKey(),
            'hall_id' => $this->integer(),
            'film_id' => $this->integer(),
            'datetime' => $this->dateTime()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-cinema_seance-hall_id}}', '{{%seances}}', 'hall_id', '{{%halls}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-cinema_seance-film_id}}', '{{%seances}}', 'film_id', '{{%films}}', 'id', 'CASCADE', 'RESTRICT');

        $this->db->createCommand("INSERT INTO `demo-db`.seances (id, hall_id, film_id, datetime) VALUES (1, 1, 1, '2019-09-28 18:26:26')")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seances}}');
    }
}
