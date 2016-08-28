<?php
/*
	Carlos Henrique Reis
	Universidade Federal de Itajubá
	Desafio as equipes.
		Fazer um programa que leia o site: https://icpc.baylor.edu/…/south-america-brazil-first-…/teams
	E diga quantas escolas diferentes tem e tem que apresentar elas em ordem crescente por seus nomes.
	Tem que ser em PHP.
	Pontos: 5 a mais na nota final (não pode exceder 100)
*/
	header("Content-Type: text/html;  charset=ISO-8859-1",true);

	$url = 'https://icpc.baylor.edu/regionals/finder/south-america-brazil-first-phase-2016/teams';
	//Puxa o código_fonte do site
	$site = utf8_decode(file_get_contents($url));
	//Expressão regular que irá conter as escolas que estão no site
	$exrg = "/role=\"row\"><td role=\"gridcell\">(.+?)<\/td>/";
	//Pesquisa no código-fonte todas as substrings reconhecidas pela expressão regular dada e as coloca em uma matriz.
	preg_match_all($exrg, $site, $matches);
	//$matches[1] contem a strings associadas ao primeiro padrão (no caso será as escolas
	//Removendo escolas duplicatas
	$escolas = array_unique($matches[1]);
	//Ordenando escolas, trata todos os elementos como string
	sort($escolas, SORT_STRING);
	//Imprime a qutd de escolas	
	echo "Quantidade de escolas:".count($escolas)."<br>";
	//Imprime as escolas em ordem crescebnte
	for ($i=0; $i < count($escolas); $i++) { 
		echo $escolas[$i]."<br>";
	}
	
?>

