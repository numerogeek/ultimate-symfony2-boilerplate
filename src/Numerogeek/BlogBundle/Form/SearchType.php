<?php

namespace Numerogeek\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword', 'text', array('label' => 'Rechercher'));
    }

    public function getName()
    {
        return 'blog_recherche_article';
    }
}
