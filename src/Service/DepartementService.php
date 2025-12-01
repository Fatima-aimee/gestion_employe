<?php

namespace App\Service;

use App\Entity\Departement;

interface DepartementService
{
    public function ajouterDepartement(string $nom): Departement;

    /**
     * @return Departement[]
     */
    public function listerDepartements(): array;

    public function trouverDepartementParId(int $id): ?Departement;
}
