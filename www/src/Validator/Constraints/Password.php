<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 28/02/2019
 * Time: 11:36
 */

namespace App\Validator\Constraints;

use App\Utils\Various\Constant;
use App\Validator\PasswordValidator;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Password extends Constraint
{
	private $messageTooShort = 'constraints.password.tooShort';

    public function validatedBy()
    {
        return PasswordValidator::class;
    }

	/**
	 * @return string
	 */
	public function getMessageTooShort(): string {
		return $this->messageTooShort;
	}

	/**
	 * @param string $messageTooShort
	 */
	public function setMessageTooShort( string $messageTooShort ) {
		$this->messageTooShort = $messageTooShort;
	}


}