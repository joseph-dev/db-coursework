<?php

use yii\db\Migration;

/**
 * Handles the creation of table `motherboards_x_slots`.
 */
class m180111_151124_create_motherboards_x_slots_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `motherboards_x_slots` (
                    `motherboard_id` int(11) NOT NULL,
                    `slot_id` int(11) NOT NULL,
                    `quantity` int(11) NOT NULL
                )'
            );

            $this->execute('ALTER TABLE `motherboards_x_slots` ADD UNIQUE INDEX `idx-unique-mb_x_slots-mb_id-slot_id` (`motherboard_id`, `slot_id`)');

            $this->execute('ALTER TABLE `motherboards_x_slots` ADD CONSTRAINT `fk-motherboards_x_slots-motherboard_id` FOREIGN KEY (`motherboard_id`) REFERENCES `motherboards` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboards_x_slots` ADD CONSTRAINT `fk-motherboards_x_slots-slot_id` FOREIGN KEY (`slot_id`) REFERENCES `slots` (`id`) ON DELETE CASCADE');

        } else {

            $this->createTable('motherboards_x_slots', [
                'motherboard_id' => $this->integer()->notNull(),
                'slot_id'        => $this->integer()->notNull(),
                'quantity'       => $this->integer()->notNull(),
            ]);

            $this->createIndex(
                'idx-unique-mb_x_slots-mb_id-slot_id',
                'motherboards_x_slots',
                ['motherboard_id', 'slot_id'],
                true
            );

            $this->addForeignKey(
                'fk-motherboards_x_slots-motherboard_id',
                'motherboards_x_slots',
                'motherboard_id',
                'motherboards',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboards_x_slots-slot_id',
                'motherboards_x_slots',
                'slot_id',
                'slots',
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
                'DROP TABLE `motherboards_x_slots`'
            );

        } else {

            $this->dropTable('motherboards_x_slots');

        }
    }
}
