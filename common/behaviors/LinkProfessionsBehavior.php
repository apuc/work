<?php


namespace common\behaviors;


use common\models\Professions;
use common\models\VacancyProfession;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class LinkProfessionsBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'linkProfessions',
            ActiveRecord::EVENT_AFTER_UPDATE => 'linkProfessions'
        ];
    }

    public function linkProfessions()
    {
        foreach (Professions::find()->each() as $profession) {
            if(
            strpos($this->owner->post, $profession->title) !== false ||
            strpos($this->owner->responsibilities, $profession->title) !== false ||
            strpos($this->owner->qualification_requirements, $profession->title) !== false ||
            strpos($this->owner->working_conditions, $profession->title) !== false ||

            strpos($this->owner->post, $profession->genitive) !== false ||
            strpos($this->owner->responsibilities, $profession->genitive) !== false ||
            strpos($this->owner->qualification_requirements, $profession->genitive) !== false ||
            strpos($this->owner->working_conditions, $profession->genitive) !== false ||

            strpos($this->owner->post, $profession->instrumental) !== false ||
            strpos($this->owner->responsibilities, $profession->instrumental) !== false ||
            strpos($this->owner->qualification_requirements, $profession->instrumental) !== false ||
            strpos($this->owner->working_conditions, $profession->instrumental) !== false
            ) {
                $vacancy_profession = new VacancyProfession();
                $vacancy_profession->vacancy_id = $this->owner->id;
                $vacancy_profession->profession_id = $profession->id;
                $vacancy_profession->save();
            } else {
                VacancyProfession::deleteAll([
                   'vacancy_id'=>$this->owner->id,
                   'profession_id'=>$profession->id
                ]);
            }

        }
    }
}



