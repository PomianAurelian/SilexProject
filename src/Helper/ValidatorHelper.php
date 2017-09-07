<?php

namespace Helper;

use Helper\BaseHelper;

/**
 * Validator helper.
 *
 * @see BaseHelper
 *
 * @author Pomian Ghe. Aurelian
 */
class ValidatorHelper extends BaseHelper
{
    /**
     * Get errors array.
     *
     * @param  ConstraintViolationList $errors
     * @return array
     */
    public function getErrorsArr($errors)
    {
        $errorsArr = [];
        foreach ($errors as $error) {
            $errorsArr[$error->getPropertyPath()] = $error->getMessage();
        }
        return $errorsArr;
    }
}

