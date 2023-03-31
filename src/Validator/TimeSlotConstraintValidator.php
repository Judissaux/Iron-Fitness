<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TimeSlotConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // Vérifie que la date de rendez-vous est un objet DateTime valide
        if (!$value instanceof \DateTime) {
            return;
        }

        // Récupère le nom du jour de la semaine
        $dayOfWeek = strtolower($value->format('l'));

        // Vérifie que le jour de la semaine est défini dans la contrainte
        if (!isset($constraint->days[$dayOfWeek])) {
            return;
        }

        // Récupère les plages horaires pour ce jour de la semaine
        $minTime = $constraint->days[$dayOfWeek][0];
        $maxTime = $constraint->days[$dayOfWeek][1];

        // Vérifie que l'heure de rendez-vous est dans la plage horaire autorisée
        if ($value->format('H:i') < $minTime || $value->format('H:i') > $maxTime) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
