<?php

use yii\db\Migration;

/**
 * Handles the creation of table `motherboadrs_x_slots`.
 */
class m180111_151124_create_motherboadrs_x_slots_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'modern') {

            $this->createTable('motherboadrs_x_slots', [
                'motherboard_id' => $this->integer()->notNull(),
                'slot_id'        => $this->integer()->notNull(),
                'quantity'       => $this->integer()->notNull(),
            ]);

            $this->createIndex(
                'idx-unique-mb_x_slots-mb_id-slot_id',
                'motherboadrs_x_slots',
                ['motherboard_id', 'slot_id'],
                true
            );

            $this->addForeignKey(
                'fk-motherboadrs_x_slots-motherboard_id',
                'motherboadrs_x_slots',
                'motherboard_id',
                'motherboards',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboadrs_x_slots-slot_id',
                'motherboadrs_x_slots',
                'slot_id',
                'slots',
                'id',
                'CASCADE'
            );

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `motherboadrs_x_slots` (
                    `motherboard_id` int(11) NOT NULL,
                    `slot_id` int(11) NOT NULL,
                    `quantity` int(11) NOT NULL
                )'
            );

            $this->execute('ALTER TABLE `motherboadrs_x_slots` ADD UNIQUE INDEX `idx-unique-mb_x_slots-mb_id-slot_id` (`motherboard_id`, `slot_id`)');

            $this->execute('ALTER TABLE `motherboadrs_x_slots` ADD CONSTRAINT `fk-motherboadrs_x_slots-motherboard_id` FOREIGN KEY (`motherboard_id`) REFERENCES `motherboards` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboadrs_x_slots` ADD CONSTRAINT `fk-motherboadrs_x_slots-slot_id` FOREIGN KEY (`slot_id`) REFERENCES `slots` (`id`) ON DELETE CASCADE');

        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if (APP_MODE === 'modern') {

            $this->dropTable('motherboadrs_x_slots');

        } elseif (APP_MODE === 'legacy') {

            $this->execute(
                'DROP TABLE `motherboadrs_x_slots`'
            );

        }
    }
}
