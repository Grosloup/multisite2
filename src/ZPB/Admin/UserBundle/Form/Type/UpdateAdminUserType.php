<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 25/08/14
 * Time: 17:29
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

namespace ZPB\Admin\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UpdateAdminUserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite','civility_type',['label'=>'Civilité'])
            ->add('firstname',null,['label'=>'Prénom'])
            ->add('lastname',null,['label'=>'Nom'])
            ->add('email','email',['label'=>'Email'])
            ->add('username',null,['label'=>'Pseudo'])
            ->add('roles','entity',['label'=>'Roles','class'=>'ZPB\Admin\UserBundle\Entity\Role','property'=>'readableName','multiple'=>true,'expanded'=>true])
            ->add('save','submit',['label'=>'Enregistrer'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class'=>'ZPB\Admin\UserBundle\Entity\AdminUser']);
    }

    public function getName()
    {
        return 'update_admin_user_form';
    }
}
