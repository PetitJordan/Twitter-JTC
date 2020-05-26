<?php

namespace App\Form\Backoffice\Job;

use App\Entity\Job\Techniques;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechniquesEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array(
                'label' => "Intitulé",
                'required' => true,
            ))
            ->add('logoFile', FileType::class, array(
                'label'         => 'Logo',
                'required'      => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => array(
                    'class' => 'btn btn-success btn-save'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Techniques::class,
        ]);
    }
}
