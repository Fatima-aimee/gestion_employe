<?php
namespace App\Repository;

use App\Entity\Employe;

interface EmployeRepository
{
    public function add(Employe $employe): void;

    /**
     * @return Employe[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Employe;

    /**
     * Retourne tous les employés d’un département.
     *
     * @return Employe[]
     */
    public function findByDepartementId(int $departementId): array;
}
