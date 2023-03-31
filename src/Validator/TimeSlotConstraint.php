<?php 


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TimeSlotConstraint extends Constraint
{
    public $message = 'L\'horaire n\'est pas correcte';

    public $days = [
        'monday' => ['09:30', '19:00'],
        'tuesday' => ['10:30', '19:00'],
        'wednesday' => ['15:30', '19:00'],
        'thursday' => ['09:30', '19:00'],
        'friday' => ['15:30', '19:00'],
        'saturday' => ['09:30', '12:00'],
    ];

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
