<?php

	require 'Slim/Slim.php';
	require 'Verifica_CPF.php';
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
	// $app->get('/logar/:dados', function($dados) {
	// 	$dadoJson = json_decode( $dados );
	// 	$conn = getConn();
	// 	$sql = "SELECT * FROM usuario WHERE login = :login AND senha = :senha";
	// 	$stmt = $conn->prepare($sql);
	// 	$stmt->bindParam("login", $dadoJson->usuario);
	// 	$stmt->bindParam("senha", $dadoJson->senha);
	// 	$stmt->execute();
	// 	echo json_encode($stmt->fetchAll());
	// });

	// GET - Selecionar
	$app->get('/user/:login/:senha', function($login, $senha) {
		$conn = getConn();
		$sql = "SELECT * FROM usuario WHERE login = :login AND senha = :senha";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("login", $login);
		$stmt->bindParam("senha", $senha);
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

		echo json_encode( array('msg' => "[OK 4] Cadastrado efetuado com Sucesso!") );
	});

	// PUT - Alterar
	$app->put('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );
		if(validaCpf($dadoJson->cpf)) {
			echo json_encode( array('msg' => "[OK] ($dadoJson->cpf) CPF Válido!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] ($dadoJson->cpf) CPF Inválido!") );
		}
	});
	
	$app->run();
?>
