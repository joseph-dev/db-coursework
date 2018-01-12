<?php

use yii\db\Migration;

/**
 * Handles the creation of table `slots`.
 */
class m180110_105138_create_slots_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'modern') {

            $this->createTable('slots', [
                'id'   => $this->primaryKey(),
                'name' => $this->string()->notNull()
            ]);

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `slots` (
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

            $this->dropTable('slots');

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'DROP TABLE `slots`'
            );

        }
    }
}
