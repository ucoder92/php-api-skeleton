<?php

/**
 * Validation
 *
 * @package     PHP Skeleton
 * @author      Ulugbek Nuriddinov <ucoder92@gmail.com>
 * @link        https://github.com/ucoder92/php-api-skeleton
 * @since       1.0.0
 */

namespace Libs;

class Validation
{
    private $rules;
    private $errors;

    /**
     * Validation
     *
     * @param array $rules
     * @return void
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * Get first error
     *
     * @return array
     */
    public function getError()
    {
        return $this->errors ? $this->errors[0] : '';
    }

    /**
     * Get all errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Run validation
     *
     * @return bool
     */
    public function run()
    {
        if (is_array($this->rules) && $this->rules) {
            $run = true;

            foreach ($this->rules as $item) {
                $messages = [];
                $item_message = array_value($item, 'message');

                $item_rules = array_value($item, 'rules');
                $rules_array = $item_rules ? explode('|', $item_rules) : array();

                if (is_array($item_message)) {
                    $messages = $item_message;
                } else {
                    $messages[] = $item_message;
                }

                if ($rules_array) {
                    $label = array_value($item, 'label');
                    $value = array_value($item, 'value');

                    foreach ($rules_array as $key => $rule) {
                        $msg = array_value($messages, $key);
                        $validate = $this->validateRule($rule, $value);

                        if ($validate['error']) {
                            $run = false;
                            $this->errors[] = $msg ? $msg : str_replace('%label%', $label, $validate['message']);
                        }
                    }
                }
            }

            return $run;
        }

        return false;
    }

    /**
     * Validate rules
     *
     * @param string $rule
     * @param string $value
     * @return array
     */
    private function validateRule($rule, $value)
    {
        $output = array(
            'error' => false,
            'message' => false,
        );

        switch ($rule) {
            case 'required':
                $output['message'] = 'Please enter the "%label%" field';
                $output['error'] = (empty($value) || is_null($value)) ? true : false;
                break;
            case 'valid_email':
                $output['message'] = 'Please enter the correct email address in the "%label%" field';
                $output['error'] = (filter_var($value, FILTER_VALIDATE_EMAIL)) ? false : true;
                break;
            case 'valid_url':
                $output['message'] = 'Please enter the correct URL in the "%label%" field';
                $output['error'] = (filter_var($value, FILTER_VALIDATE_URL)) ? false : true;
                break;
            case 'numeric':
                $output['message'] = 'Please enter a valid number in the "%label%" field';
                $output['error'] = (is_numeric($value)) ? false : true;
                break;
        }

        return $output;
    }
}
