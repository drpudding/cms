<?php namespace CMS\Validators;

	use Illuminate\Validation\Validator;

	class CustomValidation extends Validator {

    /**
     * Magically adds validation methods. Normally the Laravel Validation methods
     * only support single values to be validated like 'numeric', 'alpha', etc.
     * Here we copy those methods to work also for arrays, so we can validate
     * if a value is OR an array contains only 'numeric', 'alpha', etc. values.
     *
     * $rules = array(
     *     'row_id' => 'required|integerOrArray', // "row_id" must be an integer OR an array containing only integer values
     *     'type'   => 'inOrArray:foo,bar' // "type" must be 'foo' or 'bar' OR an array containing nothing but those values
     * );
     *
     * @param string $method Name of the validation to perform e.g. 'numeric', 'alpha', etc.
     * @param array $parameters Contains the value to be validated, as well as additional validation information e.g. min:?, max:?, etc.
     */
    public function __call($method, $parameters)
    {

        // Convert method name to its non-array counterpart (e.g. validateNumericArray converts to validateNumeric)
        if (substr($method, -7) === 'OrArray')
            $method = substr($method, 0, -7);

        // Call original method when we are dealing with a single value only, instead of an array
        if (! is_array($parameters[1]))
            return call_user_func_array(array($this, $method), $parameters);

        $success = true;
        foreach ($parameters[1] as $value) {
            $parameters[1] = $value;
            $success &= call_user_func_array(array($this, $method), $parameters);
        }

        return $success;

    }

    /**
     * All ...OrArray validation functions can use their non-array error message counterparts
     *
     * @param mixed $attribute The value under validation
     * @param string $rule Validation rule
     */
    protected function getMessage($attribute, $rule)
    {

        if (substr($rule, -7) === 'OrArray')
            $rule = substr($rule, 0, -7);

        return parent::getMessage($attribute, $rule);

    }

    // SAMPLE CUSTOM VALIDATION
    // set in a model: public static $rules = array('username' => 'required|begin_with:a);
    // field = username, value = entry, params[0] = a
    public function validateBeginWith($field, $value, $params)
    {
        if (strtolower(substr($value, 0, 1)) == $params[0])
        {
            return TRUE;
        }

        return FALSE;
    }

    // Sample Message
    // see lang/en/validation: 'username' => array('begin_with' => 'The :attribute must begin with ":string"')
    protected function replaceBeginWith($message, $attribute, $rule, $parameters)
    {
        return str_replace(':string', $parameters[0], $message);
    }

}