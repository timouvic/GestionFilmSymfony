<?php

namespace HTM\FilmoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre','text')
            ->add('description','textarea')
            ->add('categorie','entity', array(
                        'class' => 'FilmoBundle:Categorie',
                        'choice_label' => 'nom',
                    ))
            ->add('acteurs','entity', array(
                        'class' => 'FilmoBundle:Acteur',
                        'choice_label' => 'prenomnom',
                        'multiple'=>true
                        ))
            ->add('file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HTM\FilmoBundle\Entity\Film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'htm_filmobundle_film';
    }
}
