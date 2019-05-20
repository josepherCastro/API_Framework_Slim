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
	$app->get('/:dados', function($dados) {
		
		$dadoJson = json_decode( $dados );
		$user = $dadoJson->nome;
		$password = $dadoJson->senha;

		print_r("$dadoJson");
		$conn = getConn();
		$sql = "SELECT * FROM usuario WHERE login = ':login' AND senha = ':senha' LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("usuario", $user);
		$stmt->bindParam("senha", $password);
		$stmt->execute();
		$dadoJson = $stmt->fetchAll();
		
		if(empty($dadoJson)){
			echo json_encode(array('msg' => "[ERRO] Usuário ou Senha incorretos!"));
		}
		else {
			echo json_encode(array('msg' => "[OK] Usuário ($user) Logado!"));
		}

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
		if(validaCpf($dadoJson->cpf)) {
			echo json_encode( array('msg' => "[OK] ($dadoJson->cpf) CPF Válido!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] ($dadoJson->cpf) CPF Inválido!") );
		}
	});

	$app->run();
?>
