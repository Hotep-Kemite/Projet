<?php
	include("fonctions.php");

	echo debutFichier("Livre",array("normalize.css","style.css"));

	$dataLivre = curlResultat('https://api.lelivrescolaire.fr/public/books');

	$i = count($dataLivre) - 1;

	if (isset($_GET['indiceDebut']) && (int)$_GET['indiceDebut'] >= 0 && (int)$_GET['indiceDebut'] <= $i)

	{
		$i = (int)$_GET['indiceDebut'];

	}

	$entete = intoBalise("h1","Notre bibliothèque dispose les livres suivants")."\n";

	$suivant = intoBalise("a","Page suivante >",array("href"=>"livre.php?indiceDebut=".($i-9)))."\n";

	if ($i < count($dataLivre) - 1)


	// test permettant de savoir s'il faut mettre le bouton precedent ou pas

	{
		$precendent = intoBalise("a","< Page précedente",array("href"=>"livre.php?indiceDebut=".($i+9)))."\n";

		$precendent = intoBalise("button",$precendent,array("type"=>"button","id"=>"precendent"))."\n";

		$suivant = intoBalise("button",$suivant,array("type"=>"button"))."\n";

		$entete = $entete.$precendent."\n";
	}

	else

	{
		$suivant = intoBalise("button",$suivant,array("type"=>"button","id"=>"suivant"))."\n";
	}

	$entete = $entete.$suivant."\n";

	$tableau = "";

	$colonne = "";

	$ligne = "";

	for ($j = 1; $i >=0 && $j < 10; $i--, $j++)

	{
		if ($dataLivre[$i]['url'] == null)

		{
			$ligne = intoBalise("img","",array("src"=>"image.png","alt"=>"image du livre","width"=>150))."\n";
		}

		else

		{
			$ligne = intoBalise("img","",array("src"=>$dataLivre[$i]['url'],"alt"=>"image du livre","width"=>150))."\n";
		}

		$bouton = intoBalise("button",$dataLivre[$i]['title'],array("type"=>"button"));

		$ligne = $ligne.intoBalise("figcaption",$bouton)."\n";  

		$ligne = intoBalise("figure",$ligne)."\n";

		$ligne = intoBalise("a",$ligne,array("href"=>'chapitre.php?idLivre='.$dataLivre[$i]['id'].'&amp;titleLivre='.$dataLivre[$i]['displayTitle']))."\n";

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

	$entete = $entete.$tableau;

	$entete = intoBalise("div",$entete,array("id"=>"conteneur"));

	echo "$entete";

	echo finFichier();
?>