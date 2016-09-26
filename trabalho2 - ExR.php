<?php
/*
	Ideia pegar o código bruto coletar o dado time casa, time visitante, placar e data usando expressões Regulares
	Identificação das expressões
	time casa: <td width="13%" align="right">Nome do time<
	time visitante: <td width="13%" align="left">Nome visitante<
	placar: <td width="5%" style="text-align:center;font-weight:bold;">Placar<
	Data: <tr class="data"><td colspan="7">Data -

*/

	header("Content-Type: text/html;  charset=UTF-8",true);


	echo "<br><br><form action=\"index.php\" method=\"post\">
 			<p>Competição: <input type=\"text\" name=\"name\" /></p>
 			<p><input type=\"submit\"/></p>
		  </form>";
	$string = str_replace(' ', '+', $_POST['name']);
	$busca = 'http://www.google.com.br/search?gcx=c&ix=c1&sourceid=chrome&ie=UTF-8&q='.$string.'+site:http://www.futebolnacional.com.br/infobol/championship.jsp';
	//Puxa o código_fonte da busca
	$site = utf8_encode(file_get_contents($busca));
	//Expressão regular link do retorno da busca 
	$exrgbusca = "/<h3 class=\"r\"><a href=\"\/url\?q=(.+?)sa=/";
	//Pesquisa no código-fonte todas as substrings reconhecidas pela expressão regular.
	preg_match_all($exrgbusca, $site, $matchesbusca);
	//tratamento da url da 
	$url = $matchesbusca[1][0];
	$url = str_replace('%3F', '?', $url);
	$url = str_replace('%3D', '=', $url);
	$url = substr($url,0,-5);
	
	
	//Puxa o código_fonte do site
	$site = utf8_encode(file_get_contents($url));
	//Expressão regular time 1
	$exrgtim1 = "/<td width=\"13\%\" align=\"right\">(.+?)</";
	//Expressão regular time 2
	$exrgtim2 = "/<td width=\"13\%\" align=\"left\">(.+?)</";
	//Expressão regular placar
	$exrgplacar = "/<td width=\"5\%\" style=\"text-align:center;font-weight:bold;\">(.+?)</";
	//Expressão regular data
	$exrgdata = "/<tr class=\"data\"><td colspan=\"7\">(.+?) -/";
	//Expressão regular nome da competição
	$exrgNomecomp = "/<h1 class=\"torneio\">(.+?)<\/h1>/";
	//Pesquisa no código-fonte todas as substrings reconhecidas pela expressão regular .
	preg_match_all($exrgtim1, $site, $matches1);
	preg_match_all($exrgtim2, $site, $matches2);
	preg_match_all($exrgplacar, $site, $matches3);
	preg_match_all($exrgdata, $site, $matches4);
	preg_match_all($exrgNomecomp, $site, $matches5);
	/*Trata os jogos*/
	//Substitui os '-' por '/' dos times
	for ($i=0; $i < count($matches1[1]); $i++) { 
		$matches1[1][$i] = str_replace('-', '/', $matches1[1][$i]);
		$matches2[1][$i] = str_replace('-', '/', $matches2[1][$i]);
	}

	//note que alem de capturar a data temos que ver em quantos jogos ocorreram na mesma.
	//limita as partidas que ocorrram na data
	$jogosdata = explode ("<tr class=\"data\"><td colspan=\"7\">", $site);
	$j = 0;
	$datas = array();//Array final com as datas de cada partida corretas
	//Conta quantas partidas ocorrram por data
	for ($i=1; $i < count($jogosdata); $i++) { 
		for ($k=0; $k < substr_count($jogosdata[$i], 'ficha.png'); $k++) {
			array_push($datas, $matches4[1][$j]);
		}
		$j++;
	}
	echo $matches5[0][0]."<br>";
	for ($i=0; $i < count($datas); $i++) { 
		echo $datas[$i]."<br>";
		echo $matches1[1][$i]."-".$matches2[1][$i]." ".$matches3[1][$i]."<br>";
	}
	//Impressão dos dados tratados
	$linhas = $matches5[1][0]."\n";
	for ($i=0; $i < count($datas); $i++) { 
		$linhas .= $datas[$i]."\n";
		$linhas .=  $matches1[1][$i]."-".$matches2[1][$i]." ".$matches3[1][$i]."\n";
	}
	$arq = "arq1.txt";
	//abre o arquivo
	$fp = fopen($arq,"w+");
	fwrite($fp,$linhas);
	//fecha o arquivo
	fclose($fp);
?>
