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
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $password_repeat = $_POST['pw_rpt'];


    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["pw_rpt"])) {
        echo '<script type="text/javascript">',
        'setTimeout(function(){
        Materialize.toast(\'No se rellenaron todos los campos necesarios.\', 4000)
        }, 500);',
        '</script>';
    }

    $sql = "SELECT * FROM users WHERE login = '$username'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $username = '';
        echo '<script type="text/javascript">',
        'setTimeout(function(){
        Materialize.toast(\'Ya existe un usuario registrado con ese nombre.\', 4000)
        }, 500);',
        '</script>';
    }
else{

    $sql = "INSERT INTO users (login, password) VALUES( '$username', '$password')";

    if ($password == $password_repeat){
        if ($conn->query($sql) === TRUE) {
            echo '<script type="text/javascript">',
            'setTimeout(function(){
            Materialize.toast(\'Se creo el nuevo registro en el sistema.\', 3000)
            }, 1000);',
            '</script>';
            header("location: index.php");

        }
            else {
             echo '<script type="text/javascript">',
            'setTimeout(function(){
                Materialize.toast(\'Error '. $sql . '<br>' . $conn->error .' \', 2500)}, 1000);',
            '</script>';
        }

    }else{
        echo '<script type="text/javascript">',
        'setTimeout(function(){
        Materialize.toast(\'Las contraseñas no coinciden.\', 4000)
        }, 500);',
        '</script>';
    }
}



}


mysqli_close($conn);
?>


<html>

<head>

    <script type="text/javascript" src= "js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src= "js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href= "css/materialize.min.css">

</head>

<body class="ssrwa-login">
<div class="section"></div>
<main>
    <center>
        <div class="section"></div>

        <h2 class="indigo-text">Crear una nueva cuenta</h2>
        <div class="section"></div>

        <div class="container">
            <div class="z-depth-5 grey lighten-4 row" style="display: inline-block; width: 50%; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

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

                    <div class='row' >
                        <div class='input-field col s12' >
                            <input class='validate' type='password' name='password' id='password' required/>
                            <label for='password'>Ingrese su contraseña</label>
                        </div>
                    </div>

                    <div class='row' >
                        <div class='input-field col s12' >
                            <input class='validate' type='password' name='pw_rpt' id='pw_rpt' required/>
                            <label for='password'>Ingrese nuevamente su contraseña</label>
                        </div>
                    </div>

                    <br />
                    <center>
                        <div class='row'>
                            <a href="index.php">                            <button type='button' name='btn_login' class='col s5 btn btn-large waves-effect materialize-red'>Cancelar</button>
                            </a>
                            <div class="col s2"></div>
                            <button type='submit' name='btn_login' class='col s5 btn btn-large waves-effect indigo'>Registrarse</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </center>
    <div style = "font-size:11px; color:#cc0000; margin-top:10px"</div>
    <div class="section"></div>
    <div class="section"></div>
</main>

</body>

</html>
