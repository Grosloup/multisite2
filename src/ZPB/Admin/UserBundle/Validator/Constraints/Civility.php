<?php

namespace ZPB\Admin\UserBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Civility extends Constraint
{
    public $message = 'La valeur fournie ne fait pas partie des choix autorisés.';
    public $gender='La valeur fournie ne fait pas partie des choix autorisés.';

    public function validatedBy()
    {
        return 'civility_validator';
    }
}
