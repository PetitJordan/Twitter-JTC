<?php

namespace App\Form\Front\Keyword;

use App\Entity\Keyword\Keyword;
use App\Utils\Tools;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class KeywordEditType extends AbstractType
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
                    'label'    => 'Nom du keyword'
                )
            )
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
                'data_class' => Keyword::class,
            ]
        );
    }
}
