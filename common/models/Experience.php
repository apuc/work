<?php
namespace common\models;

use common\models\base\WorkActiveRecord;
use phpDocumentor\Reflection\Types\Array_;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "experience".
 *
 * @property integer $id
 * @property integer $resume_id
 * @property string $name
 * @property string $city
 * @property string $post
 * @property string $responsibility
 * @property integer $month_from
 * @property integer $month_to
 * @property integer $year_from
 * @property integer $year_to
 * @property string $department
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $period_string
 *
 * @property Resume $resume
 */
class Experience extends WorkActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static $months = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'experience';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resume_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['month_from', 'month_to'], 'integer', 'max' => 12],
            [['year_from', 'year_to'], 'integer', 'max' => date('Y')],
            [['name', 'city', 'post', 'department'], 'string', 'max' => 255],
            [['responsibility'], 'string'],
            [['resume_id', 'name'], 'required'],
        ];
    }

    public function extraFields()
    {
        return ['resume'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resume_id' => 'Резюме',
            'name' => 'Название',
            'city' => 'Город',
            'post' => 'Должность',
            'responsibility' => 'Обязанности',
            'month_from' => 'Месяц начала',
            'month_to' => 'Месяц окончания',
            'year_from' => 'Год начала',
            'year_to' => 'Год окончания',
            'department' => 'Обязанности',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен'
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
     * @return array
     */
    public function getPeriod(){
        $years = $this->year_to - $this->year_from;
        if($this->month_to >= $this->month_from){
            $months = $this->month_to - $this->month_from;
        } else {
            $years--;
            $months = 12 - ($this->month_from - $this->month_to);
        }
        if($years < 0) $years = 0;
        return [
            'years' => $years,
            'months' => $months
        ];
    }


    /**
     * @param array $period
     * @return string
     */
    public static function getPeriod_string($period)
    {
        $result = '';
        if($period['years'] > 0) {
            $result .= $period['years'];
            if ($period['years'] > 10 && $period['years'] < 20)
                $result .= ' лет ';
            else if ($period['years'] % 10 === 0)
                $result .= ' лет ';
            else if ($period['years'] % 10 === 1)
                $result .= ' год ';
            else if ($period['years'] % 10 >= 2 && $period['years'] % 10 <= 4)
                $result .= ' года ';
            else if ($period['years'] % 10 >= 5 && $period['years'] % 10 <= 9)
                $result .= ' лет ';
        }

        if($period['months'] > 0) {
            $result .= $period['months'];
            if ($period['months'] > 10 && $period['months'] < 20)
                $result .= ' месяцев ';
            else if ($period['months'] % 10 === 0)
                $result .= ' месяцев ';
            else if ($period['months'] % 10 === 1)
                $result .= ' месяц ';
            else if ($period['months'] % 10 >= 2 && $period['months'] % 10 <= 4)
                $result .= ' месяца ';
            else if ($period['months'] % 10 >= 5 && $period['months'] % 10 <= 9)
                $result .= ' месяцев ';
        }

        return $result;
    }

    /**
     * @param Experience[] $experiences
     * @return array
     */
    public static function getPeriod_sum($experiences)
    {
        $result = [
            'years' => 0,
            'months' => 0
        ];
        if ($experiences) {
            foreach ($experiences as $experience) {
                $period = $experience->getPeriod();
                $result['years'] += $period['years'];
                $result['months'] += $period['months'];
            }
        }
        $months_over = (int)($result['months'] / 12);
        if ($months_over > 0) {
            $result['months'] -= 12 * $months_over;
            $result['years'] += $months_over;
        }
        return $result;
    }

}