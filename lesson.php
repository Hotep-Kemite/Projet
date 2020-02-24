<?php
	
	include("fonctions.php");

	echo debutFichier("Leçon",array("normalize.css","style.css"));
	
	$dataLesson = curlResultat('https://api.lelivrescolaire.fr/public/chapters/'.$_GET['idChapitre'].'/lessons');

	if ($dataLesson == null)

	{
		echo "<h1>Le chapitre est inaccessible</h1>";
	}

	else

	{
		$entete = intoBalise("h1","Les leçons du chapitre".$_GET['titreChapitre']." que vous avez selectioné sont ")."\n";

		$tableau = "";

		$colonne = "";


		for ($i = count($dataLesson)-1, $j = 1; $i >= 0 ; $i--, $j++)

		{

			if ($dataLesson[$i]['valid'] == false)

			// Ce test permet de mettre en couleur grise le chapitre s'il est desactivé en donnant à la balise p une classe qui aura pour couleur grise dans la feuille de style

			{
				$ligne = intoBalise("p","Leçon ".(count($dataLesson)-$i)." : $dataLesson[$i]['title']",array("class"=>"chapitreInvalide"))."\n";
			}

			else

			{
				$ligne = intoBalise("p",'Leçon '.(count($dataLesson)-$i)." : ".$dataLesson[$i]['title'])."\n";
			}


			$ligne = $ligne.intoBalise("p","Numéro de page : ".$dataLesson[$i]['page'])."\n";


			$ligne = intoBalise("a",$ligne,array("href"=>'template.php?idLesson='.$dataLesson[$i]['id']."&amp;titreLesson=".$dataLesson[$i]['title']))."\n";


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

		$tableau = intoBalise("table",$tableau,array("border"=>1));

		$entete = $entete.$tableau;

		$entete = intoBalise("div",$entete,array("id"=>"conteneur"));

		echo "$entete";
	}

	echo finFichier();
?>