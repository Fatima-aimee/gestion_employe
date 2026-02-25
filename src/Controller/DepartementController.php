<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepartementController extends AbstractController
{
    //Nombre d'element par page
    private const LIMIT_PAR_PAGE=10;
    public function __construct(private readonly DepartementRepository $departementRepository)
    {
        
    }
    
    #[Route('/departement/list', name: 'app_departement_list',methods:["GET","POST"])]
    public function list(Request $request ): Response
    {     //Creation entity associe  au formulaire
        $departement=new Departement();
    
             //Creation du formulaire format objet
        $form=$this->createForm(DepartementType::class, $departement);
    
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->departementRepository->save($departement,true);
            return $this->redirectToRoute('app_departement_list');
        }
        $page=$request->query->get("page",1);
        $size=$request->query->get("size",self::LIMIT_PAR_PAGE);
        $offset=($page-1)*$size;
        //Entites
         $departements=$this->departementRepository->findBy([],[
            "createdAt"=>"desc"
         ],$size, $offset);
            $count =$this->departementRepository->count([]);
            $nbrePage=  ceil($count /$size);
            return $this->render('departement/index.html.twig', [
                'departements' => $departements,
                "nbrePage"=>$nbrePage,
                "pageEncours"=>$page,
                "formDept"=>$form->createView() 
            ]);
    }
    /*#[Route('/departement/create', name: 'app_departement_create',methods:["GET"])]
        public function create(Request $request ): Response
        {
            //Creation entity associe  au formulaire
             $departement=new Departement();
    
             //Creation du formulaire format objet
             $form=$this->createForm(DepartementType::class, $departement);
    
             $form->handleRequest($request);
             if($form->isSubmitted() && $form->isValid()){
                  $this->departementRepository->save($departement,true);
                   $this->addFlash('success',"Departement ajouté avec succès");
                  return $this->redirectToRoute('app_departement_list');
             }
    
                return $this->render('departement/index.html.twig', [
                    "form"=>$form->createView() //format html
                ]);
        }
    */
    
}
