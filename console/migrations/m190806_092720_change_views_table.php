<?php

use yii\db\Migration;

/**
 * Class m190806_092720_change_views_table
 */
class m190806_092720_change_views_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $views = Yii::$app->db->createCommand('SELECT * FROM views')->queryAll();
        Yii::$app->db->createCommand()->truncateTable('views');
        $this->dropColumn('views', 'company_id');
        $this->dropColumn('views', 'vacancy_id');
        $this->addColumn('views', 'subject_type', $this->string(255));
        $this->addColumn('views', 'subject_id', $this->integer(11));
        foreach ($views as $view) {
            Yii::$app->db->createCommand()->insert('views', [
                'subject_type' => 'Vacancy',
                'subject_id' => $view['vacancy_id'],
                'viewer_id' => $view['viewer_id'],
                'dt_view' => $view['dt_view'],
            ])->execute();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190806_092720_change_views_table cannot be reverted.\n";

        return false;
    }
}
