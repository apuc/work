<?php


namespace common\classes\tariff;


use common\models\Company;

abstract class TariffBase
{
    /**
     * @var TariffService
     */
    protected $tariffService;

    /**
     * TariffBase constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->tariffService = new TariffService($company);
    }

    /**
     * @return bool
     */
    abstract function activate(): bool;
}