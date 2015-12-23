<?php

namespace Devmachine\Bundle\OntheioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
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
            ->add('originalUrl', 'hidden', ['required' => false])
            ->add('width', 'hidden', ['required' => false])
            ->add('height', 'hidden', ['required' => false])
            ->add('key', 'hidden', ['required' => false])
            ->add('error', 'hidden', ['required' => false])
        ;
    }
}
