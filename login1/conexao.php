<?php
    $host="localhost";
    $db_user="root";
    $db_pass="";
    $db_name="login";

        $connect= mysqli_connect( $host, $db_user, $db_pass, $db_name );
        function login($connect){
            if (isset($_post['acessar'])and !empty($_post['email']) and !empty($_post['senha'])) {

                $email= filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $senha= sha1($_POST['senha']);
                $query= "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
                $executar= mysqli_query($connect, $query);
                $return= mysqli_fetch_assoc($executar);
        if (!empty($return['email'])) {
            //echo "Bem vindo" . $return['nome'];
            session_start();
            $_session['nome'] = $return['nome'];
            $_session['id'] = $return['id'];
            $_session['ativa'] = TRUE;
            header("location: index.php");

        }else{
            echo "Usuário ou senha não encontrado!";
        }  
            }
        }

?>