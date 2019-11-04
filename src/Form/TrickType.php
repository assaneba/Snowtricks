<?php

namespace App\Form;

use App\Entity\GroupOfTricks;
use App\Entity\Tricks;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('groupOfTricks', EntityType::class, [
                'class' => GroupOfTricks::class,
                'choice_label' => 'name'
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'required' => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'required' => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false
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
