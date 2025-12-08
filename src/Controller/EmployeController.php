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

    #[Route('/employe/new', name: 'employe_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $departements = $em->getRepository(Departement::class)->findAll();
        $specialites = Specialite::cases();

        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $tel = $request->request->get('tel');
            $salaire = $request->request->get('salaire');
            $specialite = $request->request->get('specialite');
            $departementId = $request->request->get('departement_id');

            $errors = [];
            if (!$nom) $errors[] = 'Le nom est obligatoire.';
            if (!$specialite) $errors[] = 'La spécialité est obligatoire.';
            if (!$departementId) $errors[] = 'Le département est obligatoire.';

            if (empty($errors)) {
                $departement = $em->getRepository(Departement::class)->find($departementId);
                if ($departement) {
                    $employe = new Employe();
                    $employe->setNom($nom)
                            ->setTel($tel ?: null)
                            ->setSalaire($salaire ? (float)$salaire : null)
                            ->setSpecialite(Specialite::from($specialite))
                            ->setDepartement($departement);
                    $em->persist($employe);
                    $em->flush();

                    $this->addFlash('success', 'Employé créé avec succès !');
                    return $this->redirectToRoute('employe_index');
                } else {
                    $errors[] = 'Département introuvable.';
                }
            }

            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        }

        return $this->render('employe/new.html.twig', [
            'departements' => $departements,
            'specialites' => $specialites,
        ]);
    }
}
