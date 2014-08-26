<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 15:30
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

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','file', ['label'=>'Fichier image'])
            ->add('filename','text', ['label'=>'Renommer comme'])
            ->add('title','text',['label'=>'Texte de l\'attribut title'])
            ->add('copyright','text',['label'=>'Texte du copyright'])
            ->add('save', 'submit', ['label'=>''])
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class'=>'ZPB\Admin\MediatekBundle\Entity\Image']);
    }
    
    public function getName()
    {
        return 'image_upload_form';
    }
}
