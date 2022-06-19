<?php
    include_once('config.php');
    session_start();

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)){
        header('location: deslogar.php');
    }{

        $emailLogado = $_SESSION['email'];
        $senhaLogado = $_SESSION['senha'];
        
        $idUsuario = "SELECT idUsuario, nome FROM usuarios WHERE email='$emailLogado' AND senha = '$senhaLogado'";
        $resultUsuario = $conexao->query($idUsuario);
        
        while($usuarioDB = mysqli_fetch_assoc($resultUsuario)){
            $idUsuario = $usuarioDB['idUsuario'];
            $nome = $usuarioDB['nome'];
        }

        $eventos = "SELECT * FROM eventos WHERE idOrganizador = $idUsuario";
        $resultEventos = $conexao->query($eventos);

        if(!empty($_GET['idEvento'])){
            $idEvento = $_GET['idEvento'];
            $excluirEvento = "DELETE FROM eventos WHERE idEvento = $idEvento and idOrganizador = $idUsuario";
            $result = $conexao->query($excluirEvento);
            header('location: MeusEventos.php');
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
   
    <!-- Script de icones do bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
   <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        .conteudo{
            padding-bottom: 200px;
        }

        .card{
            background-color: #1C1C1C;
        }
        .card:hover{
            background-color: #262626;
        }

        .card-title,h5{
            color: #F0F3F4;
        }

        .card-text{
            color: #B3B6B7;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand">Bem vindo, <?php echo $nome ?></a>
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
                <a class="nav-link active" href="">Meus Eventos</a>
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
      <div class="container conteudo">
        <div class="row mt-5 mb-4">
            <h2><strong>Meus Eventos</strong></h2>
        </div>
        <div class="row mb-4 ">
            <div class="col-3 ">
                <a type="button" class="btn btn-success ms-3 p-2" href="CadastrarEvento.php">Cadastrar</a>
             </div>
        </div>
        <div class="row">
                <?php         

                    while($eventosDB = mysqli_fetch_assoc($resultEventos)){
                        $dataInicio = date_create($eventosDB['dataInicio']);
                        $dataFim = date_create($eventosDB['dataFim']);

                        echo "<div class='card m-4 mt-5' style='width: 18rem;'>";
                        echo "<div class='p-3'>";
                        echo "<h3 class='card-title'><strong>".$eventosDB['nome']."</strong></h3>";
                        echo "</div>";
                        echo "<div class='card-body'>";
                        echo "<h5>Descrição:</h5>";
                        echo "<p class='card-text'>".$eventosDB['descricao']."</p>";
                        echo "<h5><i class='bi bi-calendar-event' style='color: white; font-size: 16px;'></i> Data e Hora:</h5>"; 
                        echo "<p class='card-text'>" . date_format($dataInicio, 'd/m/Y') . ", " .date("H:i", strtotime($eventosDB['horaInicio']))  .' -</br>';
                        echo  date_format($dataFim, 'd/m/Y'). ", " . date("H:i", strtotime($eventosDB['horaFim'])) . "</p>";
                        echo "</div>";
                        echo "<div class='p-3'>";
                        echo "<a type='button' class='btn btn-warning me-4' href='EditarEvento.php?idEvento=$eventosDB[idEvento]'>Editar</a>";
                        echo "<a type='button' class='btn btn-danger' href='MeusEventos.php?idEvento=$eventosDB[idEvento]'>Excluir</a>";
                        echo "</div>";
                        echo "</div>";
                    }    
                    
                ?>
        </div>
      </div>
</body>
</html>
