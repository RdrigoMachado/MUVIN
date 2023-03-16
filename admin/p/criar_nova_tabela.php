<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Negocio/Formulario.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

function criarTabela($inputUsuario){
    $inputLimpo = Formulario::limparInputUsuario($inputUsuario);

    if(Formulario::criarEntidade($inputLimpo, $novo_componente = false))
    {
        header("Location: " . URL_PAGINAS . "listar_tabelas.php?");
        die();
    }
    echo "Erro";
    die();
    
    
}

$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo == "POST")
{
    criarTabela($_POST);
}


$referencias = GerenciadorDeEstruturas::listarNomesEstruturas();
$listaReferencias = "";
foreach ($referencias as $referencia) {
    $listaReferencias .= '<option>' . $referencia . '</option>';
}
?>

<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Criar Tabela");?>
    <body>
        <div class="container">
        <?php adicionarMenu();?>

        <section id="fomulario">
            
            <form class="form">
                <h4>Criar Tabela</h4>
                <div class="form-linha">
                    <label for="nome_tabela" class="form-label">Nome Tabela</label>
                    <input class="form-control" type="text" id="nome_tabela" placeholder="Nome Tabela">
                </div>
                <div id="linhas">

                </div>
                <div class="form-linha">
                    <button type="button" class="form-botao form-botao-roxo" onClick="add()">Novo Campo</button>
                </div>
                
                <button type="button" class="form-botao form-botao-roxo" onclick="enviar()">Criar Tabela</button>
            </form>
            
            
        </section>
       
        <script type="text/javascript">
            let contador = 0;
            let qtd_campos = 0;
            let referencias = '<?= $listaReferencias ?>';

            add();

            function criarElementoTamanho(id) {
                let auxiliar = document.createElement('div');
                auxiliar.id = 'divtamanho' + id;
                auxiliar.innerHTML = '<label>Tamanho</label><input class="form-control" type="number" id="tamanho' + id + '">';
                return auxiliar;
            }

            function criarElementoReferencias(id) {
                let auxiliar = document.createElement('div');
                auxiliar.id = 'divreferencia' + id;
                auxiliar.innerHTML = '<div> <label height="20">Referencias</label>' +
                    '<select class="form-control"  id="referencia' + id + '"> ' +
                    '<?= $listaReferencias ?>' +
                    '</select></div>';
                return auxiliar;
            }

            function mudancaDeSelecao(valor, id) {
                let nodoPai = document.getElementById('aux' + id);
                if (valor.value === 'varchar') {
                    nodoPai.innerHTML = "";
                    nodoPai.appendChild(criarElementoTamanho(id));
                    nodoPai.style.visibility = 'visible';
                } else if (valor.value === "chave_estrangeira") {
                    nodoPai.innerHTML = "";
                    nodoPai.appendChild(criarElementoReferencias(id));
                    nodoPai.style.visibility = 'visible';
                } else {
                    nodoPai.style.visibility = 'hidden';
                }
            }

            function add() {
                let nova_row = document.createElement('div');
                nova_row.id = 'row' + contador;
                nova_row.innerHTML =
                '<div class="form-linha" >' +

                    '<div class="form-campo">' +
                        '<label class="form-label" >Campo</label>' +
                        '<input class="form-control" type="text" id="campo' + contador + '" placeholder="Nome Campo">' +
                    '</div>' +
                    '<div class="form-campo">' +
                        '<label class="form-label">Tipo</label>' +
                        '<select class="form-select"  id="tipo' + contador + '" onchange="mudancaDeSelecao(this, ' + contador + ')">' +
                        '<option value="int">INT</option>' +
                        '<option value="float">FLOAT</option>' +
                        '<option value="text">TEXT</option>' +
                        '<option value="date">DATA</option>' +
                        '<option value="varchar">VARCHAR</option>' +
                        '<option value="chave_estrangeira">REFERENCIA</option>' +
                        '</select>' +
                    '</div>' +
                    '<button class="form-botao form-botao-laranja" type="button" class="btn" onclick="remove(\'row' + contador + '\')">' +
                            'Remover' +
                        '</button>' +

                    '<div id="aux' + contador + '" style="visibility: hidden;"></div>' +
                '</div>';

                document.getElementById("linhas").appendChild(nova_row);
                contador++;
                qtd_campos++;
            }

            function remove(id) {
                document.getElementById(id).outerHTML = "";
                qtd_campos--;
            }

            function enviar() {
                const form = document.createElement('form');
                form.method = 'post';

                let num_camp = 0;
                let indice;
                let nome_tabela = document.createElement('input');
                nome_tabela.type = 'hidden';
                nome_tabela.name = 'tabela_nome';
                nome_tabela.value = document.getElementById('nome_tabela').value;
                form.appendChild(nome_tabela);
                let nomeCampo;
                for (indice = 0; indice <= contador; indice++) {
                    if (document.body.contains(document.getElementById('row' + indice))) {
                        num_camp++;
                        nomeCampo = 'campos[campo' + num_camp + ']';
                        let nome_campo = document.createElement('input');
                        nome_campo.type = 'hidden';
                        nome_campo.name = nomeCampo + '[nome]';
                        nome_campo.value = document.getElementById('campo' + indice).value;
                        form.appendChild(nome_campo);
                        let tipo_campo = document.createElement('input');
                        tipo_campo.type = 'hidden';
                        tipo_campo.name = nomeCampo + '[tipo]';
                        tipo_campo.value = document.getElementById('tipo' + indice).value;
                        form.appendChild(tipo_campo);
                        if (tipo_campo.value === "varchar") {
                            let tamanho_campo = document.createElement('input');
                            tamanho_campo.type = 'hidden';
                            tamanho_campo.name = nomeCampo + '[tamanho]';
                            tamanho_campo.value = document.getElementById('tamanho' + indice).value;
                            form.appendChild(tamanho_campo);
                        } else if (tipo_campo.value === "chave_estrangeira") {
                            let referencia = document.createElement('input');
                            referencia.type = 'hidden';
                            referencia.name = nomeCampo + '[referencia]';
                            referencia.value =  document.getElementById('referencia' + indice).value;
                            form.appendChild(referencia);
                        }
                    }
                }

                let qtd_campos = document.createElement('input');
                qtd_campos.type = 'hidden';
                qtd_campos.name =  'qtd_campos';
                qtd_campos.value = num_camp.toString();
                form.appendChild(qtd_campos);
                document.body.appendChild(form);
                form.submit();
            }
        </script>
        </div>
    </body>
</html>
