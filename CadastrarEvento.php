<?php
include_once('config.php');
session_start();
$erroNome = '';
$erroDescricao = '';
$erroHoraInicio = '';
$erroHoraFim = '';
$erroDataInicio = '';
$erroDataFim = '';

//Caso a variável email e senha de SESSION não exista, redireciona para a tela de login
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    header('location: deslogar.php');
} {

    $emailLogado = $_SESSION['email'];
    $senhaLogado = $_SESSION['senha'];

    // Busca no banco de dados o nome do usuario para mostrar na tela e o idUsuario para usar posteriormente
    $usuario = "SELECT idUsuario, nome FROM usuarios WHERE email='$emailLogado' AND senha = '$senhaLogado'";
    $resultUsuario = $conexao->query($usuario);

    while ($usuarioDB = mysqli_fetch_assoc($resultUsuario)) {
        $idUsuario = $usuarioDB['idUsuario'];
        $nomeUsuario = $usuarioDB['nome'];
    }

    // Verifica se exista uma requisição POST no botão submit para executar o sql de editar evento
    if (isset($_POST["submit"])) {
        if (empty($_POST['nome'])) {
            $erroNome = 'Digite o nome do evento';
        } else {
            $nomeEvento = $_POST['nome'];
            $erroNome  = '';
        }

        if (empty($_POST['descricao'])) {
            $erroDescricao = 'Digite a descrição do evento';
        } else {
            $descricao = $_POST['descricao'];
            $erroDescricao  = '';
        }

        if (empty($_POST['horaInicio'])) {
            $erroHoraInicio = 'Digite um horário';
        } else {
            $horaInicio = $_POST['horaInicio'];
            $erroHoraInicio = '';
        }

        if (empty($_POST['horaFim'])) {
            $erroHoraFim = 'Digite um horário';
        } else {
            $horafim = $_POST['horaFim'];
            $erroHoraFim = '';
        }



        if (empty($_POST['dataInicio'])) {
           $erroDataInicio = 'Digite uma data';
        } else {
            $dataInicio = $_POST['dataInicio'];
            $erroDataInicio = '';
        }

        if (empty($_POST['dataFim'])) {
            $erroDataFim  = 'Digite uma data';
        } else {
            $dataFim = $_POST['dataFim'];
            $erroDataFim = '';
        }


        if (empty($erroNome) and empty($erroDescricao) and empty($erroHoraInicio) and empty($erroHoraFim) and empty($erroDataInicio) and empty($erroDataFim)) {

            $cadastrarEvento = "INSERT INTO eventos (descricao, horaInicio, horaFim, dataInicio, dataFim, idOrganizador, nome) 
            VALUES ('$descricao','$horaInicio','$horafim','$dataInicio','$dataFim',$idUsuario,'$nomeEvento')";

            $result = $conexao->query($cadastrarEvento);
            header('location: MeusEventos.php');
        }
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
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .conteudo {
            width: 800px;
            padding-bottom: 150px;
            background-color: #1C1C1C;
        }

        h2 {
            color: #F0F3F4;
            text-align: center;
        }

        label {
            color: #F0F3F4;
            text-align: left;
        }

        span{
            color: red;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand">Bem vindo, <?php echo $nomeUsuario ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendario.php">Calendário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="MeusEventos.php">Meus Eventos</a>
                    </li>
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Perfil
                        </a>
                        <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Minha conta</a></li>
                            <li><a class="dropdown-item" href="deslogar.php">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container conteudo mt-5 mb-4">
        <div class="row p-5">
            <h2 class=""><strong>Cadastrar Evento</strong></h2>
        </div>
        <div class="row p-5">
            <form style="width: 800px;  margin-left: auto; margin-right: auto;" action="CadastrarEvento.php" method="POST">
                <div class="form-group row mb-3 mt-3 ">
                    <label for="nome" class="col-sm-3 col-form-label">Nome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nome" name="nome" <?php if(isset($_POST['nome'])){ echo "value='".$_POST['nome']."'";} ?>>
                        <span class="erroNome"><?php echo $erroNome ?></span>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="descricao" class="col-sm-3 col-form-label">Descrição</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <textarea class="form-control" id="descricao" name="descricao" rows="4"><?php if(!empty($_POST['descricao']))echo $_POST['descricao']?></textarea>
                            <span class="erroDescricao"><?php echo $erroDescricao ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="dataInicio" class="col-sm-3 col-form-label">Data de Início</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="dataInicio" name="dataInicio" <?php if(isset($_POST['dataInicio'])){ echo "value='".$_POST['dataInicio']."'";} ?>>
                        <span class="erroDataInicio"><?php echo $erroDataInicio ?></span>
                    </div>
                    <label for="dataFim" class="col-sm-3 col-form-label">Data de Término</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="dataFim" name="dataFim" <?php if(isset($_POST['dataFim'])){ echo "value='".$_POST['dataFim']."'";} ?>>
                        <span class="erroDataFim"><?php echo $erroDataFim ?></span>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="horaInicio" class="col-sm-3 col-form-label">Hora de Início</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="horaInicio" name="horaInicio"  <?php if(isset($_POST['horaInicio'])){ echo "value='".$_POST['horaInicio']."'";} ?>>
                        <span class="erroHoraInicio"><?php echo $erroHoraInicio ?></span>
                    </div>
                    <label for="horaFim" class="col-sm-3 col-form-label">Hora de Término</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="horaFim" name="horaFim"  <?php if(isset($_POST['horaFim'])){ echo "value='".$_POST['horaFim']."'";} ?>>
                        <span class="erroHoraFim"><?php echo $erroHoraFim ?></span>
                    </div>
                </div>
                <div class="form-group row pt-4">
                    <div class="col-sm-9">
                        <a class="btn btn-secondary me-5" href="MeusEventos.php">Voltar</a>
                    </div>
                    <div class="col-sm">
                        <button type="submit" name="submit" class="btn btn-success ms-5">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</body>

</html>