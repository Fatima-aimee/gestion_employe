<?php
namespace App\Entity;

use App\Entity\Specialite;


class Employe
{
    private int $id;
    private string $nom;
    private string $tel;
    private float $salaire;
    private Specialite $specialite;

    private ?Departement $departement;

    public function __construct(
        string $nom,
        string $tel,
        float $salaire,
        Specialite $specialite,
        ?Departement $departement = null
    ) {
        $this->id = 0;
        $this->nom = $nom;
        $this->tel = $tel;
        $this->salaire = $salaire;
        $this->specialite = $specialite;
        $this->departement = null;

        if ($departement !== null) {
            $this->setDepartement($departement);
        }
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

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    public function getSalaire(): float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): void
    {
        $this->salaire = $salaire;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): void
    {
        if ($this->departement !== null && $this->departement !== $departement) {
            $this->departement->removeEmploye($this);
        }

        $this->departement = $departement;

        if ($departement !== null) {
            $departement->addEmploye($this);
        }
    }
}
