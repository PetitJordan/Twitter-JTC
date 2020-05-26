<?php
namespace App\Validator\Constraints;

use App\Validator\AdultOnlyValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AdultOnly extends Constraint
{
    public $message = 'constraint.adultOnly';

    public function validatedBy()
    {
        return AdultOnlyValidator::class;
    }
}
