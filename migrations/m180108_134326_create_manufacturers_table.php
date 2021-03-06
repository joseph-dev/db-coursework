<?php

use yii\db\Migration;

/**
 * Handles the creation of table `manufacturers`.
 */
class m180108_134326_create_manufacturers_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `manufacturers` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL
                )'
            );

        } else {

            $this->createTable('manufacturers', [
                'id'   => $this->primaryKey(),
                'name' => $this->string()->notNull(),
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
                'DROP TABLE `manufacturers`'
            );

        } else {

            $this->dropTable('manufacturers');

        }
    }
}
