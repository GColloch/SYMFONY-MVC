<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * La classe du formulaire
 */
class AddBook extends AbstractType
{

    /**
     * Fonction pour créer le formulaire.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                array(
                    'label' => 'Titre du livre'
                )
            )->add(
                'date_of_publication',
                DateType::class,
                array(
                    'label' => 'Date de publication',
                    'widget' => 'single_text'
                )
            )->add('submit', SubmitType::class, array('label' => 'Ajouter le livre'));
    }
}
