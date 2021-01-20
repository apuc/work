<?php


namespace common\classes\tariff;


use common\models\Company;

class TariffService
{
    /**
     * @var Company
     */
    protected $company;

    /**
     * Продолжительность действия закрепления в секундах при поднятии с закреплением.
     */
    const RAISE_WITH_ANCHOR_DEFAULT_DURATION = 2592000; //30 дней

    /**
     * TariffService constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Даёт компании возможность безлимитно размещать вакансии.
     *
     * @param int $time время в секундах начиная с текущего момента,
     * в течении которого будет действовать безлимит на вакансии.
     *
     * @return $this
     */
    public function setUnlimitedVacancies(int $time): TariffService
    {
        $this->company->unlimited_vacancies_until = time() + $time;
        return $this;
    }

    /**
     * Даёт компании возможность поднимать вакансии в топ с запреплением.
     *
     * @param int $count количество доступных закреплений
     * @param int $duration время в секундах, сколько будет доступна возможность закрепления. По умолчанию 30 дней.
     * @return $this
     */
    public function setRaiseWithAnchorCount(int $count, int $duration = self::RAISE_WITH_ANCHOR_DEFAULT_DURATION): TariffService
    {
        $this->company->raise_with_anchor_count = $count;
        $this->company->raise_with_anchor_until = time() + $duration;
        return $this;
    }

    /**
     *  Применяет изменения. Без вызова этого метода изменения не вступят в силу.
     *
     * @return bool
     */
    public function execute(): bool
    {
        return $this->company->save();
    }
}