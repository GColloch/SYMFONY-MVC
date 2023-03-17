<?php

// src/Form/BookDeleteFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookDeleteFormType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
$builder
->add('_token', HiddenType::class)
->add('submit', SubmitType::class, [
'label' => 'Supprimer',
'attr' => ['class' => 'btn btn-danger'],
]);
}

public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults([
'data_class' => null,
'csrf_token_id' => 'delete_book',
]);
}
}