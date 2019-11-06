<?php
    header("Content-type: application/json");

    include("conexao.php");

    $p= $_POST["pg"];

    $sql = "SELECT id_cadastro, cadastro.nome as nome, cidade.nome_cidade as nome_cidade, email, sexo, salario,uf FROM cadastro INNER JOIN cidade ON cadastro.cod_cidade=cidade.id_cidade INNER JOIN estado ON cidade.cod_estado=estado.id_estado";

    if(isset($_POST["nome_filtro"]))
    {
        $nome = $_POST["nome_filtro"];
        $sql .= " WHERE cadastro.nome LIKE '%$nome%'";
    }

    $sql .= " LIMIT $p, 5";
    $resultado = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
    while($linha=mysqli_fetch_assoc($resultado))
    {
        $matriz[]=$linha;
    }

    echo json_encode($matriz);




?>