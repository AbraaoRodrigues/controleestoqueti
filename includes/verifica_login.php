<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: /controle_estoque_ti/index.php?erro=1');
    exit();
}
