<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Permet d'appeler la contraintes écrite dans la class SundayConstraintValidator
 */
class HolidayConstraint extends Constraint
{
    public $message = 'Ce jour est férié. Veuillez en sélectionner un autre.';

    public function validatedBy()
    {
        // Récupére le nom actuelle de la classe ('SundayConstraint') et lui rajoute le validator ce qui fait que la fonction validateBy appel la classe SundayConstraintValidator.php
        return \get_class($this).'Validator';
    }
}
