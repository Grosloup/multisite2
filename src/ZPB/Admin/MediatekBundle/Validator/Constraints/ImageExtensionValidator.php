<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 12:08
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

namespace ZPB\Admin\MediatekBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImageExtensionValidator extends ConstraintValidator
{
    private $allowedExtensions;

    public function __construct(array $allowedExtensions = [])
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    public function validate($value, Constraint $constraint)
    {
        if(!is_string($value)){
            $this->context->addViolation($constraint->message);
        }
        if(is_string($value) && !in_array(strtolower($value), $this->allowedExtensions)){
            $this->context->addViolation($constraint->message);
        }
    }
}
