<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IdentificationNumberValidator extends ConstraintValidator
{
    private const MULTIPLIERS = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1];

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IdentificationNumber) {
            throw new UnexpectedTypeException($constraint, IdentificationNumber::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!$this->isIdentificationNumberValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    private function isIdentificationNumberValid(string $identificationNumber): bool
    {
        if (strlen($identificationNumber) != 11) {
            return false;
        }
        $arrayOfDigits = array_map(
            function ($digit, $multiplier) {
                return intval($digit)*$multiplier;
            },
            str_split($identificationNumber),
            self::MULTIPLIERS
        );
        $controlSum = array_sum($arrayOfDigits);

        return $controlSum%10 == 0;
    }
}
