<?php
header("Content-Type: text/html;  charset=ISO-8859-1",true);
//URL DO SITE A SER CAPTURADO
	//Aqui pega o resultado do campeonato desejado.
	$url = 'http://www.futebolnacional.com.br/infobol/championship.jsp?code=9943765B8E672659FF5F629E8BCB337C';
	
	$site = utf8_decode(file_get_contents($url));
	$fase = "<tr align=\"center\" class=\"classif\"><td colspan=\"7\">";
	$q1 = explode ($fase, $site);
	$j = 0;
	for ($k = 0; $k < count($q1); $k++) {
		$at = 0;
		$at = strpos($q1[$k],"<tr class=\"data\">");
		if ($at > 0)
		{
//			echo "PARTE - $k<HR>";
			$turno[$j] = $k;
			$j++;
		}
	}
	for ($k = 0; $k < $j; $k++) {
//		echo "$turno[$k]<HR>";
		$q2 = explode ("<td width=", $q1[$turno[$k]]);
		$dt = "00/00/00";
		$j = 0;
		for ($i = 0; $i < count($q2); $i++) {
			$q2[$i] = trim(str_replace("\"13%\" align=\"right\">", "tim1",$q2[$i]));
			$q2[$i] = trim(str_replace("\"5%\" style=\"text-align:center;font-weight:bold;\">", "resu",$q2[$i]));
			$q2[$i] = trim(str_replace("\"13%\" align=\"left\">", "tim2",$q2[$i]));
			$q2[$i] = strip_tags($q2[$i], '<(.*?)>');
			$at1 = strpos($q2[$i],"/");
			$at2 = strrpos($q2[$i],"/");
//			echo "$q2[$i]<BR>";
			if ($at2 - $at1 > 0) {
				$dd = trim(substr($q2[$i],$at1 - 3,3));
				$mm = trim(substr($q2[$i],$at1+1,2));
				$aa = trim(substr($q2[$i],$at2+1,4));
				$aa = trim(substr($aa,2,2));
				$dt = "$dd/$mm/$aa";
				$dta[$j] = $dt;
//			echo "$dt<BR>";
			}
			$t1 = strstr($q2[$i], 'tim1');
			if (is_string($t1)) {
				$t1 = trim(substr($t1, 4, strlen($t1)));
	//			echo "<HR>$i<BR>$t1<BR>";
				$ti1[$j] = $t1; 
			}
			$t2 = strstr($q2[$i], 'tim2');
			if (is_string($t2)) {
				$t2 = trim(substr($t2, 4, strlen($t2)));
//				echo "$t2<BR>";
				$ti2[$j] = $t2;
				$j++;
				if (strcmp($dt,$dta[$j - 1]) == 0) $dta[$j] = $dt; 
			}
			$re = strstr($q2[$i], 'resu');
			if (is_string($re)) {
				$re = trim(str_replace("WO", "3",$re));
				$re = trim(substr($re, 4, strlen($re)));
				if (strlen($re) > 2) $re = trim(str_replace("x", "-",$re));
				else $re = "";
	//			echo "$re<BR>";
				$res[$j] = $re; 
			}
		}
		for($i = 0; $i < $j; $i++) {
			echo "$dta[$i]<BR>$ti1[$i]-$ti2[$i] $res[$i]<BR>";
		}
	}
