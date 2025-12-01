<?php
namespace App\Service\Impl;

use App\Entity\Departement;
use App\Service\DepartementService;
use App\Repository\DepartementRepository;

class DepartementServiceImpl implements DepartementService
{
    public function __construct(
        private DepartementRepository $departementRepository
    ) {}

    public function ajouterDepartement(string $nom): Departement
    {
        $departement = new Departement($nom);
        $this->departementRepository->add($departement);
        return $departement;
    }

    public function listerDepartements(): array
    {
        return $this->departementRepository->findAll();
    }

    public function trouverDepartementParId(int $id): ?Departement
    {
        return $this->departementRepository->findById($id);
    }
}
