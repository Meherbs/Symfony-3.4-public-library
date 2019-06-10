<?php

namespace FilmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AdherentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add('dateNaiss',DateType::Class, array(
                'widget' => 'choice',
                'years' => range(date('Y')-100, date('Y')),
                'months' => range(1, 12),
                'days' => range(1, 31),
            ))
            ->add('sexe' ,ChoiceType::class, [
                'choices'  => [
                    'Homme' => true,
                    'Femme' => false
                ],
            ])
            ->add('cin')
            ->add('tel')
            ->add('adresse')
            ->add('createdAt')
            ->add('updatedAt');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FilmBundle\Entity\Adherent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'filmbundle_adherent';
    }


}
