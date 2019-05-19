<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IdentificationNumber extends Constraint
{
    public $message = "Invalid value for identificationNumber";
}
