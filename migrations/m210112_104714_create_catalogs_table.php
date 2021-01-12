<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalogs`.
 */
class m210112_104714_create_catalogs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('catalogs', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'parent_id' => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk_catalogs_parent_id',
            'catalogs',
            'parent_id',
            'catalogs',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // создаем корневой каталог
        $this->insert('catalogs', ['title' => 'root']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('catalogs');
    }
}
