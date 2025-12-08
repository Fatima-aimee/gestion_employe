<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Employe;
use App\Entity\Departement;
use App\Entity\Specialite;


class EmployeController extends AbstractController
{
    #[Route('/employe/list', name: 'employe_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $departementId = $request->query->get('departement_id');
        $search = $request->query->get('q');

        $departements = $em->getRepository(Departement::class)->findAll();

        // Création du query builder pour récupérer les employés
        $qb = $em->getRepository(Employe::class)->createQueryBuilder('e');

        // Filtre par département si sélectionné
        if ($departementId) {
            $qb->andWhere('e.departement = :dep')
               ->setParameter('dep', $departementId);
        }

        // Filtre par recherche sur le nom
        if ($search) {
            $safeSearch = addcslashes($search, '%_');
            $qb->andWhere('e.nom LIKE :search')
            ->setParameter('search', "%$safeSearch%");
        }

        // Exécution de la requête
        $employes = $qb->getQuery()->getResult();

        return $this->render('employe/index.html.twig', [
            'departements' => $departements,
            'employes' => $employes,
            'selectedDepartementId' => $departementId,
            'search' => $search,
        ]);
    }

    
}
