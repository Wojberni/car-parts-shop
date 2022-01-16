<?php
session_start();
session_unset();
require_once ("./php/connection.php");

$sql = "TRUNCATE TABLE cart";
$link->query($sql);

header('Location:index.php');

