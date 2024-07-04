<?php

namespace cytDiscountTable\Validators;

use Plenty\Validation\Validator;

/**
 *  Validator Class
 */
class DiscountTableValidator extends Validator
{
    protected function defineAttributes()
    {
        $this->addString('clientClass', true);
    }
}
