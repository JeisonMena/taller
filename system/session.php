<?php
session_start();
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit();
}