<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sockets`.
 */
class m180109_095937_create_sockets_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'modern') {

            $this->createTable('sockets', [
                'id'   => $this->primaryKey(),
                'name' => $this->string()->notNull()
            ]);

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `sockets` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL
                )'
            );

        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if (APP_MODE === 'modern') {

            $this->dropTable('sockets');

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'DROP TABLE `sockets`'
            );

        }
    }
}
