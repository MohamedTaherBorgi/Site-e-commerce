<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AgeUnder18Validator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof AgeUnder18) {
            throw new UnexpectedTypeException($constraint, AgeUnder18::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        // Calculate age
        $today = new \DateTime();
        $age = $value->diff($today)->y;

        // Check if age is less than 18
        if ($age < 18) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}