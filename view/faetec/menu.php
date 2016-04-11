<?php 
require_once ('../../controle/menu.php');
?>
 <ul id="nav" class="sf-menu">
		<?php if ($acesso['ler'] == 1) { ?>
       
        	<li><a href="#">Visualizar Dados</a>
            	<ul>
                	<li><a href="index.php?pg=1">Formas de Contato</a></li>
                    <li><a href="index.php?pg=19">Den&uacute;ncias</a></li>
                    <li><a href="index.php?pg=37">Novos Coment&aacute;rios</a></li>
                    <li><a href="index.php?pg=13">Andamento de processo</a></li>
                    <li><a href="index.php?pg=15">Processos Inibidos</a></li>
                    <li><a href="index.php?pg=18">Den&uacute;ncias Inibidas</a></li>
                    <li><a href="index.php?pg=33">Processos em Bloco</a></li>
                </ul>
            </li>
            <li><a href="#">Relatório geral</a>
            	<ul>
                	<li><a href="index.php?pg=4">Formas de Contato</a></li>
                </ul>
            </li>
            <li><a href="#">Relatórios Espec&iacute;ficos</a>
            	<ul>
                	<li><a href="index.php?pg=34">Comparativos</a></li>
                    <li><a href="index.php?pg=19">Den&uacute;ncias</a></li>
                    <li><a href="index.php?pg=37">Novos Coment&aacute;rios</a></li>
                    <li><a href="index.php?pg=13">Andamento de processo</a></li>
                    <li><a href="index.php?pg=15">Processos Inibidos</a></li>
                    <li><a href="index.php?pg=18">Den&uacute;ncias Inibidas</a></li>
                    <li><a href="index.php?pg=33">Processos em Bloco</a></li>
                </ul>
            </li>
			
			
			
		<?php } ?>
		<?php if ($acesso['alterar'] == 1) { ?>
        	<li><a href="#">Formul&aacute;rio Ouvidoria</a>
            	<ul>
                	<li><a href="index.php?pg=9">Formas de Contato - Sistema On-line</a></li>
        	
			
		<?php } ?>
		<?php if ($acesso['incluir'] == 1) { ?>
        			<li><a href="index.php?pg=17">Den&uacute;ncia - Sistema On-line</a></li>
        		</ul>
            </li>
			
            <li><a href="#">Cadastros</a>
            	<ul>
                	<li><a href="index.php?pg=6">Incluir Usuários</a></li>
                    <li><a href="index.php?pg=10">Editar Usuários</a></li>
                    <li><a href="index.php?pg=7">Incluir Entidade</a></li>
                    <li><a href="index.php?pg=11">Editar Entidade</a></li>
                    <li><a href="index.php?pg=8">Incluir Resposta Padrão</a></li>
                    <li><a href="index.php?pg=12">Editar Resposta Padrão</a></li>
                    <li><a href="index.php?pg=38">Incluir Assunto</a></li>
                    <li><a href="index.php?pg=39">Editar Assunto</a></li>
                </ul>
            </li>
			
		<?php } ?>
        	<li><a href="index.php?pg=3">Sair</a></li>
        </ul>
