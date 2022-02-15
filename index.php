<?php

    require_once("config.php");
/*
    $sql = new Sql();
    $usuarios = $sql->select("SELECT * FROM tb_usuarios");

    echo json_encode($usuarios);
*/

    //Busca um usuário específico por id
    $user = new Usuario();

    $user->loadById(1);
    echo $user;

    echo "<hr>";
  
    //Traz toda a lista de usuários da tabela
    //Utilizando método de objeto instanciado da classe Usuario
    //public function getList() 

    $listUser = new Usuario();
    $lista = $listUser->getList();

    echo json_encode($lista);

    echo "<hr>";

    //Traz uma lista de usuários respeitando o valor informado na busca pelo login
    //Utilizando método estático
    //public static function searchLogin($login) 
    $search = "se";
    $searchUser = Usuario::searchLogin($search);

    echo json_encode($searchUser);

    echo "<hr>";

    //Carrega um usuário usando o login e senha
    $dadosLogin = new Usuario();
    $dadosLogin->login("wallace","987654");
    echo $dadosLogin;

    echo "<hr>";

    $aluno = new Usuario("joão","j040");
    $aluno->insert();

    echo $aluno;

    echo "<hr>";

    $usuario = new Usuario();
    $usuario->loadById(13);
    $usuario->update("joão13", "j040");

    echo $usuario;
?>