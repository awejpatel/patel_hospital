<?php
// header.php — minimal session safety header
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
