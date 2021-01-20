<?php


namespace common\classes\tariff;


class StandardTariff extends TariffBase
{
    /**
     * Продолжительность действия безграничного количества вакансий в секундах.
     */
    const UNLIMITED_VACANCIES_DURATION = 2592000; //30 дней

    /**
     * Количество поднятий вакансий с закреплением.
     */
    const RAISE_WITH_ANCHOR_COUNT = 10;

    /**
     * @return bool
     */
    public function activate(): bool
    {
       return $this->tariffService
           ->setUnlimitedVacancies(self::UNLIMITED_VACANCIES_DURATION)
           ->setRaiseWithAnchorCount(self::RAISE_WITH_ANCHOR_COUNT)
           ->execute();
    }
}