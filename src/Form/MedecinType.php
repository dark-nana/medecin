<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Matricule',HiddenType::class,['attr'=>['type'=>'hidden','value'=>'matric']])
            ->add('Prenom',TextType::class,['attr'=>['placeholder'=>'prenom']])
            ->add('Nom',TextType::class,['attr'=>['placeholder'=>'nom']])
            ->add('Telephone',TextType::class,['attr'=>['placeholder'=>'XXXXXXXXX']])
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'])
            ->add('Service',EntityType::class, [
                'class'=>Service::class,
                'choice_label'=>'libelle'
            ])
            ->add('Specialite',EntityType::class, [
                'class'=>Specialite::class,
                'choice_label'=>'libelle'
            ])
            ->getForm();
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}