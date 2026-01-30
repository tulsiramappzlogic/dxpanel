<?php
session_start();

$count = isset($_SESSION['count']) ? $_SESSION['count'] : 0;
$count++;
$_SESSION['count'] = $count;
echo $count;

?>