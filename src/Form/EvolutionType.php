<?php

namespace App\Form;

use App\Entity\Evolution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvolutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => ['class' => 'name-type'],
                'label' => 'Titre'])
            ->add('description',TextareaType::class, [
                'attr' => ['class' => 'description-evolution-type'],
                'label' => 'Description de votre proposition d\'évolution'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evolution::class,
        ]);
    }
}
