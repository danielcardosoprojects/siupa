<?php

if (!isset($_SESSION['nivel'])) {
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";

	die;
} elseif ($_SESSION['nivel'] != 1) {
	echo "<div class='btn-light'><h1>Você não possui nível de autorização para esta área.</h1><br><img src='/siiupa/imagens/icones/policial.svg' width='300px'></div>";
	die;
}
?>
<script type="text/javascript" src="/siiupa/js/script.js"></script>
<script>
	$(function() {


		$("#beditarFUNCIONARIO").click(function() {
			alert();
			$('#subconteudo').load($(this).attr('href'));
			sessionStorage.setItem('linkanterior', $(this).attr('href'));

		});


	});
</script>
<div id="topo" class="notprint">
	
	<div class="second-navbar">
		<h2 style="  font-family: 'Oswald', sans-serif; color:#fff;">SETOR ADMINISTRATIVO</h2>
		<a id="abrerh" href="?setor=adm&sub=rh" class="nav-link">Recursos Humanos</a>
		<a id="abrerh" href="/siiupa/administracao/patrimonio" class="nav-link">Patrimônio</a>
		<a id="abrerh" href="?setor=adm&sub=producao" class="nav-link">Produção e Estatística</a>
		<a id="abreadministracao" href="administracao/paginaadministracao.php" class="nav-link">Administração</a>
		<a id="abreimpressos" href="/siiupa/impressos/index.php" target='_blank' class="nav-link">Impressos</a>
		<a href="/siiupa/enviararquivo.php" class="nav-link">Arquivos</a>
	</div>
	<div id="notification-icon"><img src="/siiupa/imagens/icones/bell.svg" width="24px;">
		<span id="notification-count"></span>
		<i class="fa fa-bell"></i>
		<div id="notification-popup">
			<ul id="notification-list"></ul>
		</div>
	</div>

	<style>
		.second-navbar {
			display: flex;
			align-items: center;
			
			color:#000;
			/* Light background */
			padding: 0;
			border-top: 1px solid #e2e6ea;
			width: 80%;
			/* Subtle top border for separation */
		}

		.second-navbar .navbar-brand,
		.second-navbar .nav-link {
			color: #fff;
			/* Primary color for text */
			margin-right: 15px;
			/* Space between links */
			text-decoration: none;
			/* Remove underline from links */
			font-weight: 500;
			/* Slightly bold text */
			padding: 5px 5px;
			/* Consistent padding */
			border-radius: 4px;
			/* Slightly rounded corners */
		}

		.second-navbar .nav-link:hover {
			background-color: #e2e6ea;
			/* Light grey background on hover */
			color: #0056b3;
			/* Darker text on hover */
		}

		.second-navbar .navbar-brand {
			font-size: 18px;
			/* Slightly larger font for brand */
		}
		.subconteudo {
			background-color: #888;
		}
	</style>

</div>
<div id="subconteudo">

	<?php
	if (isset($_GET['sub'])) {
		$sub = $_GET['sub'];
		if ($sub == "rh") {
			include("paginarh.php");
		} elseif ($sub == "rhperfil") {
			include("paginarh_perfil.php");
		} elseif ($sub == "rh_perfil") {
			include("paginarh_perfil2.php");
		} elseif ($sub == "rhferias") {
			include("paginarh_ferias.php");
		} elseif ($sub == "rhfolhas") {
			include("pagina_rh_folhas.php");
		} elseif ($sub == "rhfolhasmodifica") {
			include("paginarh_folhas_criareditar.php");
		} elseif ($sub == "rhfolhaexibe") {
			include("pagina_rh_folha.php");
		} elseif ($sub == "rhfolhaadicionaservidor") {
			include("pagina_rh_folha_adicionaservidor.php");
		} elseif ($sub == "producao") {
			include("pagina_producao.php");
		} elseif ($sub == "rhescalas") {
			include("pagina_escalas.php");
		} elseif ($sub == "rhescala_exibe") {
			include("pagina_escala_exibe.php");
		} elseif ($sub == "rhalimentacao") {
			include("pagina_rh_alimentacao.php");
		} elseif ($sub == "niveis") {
			include("painel/niveis.php");
		}
	} else {
	?>
		<div class="row">
			<div class="col-sm-6">
				<div class="card" style="width: 18rem;">
					<img src="imagens/rhicones.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Recursos Humanos</h5>
						<a href="?setor=adm&sub=rh" class="btn btn-primary abrerh">Abrir</a>
					</div>
				</div>


			</div>
			<div class="col-sm-6">
				<div class="card float-right" style="width: 18rem;">
					<img src="imagens/graphs.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Produção e Estatística</h5>
						<a href="?setor=adm&sub=producao" class="btn btn-primary abrerh">Abrir</a>
					</div>
				</div>
			</div>
		</div>
	<?php

	}

	?>

