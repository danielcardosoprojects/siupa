<?php

// Carrega a imagem

// Verifica se o ID foi passado via query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']); // Converte o ID para um inteiro


// URL da API com o ID
$apiUrl = "https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/" . $id . "?join=setor_id,tb_setor";

// Função para fazer a requisição à API
function getData($url)
{
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Obter dados do equipamento
$equipamento = getData($apiUrl);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
    <style>
        .row {
            border: solid 1px #ccc;
        }
        .legend {
          
            font-size: 1.2em;
            color: #555;
        }
        .key {
            display: inline-block;
            padding: 4px 8px;
            font-size: 1em;
            
            font-weight: bold;
            color: #333;
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
    <title>Patrimônio</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="/siiupa/administracao/patrimonio">
            <img src="/siiupa/imagens/siiupa.png" class="d-inline-block align-top" alt="" width="200px">
            Administração - Controle de Patrimônio
        </a>
    </nav>
    <p class="legend">Pressione a tecla <strong class="key">F</strong> para acessar enviar uma foto.</p>
    <div class="container mt-5">
        <div class="mt-4">
        <a href="./cadastrar" class="btn btn-success">Cadastrar</a>
            <a href="<?= $id ?>/editar" class="btn btn-primary">Editar</a>
            <a href="./" class="btn btn-primary">Concluído</a>

            <?php
            $proximo = isset($_GET['id']) ? floatval($_GET['id']) + 1 : 1;
            ?>
            <a href="./<?= $proximo ?>" class="btn btn-primary">Próximo</a>
        </div>
        <h2><?= htmlspecialchars($equipamento['id']) ?>: <?= htmlspecialchars($equipamento['nome']) ?></h2>
        <div class="row">
            <div class="col-md-4">
                
            <p><strong>Quantidade:</strong> <?= htmlspecialchars($equipamento['quantidade']) ?></p>
                <p><strong>Tipo:</strong> <?= htmlspecialchars($equipamento['tipo']) ?></p>
                <p><strong>Marca:</strong> <?= htmlspecialchars($equipamento['marca']) ?></p>
                <p><strong>Modelo:</strong> <?= htmlspecialchars($equipamento['modelo']) ?></p>
                <p><strong>Número de Série:</strong> <?= htmlspecialchars($equipamento['numero_serie']) ?></p>
                <p><strong>Setor ID:</strong> <?= htmlspecialchars($equipamento['setor_id']['setor']) ?></p>
                <p><strong>Data de Cadastro:</strong> <?= htmlspecialchars($equipamento['data_cadastro']) ?></p>
                <p><strong>Última atualização:</strong> <?= htmlspecialchars($equipamento['data_update']) ?></p>
                <p><strong>Observação:</strong> <?= htmlspecialchars($equipamento['obs']) ?></p>
            </div>


            <div class="col-md-4">
                <h4>Foto Principal:</h4><br>

                <?php if ($equipamento['foto_frente']) : ?>
                    <a href="uploads/<?= htmlspecialchars($equipamento['foto_frente']) ?>" data-fancybox data-caption="Principal">
                        <img src="imagem.php?largura=200&imagem=<?= htmlspecialchars($equipamento['foto_frente']) ?>" alt="Foto Frente" style="max-width: 300px; max-height: 300px;">
                    </a>
                <?php else : ?>
                    <p>Nenhuma foto cadastrada.</p>
                <?php endif; ?>

                <a href="/siiupa/administracao/patrimonio/<?= $id ?>/foto/principal" type="button" class="btn btn-light">Editar Foto</a>

            </div>

            <div class="col-md-4">
                <h4>Foto da Etiqueta:</h4><br>
                <?php if ($equipamento['foto_etiqueta']) : ?>
                    <a href="uploads/<?= htmlspecialchars($equipamento['foto_etiqueta']) ?>" data-fancybox data-caption="Etiqueta">
                        <img src="imagem.php?largura=200&imagem=<?= htmlspecialchars($equipamento['foto_etiqueta']) ?>" alt="Foto Etiqueta" style="max-width: 150px; max-height: 150px;">
                    </a>
                <?php else : ?>
                    <p>Nenhuma foto cadastrada.</p>
                <?php endif; ?>
                <div></div>
                <a href="/siiupa/administracao/patrimonio/<?= $id ?>/foto/etiqueta" type="button" class="btn btn-light">Editar Foto</a>
            </div>
        </div>

        <!-- Botão para Editar -->

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox]', {
            // Your custom options
        });
        document.addEventListener("keydown", function(event) {
            // Verifica se a tecla pressionada foi "f" ou "F"
            if (event.key === "f" || event.key === "F") {
                window.location.href = "/siiupa/administracao/patrimonio/<?= $id ?>/foto/principal"; // Redireciona para o link desejado
            }
        });
    </script>
</body>

</html>