<?php

ini_set('date.timezone', 'Europe/Paris');

const LOCKOUT_ATTEMPTS_NUMBER = 3;
const LOCKOUT_ATTEMPTS_WINDOW = 30; // Seconds
const LOCKOUT_DURATION = 120 * 60; // Seconds (converted from minutes)

const DB_CONNECT = [
    "dbName" => "mediatek",
    "user" => "root",
    "pass" =>"",
];