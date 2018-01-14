<?php

use yii\db\Migration;

/**
 * Handles the creation of table `motherboards`.
 */
class m180110_154420_create_motherboards_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `motherboards` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(255) NOT NULL,
                    `manufacturer_id` int(11) NOT NULL,
                    `form_factor_id` int(11) NOT NULL,
                    `chipset_id` int(11) NOT NULL,
                    `socket_id` int(11) NOT NULL,
                    `ram_type_id` int(11) NOT NULL,
                    `ram_slots` int(11) NOT NULL,
                    `ram_max` int(11) NOT NULL,
                    `ram_chanels` int(11) NOT NULL,
                    `power_connector` varchar(255) NOT NULL,
                    `audio` varchar(255) NOT NULL,
                    `video` varchar(255) NOT NULL,
                    `height` int(11) NOT NULL,
                    `width` int(11) NOT NULL
                )'
            );

            $this->execute('ALTER TABLE `motherboards` ADD CONSTRAINT `fk-motherboards-manufacturer_id` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboards` ADD CONSTRAINT `fk-motherboards-form_factor_id` FOREIGN KEY (`form_factor_id`) REFERENCES `form_factors` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboards` ADD CONSTRAINT `fk-motherboards-chipset_id` FOREIGN KEY (`chipset_id`) REFERENCES `chipsets` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboards` ADD CONSTRAINT `fk-motherboards-socket_id` FOREIGN KEY (`socket_id`) REFERENCES `sockets` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `motherboards` ADD CONSTRAINT `fk-motherboards-ram_type_id` FOREIGN KEY (`ram_type_id`) REFERENCES `ram_types` (`id`) ON DELETE CASCADE');

        } else {

            $this->createTable('motherboards', [
                'id'   => $this->primaryKey(),
                'name' => $this->string()->notNull(),

                'manufacturer_id' => $this->integer()->notNull(),
                'form_factor_id'  => $this->integer()->notNull(),
                'chipset_id'      => $this->integer()->notNull(),
                'socket_id'       => $this->integer()->notNull(),
                'ram_type_id'     => $this->integer()->notNull(),

                'ram_slots'   => $this->integer()->notNull(),
                'ram_max'     => $this->integer()->notNull(),
                'ram_chanels' => $this->integer()->notNull(),

                'power_connector' => $this->string()->notNull(),
                'audio'           => $this->string()->notNull(),
                'video'           => $this->string()->notNull(),

                'height' => $this->integer()->notNull(),
                'width'  => $this->integer()->notNull(),
            ]);

            $this->addForeignKey(
                'fk-motherboards-manufacturer_id',
                'motherboards',
                'manufacturer_id',
                'manufacturers',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboards-form_factor_id',
                'motherboards',
                'form_factor_id',
                'form_factors',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboards-chipset_id',
                'motherboards',
                'chipset_id',
                'chipsets',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboards-socket_id',
                'motherboards',
                'socket_id',
                'sockets',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-motherboards-ram_type_id',
                'motherboards',
                'ram_type_id',
                'ram_types',
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
                'DROP TABLE `motherboards`'
            );

        } else {

            $this->dropTable('motherboards');

        }
    }
}
