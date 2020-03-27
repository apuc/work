<?php

use yii\db\Migration;

/**
 * Class m200327_094223_add_profession_to_meta_data
 */
class m200327_094223_add_profession_to_meta_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('meta_data', 'profession_id', $this->integer()->after('category_id'));
        $this->addForeignKey('meta_data_profession', 'meta_data', 'profession_id', 'professions', 'id');
        /** @var \common\models\Professions $profession */
        foreach (\common\models\Professions::find()->each() as $profession) {
            $this->insert('meta_data', [
                'profession_id' => $profession->id,
                'vacancy_meta_title' => "Работа $profession->instrumental. Вакансии $profession->genitive.",
                'vacancy_meta_description' => "Открытые вакансии $profession->genitive. Поиск работы $profession->instrumental. Свежие вакансии на сегодня.",
                'vacancy_header' => "Работа $profession->instrumental.",
                'vacancy_meta_title_with_city' => "Работа $profession->instrumental в {city_prep}. Вакансии $profession->genitive - {city}, {region}",
                'vacancy_meta_description_with_city' => "Открытые вакансии $profession->genitive в {city_prep}, {region}. Поиск работы $profession->instrumental - {city}. Свежие вакансии на сегодня.",
                'vacancy_header_with_city' => "Работа $profession->instrumental в {city_prep}",
                "vacancy_bottom_text" => "Вакансии по запросу - $profession->title. Свежие вакансии $profession->genitive. Выбирайте работу и отправляйте резюме! Так же на странице вакансии Вы найдете контактный телефон работодателя. Если вы не нашли подходящую вакансию $profession->genitive, разместите свое резюме на сайте и работодатели свяжутся с Вами! Сайт поиска работы №1!"
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('meta_data', ['!=', 'profession_id', null]);
        $this->dropForeignKey('meta_data_profession', 'meta_data');
        $this->dropColumn('meta_data', 'profession_id');
    }
}
