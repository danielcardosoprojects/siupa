<?php
@include_once('../bd/conectabd.php');
@include('../config/data.php');

include_once('tabelas.php');
?>

<style type="text/css">
    .oficial {
        background-color: green;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #fff;
        cursor: default;
        border-color: #0d6efd;
    }

    .rascunho {
        background-color: #ffc133;
        padding: .2rem .3rem;
        font-size: .7rem;
        border-radius: .2rem;
        color: #ff6433;
        cursor: default;
        border-color: #0d6efd;
    }
</style>

<script>
    $(function() {
        $("#accordionescalas").accordion({
            collapsible: true
        });


        $("#accordionescalas").accordion({
            collapsible: true
        });
        $('#btcriarescala').click(function() {

            $.confirm({
                title: 'Criar escalas',
                content: 'url:administracao/escalas/listasetor.php?acao=criar',
                columnClass: 'medium',
                buttons: {
                    formSubmit: {
                        text: 'Criar',
                        btnClass: 'btn-blue',
                        action: function() {
                            var setor = this.$content.find('.setor').val();
                            var mes = this.$content.find('.mes').val();
                            var ano = this.$content.find('.ano').val();
                            if (!ano) {
                                $.alert('Digite um ano' + ano);
                                return false;
                            }
                            var criaescala = 'administracao/escalas/listasetor.php?acao=cria' + '&setor=' + setor + '&mes=' + mes + '&ano=' + ano;
                            $.get(criaescala, function(data) {
                                alert(data);
                                location.reload();
                            });

                        }
                    },
                    cancel: function() {
                        //close
                    },
                }
            });
        });
    });
</script>
<h1>Gerenciar Escalas</h1>




<a class="btn btn-success" id="btcriarescala">
    <img src="imagens/icones/add_circle_outline.svg">
    Criar Escala
</a>


<CAPTION>ESCALAS POR MÊS</CAPTION>

<div id="contentEscalas">

    <?php



    if (isset($_GET['subsub'])) {
        switch ($_GET['subsub']) {
            case "criarescala":
                include('pagina_escala_criar.php');
        }
    }
    echo "<div id='accordionescalas'>";





    $sql = "SELECT
    t1.*
FROM
    u940659928_siupa.tb_escalas AS t1
INNER JOIN (
    SELECT
        ano,
        mes,
        MAX(id) AS max_id
    FROM
        u940659928_siupa.tb_escalas
    GROUP BY
        ano,
        mes
) AS t2 ON t1.ano = t2.ano AND t1.mes = t2.mes AND t1.id = t2.max_id
ORDER BY
    t1.ano DESC,
    t1.mes DESC";
    $busca = new BD;
    $resultado = $busca->consulta($sql);
    $mesext = new Data;
    $i = -1;
    foreach ($resultado as $escalas) {

        $mesextenso = $mesext->mes($escalas->mes);
        $i = $i + 1;
        $colapseAtual = $escalas->mes . $escalas->ano;
        if (date("nY") == $colapseAtual) {
            $colapsaAtual = $i;
        }

        $mesParaFrequencias = "";
        if ($escalas->mes > 10) {
            $mesParaFrequencias = $escalas->mes;
        } else {
            $mesParaFrequencias = "0" . $escalas->mes;
        }

        echo "   
        <h3 class='colapsa$escalas->mes'>$mesextenso - $escalas->ano</h3>
        <div>
        <a target='_blank' href='/siiupa/administracao/pagina_escala_esqueleto_varias_seleciona.php?mes=$escalas->mes&ano=$escalas->ano'>Selecionar para impressão</a>
          <p>";

        $sqlmes =  "SELECT s.setor, e.* FROM u940659928_siupa.tb_escalas AS e INNER JOIN u940659928_siupa.tb_setor as s ON(e.fk_setor = s.id) WHERE e.mes=$escalas->mes AND e.ano=$escalas->ano ORDER BY s.setor ASC";
        $buscames = new BD;
        $resultadomes = $buscames->consulta($sqlmes);

        foreach ($resultadomes as $escalasmes) {
            if ($escalasmes->oficial == "sim") {
                $tipo_escala = "<span class='oficial'>OFICIAL</span>";
            } else {
                $tipo_escala = "<span class='rascunho'>RASCUNHO</span>";
            }

            echo "$tipo_escala <strong><a href='?setor=adm&sub=rhescala_exibe&id=$escalasmes->id&mes=$escalasmes->mes&ano=$escalasmes->ano&oficial=$escalasmes->oficial'>$escalasmes->setor</a>
            <a title='Imprimir esta escala' class='' href='administracao/pagina_escala_esqueleto.php?id=$escalasmes->id&setorExt=$escalasmes->setor&mesExt=$mesextenso&anoExt=$escalasmes->ano' target='_blank'>
            <img src='imagens/icones/impressora.svg' width='15px'></a>
            <a title='Gerar rascunho para folha' class='' href='administracao/pagina_escala_esqueletofolha.php?id=$escalasmes->id&setorExt=$escalasmes->setor&mesExt=$mesextenso&anoExt=$escalasmes->ano' target='_blank'>
            <span class='ui-icon ui-icon-bookmark'></span></a>
            <a title='Gerar todas as frequências desta escala' class='' href='https://painel-controle-siupa.vercel.app/frequencias/$escalasmes->id/$escalasmes->ano" . "$mesParaFrequencias' target='_blank'>
             <span class='ui-icon ui-icon-calculator'></span></a>
            
            <br></strong>";
        }


        echo "</p>
        </div>";
    }


    echo "</div>";
    echo '<script>';
    echo "$( '#accordionescalas' ).accordion({
        active: $colapsaAtual
      });";

    echo 'console.log("';
    echo $colapsaAtual;
    echo '")';
    echo '</script>';


    //$sql = "DELETE FROM u940659928_siupa.tb_escalas WHERE id=4";

    //$busca = $busca->conecta();
    //$insere = $busca->prepare($sql);
    //$insere->execute();
    //$insere->execute(array('4','2021',rand(2,300),'R'));


    ?>


</div>
<?php
class Data
{
    function mes($entrada)
    {
        switch ($entrada) {
            case 1:
                return "Janeiro";
            case 2:
                return "Fevereiro";
            case 3:
                return "Março";
            case 4:
                return "Abril";
            case 5:
                return "Maio";
            case 6:
                return "Junho";
            case 7:
                return "Julho";
            case 8:
                return "Agosto";
            case 9:
                return "Setembro";
            case 10:
                return "Outubro";
            case 11:
                return "Novembro";
            case 12:
                return "Dezembro";
        }
        return $entrada;
    }
}
?>