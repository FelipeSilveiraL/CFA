<?php
session_start();

session_unset();

header("Location: ../adm.php?pag=1");
?>