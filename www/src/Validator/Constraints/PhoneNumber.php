<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 18/01/2018
 * Time: 16:05
 */

namespace App\Validator\Constraints;

use App\Validator\PhoneNumberValidator;
use Symfony\Component\Validator\Constraint;

class PhoneNumber extends Constraint
{
    public $message = 'constraints.phoneNumber';

    public function validatedBy()
    {
        return PhoneNumberValidator::class;
    }
}
