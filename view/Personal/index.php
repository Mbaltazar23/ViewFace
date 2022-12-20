<?php

require_once '../../config.php';
require_once '../../model/Conexion.php';
require_once '../../model/Vinculacion.php';
require_once '../../model/Personal.php';
session_start();
if (!isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
} else if (isset($_SESSION["cargo-usuario"])) {
    header("Location: " . URL);
}