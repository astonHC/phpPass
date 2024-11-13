<?php

/* COPYRIGHT (C) HARRY CLARK 2024 */
/* GENERIC ALL PURPOSE PHP PASSWORD GENERATOR */

/* THE FOLLOWING FILE PERTAINS TOWARDS THE FUNCTIONALITY OF USING 
PHP'S BUILT-IN CYRPTOGRAPHIC FUNCTIONS, REJECTION SAMPLING TO REMOVE RANDOM BIAS
(CON-CURRENT CREATIONS OF THE SAME HASH BASED ON THE SAME CHAR'S)

AMONG OTHER PRE-REQUISITES THAT WILL MAKE THIS UTILITY A VERSATILE ALTERNATIVE
*/

/* PRE-PROCESSOR DIRECTIVES */

define('MAX_PASSWORD_LEN', 128);
define('MIN_PASSWORD_LEN', 12);
define('MULTI', 2);

class Password implements password_impl
{
    // JUST ACCESS THE SECURE BYTES OF THE RANDOMLY GENERATED HASH

    public function GET_SECURE_BYTES($LEN) { return random_bytes($LEN); }

    // CREATES A CRYPTOGRAPHICALLY SECURE RE-ARRANGEMENT BASED ON THE CURRENT
    // ELEMENTS IN AN GIVEN ARRAY OF CHARACTERS

    // SEE FISHER-YATES SHUFFLE: https://en.wikipedia.org/wiki/Fisher%E2%80%93Yates_shuffle

    public function CRYPTO_SHUFFLE(array $ARRAY): void
    {
        // DISCERN THE ELEMENTS WITHIN THE ARRAY

        $NTH_ELEMENT = count($ARRAY);

        // ASSUME THAT THE ARRAY IS EMPTY

        if($NTH_ELEMENT <= 1) { return; }

        try
        {
            // NOW DISCERN HOW MANY ELEMENTS ARE WITHIN THE ARRAY
            // AND CREATE A NEW ITERATION TO PRODUCE A RANDOM RESULT FROM

            // LOOK FOR ALL POSSIBLE CONCURRENT ELEMENTS WITHIN THE ARRAY TO BE ABLE TO SWAP AROUND

            for($INDEX = $NTH_ELEMENT - 1; $INDEX > 0; $INDEX--)
            {
                $NEW_ITER = random_int(0, $INDEX);
                [$ARRAY[$INDEX], [$ARRAY[$NEW_ITER]] = [$ARRAY[$NEW_ITER], $ARRAY[$INDEX]]];
            }
        }

        catch (Exception $EX)
        {
            throw new Exception('Failed to generate random numbers: ' . $EX->getMessage());
        }
    }
}

?>
