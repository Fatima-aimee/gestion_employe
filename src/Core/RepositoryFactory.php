<?php

namespace App\Core;

use App\Repository\DepartementRepository;
use App\Repository\EmployeRepository;
use App\Repository\Memory\DepartementRepositoryMemory;
use App\Repository\Memory\EmployeRepositoryMemory;

class RepositoryFactory
{
    private static ?DepartementRepository $departementRepository = null;
    private static ?EmployeRepository $employeRepository = null;

    public static function departementRepository(): DepartementRepository
    {
        if (self::$departementRepository === null) {
            self::$departementRepository = new DepartementRepositoryMemory();
        }
        return self::$departementRepository;
    }

    public static function employeRepository(): EmployeRepository
    {
        if (self::$employeRepository === null) {
            self::$employeRepository = new EmployeRepositoryMemory();
        }
        return self::$employeRepository;
    }
}
