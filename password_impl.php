<?php

/* COPYRIGHT (C) HARRY CLARK 2024 */
/* GENERIC ALL PURPOSE PHP PASSWORD GENERATOR */

/* THE FOLLOWING FILE PERTAINS TOWARDS THE MODULARISATION OF LOGIC */

interface password_impl
{
    public int $HAS_UPPER = 1;
    public int $HAS_LOWER = 1;
    public int $HAS_NUMBER = 1;
    public int $HAS_SYMBOL = 1;
    public int $MIN_UPPER = 1;
    public int $MIN_LOWER = 1;
    public int $MIN_NUMBER = 1;
    public int $MIN_SYMBOL = 1;

    public function GET_SECURE_BYTES($LEN);

    // CONCATENATING AS VOID LIKE THIS DISCERNS NO NEEDED LOCAL ARGS

    public function CRYPTO_SHUFFLE(array $ARRAY): void;

}
