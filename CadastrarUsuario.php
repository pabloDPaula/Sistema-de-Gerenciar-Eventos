<?php
    include_once('config.php');
    $genero = '';
    $erroNome = '';
    $erroEmail = '';
    $erroTelefone = '';
    $erroGenero = '';
    $erroSenha = '';
    $erroConfirmarSenha = '';

    if(isset($_POST["submit"]))
    {
        

        if(empty($_POST["nome"])){
            $erroNome = 'Por favor, preencha o nome';
        }else{
            $nome = $_POST["nome"];
            if(!preg_match("/^[a-zA-Z-' ]*$/",$nome)){
                $erroNome = 'Apenas letras';
            }else{
                $erroNome = "";
            }
        }

        if(empty($_POST['email'])){
            $erroEmail = 'Por favor, preencha o email';
        }else{
            $email = $_POST['email'];
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $erroEmail = 'Email inválido';
            }else{
                $erroEmail = '';
            }
        }

        if(empty($_POST['telefone'])){
            $erroTelefone = 'Por favor, preencha o telefone';
        }else{
            $telefone = $_POST['telefone'];
            if(strlen($telefone) < 11){
                $erroTelefone = 'Número do telefone inválido';
            }else{
                $erroTelefone = '';
            }
        }

        if(empty($_POST['senha'])){
            $erroSenha = 'Por favor, digite uma senha';
        }else{
            $senha = $_POST['senha'];
            if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d]{6,}$/', $senha)){
                $erroSenha = 'Senha precisa conter letras minúsculas e maiúsculas, números e precisa ter 6 ou mais caracteres';
            }else{
                $erroSenha = '';
            }
        }

        if(empty($_POST['genero'])){
            $erroGenero = 'Escolha um gênero';
        }else{
            $genero = $_POST['genero'];
            $erroGenero = '';
        }


        if(empty($_POST['confirmarSenha'])){
            $erroConfirmarSenha = 'Por favor, digite a senha novamente';
        }else{
            $confirmarSenha = $_POST['confirmarSenha'];
            if($senha != $confirmarSenha){
                $erroConfirmarSenha = 'Digite a mesma senha acima';
            }else{
                $erroConfirmarSenha = '';
            }
        }
        

        if(empty($erroNome) and empty($erroEmail) and empty($erroTelefone) and empty($erroSenha) and empty($erroConfirmarSenha)){
            $result = mysqli_query($conexao,"INSERT INTO usuarios(nome,email,telefone,sexo,senha) 
            VALUES ('$nome','$email','$telefone','$genero','$senha')");

            header('Location: login.php');
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <!--   Scripts bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!--   Scripts do jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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

        span{
            color: red;
        }
    </style>
    <script>
        $(document).ready(function () { 
        $("#telefone").mask('(00) 00000-0000');
    });
    </script>
</head>
<body>
    <form class="form" action="CadastrarUsuario.php" method="POST">
        <div class="card">
            <div class="login-top">
                <h3>Cadastro</h3>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" <?php if (isset($_POST['nome'])){ echo "value='".$_POST['nome']."'";} ?> name="nome" >
                <span class="erroNome"><?php echo $erroNome ?></span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" <?php if (isset($_POST['email'])){ echo "value='".$_POST['email']."'";} ?> name="email" placeholder="nome@exemplo.com" >
                <span class="erroEmail"><?php echo $erroEmail ?></span>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" <?php if (isset($_POST['telefone'])){ echo "value='".$_POST['telefone']."'";} ?> name="telefone" placeholder="(00) 00000-0000" >
                <span class="erroTelefone"><?php echo $erroTelefone ?></span>
            </div>
           <div class="mb-3">
            <p>Sexo</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="genero" id="genero" value="M" <?php echo ($genero == 'M') ? 'checked' : ''?> >
                <label class="form-check-label" for="generoM">
                  Masculino
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="genero" id="genero" value="F" <?php echo ($genero== 'F') ? 'checked' : '' ?> >
                <label class="form-check-label" for="generoF">
                  Feminino
                </label>
              </div>
              </br>
              <span class="erroGenero"><?php echo $erroGenero ?></span>
           </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" <?php if (isset($_POST['senha'])){ echo "value='".$_POST['senha']."'";} ?> name="senha" > 
                <span class="erroSenha"><?php echo $erroSenha ?></span>
            </div>
            <div class="mb-3">
                <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="confirmarSenha" <?php if (isset($_POST['confirmarSenha'])){ echo "value='".$_POST['confirmarSenha']."'";} ?> name="confirmarSenha" > 
                <span class="erroConfirmarSenha"><?php echo $erroConfirmarSenha ?></span>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Cadastrar</button>
            <div class="mb-3">
                  <a href="login.php">Faça login aqui</a>
              </div>
        </div>
    </form>
</body>
</html>
