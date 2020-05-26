<?php

namespace App\Form\Team;

use App\Entity\Team\Team;
use App\Utils\Tools;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class TeamType extends AbstractType
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
                'name', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'Nom'
                )
            )
            ->add(
                'firstName', TextType::class,
                array(
                    'required' => true,
                    'label'    => 'Prénom *'
                )
            )
            ->add(
                'description', TextareaType::class,
                array(
                    'label'    => 'Description',
                    'required' => false,
                    'attr'     => array(
                        'class'                => 'simple-wysiwyg',
                        'data-svgPath'         => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                        'data-ajax-upload-url' => $this->router->generate('backoffice/ajax-upload-media'),
                        'data-entity'          => 'Team\Team',
                        'data-id'              => 0
                    )
                )
            )
            ->add(
                'poste', TextType::class,
                array(
                    'required' => true,
                    'label'    => 'poste *'
                )
            )
            ->add(
                'mediaFile', FileType::class,
                array(
                    'label'    => 'Image',
                    'required' => false
                )
            )
            ->add(
                'active', CheckboxType::class, array(
                'required' => false,
                'label'    => 'form.language.active',
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
            ->add('position')
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
                'data_class' => Team::class,
            ]
        );
    }
}
