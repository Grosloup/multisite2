<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 27/08/14
 * Time: 16:32
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

namespace ZPB\Admin\MediatekBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filename','text', ['label'=>'Renommer comme'])
            ->add('title','textarea',['label'=>'Texte de l\'attribut title'])
            ->add('copyright','text',['label'=>'Texte du copyright'])
            ->add('save', 'submit', ['label'=>'Enregistrer'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['class_data'=>'ZPB\Admin\MediatekBundle\entity\Image']);
    }

    public function getName()
    {
        return 'edit_image_form';
    }
} 
