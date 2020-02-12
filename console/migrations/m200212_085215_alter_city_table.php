<?php

use yii\db\Migration;

/**
 * Class m200212_085215_alter_city_table
 */
class m200212_085215_alter_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('geobase_city', 'resume_meta_title', $this->string());
        $this->addColumn('geobase_city', 'resume_meta_description', $this->text());
        $this->addColumn('geobase_city', 'resume_header', $this->string());
        $this->addColumn('geobase_city', 'resume_bottom_text', $this->text());
        /** @var \common\models\City $city */
        foreach (\common\models\City::find()->each() as $city) {
            $city->resume_meta_title = str_replace(['работа', 'работу'], 'резюме', str_replace(['Работа', 'Работу'], 'Резюме', $city->meta_title));
            $city->resume_meta_description = str_replace(['работа', 'работу'], 'резюме', str_replace(['Работа', 'Работу'], 'Резюме', $city->meta_description));
            $city->resume_header = str_replace(['работа', 'работу'], 'резюме', str_replace(['Работа', 'Работу'], 'Резюме', $city->header));
            $city->resume_bottom_text = str_replace(['работа', 'работу'], 'резюме', str_replace(['Работа', 'Работу'], 'Резюме', $city->bottom_text));
            $city->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('geobase_city', 'resume_meta_title');
        $this->dropColumn('geobase_city', 'resume_meta_description');
        $this->dropColumn('geobase_city', 'resume_header');
        $this->dropColumn('geobase_city', 'resume_bottom_text');
    }

}
