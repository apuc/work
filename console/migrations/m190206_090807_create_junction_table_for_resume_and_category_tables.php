<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume_category`.
 * Has foreign keys to the tables:
 *
 * - `resume`
 * - `category`
 */
class m190206_090807_create_junction_table_for_resume_and_category_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume_category', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);

        // creates index for column `resume_id`
        $this->createIndex(
            'idx-resume_category-resume_id',
            'resume_category',
            'resume_id'
        );

        // add foreign key for table `resume`
        $this->addForeignKey(
            'fk-resume_category-resume_id',
            'resume_category',
            'resume_id',
            'resume',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-resume_category-category_id',
            'resume_category',
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-resume_category-category_id',
            'resume_category',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `resume`
        $this->dropForeignKey(
            'fk-resume_category-resume_id',
            'resume_category'
        );

        // drops index for column `resume_id`
        $this->dropIndex(
            'idx-resume_category-resume_id',
            'resume_category'
        );

        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-resume_category-category_id',
            'resume_category'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-resume_category-category_id',
            'resume_category'
        );

        $this->dropTable('resume_category');
    }
}
