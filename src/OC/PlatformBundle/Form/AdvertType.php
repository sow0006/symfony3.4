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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use OC\PlatformBundle\Repository\CategoryRepository;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class AdvertType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $pattern = 'D%';

    $builder
      ->add('date',      DateType::class)
      ->add('title',     TextType::class)
      ->add('author',    TextType::class)
      ->add('content',   TextareaType::class)
      // Image
      ->add('image',     ImageType::class)
      // Categorie
      ->add('categories', EntityType::class, array(
        'class'         => 'OCPlatformBundle:Category',
        'choice_label'  => 'name',
        'multiple'      => true,
        'query_builder' => function(CategoryRepository $repository) use($pattern) {
          return $repository->getLikeQueryBuilder($pattern);
        }
      ))
      ->add('save',      SubmitType::class)
    ;

    $builder->addEventListener(
      FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
      function(FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
        // On récupère notre objet Advert sous-jacent
        $advert = $event->getData();
        if (null === $advert) {
          return; 
        }
        if (!$advert->getPublished() || null === $advert->getId()) {
          $event->getForm()->add('published', CheckboxType::class, array('required' => false));
        } else {
          $event->getForm()->remove('published');
        }
      }
    );
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