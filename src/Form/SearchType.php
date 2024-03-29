<?php

namespace App\Form;
use App\Classe\Search;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add("string", TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Votre recherche ...",
                    "class" => "form-control-sm"
                ]
            ])
            ->add("categories", EntityType::class, [ // Permet de lié un input du formulaire en lui disant qu'on veut que ca represente une entité
                "label" => false,
                "required" => false,
                "class" => Category::class, // Permet de dire avec quelle class on veut faire le lien de l'input
                "multiple" => true,
                "expanded" => true 
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Filtrer",
                "attr" => [
                    "class" => "btn btn-info"
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Search::class,
            "method" => "GET",
            "crsf_protection" => false
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}