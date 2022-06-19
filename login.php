<?php
    include_once('config.php');
    session_start();

    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        //Acessa
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $result = $conexao->query($sql);
        //print_r($sql);
        //print_r($result);

        if(mysqli_num_rows($result) < 1){
            //Caso não tenha nenhum registro com esse email e senha, detroi qualquer variável que tenha essas SESSiON email e senha
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location: login.php');
        }else{
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
           header('location: home.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
     <!--   Scripts do jquery-->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(90deg, rgba(255,137,71,1) 0%, rgba(255,113,34,1) 52%, rgba(255,92,0,1) 100%);
        }
        .form{
            width: 400px;
            margin: auto;
            padding-top: 100px;
        }

        .login-top{
            text-align: center;
            padding-bottom: 25px;
        }

        .card{
            box-shadow: 1px 1px 5px #ccc;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
        }

        h3{
            font-weight: bold;
        }

        button{
            margin-bottom: 20px;
        }

        a{
            color: #1E90FF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <form class="form" action="login.php" method="POST">
        <div class="card">
            <div class="login-top">
                <h3>Faça seu login</h3>
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="nome@gmail.com">
              </div>
              <div class="mb-3">
                <label for="inputSenha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="inputSenha" name="senha">
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Login</button>
              <div class="mb-3">
                  <a href="CadastrarUsuario.php">Registre-se aqui</a>
              </div>
        </div>
    </form>
</body>
</html>
