<?php

namespace App\Form\Backoffice\Testimony;

use App\Entity\Testimony\Testimony;
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

class TestimonyEditType extends AbstractType
{
    protected $tools;
    protected $router;

    public function __construct(Tools $tools, RouterInterface $router)
    {
        $this->tools = $tools;
        $this->router = $router;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logoFile', FileType::class, array(
                'label'         => 'Logo',
                'required'      => false
            ))
            ->add('company',TextType::class, array(
                'required'          => true,
                'label'             => 'Nom entreprise *'
            ))
            ->add('message', TextareaType::class, array(
                'label'         => 'Message à afficher *',
                'required'      => true,
                'attr'          => array(
                    'class'                 => 'simple-wysiwyg',
                    'data-svgPath'          => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url'  => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'           => 'Testimony\Testimony',
                    'data-id'               => 0
                )
            ))
            ->add('active', CheckboxType::class,
                  array(
                      'required' => false,
                      'label'    => 'Activer ?',
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
            ->add('submit', SubmitType::class, array(
                'label'                 => 'Sauvegarder',
                'attr'                  => array(
                    'class'                 => 'btn btn-success btn-save'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Testimony::class,
        ]);
    }
}
