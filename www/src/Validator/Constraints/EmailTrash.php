<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 12/02/2019
 * Time: 16:36
 */

namespace App\Validator\Constraints;

use App\Validator\EmailTrashValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailTrash extends Constraint
{
    public $message = 'constraint.emailTrash';

    public function validatedBy()
    {
        return EmailTrashValidator::class;
    }
}
