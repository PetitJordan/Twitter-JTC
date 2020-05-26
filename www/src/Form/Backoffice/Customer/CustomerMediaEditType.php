<?php

namespace App\Form\Backoffice\Customer;

use App\Entity\Customer\CustomerMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerMediaEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'mediaFile', FileType::class, array(
                    'required' => false,
                    'label'    => 'Image *'
                )
            )
            ->add(
                'position', ChoiceType::class, array(
                    'required' => false,
                    'label'    => 'Position *',
                    'placeholder'    => 'Choisissez une position',
                    "choices" => [
                        'Visuel tuile (homepage & réalisations)' => 'homePage',
                        'Customer Details - Entête' => 'entete',
                        'Customer Details - Conseiller' => 'conseiller',
                        'Customer Details - Imaginer Gauche' => 'hg',
                        'Customer Details - Imaginer Droit' => 'hd',
                        'Customer Details - Développer Gauche' => 'bg',
                        'Customer Details - Développer Droit' => 'bd'
                    ]
                )
            );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $customerMedia = $event->getData();
            $form         = $event->getForm();

            if ($customerMedia && $customerMedia->getId()) {
//                $form
//                    ->remove('mediaFile')
//                ;
            }
        }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CustomerMedia::class,
        ]);
    }
}
