<?php

namespace App\Form;

use App\Entity\GroupOfTricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name');
        /*
            ->add('name', ChoiceType::class, [
                'placeholder' => 'Choisir le/les groupe(s)',
                'multiple'    => true,
                'expanded'    => true,
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupOfTricks::class,
        ]);
    }
}
