<?php
namespace App\Repository\Memory;

use App\Entity\Departement;
use App\Repository\DepartementRepository;

class DepartementRepositoryMemory implements DepartementRepository
{
    /** @var Departement[] */
    private array $departements = [];

    private static int $autoId = 1;

    public function add(Departement $departement): void
    {
        if ($departement->getId() === 0) {
            $departement->setId(self::$autoId++);
        }

        $this->departements[] = $departement;
    }

    public function findAll(): array
    {
        return $this->departements;
    }

    public function findById(int $id): ?Departement
    {
        foreach ($this->departements as $dep) {
            if ($dep->getId() === $id) {
                return $dep;
            }
        }
        return null;
    }
}
