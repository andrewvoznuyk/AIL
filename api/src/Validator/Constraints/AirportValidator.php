<?php

namespace App\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\Airport;

/**
 * @Annotation
 */
class AirportValidator extends ConstraintValidator
{

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Airport) {
            throw new UnexpectedTypeException($constraint, Airport::class);
        }

        if (!$value instanceof Airport) {
            throw new UnexpectedTypeException($constraint, Airport::class);
        }
    }

}