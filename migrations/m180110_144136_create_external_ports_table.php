<?php

use yii\db\Migration;

/**
 * Handles the creation of table `external_ports`.
 */
class m180110_144136_create_external_ports_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `external_ports` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL
                )'
            );

        } else {

            $this->createTable('external_ports', [
                'id'   => $this->primaryKey(),
                'name' => $this->string()->notNull()
            ]);

        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'DROP TABLE `external_ports`'
            );

        } else {

            $this->dropTable('external_ports');

        }
    }
}
