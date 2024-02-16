<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AgeUnder18 extends Constraint
{
    public string $message = 'Vous devez avoir au moins 18 ans';
}
