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

	$url = 'http://www.futebolnacional.com.br/infobol/championship.jsp?code=9943765B8E672659FF5F629E8BCB337C';
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
	//Pesquisa no código-fonte todas as substrings reconhecidas pela expressão regular .
	preg_match_all($exrgtim1, $site, $matches1);
	preg_match_all($exrgtim2, $site, $matches2);
	preg_match_all($exrgplacar, $site, $matches3);
	preg_match_all($exrgdata, $site, $matches4);
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
	//Impressão dos dados tratados
	for ($i=0; $i < count($datas); $i++) { 
		echo $datas[$i]."<br>";
		echo $matches1[1][$i]."-".$matches2[1][$i]." ".$matches3[1][$i]."<br>";
	}
?>