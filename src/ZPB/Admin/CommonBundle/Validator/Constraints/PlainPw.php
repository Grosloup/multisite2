<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/08/2014
 * Time: 14:31
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

namespace ZPB\Admin\CommonBundle\Validator\Constraints;



use Symfony\Component\Validator\Constraint;

/**
 * Class PlainPw
 * @package ZPB\Admin\CommonBundle\Validator\Constraints
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class PlainPw extends Constraint
{
    public $message = 'Le mot de passe fourni est incorrect';
    public $minLen = 'Le mot de passe doit contenir au moins %d caractères';
    public $hasNum = 'Le mot de passe doit contenir au moins un chiffre.';
    public $hasLower = 'Le mot de passe doit contenir au moins une lettre minuscule.';
    public $hasUpper = 'Le mot de passe doit contenir au moins une lettre majuscule.';

    public function validateBy()
    {
        return 'plainpw_validator';
    }
}
