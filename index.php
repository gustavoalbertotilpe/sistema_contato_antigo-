<?php
    $bd= new mysqli("localhost","root","","contato");
    if(isset($_GET["pesquisa"]) && empty($_GET["pesquisa"])==false)
    {
        $sql = "SELECT IDCONTATO,NOME,TELEFONE,RAMAL FROM CONTATO WHERE NOME LIKE '%".$_GET["pesquisa"]."%' ORDER BY NOME ASC";
    }
    else
    {
        $sql = "SELECT IDCONTATO,NOME,TELEFONE,RAMAL FROM CONTATO  ORDER BY NOME ASC";
    }
   
    
    $consulta = mysqli_query($bd,$sql);

    if(isset($_POST["nome"]))
    {
        $id = $_POST["id"];
        $ramal = $_POST["ramal"];
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];

        $sql_alteracao = "UPDATE CONTATO SET NOME ='$nome', RAMAL = '$ramal', TELEFONE = '$telefone' WHERE IDCONTATO = $id "; 
        if(mysqli_query($bd,$sql_alteracao))
        {
            echo"<script>";
            echo"alert('Contato alterado com sucesso!')";
            echo"</script>";
            header('Refresh:0');
        }
    }
    if(isset($_POST['id-exclusao']))
    {
        $id = $_POST["id-exclusao"];

        $sql_exclusao = "DELETE FROM CONTATO WHERE IDCONTATO = $id "; 

        if(mysqli_query($bd,$sql_exclusao))
        {
            echo"<script>";
            echo"alert('Contato deletado com sucesso!')";
            echo"</script>";
            header('Refresh:0');
        }

    }

    if(isset($_POST['novonome']) && empty($_POST['novonome'])==false)
    {
        $querycadastro = "INSERT INTO CONTATO (NOME,RAMAL,TELEFONE) VALUES ('".$_POST["novonome"]."','".$_POST["novoramal"]."','".$_POST["novotelefone"]."')";
        if(mysqli_query($bd,$querycadastro))
        {
            echo"<script>";
            echo"alert('Contato cadastrado com sucesso!')";
            echo"</script>";
            header('Refresh:0');
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    <title>Contatos</title>

    <!-- Bootstrap -->
    <link href="bootstrap3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id='novocontato' class='modal fade  modal-index'   tabindex='-1' role='dialog'>
                
                <div class='modal-dialog ' role='document'>

                    <div class='modal-content'>

                        <div class='modal-header'>

                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
           
                        </div>
                        
                        <form action='' method='POST'>
                        <div class='modal-body'>

                            <input type='text' name='novonome' class='form-control' placeholder="Nome" required>
                            <input type='text' name='novoramal' class='form-control' placeholder='Ramal' required> 
                            <input type='text' name='novotelefone'  class='form-control' placeholder='Telefone ligação externa'  required>

                        </div>

                        <div class='modal-footer'>

                        <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                        <button type='submit' class='btn btn-primary'>Salvar</button>
                        </form> 
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

    </div>

    <nav class="navbar navbar-default navbar-personalisada">

        <div class='row topo'>

            <div class="col-md-3">

                <form action="" method="GET">

                    <div class="input-group">

                        <input class="form-control" type="search" name="pesquisa">

                        <span class="input-group-btn">

                            <button type="sumit" class="btn btn-default btn-pesquisa-input-topo">
                                Pesquisar <span class="glyphicon glyphicon-search"></span>
                            </button>

                        </span>

                    </div>

                </form>

            </div>  

            <div class='col-md-3'>

                 <button type='button' class='btn btn-success' data-toggle='modal' data-target='#novocontato'>Novo contato</button>
            </div>
               
        </div>
        
    </nav>

    <div class="clear"></div>

    <div class="container clear corpo ">

        <div class="row">

            <div class="col-md-12">


                <div>
			 <?php 
                         
                         if( mysqli_num_rows($consulta) == 0)
                         {
                             echo"Nem registro encontrado";
                         }
                         else
                         {
                     ?>     
                    <table class="table">
                       <tr>
                            <td>Ramal</td>
                            <td>Nome</td>
                            <td>Ligação para fora</td>
                            <td>Ação</td>
                        </tr>
                            
                            <?php

                                while($row = mysqli_fetch_assoc($consulta)){
                                    echo"
                                        <tr>
                                            <td>".$row["RAMAL"]."</td>
                                            <td>".$row["NOME"]."</td>
                                            <td>".$row["TELEFONE"]."</td>
                                            <td>
                                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#".$row["IDCONTATO"]."'>
                                                    Editar
                                                </button>
                                                    <div id='".$row["IDCONTATO"]."' class='modal fade' tabindex='-1' role='dialog'>
                                                    
                                                        <div class='modal-dialog' role='document'>

                                                            <div class='modal-content'>

                                                                <div class='modal-header'>
                                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                                                    <form action='' method='POST'>
                                                                        <input type='hidden' value='".$row["IDCONTATO"]."' name='id-exclusao'>
                                                                        <button type='submit' class='btn btn-danger'>Excluir</button>
                                                                     </form>   
                                                                    
                                                                </div>
                                                                <form action='' method='POST'>
                                                                <div class='modal-body'>
                                                                    <input type='text' name='ramal' value='".$row["RAMAL"]."' class='form-control'>
                                                                    <input type='text' name='nome' value='".$row["NOME"]."' class='form-control'>
                                                                    <input type='text' name='telefone' value='".$row["TELEFONE"]."' class='form-control'>
                                                                    <input type='hidden' name='id' value='".$row["IDCONTATO"]."' class='form-control'>
                                                                </div>

                                                                <div class='modal-footer'>

                                                                <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
                                                                <button type='submit' class='btn btn-primary'>Salvar mudanças</button>
                                                                </form> 
                                                                </div>

                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                                                               
                                            </td>
                                        </tr>    
                                    ";
                                }
			     }
                            ?>
                  
                    </table>

                </div>

            </div>

        </div>
    </div>    
        
    <?php
        mysqli_close($bd);
    ?>    
    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="bootstrap3.4.1/js/bootstrap.min.js"></script>
  </body>
</html>