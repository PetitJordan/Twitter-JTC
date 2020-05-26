<?php

namespace App\Form\Backoffice\Configuration\Language;

use App\Entity\Configuration\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
            	'required'          => true,
	            'label'             => 'form.language.name'
            ))
            ->add('iso', TextType::class, array(
            	'required'          => true,
	            'label'             => 'form.language.iso'
            ))
	        ->add('active', CheckboxType::class, array(
		        'required'      => false,
		        'label'         => 'form.language.active',
		        'attr'          => array(
			        'data-toggle'       => 'toggle',
			        'data-size'         => 'sm',
			        'data-on'           => ' ',
			        'data-off'          => ' ',
			        'data-onstyle'      => 'success',
			        'data-offstyle'     => 'secondary'
		        )
	        ))
            ->add('mediaFile', FileType::class, array(
            	'required'      => false,
	            'label'         => 'form.language.mediaFile'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
        ]);
    }
}
