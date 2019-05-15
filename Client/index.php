<?php

	include_once('rotinas.php');

	if( !empty($_POST['form_submit']) ) {

		if($_POST['botao'] == "get") {
			// GET
			$get = GET();
			$post = "";
			$put = "";
			$delete = "";
		}
		else if($_POST['botao'] == "post") {
			// POST
			$post = POST();
			$get = "";
			$put = "";
			$delete = "";
		}
		else if($_POST['botao'] == "put") {
			// PUT
			$put = PUT();
			$get = "";
			$post = "";
			$delete = "";
		}
		else if($_POST['botao'] == "delete") {
			// DELETE
			$delete = DELETE();
			$get = "";
			$post = "";
			$put = "";
		}
    }
	else {
		$get = "";
		$post = "";
		$put = "";
		$delete = "";
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/umidae_icon.ico">

    <title>API com Slim</title>

    <!-- Bootstrap core CSS -->
    <link href="bs/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="bs/themes/signin.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  </head>

  <body role="document">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Autenticação Usuario || Validação CPF</a>
        </div>
	<div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

		<form class="form" method="post" action="index.php">
	    	<input TYPE="hidden" NAME="form_submit" VALUE="OK">

			<div class="page-header">
				<h1 class="form-signin-heading">
					<div id="m_texto">Cliente Web Service (Slim)</div>
				</h1>
			</div>

			<!-- post -->
			<div class='row'>
				<div class='col-sm-3'>
					<h3>Cadastrar Usuário</h3>
					<br>
					<!-- Número de Registros -->
					<label>Nome</label>
					<input type="name" class="form-control" name="name"  maxlength="255">
					<br>
					<label>Usuário</label>
					<input type="name" class="form-control" name="usuario"  maxlength="255">
					<br>
					<label>Senha</label>
					<input type="password" class="form-control" name="password"  maxlength="255">
					<br>
					<button type="submit" name="botao" value="post" class="btn btn-success btn-block">
						<b>Confirmar|Cadastrar</b>
					</button>
					<?php
						if($post != "") {
							echo "<div class='alert alert-success' role='alert'>";
								$dadoJson = json_decode($post);
								$msg = $dadoJson->{'msg'};
			   					echo "<strong>Retorno do Web Service!</strong><br>$msg";
			 				echo "</div>";
						}
					?>
				</div>

				<!-- GET -->
				<div class='col-sm-3'>
					<h3>Autenticar Usuário</h3>
					<br>
					<!-- Dados de login -->
					<label>Usuário</label>
					<input type="text" class="form-control" name="user" maxlength="40">
					<br>
					<label>Senha</label>
					<input type="password" class="form-control" name="password" maxlength="40">
					<br>
					<button type="submit" name="botao" value="get" class="btn btn-primary btn-block">
						<b>Confirmar|Autenticar</b>
					</button>
					<?php
						if($get != "") {
							echo "<h4><b>Informação de Usuario</b></h4>";
							echo "<div class='alert alert-success' role='alert'>";
								$dadoJson = json_decode($get);

								echo "<strong>Retorno do Web Service!</strong>";

								if($dadoJson->msg != "") {
									echo "<br>$dadoJson->msg";
								}
								else {
									foreach ($dadoJson as $dado) {
				   						echo "<br>($dado->id) $dado->nome";
									}
								}

			 				echo "</div>";
						}
					?>
				</div>

				<!-- PUT -->
				<div class='col-sm-3'>
					<h3>Validar CPF</h3>
					<br>
					<!-- ID -->
					<label>CPF</label>
					<input type="number" class="form-control" name="id_put" maxlength="5">
					<br>
					<button type="submit" name="botao" value="put" class="btn btn-warning btn-block">
						<b>PUT (Alterar)</b>
					</button>
					<!-- Nome -->
					<!-- <label>Produto</label>
					<input type="text" class="form-control" name="nome_put" maxlength="40">
					<br> -->
					<?php
						if($put != "") {
							echo "<div class='alert alert-success' role='alert'>";
								$dadoJson = json_decode($put);
								$msg = $dadoJson->{'msg'};
			   					echo "<strong>Retorno do Web Service!</strong><br>$msg";
			 				echo "</div>";
						}
					?>
				</div>

				<!-- DELETE -->
				<div class='col-sm-3'>
					<button type="submit" name="botao" value="delete" class="btn btn-danger btn-block">
						<b>DELETE (Remover)</b>
					</button>
					<br>
					<!-- ID -->
					<label>ID</label>
					<input type="text" class="form-control" name="id_delete" maxlength="5">
					<br>
					<?php
						if($delete != "") {
							echo "<div class='alert alert-success' role='alert'>";
								$dadoJson = json_decode($delete);
								$msg = $dadoJson->{'msg'};
			   					echo "<strong>Retorno do Web Service!</strong><br>$msg";
			 				echo "</div>";
						}
					?>
				</div>
			</div>
		</form>

		<div class="page-header">
			<b>&copy;2018&nbsp;&nbsp;&raquo;&nbsp;&nbsp; Gil Eduardo de Andrade</b>
		</div>
    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
