<?php

namespace App\Service;

use App\Entity\Employe;
use App\Entity\Specialite;

interface EmployeService
{
    public function ajouterEmploye(
        string $nom,
        string $tel,
        float $salaire,
        Specialite $specialite,
        int $departementId
    ): Employe;

    /**
     * @return Employe[]
     */
    public function listerEmployesParDepartement(int $departementId): array;
    public function listerEmployes(): array;
}
