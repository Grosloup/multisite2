<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/08/2014
 * Time: 13:11
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

namespace ZPB\Admin\NewsBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class PostTypes
 * @package ZPB\Admin\NewsBundle\Validator\Constraints
 * @Annotation
 */
class PostTypes extends Constraint
{
    public $message="La valeur fournie ne fait pas partie des choix autorisés.";

    public function validatedBy()
    {
        return 'post_types_validator';
    }


}
