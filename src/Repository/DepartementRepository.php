<?php
namespace App\Repository;

use App\Entity\Departement;

interface DepartementRepository
{
    public function add(Departement $departement): void;

    /**
     * @return Departement[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Departement;
}
