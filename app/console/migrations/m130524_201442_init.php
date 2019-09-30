<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'email_confirm_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->db->createCommand('INSERT INTO `demo-db`.users (id, username, auth_key, password_hash, password_reset_token, email, email_confirm_token, status, created_at, updated_at) VALUES (1, \'admin\', \'iIy5TCbvTZNmlZdpA1XJXnVmt5Io18sg\', \'$2y$13$gOk8/luzsFqQcr6.OyZVfeTHg.SCdbJEgiolT0Z7Agchq6MwiM04i\', null, \'admin@mail.com\', null, 10, 1569504991, 1569504991)')->execute();
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
