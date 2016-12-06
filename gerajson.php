<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
/*
Criado por Alisson Acioli
Data: 05/12/2016

$inpCSV: Caminho até o arquivo CSV
$outJSON: Caminho onde quer salvar o jSON (manter o .json no final)
$delimitador: Separador de colunas. Padrão ";" (sem aspas)
*/

$inpCSV  = 'painel.csv';
$outJSON = 'output.json';
$delimitador = ';';

$colunas = array();
$json = array();
$ponteiro = 1;

if(is_file($$inpCSV))

    $arquivo = file($inpCSV);

    if(!empty($arquivo)){

        foreach($arquivo as $linha){

            if($ponteiro === 1){

                $quebra = explode($delimitador, $linha);

                if(!empty($quebra)){

                    foreach($quebra as $coluna){

                        $colunas[] = utf8_encode(trim($coluna));
                    }

                }else{
                    echo 'Nenhuma coluna foi encontrada para fazer a conversão.';
                    exit;
                }
            }else{

                $quebra = explode($delimitador, $linha);

                if(!empty($quebra)){

                    $indice = 0;
                    $arrayRegistro = array();

                    foreach($quebra as $registro){

                        if(isset($colunas[$indice])){

                            $arrayRegistro[$colunas[$indice]] = utf8_encode(trim($registro));
                        }else{
                            $arrayRegistro[] = "";
                        }

                        $indice++;
                    }

                    $json[] = $arrayRegistro;

                }else{
                    echo 'Nenhum registro encontrado no CSV informado.';
                }
            }


            $ponteiro++;

        }

        $saida = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

        $fp = fopen($outJSON, 'w+');
        $fw = fwrite($fp, $saida);
        fclose($fp);

    }else{
        echo 'Nenhum conteúdo encontrado para fazer a conversão';
    }
}else{
    echo 'O arquivo CSV informado não existe. Informe um arquivo válido';
}
?>