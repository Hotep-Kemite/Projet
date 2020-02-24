<?php
	
	include("fonctions.php");

	echo debutFichier("Chapitre",array("normalize.css","style.css"));

	$dataLivre = curlResultat('https://api.lelivrescolaire.fr/public/books');

	$dataChapitre = curlResultat('https://api.lelivrescolaire.fr/public/books/'.$_GET['idLivre'].'/chapters');

	if ($dataChapitre != null)

	{	

		$tableau = "";

		$colonne = "";


		for ($i = count($dataChapitre)-1, $j = 1; $i >= 0 ; $i--, $j++)

		{

			if ($dataChapitre[$i]['valid'] == false)

			{
				$ligne = intoBalise("p",'Chapitre '.(count($dataChapitre)-$i),array("class"=>"chapitreInvalide"))."\n";
			}

			else

			{
				$ligne = intoBalise("p",'Chapitre '.(count($dataChapitre)-$i))."\n";
			}

			if ($dataChapitre[$i]['url'] == null)

			{
				$ligne = $ligne.intoBalise("img","",array("src"=>"chapitre.jpg","alt"=>"image du Chapitre","width"=>150))."\n";
			}


			else

			{
				$ligne = $ligne.intoBalise("img","",array("src"=>$dataChapitre[$i]['url'],"alt"=>"image du Chapitre","width"=>150))."\n";
			}

			if ($dataChapitre[$i]['valid'] == false)

			{
				$ligne = $ligne.intoBalise("figcaption",$dataChapitre[$i]['title'],array("class"=>"chapitreInvalide"))."\n";
			}

			else

			{
				$ligne = $ligne.intoBalise("figcaption",$dataChapitre[$i]['title'])."\n";
			}

			$ligne = intoBalise("figure",$ligne)."\n";

			$ligne = intoBalise("a",$ligne,array("href"=>'lesson.php?idChapitre='.$dataChapitre[$i]['id']."&amp;titreChapitre=".$dataChapitre[$i]['title']))."\n";

			$ligne = intoBalise("td",$ligne)."\n";

			$colonne = $colonne.$ligne;

			if ($j%3 == 0)

			{
				$colonne = intoBalise("tr",$colonne)."\n";

				$tableau = $tableau.$colonne;

				$colonne = "";
			}

		}
		
		if ($colonne != "")

		{
			$colonne = intoBalise("tr",$colonne)."\n";
		}

		$tableau = $tableau.$colonne;

		$tableau = intoBalise("table",$tableau);

		$entete = intoBalise("h1","Les chapitres du livre ".$_GET['titleLivre']." que vous avez selectioné sont ")."\n";

		$entete = $entete.$tableau;

		$entete = intoBalise("div",$entete,array("id"=>"conteneur"));

		echo "$entete";
	}

	else

	{
		echo "<h1>Le serveur n'arrive pas à trouver les chapitres du livre que vous avez selectionné. Désolé</h1>";
	}

	echo finFichier();
?>