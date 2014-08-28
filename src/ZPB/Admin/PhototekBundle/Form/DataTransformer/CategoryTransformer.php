<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 16:37
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

namespace ZPB\Admin\PhototekBundle\Form\DataTransformer;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }
    public function transform($value)
    {
        if($value === null){
            return '';
        }
        return $value->getId();
    }

    public function reverseTransform($value)
    {
        if(!$value){
            return null;
        }
        $category = $this->em->getRepository('ZPBAdminPhototekBundle:PhotoCategory')->findOneBy(['id'=>$value]);
        if(null === $category){
            throw new TransformationFailedException();
        }
        return $category;
    }
}
