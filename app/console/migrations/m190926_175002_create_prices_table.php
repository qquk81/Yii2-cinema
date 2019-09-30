<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 */
class m190926_175002_create_prices_table extends Migration
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
        $this->createTable('{{%prices}}', [
            'id' => $this->primaryKey(),
            'seance_id' => $this->integer(),
            'sector_id' => $this->integer(),
            'price' => $this->decimal()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-cinema_prices-seance_id}}', '{{%prices}}', 'seance_id', '{{%seances}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-cinema_prices-sector_id}}', '{{%prices}}', 'sector_id', '{{%sectors}}', 'id', 'CASCADE', 'RESTRICT');

        $this->db->createCommand("INSERT INTO `demo-db`.prices (id, seance_id, sector_id, price) VALUES (1, 1, 1, 70)")->execute();
        $this->db->createCommand("INSERT INTO `demo-db`.prices (id, seance_id, sector_id, price) VALUES (2, 1, 2, 100)")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prices}}');
    }
}
