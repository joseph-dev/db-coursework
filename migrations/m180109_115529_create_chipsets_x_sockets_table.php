<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chipsets_x_sockets`.
 */
class m180109_115529_create_chipsets_x_sockets_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (APP_MODE === 'legacy') {

            $this->execute(
                'CREATE TABLE `chipsets_x_sockets` (
                    `chipset_id` int(11) NOT NULL,
                    `socket_id` int(11) NOT NULL
                )'
            );

            $this->execute('ALTER TABLE `chipsets_x_sockets` ADD UNIQUE INDEX `idx-unique-chipsets_x_sockets-chipset_id-socket_id` (`chipset_id`, `socket_id`)');

            $this->execute('ALTER TABLE `chipsets_x_sockets` ADD CONSTRAINT `fk-chipsets_x_sockets-chipset_id` FOREIGN KEY (`chipset_id`) REFERENCES `chipsets` (`id`) ON DELETE CASCADE');

            $this->execute('ALTER TABLE `chipsets_x_sockets` ADD CONSTRAINT `fk-chipsets_x_sockets-socket_id` FOREIGN KEY (`socket_id`) REFERENCES `sockets` (`id`) ON DELETE CASCADE');

        } else {

            $this->createTable('chipsets_x_sockets', [
                'chipset_id' => $this->integer()->notNull(),
                'socket_id'  => $this->integer()->notNull(),
            ]);

            $this->createIndex(
                'idx-unique-chipsets_x_sockets-chipset_id-socket_id',
                'chipsets_x_sockets',
                ['chipset_id', 'socket_id'],
                true
            );

            $this->addForeignKey(
                'fk-chipsets_x_sockets-chipset_id',
                'chipsets_x_sockets',
                'chipset_id',
                'chipsets',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-chipsets_x_sockets-socket_id',
                'chipsets_x_sockets',
                'socket_id',
                'sockets',
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
                'DROP TABLE `chipsets_x_sockets`'
            );

        } else {

            $this->dropTable('chipsets_x_sockets');

        }
    }
}
