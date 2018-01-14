<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ram_types`.
 */
class m180110_104136_create_ram_types_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `ram_types` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL
                )'
            );

        } else {

            $this->createTable('ram_types', [
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
                'DROP TABLE `ram_types`'
            );

        } else {

            $this->dropTable('ram_types');

        }
    }
}
