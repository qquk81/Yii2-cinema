<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%halls}}`.
 */
class m190926_163221_create_halls_table extends Migration
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

        $this->createTable('{{%halls}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text(),
            'raw_count' => $this->integer(),
            'place_count' => $this->integer(),
            'capacity' => $this->integer(11)
        ], $tableOptions);

        $this->db->createCommand("INSERT INTO `demo-db`.halls (id, name, description, raw_count, place_count, capacity) VALUES (1, 'Red hall', null, 20, 20, 400)")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%halls}}');
    }
}
