<?php

namespace Devmachine\Bundle\OntheioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'devmachine_ontheio_image';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'devmachine-ontheio',
            'label'              => 'image.label.image',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('originalUrl', HiddenType::class, ['required' => false])
            ->add('width', HiddenType::class, ['required' => false])
            ->add('height', HiddenType::class, ['required' => false])
            ->add('key', HiddenType::class, ['required' => false])
            ->add('error', HiddenType::class, ['required' => false])
        ;
    }
}
