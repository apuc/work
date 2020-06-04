<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m200604_134311_fill_status_column_on_users_table
 */
class m200604_134311_fill_status_column_on_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $users = (new Query())->from('user');
        foreach ($users->each() as $user) {
            if(\common\models\Vacancy::find()->where(['owner'=>$user['id']])->count() > 0) {
                if(\common\models\Company::find()->where(['owner'=>$user['id'], 'status'=>1])->andWhere(['!=', 'name', ''])->count() > 0)
                    $this->update('user', ['status'=>20], ['id'=>$user['id']]);
                else if (\common\models\Company::find()->where(['owner'=>$user['id'], 'status'=>1])->andWhere(['name' => ''])->count() > 0)
                    $this->update('user', ['status'=>21], ['id'=>$user['id']]);
            } else
                $this->update('user', ['status'=>10], ['id'=>$user['id']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
