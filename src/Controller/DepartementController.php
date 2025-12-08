<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Departement;
use App\Repository\DepartementRepository;


class DepartementController extends AbstractController
{   
    public function __construct(private readonly DepartementRepository $repository)
    {
    }
    #[Route('/departement/list', name: 'departement_index', methods: ['GET'])]
    public function index(): Response
    {
        $departements = $this->repository->findAll();

        return $this->render('departement/index.html.twig', [
            'departements' => $departements,
        ]);
    }

}
