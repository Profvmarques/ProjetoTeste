<?php
// definindo o tempo limite da aplicação o time default é de 30 segundos 
// você setando para 0  fica um tempo indefinido

set_time_limit(0);
// variavel que vai armazenar o nome do site
$ftp_server = 'aurora.proderj.rj.gov.br';
// efetua a conexão
$conn_id = ftp_connect($ftp_server);
// caso ocorra algum erro de conexao
if(!$conn_id)
{
 echo "nao foi possivel conectar ao servidor de ftp dp site ".$ftp;
 exit;
}
else
{
 // faz a autenticação do usuario 
 // nessa parte sera necessário informar o login e senha
 $login = "testeftp2";
 $senha = "testeftp2";
 $login_result = ftp_login($conn_id, $login, $senha);
 if(!$login_result)
 {
  echo "erro ao efetuar login";
  exit;
 }
 else
 {
  echo "login efetuado com sucesso...<br>";
  // vejamos agora  em que diretorio estamos com a função ftp_pwd
  echo "O diretório atual agora é: " . ftp_pwd($conn_id) . "<br>";
  // hora de listar o conteudo(arquivos e diretorios) do  diretorio atual
  $buff = ftp_nlist($conn_id, ftp_pwd($conn_id));
  // caso de erro
  if(!$buff)
  {
   echo "Erro ao listar conteudo do diretorio";
   exit;
  }
  else
  {
   echo "listando conteudo do diretorio -> ".ftp_pwd($conn_id)."<Br>";
   // o nome dos arquivos bem como seus diretorios sao devolvidos em um vetor
   // imprimindo-os

$quantidade = count($buff);
   for($i=0;$i<$quantidade;$i++)
   {
    echo $buff[$i]."<Br>";
   }
   // supondo que eu desejo fazer o upload do  arquivo chamado envia_menssagem.php 
   // puxar para a minha maquina local e desejo armazenar ela com o nome de upload.php

   // os parametros passados
   // $conn_id - > é  a propria conexao
   // $end_local - > o endereço onde  será salvo o arquivo ex: teste/teste.php ou
   // seja salvara dentro da pasta teste com o nome teste.php
   // $end_server - > endereço onde está o arquivo no servidor ex: teste/abcd.php ou
   // seja  fara upload do arquivo chmado abcd.php que esta dentro da pasta teste
   // FTP_BINARY - > tipo da transferencia de dados
   $end_local = "upload.php";
   $end_server ="file:///home/valdir/envia_mensagem.php";
   // $upload = ftp_get($conn_id, $end_local, $end_server, FTP_BINARY);
   $upload = ftp_put($conn_id, $end_local, $end_server, FTP_BINARY);
   if (!$upload) 
   {
     echo "O upload FTP falhou!";
     exit;
   }
   else
   {
    echo "Arquivo Transferido com sucesso";
   }
}
 }
}
// fechando a conexao FTP
ftp_close($conn_id);
?>
