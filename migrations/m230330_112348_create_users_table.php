<?php

use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m230330_112348_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $result = Yii::$app->db->createCommand("SHOW TABLES LIKE '" . User::tableName() . "'")->execute();
            if ($result == 0) {
                $this->createTable(User::tableName(), [
                    'id' => 'int(10) unsigned not null AUTO_INCREMENT PRIMARY KEY',
                    'first_name' => $this->string('255')->notNull(),
                    'last_name' => $this->string('255')->notNull(),
                    'email' => $this->string('255')->notNull(),
                    'password' => $this->string('255')->notNull(),
                    'age' => $this->integer()->null()
                ]);
            }
        } catch (Exception $e) {
            echo 'Exception : ' . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(User::tableName());
    }
}
