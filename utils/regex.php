<?php

$validPatterns = array(
    "date_slashes"    => "/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", // TODO: Refine this regex
    "date_hyphens"    => "/^[0-9]{4}-[0-9]{2}-[0-9]{2}/", // TODO: Refine this regex
    "date_hyphens_fr" => "/^[0-9]{2}-[0-9]{2}-[0-9]{4}/", // TODO: Refine this regex
    "email"           => "/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/",
    "password_weak"   => "/^[a-zA-Z0-9?@\.;:!_-]{6,14}$/",
    "password_policy" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\s])(?=.*[?!@#$%^&*]).{10,}$/",
    "postal_address"  => "/^.{2, 255}$/",
    "proper_name"     => "/^[a-zA-ZéçèàêëîïôöûüâäÉÀÈËËÏÎÖÔÛÜÄÂ][a-zA-ZéçèàêëîïôöûüâäÉÀÈËËÏÎÖÔÛÜÄÂ' -]{1,50}$/",
    "username"        => "/^[a-zA-Z0-9_]{5,15}$/",
    "zip_code"        => "/^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/",
    "isbn"            => "/^[0-9]{13}$/",
    "year"            => "/^[0-9]{4}$/", // TODO: Refine this regex
    "six_digits_code" => "/^[0-9]{6}$/", // TODO: Refine this regex
);