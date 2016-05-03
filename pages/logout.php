<?php
include('../header.php');

session_start();
session_destroy();

header('Location: ' . base_url() . 'pages/dashboard.php');
?>