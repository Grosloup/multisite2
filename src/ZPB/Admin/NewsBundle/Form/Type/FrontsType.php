<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 21/08/2014
 * Time: 18:47
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


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FrontsType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = [];
        $targets = $this->manager->getRepository('ZPBAdminNewsBundle:PostTarget')->findAll();
        foreach($targets as $target){
            $choices[$target->getId()] = $target->getName();
        }


        $resolver->setDefaults(['label'=>'Article à la une de', 'choices'=>$choices, 'multiple'=>true, 'expanded'=>true]);
    }

    public function getParent()
    {
        return 'choice';
    }


    public function getName()
    {
        return "fronts_type";
    }
}