</div>

<style>
	#topo {
		display: flex;
		gap: 10px;
		background-color: #4e009b; /*rgba(85, 85, 85, 0.8)*/;
		color: #ffffff;
		
	}

	#notification-icon {
		position: relative;
		cursor: pointer;
		float: left;
		margin-right: 30px;
		margin-top: 5px;


	}

	#notification-count {
		position: absolute;
		left: 10;

		background: red;
		color: white;
		padding: 3px 7px;
		border-radius: 50%;
		font-size: 12px;
		font-weight: bold;
		display: none;
	}

	#notification-popup {
		position: absolute;
		font-family: 'Open Sans', sans-serif;
		font-size: 16px;
		margin-top: 20px;
		width: 400px;
		background: white;
		border: 1px solid gray;
		padding: 10px;
		display: none;
		z-index: 999;
		text-align: left;
		box-shadow: 5px 5px 5px #888;
		border-radius: 10px;
	}

	#notification-list {
		list-style: none;
		margin: 0;
		padding: 0;
		color:#000;
	}
</style>
<script>
	var notificationCount = 0;

	// Exemplo de notificações
	var notifications = [
		// { id: 1, message: "<a href='#'>Notificação 1</a>" },
		// { id: 2, message: "Notificação 2" },
		// { id: 3, message: "Notificação 3" }
	];

	var today = new Date();
	var dayOfWeek = today.getDay();


	if (dayOfWeek === 1 || dayOfWeek === 3 || dayOfWeek === 5) {
		// Executar função aqui
		addNotification('Fazer pedido para White Martins');
	}
	if (dayOfWeek === 1) {
		// Executar função aqui
		addNotification('Fazer pedido para Almoxarifado');
	}

	async function consultBirth() {
		// URL da API
		const url = '/siiupa/bd/jsons/consultaaniversario.php';

		// Fazer a requisição HTTP
		const response = await fetch(url);

		// Converter o retorno para JSON
		const data = await response.json();


		// Mapear o retorno
		data.map(item => {

			addNotification(`Aniversário: ${item.nome} - ${item.data_nasc}`);

		});


	}
	consultBirth();

	// Função para
	function addNotification(message) {
		notificationCount++;
		var notificationId = (new Date()).getTime();
		notifications.push({
			id: notificationId,
			message: message
		});
		updateNotificationCount();
		updateNotificationList();
	}

	// Função para atualizar o contador de notificações
	function updateNotificationCount() {
		$("#notification-count").text(notificationCount);
		if (notificationCount > 0) {
			$("#notification-count").show();
		} else {
			$("#notification-count").hide();
		}
	}

	// Função para atualizar a lista de notificações
	function updateNotificationList() {
		$("#notification-list").empty();
		for (var i = 0; i < notifications.length; i++) {
			var notification = notifications[i];
			$("#notification-list").append("<li>" + notification.message + "</li>");
		}
	}

	// Evento de clique para abrir/fechar a janela de notificações
	$("#notification-icon").click(function() {
		$("#notification-popup").toggle();
	});
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">