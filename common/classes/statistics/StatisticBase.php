<?php

namespace common\classes\statistics;

use common\models\Resume;
use common\models\Vacancy;

interface StatisticBase
{
    public function createVacancy(): Vacancy;

    public function createResume(): Resume;
}