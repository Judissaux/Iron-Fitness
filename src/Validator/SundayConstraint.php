<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Permet d'appeler la contraintes écrite dans la class SundayConstraintValidator
 */
class SundayConstraint extends Constraint
{
    public $message = 'Vous ne pouvez pas sélectionner un dimanche.';

    public function validatedBy()
    {
        // Récupére le nom actuelle de la classe ('SundayConstraint') et lui rajoute le validator ce qui fait que la fonction validateBy appel la classe SundayConstraintValidator.php
        return \get_class($this).'Validator';
    }
}
