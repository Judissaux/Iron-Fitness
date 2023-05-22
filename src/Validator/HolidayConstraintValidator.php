<?php 

namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class HolidayConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        // Récupérer les jours fériés pour l'année en cours
        $currentYear = date('Y');
        $joursFeries = $this->getJoursFeries($currentYear);

        // Vérifier si la date sélectionnée est un jour férié
        $selectedDate = $value->format('Y-m-d');
        if (in_array($selectedDate, $joursFeries)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ date }}', $selectedDate)
                ->addViolation();
        }
    }

    private function getJoursFeries($year)
    {
        // Générer les jours fériés pour l'année spécifiée
        // Remplacez cette logique par la méthode que vous utilisez pour obtenir les jours fériés

        $joursFeries = [
            $year . '-01-01',
            $year . '-04-10',
            $year . '-05-01',
            $year . '-05-08',
            $year . '-05-18',
            $year . '-05-29',
            $year . '-07-14',
            $year . '-08-15',
            $year . '-11-01',
            $year . '-11-11',
            $year . '-12-25',
        ];

        return $joursFeries;
    }
}
