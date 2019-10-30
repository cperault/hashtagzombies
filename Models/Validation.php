<?php

/******************************************************************************************************************\
 *File:    Validation.php                                                                                         *
 *Project: #ZOMBIES                                                                                               *
 *Date:    October 27th, 2019                                                                                     *
 *Purpose: This is the registration page through which a player can register if they don't have FB or Google      *
\******************************************************************************************************************/


class Validation
{
    //function to validate length
    public static function is_valid_length($input_value = '')
    {
        //initial validator variable
        $valid = false;
        $length = mb_strlen($input_value);
        //cannot be more than 20 characters
        if ($length >= 1 && $length <= 20) {
            $valid = true;
        }
        return $valid;
    }

    //function to validate proper email entry
    public static function is_valid_email($email = '')
    {
        //initial validator variable
        $valid = false;
        //remove illegal characters from the input
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        //validate the sanitized email address
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid = true;
        }
        return $valid;
    }
    //function to validate form input; receives in array of input so that it is extensible in any validation scenario
    public static function is_valid($input = [])
    {
        //initial validator variable
        $valid = false;
        $message = []; //array to store erroroneous input
        //iterate through the array of input values
        foreach ($input as $key => $value) {
            //check to make sure no value is empty
            if (trim($value) === '') {
                $valid = false;
                $message[] = $value . " cannot be blank.";
            } else {
                $valid = true;
            }
            //validate email
            if ($key === "email") {
                if (!Validation::is_valid_email($value)) {
                    $valid = false;
                    $message[] = $value . " is not a valid email address.";
                } else {
                    $valid = true;
                }
            }
            //validate username, first name, and last name
            if ($key === "username" || $key === "first_name" || $key === "last_name") {
                if (!Validation::is_valid_length($value)) {
                    $valid = false;
                    $message[] = $value . " cannot exceed 20 characters.";
                } else {
                    $valid = true;
                }
            }
        }
        if (count($message) > 0) {
            $validation_result = array('valid' => $valid, 'errors' => $message);
        } else {
            $validation_result = $valid;
        }

        return $validation_result;
    }
}
