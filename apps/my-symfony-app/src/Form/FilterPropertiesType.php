<?php

namespace App\Form;

use App\Entity\FilterProperties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterPropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('price')
            ->add('postal_code')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FilterProperties::class,
        ]);
    }
}
