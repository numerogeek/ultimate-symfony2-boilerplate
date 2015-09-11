<?php

namespace Numerogeek\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'blog.article.field.title'))
            ->add('summary', null, array('label' => 'blog.article.field.summary'))
            ->add('content',  'ckeditor', array(
                'config_name' => 'my_config',
                'label' => 'blog.article.field.content',
            ))
            ->add('publishedAt', 'datetime', array('label' => 'blog.article.field.publishedAt'))
            ->add('cover', 'vich_image', array(
                'label' => 'blog.article.field.cover',
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
            ->add('online', null, array('label' => 'blog.article.field.online'))
            ->add('category', null,
                array(
                    'label' => 'blog.article.field.category',
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Numerogeek\BlogBundle\Entity\Post',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogbundle_post';
    }
}
