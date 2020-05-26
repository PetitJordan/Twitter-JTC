<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 28/02/2019
 * Time: 11:36
 */

namespace App\Validator;

use App\Utils\Various\Constant;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

class PasswordValidator extends ConstraintValidator
{
	protected $translator;

	public function __construct(TranslatorInterface $translator) {
		$this->translator = $translator;
	}

	public function validate($value, Constraint $constraint)
    {
        if ($value == '') {
            $this->context->buildViolation(
	            $this->translator->trans($constraint->getMessageTooShort(), array(
		            'nb' => Constant::PASSWORD_MIN_LENGTH,
	            ))
            )
                ->addViolation();
        } else {
            if (strlen($value) < Constant::PASSWORD_MIN_LENGTH) {
                $this->context->buildViolation(
	                $this->translator->trans($constraint->getMessageTooShort(), array(
		                'nb' => Constant::PASSWORD_MIN_LENGTH,
	                ))
                )
                    ->addViolation();
            }
        }
    }
}