<?php

namespace App\Form;

use App\Entity\GroupOfTricks;
use App\Entity\Tricks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            //->add('createdAt')
            //->add('lastModifyAt')
            ->add('defaultImage')
            ->add('groupgroup', EntityType::class, [
                'class' => GroupOfTricks::class,
                'label' => 'Groupe du trick'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
