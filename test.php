<?php
	include("tp2.php");
	$livre = curl_init('https://api.lelivrescolaire.fr/public/books');

	$chapitre = curl_init("https://api.lelivrescolaire.fr/public/books/1339497/chapters");

	$lesson = curl_init("https://api.lelivrescolaire.fr/public/chapters/1339669/lessons");

	curl_setopt($livre, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($chapitre, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($lesson, CURLOPT_RETURNTRANSFER, true);

	$dataLivre = curl_exec($livre);

	$dataChapitre= curl_exec($chapitre);

	$dataLesson = curl_exec($lesson);

	$dataLivre = json_decode($dataLivre,true);

	$dataChapitre = json_decode($dataChapitre,true);

	$dataLesson = json_decode($dataLesson,true);
	
	//echo "<p> Type de dataLivre :".gettype($dataLivre)."</p>";

	for ($i=0; $i < count($dataLivre) ; $i++)

	{ 
		if ($dataLivre[$i]['id'] == 1339497)

		{
			echo "<h1> Livre de ".$dataLivre[$i]['displayTitle']."</h1>";
		}
	}

	$chaine = "";

	$af = "";

	$intermediaire = "";

	$intermediaire = "\n".intoBalise("img","",array('src' => $dataChapitre[0]['url'],'width' => 100))."\n";

	$intermediaire = $intermediaire."\n".intoBalise("figcaption",$dataChapitre[0]['title'])."\n Chapitre 0"."\n";

	$intermediaire = "\n".intoBalise("figure",$intermediaire)."\n";

	$intermediaire = "\n".intoBalise("a",$intermediaire,array("href" => 'lesson.php?chapitre='.$dataChapitre[0]['id']))."\n";

	$intermediaire = "\n".intoBalise('td',$intermediaire)."\n";

	$chaine = $chaine.$intermediaire."\n";

	for ($i=count($dataChapitre) - 1; $i > 0 ; $i--)

	{ 
		$intermediaire = "\n".intoBalise("img","",array('src' => $dataChapitre[$i]['url'],'width' => 100))."\n";

		$intermediaire = $intermediaire."\n".intoBalise("figcaption",$dataChapitre[$i]['title'])."\n Chapitre ".(count($dataChapitre)-$i)."\n";

		$intermediaire = "\n".intoBalise("figure",$intermediaire)."\n";

		$intermediaire = "\n".intoBalise("a",$intermediaire,array("href" => 'lesson.php?chapitre='.$dataChapitre[$i]['id']))."\n";

		$intermediaire = "\n".intoBalise('td',$intermediaire)."\n";

		$chaine = $chaine.$intermediaire."\n";

		if (($i-1)%3 == 0)

		{
			$chaine = "\n".intoBalise("tr",$chaine);

			$af = $af.$chaine;

			$chaine = "";
		}
	}

	$af = "\n".intoBalise("table",$af/*,array('border' => 1)*/);

	echo "$af";

	//$intermediaire = intoBalise('td','<a href="lesson.php?chapitre='.$dataChapitre[$i]['id'].'"> Chapitre '.($i+1).' : '.$dataChapitre[$i]['title'].'</a>')."\n";
?>