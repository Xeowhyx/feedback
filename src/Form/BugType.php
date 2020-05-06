<?php

namespace App\Form;

use App\Entity\Bug;
use App\Entity\Location;
use App\Entity\Os;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => ['class' => 'name-type'],
                'label' => 'Titre'])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'description-bug-type'],
                'label' => 'Décriver dans quelle situation ce bug est arrivé'])
            ->add('os',EntityType::class,[
                'class'=>Os::class,
                'required' => false,
                'choice_label'=> 'name',
                'label' => 'Système d\'exploitation'
            ])
            ->add('location',EntityType::class,[
                'class'=>Location::class,
                'required' => false,
                'choice_label'=>'name',
                'label' => 'Emplacement'

            ])

            ->add('imageFile',FileType::class,[
                'required' => false,
                'label' => 'Ajouter un screenshot afin de nous aider à localiser le dysfonctionnement'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bug::class,
        ]);
    }
}
