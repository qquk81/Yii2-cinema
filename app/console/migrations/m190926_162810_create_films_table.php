<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%films}}`.
 */
class m190926_162810_create_films_table extends Migration
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

        $this->createTable('{{%films}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text()
        ], $tableOptions);

        $this->db->createCommand("INSERT INTO `demo-db`.films (id, name, description) VALUES (1, 'Joker', 'Joker')")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%films}}');
    }
}
