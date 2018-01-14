<?php

use yii\db\Migration;

/**
 * Handles the creation of table `motherboadrs_x_external_ports`.
 */
class m180112_141250_create_motherboadrs_x_external_ports_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `motherboadrs_x_external_ports` (
                    `motherboard_id` int(11) NOT NULL,
                    `external_port_id` int(11) NOT NULL,
                    `quantity` int(11) NOT NULL
                )'
            );

            $this->execute('ALTER TABLE `motherboadrs_x_external_ports` ADD UNIQUE INDEX `idx-unique-mb_x_external_ports-mb_id-external_port_id` (`motherboard_id`, `external_port_id`)');

            $this->execute('ALTER TABLE `motherboadrs_x_external_ports` ADD CONSTRAINT `fk-motherboadrs_x_external_ports-motherboard_id` FOREIGN KEY (`motherboard_id`) REFERENCES `motherboards` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboadrs_x_external_ports` ADD CONSTRAINT `fk-motherboadrs_x_external_ports-external_port_id` FOREIGN KEY (`external_port_id`) REFERENCES `external_ports` (`id`) ON DELETE CASCADE');

        } else {

            $this->createTable('motherboadrs_x_external_ports', [
                'motherboard_id'   => $this->integer()->notNull(),
                'external_port_id' => $this->integer()->notNull(),
                'quantity'         => $this->integer()->notNull(),
            ]);

            $this->createIndex(
                'idx-unique-mb_x_external_ports-mb_id-external_port_id',
                'motherboadrs_x_external_ports',
                ['motherboard_id', 'external_port_id'],
                true
            );

            $this->addForeignKey(
                'fk-motherboadrs_x_external_ports-motherboard_id',
                'motherboadrs_x_external_ports',
                'motherboard_id',
                'motherboards',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboadrs_x_external_ports-external_port_id',
                'motherboadrs_x_external_ports',
                'external_port_id',
                'external_ports',
                'id',
                'CASCADE'
            );

        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'DROP TABLE `motherboadrs_x_external_ports`'
            );

        } else {

            $this->dropTable('motherboadrs_x_external_ports');

        }
    }
}
