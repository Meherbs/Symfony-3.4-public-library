<?php

namespace FilmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FilmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('dateSortie',DateType::Class, array(
                'widget' => 'choice',
                'years' => range(date('Y')-100, date('Y')),
                'months' => range(1, 12),
                'days' => range(1, 31),
            ))
            ->add('file', FileType::class, ['label' => 'Brochure (PDF file)'])
            ->add('couverture')
            ->add('description')
            ->add('disponible',ChoiceType::class, [
        'choices' => [
            'oui' => true,
            'non' => false,
        ]])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('categorie')
            ->add('acteur');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FilmBundle\Entity\Film'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'filmbundle_film';
    }


}
