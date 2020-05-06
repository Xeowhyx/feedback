<?php

namespace App\Form;

use App\Entity\BugSearch;
use App\Entity\Location;
use App\Entity\Os;
use App\Entity\Priority;
use App\Entity\Severity;
use App\Entity\State;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BugSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Rechercher par nom:',
                'required' => false])
            ->add('orderby', ChoiceType::class,[
                'label' => 'Classer par ordre:',
                'required' => false,
                'choices' => [
                    'Du + récent au + ancien' => false,
                    'Du + ancien au + récent'=> true
                ]
            ])
            ->add('os', EntityType::class,[
                'label' => 'Système d\'exploitation:',
                'class'=> Os::class,
                'required' => false,
                'choice_label'=> 'name',
            ])
            ->add('location',EntityType::class,[
                'label' => 'Localisation:',
                'class'=> Location::class,
                'required' => false,
                'choice_label'=>'name',
            ])
            ->add('priority', EntityType::class,[
                'label' => 'Priorité:',
                'class'=> Priority::class,
                'required' => false,
                'choice_label'=>'name',
            ])
            ->add('severity',EntityType::class,[
                'label' => 'Gravité:',
                'class' => Severity::class,
                'required' => false,
                'choice_label'=>'name',
            ])
            ->add('state', EntityType::class,[
                'label' => 'Statut:',
                'class' => State::class,
                'required' => false,
                'choice_label'=>'name',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BugSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
