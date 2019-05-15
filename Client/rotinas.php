<?php

	function getConn() {

		return new PDO('mysql:host=localhost;dbname=api_slim_web2', 'root', '',
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	function GET() {

		// DADO DE ENTRADA VAZIO - ERRO
		if(($_POST['usuario'] || $_POST['password']) == "") {
		 	return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('login' => mb_strtoupper($_POST['usuario'], 'UTF-8'),
						'senha' => mb_strtoupper($_POST['password'], 'UTF-8'));
		

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/ATV_API_Slim/rest.php/".json_encode($dados));
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		
		curl_close($curl);

		return $curl_resposta;
	}

	function POST() {

		// DADO DE ENTRADA VAZIO - ERRO
		if(($_POST['nome'] || $_POST['usuario'] || $_POST['password']) == "") {
			return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('nome' => mb_strtoupper($_POST['name'], 'UTF-8'), 
						'login' => mb_strtoupper($_POST['usuario'], 'UTF-8'),
						'senha' => mb_strtoupper($_POST['password'], 'UTF-8'));

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/ATV_API_Slim/rest.php");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}

	function PUT() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['id_put'] == "" || $_POST['nome_put'] == "") {
			return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('id' => $_POST['id_put'],
			'nome' => mb_strtoupper($_POST['nome_put'], 'UTF-8')
		);

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/exemplo_aula/rest.php");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;

	}

	function DELETE() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['id_delete'] == "") {
			return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('id' => $_POST['id_delete']);

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/exemplo_aula/rest.php");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}
?>
