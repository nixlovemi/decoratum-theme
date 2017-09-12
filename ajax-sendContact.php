<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
if (@session_id() == "") @session_start();

$arrRet        = array();
$arrRet["ok"]  = false;
$arrRet["msg"] = "Erro ao enviar mensagem. Se o problema persistir, nos avise em contato@decoratum.com.br.";

if( count($_POST) > 0 ){
    $vExec = (isset($_POST["exec"])) ? $_POST["exec"]: "";
    $vName = (isset($_POST["name"])) ? $_POST["name"]: "";
    $vMail = (isset($_POST["mail"])) ? $_POST["mail"]: "";
    $vMsg  = (isset($_POST["msg"])) ? $_POST["msg"]: "";

    if(!$vExec == 1){
        $arrRet["ok"]  = false;
        $arrRet["msg"] = "Erro ao executar envio de mensagem. Se o problema persistir, nos avise em contato@decoratum.com.br.";
    } else {
        $arrError = array();

        if(strlen($vName) < 3){
            $arrError[] = "Nome";
        }

        if (!filter_var($vMail, FILTER_VALIDATE_EMAIL)) {
            $arrError[] = "Email";
        }

        if(strlen($vMsg) < 3){
            $arrError[] = "Mensagem";
        }

        if(count($arrError) > 0){
            $arrRet["ok"]  = false;
            $arrRet["msg"] = "Preencha corretamente as informa&ccedil;&otilde;es antes de enviar o contato:<br />" . implode(", ", $arrError);
        } else {
            $to      = "contato@decoratum.com.br,carla@decoratum.com.br,nixlovemi@gmail.com";
            $subject = "Contato Site - Decoratum";
            $body    = "
                Nome: $vName<br />
                Email: $vMail<br /><br />

                <i>\"".nl2br($vMsg)."\"<i>
            ";

            $ret = sendMail($to, $subject, $body);
            if(!$ret){
                $arrRet["ok"]  = false;
                $arrRet["msg"] = "Erro ao enviar mensagem. Tente novamente mais tarde!";
            } else {
                $arrRet["ok"]  = true;
                $arrRet["msg"] = "Mensagem enviada com sucesso!!";
            }
        }
    }
}

echo json_encode($arrRet);