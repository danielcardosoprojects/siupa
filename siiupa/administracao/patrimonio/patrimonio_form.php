<?php
session_start();
include('../../../conexao/verifica_login.php');
// Verifica se a variável 'minhaChave' está definida na sessão
if (isset($_SESSION['token'])) {
    // Pega o valor armazenado na sessão
    $valor = $_SESSION['token'];
    // echo "Valor armazenado: " . $valor;
} else {
    echo "Nenhum valor encontrado na sessão.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Patrimônio</title>
    <!-- Incluindo CSS do Bootstrap e jQuery UI para autocomplete -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link href="/siiupa/administracao/patrimonio/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    .clickable {
        cursor: pointer;
    }

    .clickable:hover {
        background-color: #f0f0f0;
    }
</style>

<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="/siiupa/administracao/patrimonio">
            <img src="/siiupa/imagens/siiupa.png" class="d-inline-block align-top" alt="" width="200px">
            Administração - Controle de Patrimônio
        </a>
    </nav>
    <div class="container mt-4">

        <button type="button" class="btn btn-primary" id="repetirUltimo">Carregar último</button>
        <br><br>
        <form id="itemForm">
            <input type="hidden" value="<?= $_GET['acao']; ?>" id="acao">
            <!-- Campo Setor -->
            <div class="mb-3">
                <label for="setor" class="form-label setorSetor">Setor</label>
                <select class="form-select js-example-responsive" style="width: 50%" id="setor" required>
                    <option value="">Selecione um setor</option>
                </select>
            </div>

            <!-- Campo Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" required list="suggestionsNome">
                <datalist id="suggestionsNome"></datalist>
            </div>

            <!-- Campo Tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" required>
                    <option value="Equipamento">Equipamento</option>
                    <option value="Móvel">Móvel</option>
                    <option value="Material">Material</option>
                </select>
                <a id="completaVazio" href="#salvar">Vazio</a>
            </div>

            <!--- Campo quantidade -->
            
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" required="" min="0">
                
            </div>

            <!-- Campo Marca -->
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" required list="suggestionsMarca">
                <datalist id="suggestionsMarca"></datalist>
            </div>

            <!-- Campo Modelo -->
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" required list="suggestionsModelo">
                <datalist id="suggestionsModelo"></datalist>
            </div>

            <!-- Campo Número de Série -->
            <div class="mb-3">
                <label for="numeroSerie" class="form-label">Número de Série</label>
                <input type="text" class="form-control" id="numeroSerie" required list="suggestionsNumeroSerie">
                <datalist id="suggestionsNumeroSerie"></datalist>
            </div>
            <!-- Campo Observação -->

            <div class="mb-3">
                <label for="obs" class="form-label">Observação</label>
                <textarea class="form-control" id="obs" rows="3"></textarea>
            </div>


            <input type="hidden" id="itemId" value="<?= $_GET['id']; ?>">
            <button type="submit" class="btn btn-primary" id="salvar">Salvar</button>
        </form>
    </div>

    <!-- Incluindo JS do jQuery, Bootstrap, jQuery UI e Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            const selectSetor = document.getElementById('setor');
            $('#setor').select2();

            $('#completaVazio').click((e)=>{
                document.getElementById('numeroSerie').value = 'sn';
            })

        });
        // Função para carregar os setores da API
        function carregarSetores() {
            axios.get('https://www.siupa.com.br/siiupa/api/api.php/records/tb_setor?order=setor,asc')
                .then(function(response) {
                    const setores = response.data.records;
                    const selectSetor = document.getElementById('setor');
                    setores.forEach(function(setor) {
                        const option = document.createElement('option');
                        option.value = setor.id;
                        option.text = setor.setor;
                        selectSetor.appendChild(option);
                    });

                    // Verifica se a chave "setor" existe no localStorage
                    const setorLocalStorage = localStorage.getItem('setor');

                    // Se a chave existir, encontra o elemento com o id "setor" e atribui o valor
                    if (setorLocalStorage) {
                        const elementoSetor = document.getElementById('setor');
                        if (elementoSetor) {
                            elementoSetor.value = setorLocalStorage;
                            $('#setor').val(setorLocalStorage).trigger('change');

                        } else {
                            console.error('Elemento com id "setor" não encontrado.');
                        }
                    } else {
                        console.log('Chave "setor" não encontrada no localStorage.');
                    }
                })
                .catch(function(error) {
                    console.log('Erro ao carregar setores:', error);
                });
        }

        // Carregar sugestões para Nome, Marca, Modelo e Número de Série
        function carregarSugestoes(campo, endpoint, datalistId) {
            axios.get(endpoint)
                .then(function(response) {
                    const suggestions = response.data.records;
                    const datalist = document.getElementById(datalistId);
                    suggestions.forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item[campo];
                        datalist.appendChild(option);
                    });


                })
                .catch(function(error) {
                    console.log(`Erro ao carregar sugestões para ${campo}:`, error);
                });
        }

        // Função para carregar dados do item ao editar
        function carregarItem(itemId) {
            axios.get(`https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/${itemId}?join=setor_id,tb_setor`)
                .then(function(response) {
                    const item = response.data;


                    document.getElementById('nome').value = item.nome;
                    document.getElementById('marca').value = item.marca;
                    document.getElementById('modelo').value = item.modelo;
                    document.getElementById('numeroSerie').value = item.numero_serie;
                    document.getElementById('tipo').value = item.tipo;
                    document.getElementById('quantidade').value = item.quantidade;
                    document.getElementById('setor').value = item.setor_id.id;
                    setTimeout(function() {
                        $('#setor').val(item.setor_id.id).trigger('change');
                    }, 1500); // 3000 milissegundos = 3 segundos


                    document.getElementById('itemId').value = itemId; // Armazena o ID do item para atualizações
                    document.getElementById('obs').value = item.obs; // Armazena a observação do item para atualizações
                })
                .catch(function(error) {
                    console.log('Erro ao carregar item:', error);
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            // carregarSetores();

            // Obter o ID do item da URL
            const urlParams = new URLSearchParams(window.location.search);
            const itemId = urlParams.get('id');

            if (itemId) {
                carregarItem(itemId); // Carregar dados do item se o ID estiver presente
            }

            // Carregar sugestões de nome, marca, modelo, número de série
            carregarSugestoes('nome', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsNome');
            carregarSugestoes('marca', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsMarca');
            carregarSugestoes('modelo', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsModelo');
            carregarSugestoes('numeroSerie', 'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos', 'suggestionsNumeroSerie');
        });

        // Submissão do formulário
        document.getElementById('itemForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const acao = document.getElementById('acao').value;

            function cadastra() {
                const nome = document.getElementById('nome').value;
                const marca = document.getElementById('marca').value;
                const modelo = document.getElementById('modelo').value;
                const numero_serie = document.getElementById('numeroSerie').value;
                const tipo = document.getElementById('tipo').value;
                const quantidade = document.getElementById('quantidade').value;
                const setor = document.getElementById('setor').value;
                const itemId = document.getElementById('itemId').value;
                const obs = document.getElementById('obs').value;

                if (!nome || !marca || !modelo || !numero_serie || !tipo || !quantidade || !setor) {
                    alert('Preencha todos os campos.');
                    return;
                }

                // Atualização ou adição de novo item
                const url = itemId != 0 ?
                    `https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos/${itemId}` :
                    'https://www.siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos';
                const metodo = itemId != 0 ? 'put' : 'post';

                axios({
                        method: metodo,
                        url: url,
                        data: {
                            nome: nome,
                            marca: marca,
                            modelo: modelo,
                            numero_serie: numero_serie,
                            tipo: tipo,
                            quantidade: quantidade,
                            setor_id: setor,
                            obs: obs
                        }
                    })
                    .then(function(response) {
                        let idUrl;
                        let mensagem;
                        if (metodo == "post") {
                            idUrl = response.data;
                            mensagem = "Cadastrado com sucesso!";
                        } else {
                            idUrl = itemId;
                            mensagem = "Editado com sucesso!";
                        }
                        Swal.fire({
                            icon: "success",
                            title: mensagem,
                            showConfirmButton: false,
                            timer: 1500
                        });


                        setTimeout(function() {

                            window.location.href = `/siiupa/administracao/patrimonio/${idUrl}`;
                        }, 1600); // 3000 milissegundos = 3 segundos
                    })
                    .catch(function(error) {
                        console.log('Erro ao salvar:', error);
                    });
            }

            function edita() {
                console.log('edita');
            }

            if (acao == "cadastrar") {
                
                cadastra();

            } else {
                cadastra();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Chama a API para obter os setores
            axios.get('https://www.siupa.com.br/siiupa/api/api.php/records/tb_setor?order=setor,asc')
                .then(function(response) {
                    const setores = response.data.records;
                    const setorSelect = document.getElementById('setor');

                    // Popula o select de setor com os dados da API
                    setores.forEach(function(setor) {
                        const option = document.createElement('option');
                        option.value = setor.id;

                        option.textContent = setor.setor;
                        setorSelect.appendChild(option);
                    });

                })
                .catch(function(error) {
                    console.error("Erro ao carregar os setores:", error);
                });

            ////////// se for edição vai carregar os dados 

            const acao = document.getElementById('acao').value;
            const itemId = document.getElementById('itemId').value;

            if (acao == "editar") {
                carregarItem(itemId);
            }

            //////////////// CARREFGAR ULTIMO NO FOMRULARIO



            function carregaUltimo() {
                const ultimoUrl = 'https://siupa.com.br/siiupa/api/api.php/records/tb_equipamentos_equipamentos?order=id,desc&page=1,1';
                axios.get(ultimoUrl)
                    .then(response => {
                        // La richiesta è andata a buon fine
                        const data = response.data;

                        // Estrai i dati specifici che ti interessano
                        const equipamentos = data.records;
                        equipamentos.forEach(equipamento => {
                            console.log(equipamento);

                            let setor = document.getElementById('setor');
                            let nome = document.getElementById('nome');
                            let tipo = document.getElementById('tipo');
                            let quantidade = document.getElementById("quantidade");
                            let marca = document.getElementById('marca');
                            let modelo = document.getElementById('modelo');
                            let obs = document.getElementById('obs');

                            setor.value = equipamento.setor_id;
                            $("#setor").val(equipamento.setor_id).trigger('change');
                            nome.value = equipamento.nome;
                            tipo.value = equipamento.tipo;
                            quantidade.value = equipamento.quantidade;
                            marca.value = equipamento.marca;
                            modelo.value = equipamento.modelo;
                            obs.value = equipamento.obs;
                        });
                    })
                    .catch(error => {
                        // Si è verificato un errore
                        console.error('Errore durante la richiesta:', error);
                    });
            }
            // Seleciona o elemento com o ID "repetirUltimo"
            const botaoRepetir = document.getElementById('repetirUltimo');

            // Adiciona um event listener para o evento de clique
            botaoRepetir.addEventListener('click', function() {
                // Código a ser executado quando o botão for clicado

                carregaUltimo();
            });
        });
    </script>
</body>

</html>