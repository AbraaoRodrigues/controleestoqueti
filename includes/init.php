<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include 'verifica_login.php';
include 'conexao.php';
