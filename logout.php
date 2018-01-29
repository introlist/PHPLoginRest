<?php
/**
 * Created by IntelliJ IDEA.
 * User: Roberto
 * Date: 16/01/2018
 * Time: 11:41 AM
 */

session_start();
$_SESSION['loggedin'] = false;
unset ($_SESSION['username']);
session_destroy();

header('Location: index.php');


?>