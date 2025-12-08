<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Departement;
use App\Repository\DepartementRepository;

#[Route('/departement')]
class DepartementController extends AbstractController
{   
    public function __construct(private readonly DepartementRepository $repository)
    {
    }
    #[Route('/', name: 'departement_index', methods: ['GET'])]
    public function index(): Response
    {
        $departements = $this->repository->findAll();

        return $this->render('departement/index.html.twig', [
            'departements' => $departements,
        ]);
    }

    #[Route('/new', name: 'departement_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');

            if ($nom) {
                $departement = new Departement();
                $departement->setNom($nom);
                $em->persist($departement);
                $em->flush();

                $this->addFlash('success', 'Département créé avec succès !');

                return $this->redirectToRoute('departement_index');
            }

            $this->addFlash('error', 'Le nom est obligatoire.');
        }

        return $this->render('departement/new.html.twig');
    }
}
