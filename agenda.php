<?php
//FAVOR ALTERAR AS INFORMAÇÕES DE ACORDO COM AS CONFIGURAÇÕES DA SUA MÁQUINA
    $ipLocal = "localhost";
    $user = "root";                                        
    $senha ="";                                            
    $banco = "db_agenda";
//##########################################################################

    if($con = @mysqli_connect($ipLocal, $user, $senha, $banco)){
        echo("<script>alert('Banco de Dados conectado com sucesso')</script>");
    }else{
        echo("<script>alert('Erro na conexão com o banco, Favor alterar as propiedades de acesso ao banco de dados')</script>");
    }

    session_start();

    $botao = "Salvar";
    $nome = "";
    $email = "";
    $celular = "";

//SALVANDO E ATUALIZANDO REGISTROS
    if(isset($_POST['btnSalvar'])){
        $nome = $_POST['txtNome'];
        $email = $_POST['txtEmail'];
        $celular = $_POST['txtCelular'];
        
        if($_POST['btnSalvar'] == "Salvar"){
            $sql = "INSERT INTO tbl_contato(nome, email, celular) VALUES (
        '".$nome."', '".$email."', '".$celular."')";
        }else if($_POST['btnSalvar'] == "Editar"){
            $sql = "UPDATE tbl_contato SET nome='".$nome."',
            email='".$email."', 
            celular='".$celular."' WHERE id =".$_SESSION['idRegistro'];
            
            echo($sql);
        }
        
        mysqli_query($con,$sql);
        
        header('location:agenda.php');
    }

//EXCLUINDO REGISTROS
    if(isset($_GET['modo'])){
        $modo = $_GET['modo'];
        
        if($modo == "excluir"){
            $id = $_GET['id'];
            
            $sql = "DELETE FROM tbl_contato WHERE id = ".$id;
            
            mysqli_query($con,$sql);
        
            header('location:agenda.php');
        }else if($modo = "consultar"){//RECARREGANDO DADOS NOS INPUTS
             $id = $_GET['id'];
            
            $_SESSION['idRegistro'] = $id;
            
            $sql = "SELECT * FROM tbl_contato WHERE id =".$id;
            
            $lista = mysqli_query($con,$sql);
            
            if($rsContatos = mysqli_fetch_array($lista)){
                $id = $rsContatos['id'];
                $nome = $rsContatos['nome'];
                $email = $rsContatos['email'];
                $celular = $rsContatos['celular'];
            
                $botao = "Editar";
            }
        }
    }
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>CRUD - Agenda</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <style>
            body{
               
                font-family: sans-serif;
            }
            .img-icon{
                width: 20px;
                height: 20x;
            }
            #dados tr:hover{
                background-color: #eaffeb;
            }
        </style>
        
        <script src="js/forms.js"></script>
    </head>
    <body>
        <div class="container-fluid" style="box-shadow: 3px 3px 5px 5px gray; border-radius: 5px;">
            <nav class="navbar navbar-default" style="margin-top: 10px; padding: 5px; background-color: #1f497a;">
                <div class="container-fluid">
                    <div class="navbar-header" style="font-size: 30px;">
                        <img src="imagens/logoMdf.png" width="100" height="100">
                        <strong style="color: white;">Agenda de Contatos</strong>
                    </div>
                </div>
            </nav>
            <div class="row"><!--FORMULARIO-->
                    <div class="col-md-12">
                        <form class="form-inline" action="agenda.php" method="POST">
                            <div class="form-group">
                              <label for="nome">Nome:</label>
                              <input type="text" value="<?php echo($nome)?>" class="form-control" id="nome" name="txtNome" required maxlength="40">
                            </div>
                            <div class="form-group">
                              <label for="email">Email:</label>
                              <input type="email" value="<?php echo($email)?>" class="form-control" id="email" name="txtEmail" required maxlength="40">
                            </div>
                            <div class="form-group">
                              <label for="celular">Celular:</label>
                              <input type="cel" value="<?php echo($celular)?>" class="form-control" id="celular" name="txtCelular" required maxlength="15" onkeypress="mascaraCelular(celular)">
                            </div>
                            <input type="submit" class="btn btn-success" name="btnSalvar" value="<?php echo($botao)?>">
                            <button type="reset" class="btn btn-warning">Limpar</button>
                        </form>
                     </div>
            </div>
            <div class="row" style="margin-top:20px; margin-left:10px;margin-right:10px;"><!--Tabela-->
                <div class="table-responsive">
                    <table class="table table-striped table-hover" >
                        <thead>
                          <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Opções</th>
                          </tr>
                        </thead>
                        <?php
                            $sql = "SELECT * FROM tbl_contato ORDER BY id DESC";
                        
                            $lista = mysqli_query($con, $sql);
                        
                            while($rsContatos = mysqli_fetch_array($lista)){
                                
                        ?>
                        
                        <tbody id="dados">
                          <tr>
                            <td><?php echo($rsContatos['nome']);?></td>
                            <td><?php echo($rsContatos['email']);?></td>
                            <td><?php echo($rsContatos['celular']);?></td>
                              <td><a href="agenda.php?modo=consultar&id=<?php echo($rsContatos['id']);?>"><img src="imagens/edit.png" class="img-icon" title="Editar"></a> | 
                                  <a href="agenda.php?modo=excluir&id=<?php echo($rsContatos['id']);?>"><img src="imagens/delete.png" class="img-icon" title="Excluir"></a></td>
                          </tr>
                        </tbody>
                        <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
            
            <div class="row" >
                <div class="panel-footer" style="background-color:#1f497a;">
                    <p class="text-center" style="color:white; font-size:16px;">
                        <strong >Desenvolvido por: </strong>Gustavo dos Santos
                    </p>
                 </div>
            </div>
        </div>
    </body>
</html>
