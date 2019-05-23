<?php
namespace common\models;

use common\models\base\WorkActiveRecord;

/**
 * This is the model class for table "resume_skill".
 *
 * @property integer $id
 * @property integer $resume_id
 * @property integer $skill_id
 *
 * @property Skill $skill
 * @property Resume $resume
 */
class ResumeSkill extends WorkActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resume_id', 'skill_id', 'owner'], 'integer'],
            [['resume_id', 'skill_id'], 'required'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skill_id']);
    }
}