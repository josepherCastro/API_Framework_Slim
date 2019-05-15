<?php

	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	// CONEXÃO COM O BD
	function getConn() {
		return new PDO('mysql:host=localhost;dbname=api_slim_web2', 'root', '',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	// TESTAR WEBSERVICE
	$app->get('/', function() {
		echo "<h1>Web Service: GET / POST / PUT / DELETE!</h1>";
	});

	// GET - Selecionar
	$app->get('/:dados', function($dados) {

		$dadoJson = json_decode( $dados );
		// print_r($dadoJson);
		$conn = getConn();
		$sql = "SELECT nome FROM usuario where (login = :login) and (senha = :senha)";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		echo json_encode($stmt->fetchAll());
	});

	// POST - Inserir
	$app->post('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$sql = "INSERT INTO usuario (nome, login, senha) values(:nome,:login,:senha)";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("nome", $dadoJson->nome);
		$stmt->bindParam("login", $dadoJson->login);
		$stmt->bindParam("senha", $dadoJson->senha);
		$stmt->execute();
		$id = $conn->lastInsertId();

		echo json_encode( array('msg' => "[OK] Produto ($id) Cadastro com Sucesso!") );
	});

	// PUT - Alterar
	$app->put('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$sql = "UPDATE tb_produto SET nome=:nome WHERE id=:id";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("nome", $dadoJson->nome);
		$stmt->bindParam("id", $dadoJson->id);

		if($stmt->execute()) {
			echo json_encode( array('msg' => "[OK] Produto ($dadoJson->id) Alterado com Sucesso!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] Não foi possível Alterar o Produto ($dadoJson->id)!") );
		}
	});

	// DELETE - Remover
	$app->delete('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$sql = "DELETE FROM tb_produto WHERE id=:id";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("id", $dadoJson->id);

		if($stmt->execute()) {
			echo json_encode( array('msg' => "[OK] Produto ($dadoJson->id) Removido com Sucesso!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] Não foi possível Remover o Produto ($dadoJson->id)!") );
		}
	});

	$app->run();
?>
