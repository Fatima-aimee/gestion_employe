<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\ServiceFactory;
use App\Entity\Specialite;


$departementService = ServiceFactory::departementService();
$employeService = ServiceFactory::employeService();

function menu(): void
{
    echo "\n=== GESTION EMPLOYES ===\n";
    echo "1. Enregistrer un service\n";
    echo "2. Lister tous les services\n";
    echo "3. Enregistrer un employé dans un service\n";
    echo "4. Lister les employés d’un service\n";
    echo "5. Lister tous les employés\n";
    echo "6. Quitter\n";
    echo "Votre choix : ";
}

while (true) {
    menu();
    $choix = trim(fgets(STDIN));

    switch ($choix) {

        case "1": 
            echo "1.Enregistrer un service\n";
            echo "Nom du service : ";
            $nom = trim(fgets(STDIN));
            $dep = $departementService->ajouterDepartement($nom);
            echo "✔ Service '{$dep->getNom()}' ajouté avec ID {$dep->getId()}\n";
            break;

        case "2": 
            echo "2.Lister tous les services\n";
            $deps = $departementService->listerDepartements();
            if (empty($deps)) {
                echo "Aucun service enregistré.\n";
            } else {
                echo "--- LISTE DES SERVICES ---\n";
                foreach ($deps as $d) {
                    echo "ID: {$d->getId()} | Nom: {$d->getNom()}\n";
                }
            }
            break;

        case "3": 
            echo "3.Enregistrer un employé dans un service\n";
            $deps = $departementService->listerDepartements();
            if (empty($deps)) {
                echo "Aucun service disponible. Ajoutez un service d'abord.\n";
                break;
            }

            echo "Nom de l'employé : ";
            $nom = trim(fgets(STDIN));
            echo "Téléphone : ";
            $tel = trim(fgets(STDIN));
            echo "Salaire : ";
            $salaire = (float) trim(fgets(STDIN));

            // Choix du service
            echo "Sélectionnez le service (ID) :\n";
            foreach ($deps as $d) {
                echo "{$d->getId()} - {$d->getNom()}\n";
            }
            $depId = (int) trim(fgets(STDIN));

            // Choix de la spécialité
            echo "Spécialité (1=FULLSTACK, 2=BACKEND, 3=FRONTEND) : ";
            $sp = (int) trim(fgets(STDIN));
            $specialite = match($sp) {
                1 => Specialite::FULLSTACK,
                2 => Specialite::BACKEND,
                3 => Specialite::FRONTEND,
                default => Specialite::FULLSTACK
            };

            try {
                $emp = $employeService->ajouterEmploye($nom, $tel, $salaire, $specialite, $depId);
                echo "Employé '{$emp->getNom()}' ajouté dans le service '{$emp->getDepartement()->getNom()}'\n";
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage() . "\n";
            }

            break;

        case "4": 
            echo "4.Lister les employés d’un service\n";
            $deps = $departementService->listerDepartements();
            if (empty($deps)) {
                echo "Aucun service disponible.\n";
                break;
            }

            echo "Sélectionnez le service pour voir ses employés (ID) :\n";
            foreach ($deps as $d) {
                echo "{$d->getId()} - {$d->getNom()}\n";
            }
            $depId = (int) trim(fgets(STDIN));

            $employes = $employeService->listerEmployesParDepartement($depId);
            if (empty($employes)) {
                echo "Aucun employé dans ce service.\n";
            } else {
                echo "--- EMPLOYES DU SERVICE ---\n";
                foreach ($employes as $e) {
                    echo "ID: {$e->getId()} | Nom: {$e->getNom()} | Tel: {$e->getTel()} | Salaire: {$e->getSalaire()} | Spécialité: {$e->getSpecialite()->value}\n";
                }
            }
            break;

        case "5":
            echo "5.Lister tous les employés\n";
            $employes = $employeService->listerEmployes();
            if (empty($employes)) {
                echo "Aucun employé enregistré.\n";
            } else {
                echo "--- LISTE DES EMPLOYES ---\n";
                foreach ($employes as $e) {
                    echo "ID: {$e->getId()} | Nom: {$e->getNom()} | Tel: {$e->getTel()} | Salaire: {$e->getSalaire()} | Spécialité: {$e->getSpecialite()->value} | Service: {$e->getDepartement()->getNom()}\n";
                }
            }
            break; 
        case "6": 
            echo "Au revoir!\n";
            exit(0);
            

        default:
            echo "Choix invalide.\n";
    }
}
