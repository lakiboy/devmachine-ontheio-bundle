<?php

namespace Devmachine\Bundle\OntheioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageGalleryType extends AbstractType
{
    public function getName()
    {
        return 'devmachine_ontheio_image_gallery';
    }

    public function getParent()
    {
        return 'collection';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'devmachine-ontheio',
            'label'              => 'image.label.gallery',
            'thumb_width'        => 200,
            'thumb_height'       => 150,
            'required'           => false,
            'type'               => new ImageType(),
            'allow_add'          => true,
            'allow_delete'       => true,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['thumb_width']  = $options['thumb_width'];
        $view->vars['thumb_height'] = $options['thumb_height'];
    }
}
