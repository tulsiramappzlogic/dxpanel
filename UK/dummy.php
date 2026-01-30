<?php
session_start();

if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

$_SESSION['counter']++;

echo "Session ID: " . session_id() . "<br>";
echo "Counter: " . $_SESSION['counter'] . "<br>";
echo "Save Path: " . session_save_path() . "<br>";
?>