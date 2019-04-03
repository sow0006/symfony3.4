<?php
// src/OC/PlatformBundle/Form/AdvertType.php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use OC\PlatformBundle\Form\ImageType;
use OC\PlatformBundle\Form\CategoryType;
use OC\PlatformBundle\Form\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AdvertType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('date',      DateType::class)
      ->add('title',     TextType::class)
      ->add('author',    TextType::class)
      ->add('content',   TextareaType::class)
      ->add('published', CheckboxType::class, array('required' => false))
      ->add('image',     ImageType::class)
      ->add('categories', EntityType::class, array(
        'type'         => CategoryType::class,
        'allow_add'    => true,
        'allow_delete' => true
      ))
      ->add('save',      SubmitType::class)
    ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'OC\PlatformBundle\Entity\Advert'
    ));
  }

  public function getName()
  {
    return 'oc_platformbundle_advert';
  }
}