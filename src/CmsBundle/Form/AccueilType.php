<?php

namespace CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccueilType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('file', FileType::class, array('label' => 'Image', 'required' => false))
            ->add('contenu', TextareaType::class, array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'bbcode' // Skip it if you want to use default theme
                )))
            ->add('premiertitre')
            ->add('premiercontenu', TextareaType::class)
            ->add('deuxiemetitre' )
            ->add('deuxiemecontenu', TextareaType::class)
            ->add('troisiemetitre')
            ->add('troisiemecontenu', TextareaType::class)
            ->add('image2', ImagesType::class)
            ->add('video', YoutubeType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CmsBundle\Entity\Accueil'
        ));
    }
}
