<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 19:36
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

namespace ZPB\Admin\NewsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ZPB\Admin\NewsBundle\Form\DataTransformer\CategoryTransformer;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
        $categoryTransformer = new CategoryTransformer($em);
        $builder
            ->add('title', null, ['label'=>'Titre de l\'article'])
            ->add('type', 'posts_types_type', ['label'=>'Type d\'article', 'empty_value'=>'Type de l\'article'])
            ->add('body', 'textarea', ['label'=>'Corps de l\'article', 'required'=>false])
            ->add('excerpt', 'textarea', ['label'=>'Résumé de l\'article', 'required'=>false])
            ->add($builder->create('category', 'entity', ['label'=>'Catégorie','empty_value'=>'Choisir une catégorie', 'class'=>'ZPBAdminNewsBundle:PostCategory', 'data_class'=>'ZPB\Admin\NewsBundle\Entity\PostCategory', 'property'=>'name'])->addModelTransformer($categoryTransformer))
            ->add('targets', 'entity', ['label'=>'Sites cibles','class'=>'ZPBAdminNewsBundle:PostTarget','property'=>'name', 'multiple'=>true, 'expanded'=>true])
            ->add('tags', 'collection', ['label'=>'Mots-clés', 'type'=>new SimpleTagType(),'allow_add'=>true,'allow_delete'=>true, 'by_reference'=>false])
            ->add('fronts', 'fronts_type')
            ->add('save_draft','submit',['label'=>'Enregistrer le brouillon'])
            ->add('save_publish', 'submit', ['label'=>'Enregistrer et publier'])
            ->add('save_update', 'submit', ['label'=>'Mettre à jour'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>'ZPB\Admin\NewsBundle\Entity\Post',
        ]);
        $resolver->setRequired(['em']);
        $resolver->setAllowedTypes(['em'=>'\Doctrine\Common\Persistence\ObjectManager']);
    }

    public function getName()
    {
        return "post_form";
    }
}
