<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chipsets`.
 */
class m180109_093242_create_chipsets_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `chipsets` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL
                )'
            );

        } else {

            $this->createTable('chipsets', [
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
                'DROP TABLE `chipsets`'
            );

        } else {

            $this->dropTable('chipsets');

        }
    }
}
