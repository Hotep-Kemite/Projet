<?php 

	include("fonctions.php"); // inclure le fichier qui contient les fonctions dont on aura besoin

	echo debutFichier("Template",array("normalize.css","style.css")); // affiche de l'entete

	$dataTemplate = curlResultat('https://api.lelivrescolaire.fr/public/templates/'.$_GET['idLesson']); 

	// on recupère les données sous forme de tableau en se servivant de l'ID de la leçon qu'à choisie l'utilsateur 

	$contenu = "";

	for ($i = 0; $i < count($dataTemplate['documents']); ++$i)

	{
		$rurl = $dataTemplate['documents'][$i]['url'];

		$rurl = substr($rurl,-4);

		//echo "$rurl";

		if ($dataTemplate['documents'][$i]['url'] != null && $rurl != ".mp3") 

		/* Ce test permet d'éviter d'afficher une url de musique au format mp3 mais aussi d'éviter d'inclure dans la source de l'image une url qui n'existe pas*/

		{
			$contenu = $contenu.intoBalise("img","",array("src"=>$dataTemplate['documents'][$i]['url'], "width"=>70))."\n";
		}

		if ($dataTemplate['documents'][$i]['content'] != null)

		{
			$contenu = $contenu.$dataTemplate['documents'][$i]['content']."\n";
		}
	}

	$contenu = intoBalise("div",$contenu,array("id"=>"conteneur"));

	echo "$contenu";
 ?>