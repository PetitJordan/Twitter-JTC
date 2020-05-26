<?php

namespace App\Form\Backoffice\Job;

use App\Entity\Job\Job;
use App\Entity\Job\Techniques;
use App\Utils\Tools;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class JobEditType extends AbstractType
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

            ->add('title', TextType::class, array(
                'label' => "Intitulé de l'offre",
                'required' => true,
            ))

            ->add('shortText', TextType::class, array(
                'label' => "Description de la tuile",
            ))

            ->add('description', TextareaType::class, array(
                'label'         => 'Description de l\'offre *',
                'required'      => true,
                'attr'          => array(
                    'class'                 => 'simple-wysiwyg',
                    'data-svgPath'          => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url'  => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'           => 'Job\Job',
                    'data-id'               => 0
                )
            ))

            ->add('tasks', TextareaType::class, array(
                'label'         => 'Missions (première colonne)*',
                'required'      => true,
                'attr'          => array(
                    'class'                 => 'simple-wysiwyg',
                    'data-svgPath'          => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url'  => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'           => 'Job\Job',
                    'data-id'               => 0
                )
            ))

            ->add('otherTasks', TextareaType::class, array(
                'label'         => 'Missions (deuxième colonne)',
                'required'      => true,
                'attr'          => array(
                    'class'                 => 'simple-wysiwyg',
                    'data-svgPath'          => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url'  => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'           => 'Job\Job',
                    'data-id'               => 0
                )
            ))

            ->add('techniques', EntityType::class, array(
                'label' => "Techniques",
                'class' => Techniques::class,
                'choice_label' => "name",
                'choice_value'  => 'id',
                'expanded'  => true,
                'multiple'  => true,
            ))

            ->add('mediaFile', FileType::class, array(
                'label'         => 'Image',
                'required'      => false
            ))

            ->add('conclusion', TextareaType::class, array(
                'label'         => 'Message de fin *',
                'required'      => true,
                'attr'          => array(
                    'class'                 => 'simple-wysiwyg',
                    'data-svgPath'          => $this->tools->packageUtils->getUrl('build/assets/js/trumbowyg/ui/icons.svg', true),
                    'data-ajax-upload-url'  => $this->router->generate('backoffice/ajax-upload-media'),
                    'data-entity'           => 'Job\Job',
                    'data-id'               => 0
                )
            ))

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
            'data_class' => Job::class,
        ]);
    }
}
