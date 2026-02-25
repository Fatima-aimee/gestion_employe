<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DepartementRepository;
use App\Repository\EmployeRepository;


class EmployeController extends AbstractController
{   
    private const LIMIT_PAR_PAGE=10;
    public function __construct(private readonly EmployeRepository $employeRepository,private readonly DepartementRepository $departementRepository)
    { 
    }
    
    #[Route('/employe/list/{idDept?}', name: 'app_employe_list', methods: ['GET'])]
    public function index(?int $idDept, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = self::LIMIT_PAR_PAGE; 
        $offset = ($page - 1) * $limit;
        if ($idDept !== null) {
            $employes = $this->employeRepository->findBy(
                ['departement' => $idDept],
                ['id' => 'asc'],
                $limit,
                $offset
            );
            $total = $this->employeRepository->count(['departement' => $idDept]);
        } else {
            $employes = $this->employeRepository->findBy(
                [],
                ['id' => 'asc'],
                $limit,
                $offset
            );
            $total = $this->employeRepository->count([]);
        }
        $nbrePage = ceil($total / $limit);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            'pageEncours' => $page,
            'nbrePage' => $nbrePage,
            'idDept' => $idDept,
            'departements' => $this->departementRepository->findAll(),
        ]);
    }

    #[Route('/employe/add', name: 'app_employe_add',methods:["GET","POST"])]
    public function add(Request $request): Response
    {
        $employe=new Employe();
        $form=$this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             $this->employeRepository->save($employe, true);
             return $this->redirectToRoute('app_employe_list');
        }

         return $this->render('employe/form.html.twig', [
             'formEmp' => $form->createView()
         ]);
    }
}