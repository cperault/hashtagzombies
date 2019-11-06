<?php

/******************************************************************************************************************\
 *File:    Confirmation.php                                                                                       *
 *Project: #ZOMBIES                                                                                               *
 *Date:    November 6th, 2019                                                                                     *
 *Purpose: This class will be used to confirmation the registration of a user                                     *
\******************************************************************************************************************/

//function to generate an encrypted code which will be emailed to the email address of the person registering
function generate_security_code()
{
    //salt
    $options = [
        'cost' => 14,
    ];
    //value to hash
    $pre_hash_value = rand(300, 5000);
    //hash the randomly generated value and use bcrypt with salt
    $security_code = password_hash($pre_hash_value, PASSWORD_BCRYPT, $options);

    return $security_code;
}
