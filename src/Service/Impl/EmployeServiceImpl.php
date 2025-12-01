<?php

namespace App\Service\Impl;

use App\Entity\Employe;
use App\Entity\Specialite;
use App\Service\EmployeService;
use App\Repository\EmployeRepository;
use App\Repository\DepartementRepository;

class EmployeServiceImpl implements EmployeService
{
    public function __construct(
        private EmployeRepository $employeRepository,
        private DepartementRepository $departementRepository
    ) {}

    public function ajouterEmploye(
        string $nom,
        string $tel,
        float $salaire,
        Specialite $specialite,
        int $departementId
    ): Employe {

        // 1. Vérifier que le département existe
        $departement = $this->departementRepository->findById($departementId);
        if (!$departement) {
            throw new \Exception("Le département avec ID $departementId n'existe pas.");
        }

        // 2. Créer l'objet Employe
        $employe = new Employe(
            $nom,
            $tel,
            $salaire,
            $specialite,
            $departement
        );

        // 3. Ajouter employé dans le repository
        $this->employeRepository->add($employe);

        // 4. Relation bidirectionnelle
        $departement->addEmploye($employe);

        return $employe;
    }

    public function listerEmployesParDepartement(int $departementId): array
    {
        return $this->employeRepository->findByDepartementId($departementId);
    }

    public function listerEmployes(): array
    {
        return $this->employeRepository->findAll();
    }
}