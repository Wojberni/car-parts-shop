<?php

const DB_SERVER = 'db';
const DB_USERNAME = 'iab';
const DB_PASSWORD = 'iab';
const DB_DATABASE = 'iab';
$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}