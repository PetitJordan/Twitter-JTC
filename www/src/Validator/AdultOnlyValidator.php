<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdultOnlyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value == '') {
            return false;
        }

        $now = new \DateTime(date('Y-m-d'));
        $interval = $now->diff($value);

        if ($interval->y < 18) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
