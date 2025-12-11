<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Departement;
use App\Entity\Employe;
use App\Entity\Specialite;
use App\Repository\DepartementRepository;
use Dom\Entity;

class AppFixtures extends Fixture
{   private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em, private readonly DepartementRepository $repo)
    {
        $this->em = $em;
    }
    public function load(ObjectManager $manager): void
    {   
        for ($i = 1; $i <= 5; $i++){
            $departement = new Departement();
            $departement->setNom('Département ' . $i);
            $departement->setIsActive(true);
            $departement->setCreatedAt(new \DateTimeImmutable());
            $this->em->persist($departement);
        }
        $this->em->flush();
        $departements = $this->repo->findAll();
        foreach($departements as $key => $dep){
            for ($j = 1; $j <= 10; $j++){
                $employe = new Employe();
                $employe->setNom('Employé ' . $j.'-'. $dep->getNom());
                $specialites = Specialite::cases();
                $employe->setSpecialite($specialites[array_rand($specialites)]);
                $employe->setCreatedAt(new \DateTimeImmutable());
                $employe->setTel('070000000' .$key. $j);
                $employe->setIsActive(true);
                $employe->setDepartement($dep);
                $this->em->persist($employe);
            }
        }
        $this->em->flush();
    }
}
