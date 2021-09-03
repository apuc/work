<?php

namespace common\classes\statistics;

use common\models\Resume;
use common\models\Vacancy;

class StatisticFactory implements StatisticBase
{
    public function createResume(): Resume
    {
        return new Resume();
    }

    public function createVacancy(): Vacancy
    {
        return new Vacancy();
    }
}