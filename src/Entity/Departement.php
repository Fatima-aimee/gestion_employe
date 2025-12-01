<?php
namespace App\Entity;

use App\Entity\Employe;


class Departement
{
    private int $id;
    private string $nom;

    /**
     * @var Employe[]
     */
    private array $employes = [];

    public function __construct(string $nom)
    {
        $this->id = 0;
        $this->nom = $nom;
        $this->employes = [];
    }

    public function setId(int $id): void
    {
        if ($this->id === 0) {
            $this->id = $id;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * Retourne la liste des employés du département.
     *
     * @return Employe[]
     */
    public function getEmployes(): array
    {
        return $this->employes;
    }

    /**
     * Ajoute un employé au département (met à jour la relation bidirectionnelle).
     */
    public function addEmploye(Employe $employe): void
    {
        foreach ($this->employes as $e) {
            if ($e->getId() === $employe->getId()) {
                return;
            }
        }

        $this->employes[] = $employe;

        if ($employe->getDepartement() !== $this) {
            $employe->setDepartement($this);
        }
    }

    /**
     * Retire un employé du département (met à jour la relation bidirectionnelle).
     */
    public function removeEmploye(Employe $employe): void
    {
        foreach ($this->employes as $idx => $e) {
            if ($e->getId() === $employe->getId()) {
                array_splice($this->employes, $idx, 1);
                break;
            }
        }

        if ($employe->getDepartement() === $this) {
            $employe->setDepartement(null);
        }
    }
}
