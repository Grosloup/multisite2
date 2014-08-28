<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 14:54
 */
  /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/

namespace ZPB\Admin\PhototekBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZPB\Admin\PhototekBundle\Form\DataTransformer\CategoryTransformer;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
        $categoryTransformer = new CategoryTransformer($em);
        $builder
            ->add('file', 'file', ['label'=>'Fichier photo'])
            ->add('filename',null, ['label'=>'Nom du fichier'])
            ->add('title', 'textarea', ['label'=>'Texte de l\'attribut title'])
            ->add('copyright', null, ['label'=>'Texte du copyright'])
            ->add($builder->create('category', 'entity', ['label'=>'Catégorie','empty_value'=>'Choisir une catégorie', 'class'=>'ZPBAdminPhototekBundle:PhotoCategory', 'data_class'=>'ZPB\Admin\PhototekBundle\Entity\PhotoCategory', 'property'=>'name'])->addModelTransformer($categoryTransformer))
            ->add('tags', 'collection', ['label'=>'Mots-clés', 'type'=>new SimplePhotoTagType(), 'allow_add'=>true, 'allow_delete'=>true, 'by_reference'=>false])
            ->add('save', 'submit', ['label'=>'Upload'])
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class'=>'ZPB\Admin\PhototekBundle\Entity\Photo']);
        $resolver->setRequired(['em']);
        $resolver->setAllowedTypes(['em'=>'\Doctrine\Common\Persistence\ObjectManager']);
    }
    
    public function getName()
    {
        return 'photo_form';
    }
}
