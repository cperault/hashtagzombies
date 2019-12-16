<?php

/******************************************************************************************************************\
 *File:    Validation.php                                                                                         *
 *Project: #ZOMBIES                                                                                               *
 *Date:    October 27th, 2019                                                                                     *
 *Purpose: This is the registration page through which a player can register if they don't have FB or Google      *
\******************************************************************************************************************/


class Validation
{
    //function to validate proper email entry
    public static function is_valid_email($email = '')
    {
        //initial validator variable
        $valid = false;
        //remove illegal characters from the input
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        //validate the sanitized email address; returns true if filter_var passes validation of the email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid = true;
        }
        return $valid;
    }

    //function to check if email address already has been used for registration
    public static function email_address_is_available($email = '')
    {
        //check to make sure that the user hasn't already registered
        if (!PlayerDB::is_registered($email)) {
            $valid = true;
        }
        return $valid;
    }

    //function to validate input is neither empty nor null
    public static function input_is_present($input = '')
    {
        $valid = false;
        if (trim($input) !== '') {
            $valid = true;
        }
        return $valid;
    }

    //function to validate input deos not contain special characters
    public static function input_contains_special_characters($input = '')
    {
        $valid = false;
        if (preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $input) === 1) {
            $valid = true;
        }
        return $valid;
    }

    //function to validate each input value
    public static function is_valid($input = [])
    {
        //array to store validation result(s)
        $result = [];

        //iterate through the array of input values received
        foreach ($input as $key => $value) {
            //length of input received
            $length = strlen($value);
            switch ($key) {
                case 'Login username':
                case 'Login password':
                    //check username is not empty 
                    if (!Validation::input_is_present($value)) {
                        $result[] = $key . " is required";
                    }
                    break;
                case 'Username';
                    //check username is not empty 
                    if (!Validation::input_is_present($value)) {
                        $result[] = $key . " is required";
                    }
                    //username must be between 5 and 20 characters
                    elseif ($length < 5 || $length > 20) {
                        $result[] = $key . " must be between 5 and 20 characters";
                    }
                    //username cannot contain special characters
                    if (Validation::input_contains_special_characters($value)) {
                        $result[] = $key . " cannot contain special characters";
                    }
                    break;
                case 'First Name':
                case 'Last Name':
                    //check if first or last name is not empty
                    if (!Validation::input_is_present($value)) {
                        $result[] = $key . " is required";
                    }
                    //first or last name must not exceed 50 characters
                    elseif ($length <= 0 || $length > 50) {
                        $result[] = $key . " must be between 1 and 50 characters";
                    }
                    //first or last name cannot contain special characters
                    if (Validation::input_contains_special_characters($value)) {
                        $result[] = $key . " cannot contain special characters";
                    }
                    break;
                case 'Email Address':
                    //check that email address is not empty
                    if (!Validation::input_is_present($value)) {
                        $result[] = $key  . " is required";
                    }
                    //validate proper email format
                    elseif (!Validation::is_valid_email($value)) {
                        $result[] = $key . " is invalid";
                    } elseif (!Validation::email_address_is_available($value)) {
                        $result[] = $key . " provided has already been used";
                    }
                    break;
                case 'Password':
                    //check that password is not empty
                    if (!Validation::input_is_present($value)) {
                        $result[] = $key  . " is required";
                    }
                    //check that password is between 10 and 100 characters
                    elseif ($length < 10 || $length > 100) {
                        $result[] = $key . " must be between 10 and 100 characters";
                    }
                    break;
                case 'Password reset username':
                    //check that the username on the password reset form is not empty
                    if (!Validation::input_is_present($value)) {
                        $result[] = "Username is required";
                    }
            }
        }
        return $result;
    }
}
