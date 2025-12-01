<?php

namespace App\Core;

use App\Service\DepartementService;
use App\Service\EmployeService;
use App\Service\Impl\DepartementServiceImpl;
use App\Service\Impl\EmployeServiceImpl;

class ServiceFactory
{
    private static ?DepartementService $departementService = null;
    private static ?EmployeService $employeService = null;

    public static function departementService(): DepartementService
    {
        if (self::$departementService === null) {
            self::$departementService = new DepartementServiceImpl(
                RepositoryFactory::departementRepository()
            );
        }
        return self::$departementService;
    }

    public static function employeService(): EmployeService
    {
        if (self::$employeService === null) {
            self::$employeService = new EmployeServiceImpl(
                RepositoryFactory::employeRepository(),
                RepositoryFactory::departementRepository()
            );
        }
        return self::$employeService;
    }
}
