<?php

use yii\db\Migration;

/**
 * Handles the creation of table `storage_ports`.
 */
class m180110_135332_create_storage_ports_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `storage_ports` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL
                )'
            );

        } else {

            $this->createTable('storage_ports', [
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
                'DROP TABLE `storage_ports`'
            );

        } else {

            $this->dropTable('storage_ports');

        }
    }
}
