<?php

use yii\db\Migration;

/**
 * Handles the creation of table `form_factors`.
 */
class m180109_090729_create_form_factors_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'modern') {

            $this->createTable('form_factors', [
                'id'     => $this->primaryKey(),
                'name'   => $this->string()->notNull()
            ]);

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `form_factors` (
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

            $this->dropTable('form_factors');

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'DROP TABLE `form_factors`'
            );

        }
    }
}
