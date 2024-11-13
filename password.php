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

    /* CREATES A CRYPTOGRAPHICALLY SECURE RE-ARRANGEMENT BASED ON THE CURRENT
    * ELEMENTS IN AN GIVEN ARRAY OF CHARACTERS
    *  SEE FISHER-YATES SHUFFLE: https://en.wikipedia.org/wiki/Fisher%E2%80%93Yates_shuffle
    *
    *  PROVIDES UNBIASED RANDOMIZATION OF PASSWORD CHARACTERS
    *  @param &$ARRAY: REFERENCE TO ARRAY TO BE SHUFFLED
    *  @throws Exception ON RANDOM NUMBER GENERATION FAILURE
    */

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

    /* GENERATES UNBIASED RANDOM CHARACTER FROM CHARSET
    *  USES REJECTION SAMPLING TO ELIMINATE MODULO BIAS
    *  @param $CHARSET: CHARACTER SET TO SAMPLE FROM
    *  @param &$POOL: REFERENCE TO ENTROPY POOL
    *  @param &$INDEX: REFERENCE TO CURRENT POOL INDEX
    *  @return: RANDOMLY SELECTED CHARACTER
    */

    public function GET_UNBIASED_CHAR($CHARSET, &$POOL, &$INDEX)
    {
        $CHARSET_SIZE = strlen($CHARSET);
        $MAX_VALID = (PHP_INT_MAX - (PHP_INT_MAX % $CHARSET_SIZE));

        // ASSUME THAT THE LENGTH OF THE STRING IS INDICATIVE OF THE PRE-REQUSITIES

        do 
        {
            if ($INDEX >= strlen($POOL))
            {
                $POOL = $this->GET_SECURE_BYTES(strlen($POOL));
                $INDEX = 0;
            }

            // ASSUME WE HAVE AN INDICATIVE MATCH, READ THE FIRST 4 BYTES
            // OF THE ENTROPY POOL TO DISCERN A VALID BITWISE LENGTH 

            $RANDOM = unpack('N', substr($POOL, $INDEX, 4))[1];
            $INDEX += 4;

        } while ($RANDOM > $MAX_VALID);

        return $CHARSET[$RANDOM % $CHARSET_SIZE];
    }


    public function IS_VALID_PASSWORD($PASSWORD, $LEN, $REQS)
    {

    }

    public function GENERATE_PASSWORD($LEN, $REQS)
    {

    }
}

?>
