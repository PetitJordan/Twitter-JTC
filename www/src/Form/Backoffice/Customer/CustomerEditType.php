<?php

namespace App\Form\Backoffice\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\Expertise;
use App\Utils\Tools;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class CustomerEditType extends AbstractType
{
    protected $tools;
    protected $router;

    public function __construct(Tools $tools, RouterInterface $router)
    {
        $this->tools  = $tools;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name', TextType::class, array(
                'required' => true,
                'label'    => 'Nom du client *'
            )
            )
            ->add(
                'project_name', TextType::class, array(
                'required' => true,
                'label'    => 'Nom du projet *'
            )
            )
//            ->add('slug',TextType::class, array(
//                'required'          => true,
//                'label'             => 'Slug'
//            ))
            ->add(
                'concept', TextType::class, array(
                'required' => false,
                'label'    => 'Concept *'
            )
            )
            ->add(
                'descriptif', TextareaType::class, array(
                'label'    => 'Description du projet (affiché sur la tuile) *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'context', TextareaType::class, array(
                'label'    => 'Contexte *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'mission', TextareaType::class, array(
                'label'    => 'Mission *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'conseiller', TextareaType::class, array(
                'label'    => 'Conseiller *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'conseillerActive', CheckboxType::class, array(
                'required' => false,
                'label'    => 'Activer le champ "Conseiller"',
                'attr'     => array(
                    'data-toggle'   => 'toggle',
                    'data-size'     => 'sm',
                    'data-on'       => ' ',
                    'data-off'      => ' ',
                    'data-onstyle'  => 'success',
                    'data-offstyle' => 'secondary'
                )
            )
            )
            ->add(
                'imaginer', TextareaType::class, array(
                'label'    => 'Imaginer *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'imaginerActive', CheckboxType::class, array(
                'required' => false,
                'label'    => 'Activer le champ "Imaginer"',
                'attr'     => array(
                    'data-toggle'   => 'toggle',
                    'data-size'     => 'sm',
                    'data-on'       => ' ',
                    'data-off'      => ' ',
                    'data-onstyle'  => 'success',
                    'data-offstyle' => 'secondary'
                )
            )
            )
            ->add(
                'developper', TextareaType::class, array(
                'label'    => 'Développer *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'developperActive', CheckboxType::class, array(
                'required' => false,
                'label'    => 'Activer le champ "Développer"',
                'attr'     => array(
                    'data-toggle'   => 'toggle',
                    'data-size'     => 'sm',
                    'data-on'       => ' ',
                    'data-off'      => ' ',
                    'data-onstyle'  => 'success',
                    'data-offstyle' => 'secondary'
                )
            )
            )
            ->add(
                'accompagner', TextareaType::class, array(
                'label'    => 'Accompagner *',
                'required' => false,
                'attr'     => array(
                    'class'                => 'simple-wysiwyg',
                    'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'          => 'Customer\Customer',
                    'data-id'              => 0
                )
            )
            )
            ->add(
                'accompagnerActive', CheckboxType::class,
                array(
                    'required' => false,
                    'label'    => 'Activer le champ "Accopagner"',
                    'attr'     => array(
                        'data-toggle'   => 'toggle',
                        'data-size'     => 'sm',
                        'data-on'       => ' ',
                        'data-off'      => ' ',
                        'data-onstyle'  => 'success',
                        'data-offstyle' => 'secondary'
                    )
                )
            )
            ->add(
                'webUrl', UrlType::class, array(
                'label'    => 'Url Web *',
                'required' => true,
            )
            )
            ->add(
                'expertise', EntityType::class, array(
                'label'         => false,
                'class'         => Expertise::class,
                'choice_label'  => function ($expertise) {
//                    if ($expertise->getActive() == true){
                    return $expertise->getName();
//                    } else {
//                        return false;
//                    }
                },
                //                'choice_label' => "name",
                //                'choice_value'  => 'id',
                'expanded'      => true,
                'multiple'      => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('pc')
                        ->orderBy('pc.id', 'ASC')
                        ->where('pc.active = 1');
                },
            )
            )
            ->add(
                'customerMedias', CollectionType::class,
                array(
                    'entry_type'    => CustomerMediaEditType::class,
                    'entry_options' => array(
                        'label' => false
                    ),
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'label'         => false,
                    'by_reference'  => false
                )
            )
//            ->add(
//                'active', CheckboxType::class,
//                array(
//                    'required' => false,
//                    'label'    => 'Activer ?',
//                    'attr'     => array(
//                        'data-toggle'   => 'toggle',
//                        'data-size'     => 'sm',
//                        'data-on'       => ' ',
//                        'data-off'      => ' ',
//                        'data-onstyle'  => 'success',
//                        'data-offstyle' => 'secondary'
//                    )
//                )
//            )
            ->add(
                'submit', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr'  => array(
                    'class' => 'btn btn-success btn-save'
                )
            )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Customer::class,
            ]
        );
    }
}
