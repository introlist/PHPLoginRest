<?php
include("config.php");
// Check connection
if ($conn->connect_error) {
    echo '<script type="text/javascript">',
    'setTimeout(function(){
 Materialize.toast(\'Fallo la conexión a la base de datos.\', 4000)
}, 1000);',
    '</script>';
    die("Connection failed: " . $conn->connect_error);
}
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form


    $username =  strtolower($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE login = '$username'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (($password == $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);

            echo "Bienvenido! " . $_SESSION['username'];
            header("location: repositories.php");


        } else {
            echo '<script type="text/javascript">',
            'setTimeout(function(){
 Materialize.toast(\'Intente de nuevo por favor.\', 2500)
}, 1000);',
            '</script>';
        }
    }else{
        echo '<script type="text/javascript">',
        'setTimeout(function(){
 Materialize.toast(\'No existe registro de esa cuenta en el sistema.\', 2500)
}, 500);',
        '</script>';
    }
}
mysqli_close($conn);
?>
<html>

<head>

    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/materialize.min.css">

</head>

<body class="ssrwa-login">
<div class="section"></div>
<main>
    <center>
        <img class="responsive-img" style=" height: 133px;" src="img/user-icon.svg" />
        <div class="section"></div>

        <h5 class="indigo-text">Introduzca sus credenciales para acceder a la aplicación</h5>
        <div class="section"></div>

        <div class="container">
            <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

                <form class="col s12" method="post">
                    <div class='row'>
                        <div class='col s12'>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='input-field col s12'>
                            <input class='validate' type='text' name='username' id='username' value="<?php if (!empty($username)){echo  $username;} ;?>"required/>
                            <label for='username'>Ingrese su nombre de usuario</label>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='input-field col s12'>
                            <input class='validate' type='password' name='password' id='password' required/>
                            <label for='password'>Ingrese su contraseña</label>
                        </div>
                        <label disabled="disabled" style='float: right;'>
                            <b class="pink-text">Demo</b>
                        </label>
                    </div>

                    <br />
                    <center>
                        <div class='row'>
                            <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>Iniciar Sesión</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
        <a href="newaccount.php">Crear una nueva cuenta</a>
    </center>
    <div style = "font-size:11px; color:#cc0000; margin-top:10px"</div>
    <div class="section"></div>
    <div class="section"></div>
</main>

</body>

</html>