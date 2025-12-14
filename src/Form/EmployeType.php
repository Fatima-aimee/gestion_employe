<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Employe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'label' => 'Nom et Prenom',
                'required'=>true,
                "attr"=>[
                    "class"=>"form-control",
                    "placeholder"=>"Nom et Prénom de l'employé"
                ]
            ])
            ->add('tel',TextType::class,[
                'required'=>true,
                "attr"=>[
                    "class"=>"form-control",
                    "placeholder"=>"Numéro de téléphone"
                ]
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'required'=>false,
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom',
                'label' => 'Département',
                'placeholder' => 'Sélectionner un département',
                'required' => true,
                "attr"=>[
                    "class"=>"form-select"
                ]
            ])
            ->add('isActive',ChoiceType::class, [
                'label' => 'Actif',
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                "expanded" => true,
                'data' => false
            ])

            ->add("btnSaveDept",SubmitType::class,[
                "label"=>"Enregistrer l'Employe",
                "attr"=>[
                    "class"=>"btn btn-primary float-end"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
             "attr"=>[
                 "data-turbo"=>'false'
             ]
        ]);
    }
}
