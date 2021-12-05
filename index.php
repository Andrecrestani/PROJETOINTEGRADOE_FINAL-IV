<?php

require_once'classe-cadastrocompraingresso.php';
$p = new pessoa("crudpdo","localhost","root","");


?>




<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>SEU INGRESSO AGORA</title>
</head>
<body>
    <?php
        if(ISSET($_POST['nome']))
        {
            if(isset($_GET['id_up']) && !empty ($_GET['id_up']) )

            //---------------------botao editar------------------------------------

            {
                $id_upd = addslashes ($_GET['id_up']);
                $nome = addslashes ($_POST['nome']);
                $telefone = addslashes ($_POST['telefone']);
                $email = addslashes ($_POST['email']);
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {
                   $p->atualizarDados($id_upd, $nome,$telefone,$email);
                   header("location: index.php");
                       
                   
                }else{

                    ?>
                        <h4 class="aviso">preencha todos os campos</h4>
                    <?php
                }


            }else
            
            //----------------------botão cadastrar-----------------------------------
            {
                $nome = addslashes ($_POST['nome']);
                $telefone = addslashes ($_POST['telefone']);
                $email = addslashes ($_POST['email']);
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {
                   if( !$p->cadastrarPessoa($nome,$telefone,$email)){

                    ?>
                    <h4 class="aviso">Email já está cadastrado</h4>
                    <?php
                       
                   }
                }else{

                    ?>
                    <h4 class="aviso">preencha todos os campos</h4>
                    <?php
                    
                }

            }

        }
        
    ?>
    <?php
        if(isset($_GET ['id_up'])){
            $id_update =  addslashes($_GET['id_up']);
            $res =  $p->buscarDadosPessoa($id_update);
            

        }
    
    ?>
    <div id="tela">
    <section id="esquerda">
        <form action="" method="POST">
            <h2>CADASTRO DE CLIENTES</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" 
            value="<?php if(isset($res)){echo $res['nome'];} ?>"
            >
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" 
            value="<?php if(isset($res)){echo $res['telefone'];} ?>"
            >
            <label for="email">Email</label>
            <input type="text" name="email" id="email" 
            value="<?php if(isset($res)){echo $res['email'];} ?>"
            >
            <input type="submit" 
            value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?>"
            >
        </form>
    </section>
    <section  id="direita" >
    <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">Email</td>
            </tr>
        <?php
        
        $dados = $p->buscarDados();
        if(count($dados) > 0)
        {
            for($i=0; $i < count($dados);$i++){
                echo"<tr>";
                foreach($dados[$i] as $k =>$v){

                    if($k != "id"){
                        echo "<td>".$v."</td>";
                    } 
                }
             ?>
                <td><a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                <a href=" index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a></td>
             <?php
                echo"</tr>";
            }
            ?>
                
            <?php
        }
        else{

            
            
     ?>       
        </table>

        ?>
        <h4 class="aviso">ainda não há pessoas cadastradas !</h4>
        <?php


    }
        
        
    ?> 
    </section>
    </div>
</body>
</html>
<?php

        if(isset($_GET['id'])){

            $id_pessoa =  addslashes($_GET['id']);
            $p->excluirPessoa($id_pessoa);
            header("location:index.php");

        }



?>