/*
//	$fase = "2? Turno";
//	$fase = "Final";
//	echo "$site<BR>";
	$q1 = explode ($fase, $site);
//	$q1[1] = trim(str_replace("<tr class=\"data\"><td colspan=\"7\">", "%",$q1[1]));
//	$q1[1] = trim(str_replace(" - ", "%",$q1[1]));
//	$q1[1] = trim(str_replace("<tr class=\"jogos1\"><td width=\"15%\" align=\"right\">", "%",$q1[1]));
//	$q1[1] = trim(str_replace("<td width=\"5%\" style=\"text-align:center;font-weight:bold;\">", "%",$q1[1]));
//	$q1[1] = trim(str_replace("<td width=\"15%\" align=\"left\">", "%",$q1[1]));
//	$q1[1] = trim(str_replace("<td width=\"8%\">", "%",$q1[1]));
//	$q1[1] = trim(str_replace("<td width=\"15%\" align=\"right\">", "%%%%",$q1[1]));
//	$q1[1] = strip_tags($q1[1], '<(.*?)>');
//	echo "$q1[1]<BR>";
//Retirar datas
	$q2 = explode ("<tr class=\"data\"><td colspan=\"7\">", $q1[1]);
	$j = 0;
	for($i = 1; $i < count($q2); $i++) {
		$q3 = explode (" - ", $q2[$i]);
		$dt[$j] = $q3[0];
//		echo "$dt[$j]<BR>";
		$q4 = explode ("<tr class=\"jogos1\"><td width=\"15%\" align=\"right\">", $q2[$i]);
		$q5 = explode ("<td width=\"5%\" style=\"text-align:center;font-weight:bold;\">", $q4[1]);
		echo "$q5[0]<BR>";
		$j++;
	}
/*
	$arq = "arq3.txt";
	//abre o arquivo
	$fp = fopen($arq,"w+");
	$exibir = trim(str_replace("<tr class=\"data\"><td colspan=\"7\">", "%",$exibir));
	$exibir = trim(str_replace("<tr class=\"jogos1\"><td width=\"12%\" align=\"right\">", "%",$exibir));
	$exibir = trim(str_replace("<tr class=\"jogos2\"><td width=\"12%\" align=\"right\">", "%",$exibir));
	$exibir = trim(str_replace("<td width=\"4%\" style=\"text-align:center;font-weight:bold;\">", "-+-",$exibir));
	$exibir = trim(str_replace("<td width=\"12%\" align=\"left\">", "-+-",$exibir));
	$exibir = trim(str_replace("<td width=\"7%\">", "---",$exibir));
	$exibir = strip_tags($exibir, '<tr(.*?)>');
	$at1 = strpos($exibir,$fase);
	$at2 = strpos($exibir,"Classifica??o");
	echo "<BR><HR>at1 = $at1   -   at2 = $at2<HR><BR>";
	echo "<BR><HR>$exibir<HR><BR>";
	while ($at1 > $at2)
	{
		$exibir = trim(substr($exibir, $at1 ,strlen($exibir) - $at1));		
		$at1 = strpos($exibir,$fase);
		$at2 = strpos($exibir,"Classifica??o");
		echo "<BR><HR>at1 = $at1   -   at2 = $at2<HR><BR>";
		echo "<BR><HR>$exibir<HR><BR>";
	}
	$exibir = trim(substr($exibir, $at1 + 8, $at2 - $at1 - 7));
	echo "<BR><HR>at1 = $at1   -   at2 = $at2<HR><BR>";
	echo "<BR><HR>$exibir<HR><BR>";
//		fwrite($fp,$exibir);
		echo "<BR><HR>$exibir<HR><BR>";
	$q1 = explode("%", $exibir);
	$j = 0;
	for($i = 1; $i < count($q1); $i++) {
//		echo "<BR><HR>$i<BR>$q1[$i]<HR><BR>";
		$at = strpos($q1[$i]," - ");
//		echo "<BR><HR>$i<BR>$at<HR><BR>";
		if (is_numeric($at)) {
			$aa = trim(preg_replace('/(\d+)\/(\d+)\/(\d+)/i','$3',$q1[$i]));
			$aa = trim(substr($aa,2,2));
			$dt = trim(preg_replace('/(\d+)\/(\d+)\/(\d+)/i','$1/$2',$q1[$i]));
			$dt = trim(substr($dt,0,5));
			$dt = "$dt/$aa";
//			echo "<BR><HR>$i<BR>$dt<HR><BR>";
		} else {
			$at = strpos($q1[$i],"-+-");
//			echo "<BR><HR>$i<BR>at = $at<HR><BR>";
			if (is_numeric($at))
			{
				$t1 = trim(substr($q1[$i],0,$at));
				$tt = trim(substr($q1[$i],$at + 3,strlen($q1[$i]) - $at));
				$at1 = strpos($tt,"-+-");
				$re = trim(substr($tt,0,$at1));
				$tt = trim(substr($tt,$at1 + 3,strlen($tt) - $at1));
				$at1 = strpos($tt,"---");
				$t2 = trim(substr($tt,0,$at1));
				$re = trim(str_replace("x", "-",$re));
				$at1 = strpos($re,"-");
				$r1 = trim(substr($re,0,$at1));
				$r2 = trim(substr($re,$at1 + 1,strlen($re) - $at1));
				$dta[$j] = $dt;
				$tm1[$j] = $t1;
				$tm2[$j] = $t2;
				$re1[$j] = $r1;
				$re2[$j] = $r2;
				$j++;
//				echo "<BR><HR>$dt<BR>$t1-$t2 $r1-$r2<HR><BR>";
			}
		}
	}
	$n = $j;
	for($i = 0; $i < count($dta); $i++) {

		echo "$dta[$i]<BR>$tm1[$i]-$tm2[$i] $re1[$i]-$re2[$i]<BR>";
		fwrite($fp,"$dta[$i]\n$tm1[$i]-$tm2[$i] $re1[$i]-$re2[$i]\n");
	}
*/
	//fecha o arquivo
	fclose($fp);
?>


