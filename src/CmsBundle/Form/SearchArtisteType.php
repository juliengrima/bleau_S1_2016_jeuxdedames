<?php

namespace CmsBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchArtisteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', EntityType::class, array(
                'class' => 'CmsBundle\Entity\Categorie',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nomDeLaCategorie', 'ASC');
                },
                'choice_label' => 'nomDeLaCategorie',
                'placeholder' => 'Spécifiez une catégorie',
                'empty_data'  => null,
                'required' => false
            ));
    }
}