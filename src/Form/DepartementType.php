<?php

namespace App\Form;

use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartementType extends AbstractType
{

    //champs du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                "required"=>true,
                "attr"=>[
                    "class"=>"form-control",
                    "placeholder"=>"Création d'un Departement"
                ]
            ])
            ->add("saveDepartement",SubmitType::class,[
               "label"=>"Enregistrer",
                //"required"=>true,
                "attr"=>[
                    "class"=>"btn btn-primary",
                ]
            ])
        ;
    }

    //<form> </form>
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,//entity lie au formulaire
        ]);
    }
}
