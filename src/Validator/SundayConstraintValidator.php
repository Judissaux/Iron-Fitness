<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SundayConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {   
        //Vérifie si la valeur est une instance de datetimeInterface et que la valeur passée est bien un dimanche
        if ($value instanceof \DateTimeInterface && $value->format('w') == 0) {
            // Code qui crée une violation et qui retourne le message inscrit dans SundayConstraint.php
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
