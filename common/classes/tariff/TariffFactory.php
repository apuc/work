<?php


namespace common\classes\tariff;


use common\models\Company;

class TariffFactory
{
    public static $enum = [
        'standard' => StandardTariff::class
    ];

    /**
     * @param string $name
     * @param Company $company
     * @return TariffBase|null
     */
    public function getTariffByName(string $name, Company $company)
    {
        if (isset(self::$enum[$name])) {
            return new self::$enum[$name]($company);
        }
        return null;
    }
}