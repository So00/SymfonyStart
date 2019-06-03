<?php

namespace App\Form;

use App\Entity\FilterProperties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Options;

class FilterPropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surface',
                IntegerType::class,
                [
                    "required" => false,
                    "label" => false,
                    "attr" => ["placeholder" => "Surface minimum"]
                ])
            ->add('rooms',
            IntegerType::class,
            [
                "required" => false,
                "label" => false,
                "attr" => ["placeholder" => "Nombre de pièces minimum"]
            ])
            ->add('bedrooms',
            IntegerType::class,
            [
                "required" => false,
                "label" => false,
                "attr" => ["placeholder" => "Nombre de chambre minimum"]
            ])
            ->add('price',
            IntegerType::class,
            [
                "required" => false,
                "label" => false,
                "attr" => ["placeholder" => "Prix maximum"]
            ])
            ->add('postal_code',
            TextType::class,
            [
                "required" => false,
                "label" => false,
                "attr" => ["placeholder" => "Code postal"]
            ])
            ->add("options", EntityType::class, [
                "class" => Options::class,
                "choice_label" => "name",
                "multiple" => true,
                "required" => false,
                "label" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FilterProperties::class,
            "method" => "get",
            "csrf_protection" => false
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}
