<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 18/01/2018
 * Time: 16:03
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PhoneNumberValidator extends ConstraintValidator
{
    const LENGTH = 10;

    public function validate($value, Constraint $constraint)
    {
        if ($value == '') {
            return true;
        }

        $newValue = preg_replace('/[^\d]+/', '', $value);

        if ($value != $newValue || strlen($newValue) != self::LENGTH) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
