<?php

namespace common\models;

use Yii;
use yii\base\UserException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "promocode".
 *
 * @property int $id
 * @property string $code
 * @property int $active_until
 * @property int $created_at
 * @property int $usages_left
 * @property string $action
 */
class Promocode extends ActiveRecord
{
    public static function getActions() {
        return [
            'vacancy_renew' => 'Поднятие вакансии',
            'resume_audit' => 'Аудит резюме'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promocode';
    }

    public function behaviors()
    {
        return [
            'timestamp' => ['class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active_until', 'created_at'], 'integer'],
            [['usages_left'], 'integer', 'min'=>0],
            [['code'], 'required'],
            [['code'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'active_until' => 'Активен до',
            'created_at' => 'Создан',
            'usages_left' => 'Остально использований',
            'action' => 'Действие',
        ];
    }

    /**
     * @throws UserException
     */
    public function activate() {
        if ($this->active_until < time()) {
            throw new UserException('Срок действия промокода окончен.');
        }
        if ($this->usages_left === 0) {
            throw new UserException('Этот промокод достиг предела использований.');
        }
        if (Yii::$app->user->isGuest) {
            throw new UserException('Вы не авторизованы.');
        }
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($user->status < 20) {
            if ($this->action === 'vacancy_renew') {
                throw new UserException('Этот промокод доступен только для работодателей.');
            }
            if ($this->action === 'resume_audit') {
                if (PromocodeUser::register($this)) {
                    $user->employer->audit_count += 1;
                    $user->employer->save();
                } else {
                    throw new UserException('Вы уже использовали этот промокод.');
                }

            }
        } else if ($user->status >= 20) {
            if ($this->action === 'resume_audit') {
                throw new UserException('Этот промокод доступен только для соискателей.');
            }
            if ($this->action === 'vacancy_renew') {
                if (!$user->company) {
                    throw new UserException('Создайте компанию.');
                } else {
                    if (PromocodeUser::register($this)) {
                        $user->company->vacancy_renew_count += 3;
                        $user->company->save();
                    } else {
                        throw new UserException('Вы уже использовали этот промокод.');
                    }
                }
            }
        }
    }
}
