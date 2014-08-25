<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/08/2014
 * Time: 14:33
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

namespace ZPB\Admin\UserBundle\Validator\Constraints;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PassWordValidator extends ConstraintValidator implements ContainerAwareInterface
{
    private $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function validate($value, Constraint $constraint)
    {
        $params = $this->container->getParameter('zpb.password_validator.params');
        if(!empty($params['minlen']) && strlen($value) < $params['minlen']){
            $this->context->addViolation(sprintf($constraint->minLen, $params['minlen']));
        }

        if(!empty($params['hasnum']) && $params['hasnum']===true){
            $p = preg_replace('/[^0-9]/','',$value);
            if(strlen($p)<1){
                $this->context->addViolation($constraint->hasNum);
            }
        }

        if(!empty($params['haslower']) && $params['haslower']===true){
            $p = preg_replace('/[^[:lower:]]/','',$value);
            if(strlen($p)<1){
                $this->context->addViolation($constraint->hasLower);
            }
        }

        if(!empty($params['hasupper']) && $params['hasupper']===true){
            $p = preg_replace('/[^[:upper:]]/','',$value);
            if(strlen($p)<1){
                $this->context->addViolation($constraint->hasUpper);
            }
        }
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
       $this->container = $container;
    }
}
