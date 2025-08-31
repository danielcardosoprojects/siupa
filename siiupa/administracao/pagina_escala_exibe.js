$(function () {

    //exibe os checkbox de exclusao


    $("#blocodenotas").click((e) => {
        e.preventDefault();
        // $("#dialogAnota").dialog();
        // $("#dialogAnota").dialog({
        //     appendTo: "window"
        // });
        // $(".ui-dialog").css({
        //     'position': 'fixed',
        //     'top': '10px',
        //     'right': '0',    
        //     'z-index': '999'
        // });
        document.getElementById('bloco-de-notas').style.display = 'block';
    });


    $(".bt_oficial").click(function (e) {
        e.preventDefault();
        valor = $(this).data('oficial');
        idescala = $(this).data('idescala');
        mes = $(this).data('mes');
        ano = $(this).data('ano');
        linknovo = "?setor=adm&sub=rhescala_exibe&id=" + idescala + "&oficial=" + valor + "&mes=" + mes + "&ano=" + ano;
        if (valor == "sim") {
            bt_sucess = "btn btn-success";
            bt_sucess_out = "btn btn-outline-success";
            bt_rascunho_out = "btn btn-outline-warning";
            bt_rascunho = "btn btn-warning";
            $("#bt_esc_oficial").removeClass(bt_sucess_out);
            $("#bt_esc_oficial").addClass(bt_sucess);
            $("#bt_esc_rascunho").removeClass(bt_rascunho);
            $("#bt_esc_rascunho").addClass(bt_rascunho_out);
            $('#done-rascunho').hide();
            $("#done-oficial").removeClass("d-none");
            $('#done-oficial').show();

        } else {
            bt_sucess = "btn btn-success";
            bt_sucess_out = "btn btn-outline-success";
            bt_rascunho_out = "btn btn-outline-warning";
            bt_rascunho = "btn btn-warning";
            $("#bt_esc_rascunho").removeClass(bt_rascunho_out);
            $("#bt_esc_rascunho").addClass(bt_rascunho);
            $("#bt_esc_oficial").removeClass(bt_sucess);
            $("#bt_esc_oficial").addClass(bt_sucess_out);
            $('#done-rascunho').show();
            $('#done-oficial').hide();
        }
        var escala_oficial = 'administracao/escalas/atualiza_oficial.php?idescala=' + idescala + '&valor=' + valor;
        $("#load_status_escala").removeClass("d-none");
        $.get(escala_oficial, function (data) {

            window.history.pushState(null, 'hi', linknovo);
            window.location.reload();

            $("#load_status_escala").addClass("d-none");
        });
    });


    $("#dialogadd").dialog({
        autoOpen: false,
        height: 500,
        width: 600
    });
    $('#addservidor').click(function () {
        $("#dialogadd").dialog("open");

    });

    $("#btaddservidor").click(function (e) {
        e.preventDefault();
        $('#form-busca-servidores').submit();
        $("#btAddTodos2").removeClass("d-none");
    });

    $('#form-busca-servidores').submit(function (event) {


        event.preventDefault();

        var buscar = encodeURI($('#buscar').val());
        var busca_servidor_setor = $('#busca_servidor_setor').val();
        var acao = "buscar";
        var urlbusca = "https://siupa.com.br/siiupa/administracao/escalas/buscarservidor.php?acao=busca&nome=" + buscar + "&setor=" + busca_servidor_setor;
        console.log(urlbusca);

        $('#dialogaddresultadobusca').load(urlbusca,
            function () {
                $(".escolhido").click(function (e) {
                    e.preventDefault();
                    var urlescala = (location.search);


                    var inserirlink = "administracao/escalas/buscarservidor.php" + urlescala + "&acao=insere&idservidor=" + $(this).data('idescolhido');

                    $('#dialogaddresultadobusca').load(inserirlink, function () {
                        var urlescala = (location.search);
                        var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;

                        $('#subconteudo').load(recarregaescala);

                    });



                });

                $('#btAddTodos2').off('click').click(function (e) {
                    e.preventDefault();

                   
                    buscaTodos = $(".escolhido");
                   

                 
                    let idEscala = $(".bt_oficial").data("idescala");
                    let anoEscala = $(".bt_oficial").data("ano");
                    let mesEscala = $(".bt_oficial").data("mes");
                    let todosJson = [];
                    
                    $(buscaTodos).each(function () {
                        nomeBT = $(this).data('nome');
                        idEscolhidoBT = $(this).data('idescolhido');

                        todosJson.push({ fk_escala: idEscala, fk_funcionario: idEscolhidoBT, mes: mesEscala, ano: anoEscala });


                    });


                  
                    // URL da API
                    let url = "https://www.siupa.com.br/siiupa/api/api.php/records/tb_escala_funcionario";

                    // Enviar o JSON via POST
                    
                  

                    $.ajax({
                        url: url,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(todosJson),
                        success: function (response) {
                            var urlescala = (location.search);
                            var recarregaescala = 'administracao/pagina_escala_exibe.php' + urlescala;
    
                            $('#subconteudo').load(recarregaescala);
                            $("#dialogaddresultadobusca").html('Adicionado todos!');
                        },
                        error: function (xhr, status, error) {
                            console.error("Erro:", error);
                        }
                    });


                });


            });
    });

    //DIALOGO QUE CONFIGURA OU EDITA OS SERVIDORES- CHAMADO DE CONFIG
    $("#dialogconfig").dialog({
        autoOpen: false,
        height: "auto",
        width: 500
    });

    $('.link-oculto').click(function (e) {
        e.preventDefault();

    });
    $('.editafuncionario').dblclick(function () {
        var edita = $(this);

        function centralizaDialog(idDialog) {
            appendTo: "body",
                $(idDialog).dialog({
                    position: {
                        my: "center",
                        at: "center",
                        of: window
                    }
                });
        }

        dialogConfig = $("#dialogconfig");
        var linkedita = 'administracao/escalas/editaservidor.php?idef=' + edita.data('idef') + '&idf=' + edita.data('idf') + '&nomeservidor=' + encodeURI(edita.data('nomeservidor')) + '&posicao=' + edita.data('posicao');
        $.get(linkedita, function (data) {
            dialogConfig.html(data), centralizaDialog("#dialogconfig");
        }).done(centralizaDialog("#dialogconfig"));
        //$("#dialogcfgresult").load(linkedita);
        $("#dialogconfig").dialog("open");



    });


});
