<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/08/2014
 * Time: 14:33
 */

namespace ZPB\Admin\CommonBundle\Validator\Constraints;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PlainPwValidator extends ConstraintValidator
{
    private $params;

    public function __construct(array $params = null)
    {
        $this->params = $params;
    }


    public function validate($value, Constraint $constraint)
    {
        $params = $this->params;
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
}
