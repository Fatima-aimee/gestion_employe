<?php
namespace App\Repository\Memory;

use App\Entity\Employe;
use App\Repository\EmployeRepository;

class EmployeRepositoryMemory implements EmployeRepository
{
    /** @var Employe[] */
    private array $employes = [];

    private static int $autoId = 1;

    public function add(Employe $employe): void
    {
        if ($employe->getId() === 0) {
            $employe->setId(self::$autoId++);
        }

        $this->employes[] = $employe;
    }

    public function findAll(): array
    {
        return $this->employes;
    }

    public function findById(int $id): ?Employe
    {
        foreach ($this->employes as $emp) {
            if ($emp->getId() === $id) {
                return $emp;
            }
        }
        return null;
    }

    public function findByDepartementId(int $departementId): array
    {
        $result = [];
        foreach ($this->employes as $emp) {
            if ($emp->getDepartement()?->getId() === $departementId) {
                $result[] = $emp;
            }
        }
        return $result;
    }
}
