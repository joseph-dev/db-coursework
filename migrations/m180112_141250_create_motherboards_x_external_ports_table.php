<?php

use yii\db\Migration;

/**
 * Handles the creation of table `motherboards_x_external_ports`.
 */
class m180112_141250_create_motherboards_x_external_ports_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `motherboards_x_external_ports` (
                    `motherboard_id` int(11) NOT NULL,
                    `external_port_id` int(11) NOT NULL,
                    `quantity` int(11) NOT NULL
                )'
            );

            $this->execute('ALTER TABLE `motherboards_x_external_ports` ADD UNIQUE INDEX `idx-unique-mb_x_external_ports-mb_id-external_port_id` (`motherboard_id`, `external_port_id`)');

            $this->execute('ALTER TABLE `motherboards_x_external_ports` ADD CONSTRAINT `fk-motherboards_x_external_ports-motherboard_id` FOREIGN KEY (`motherboard_id`) REFERENCES `motherboards` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboards_x_external_ports` ADD CONSTRAINT `fk-motherboards_x_external_ports-external_port_id` FOREIGN KEY (`external_port_id`) REFERENCES `external_ports` (`id`) ON DELETE CASCADE');

        } else {

            $this->createTable('motherboards_x_external_ports', [
                'motherboard_id'   => $this->integer()->notNull(),
                'external_port_id' => $this->integer()->notNull(),
                'quantity'         => $this->integer()->notNull(),
            ]);

            $this->createIndex(
                'idx-unique-mb_x_external_ports-mb_id-external_port_id',
                'motherboards_x_external_ports',
                ['motherboard_id', 'external_port_id'],
                true
            );

            $this->addForeignKey(
                'fk-motherboards_x_external_ports-motherboard_id',
                'motherboards_x_external_ports',
                'motherboard_id',
                'motherboards',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboards_x_external_ports-external_port_id',
                'motherboards_x_external_ports',
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
                'DROP TABLE `motherboards_x_external_ports`'
            );

        } else {

            $this->dropTable('motherboards_x_external_ports');

        }
    }
}
