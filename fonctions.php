<?php

	function intoBalise(string $nomElement, string $contenuElement, array $params=null): string

	{
		$chaine = '<'.$nomElement;

		if ($contenuElement !== "")

		{

			if ($params != null)

			{
				foreach ($params as $key => $value)

				{
					$chaine = $chaine.' '.$key.'=\''.$value.'\'';
				}
			}

			$chaine = $chaine.'>'.$contenuElement.'</'.$nomElement.'>';

			return $chaine;
		}

		if ($params != null)

		{
			foreach ($params as $key => $value)

			{
				$chaine = $chaine.' '.$key.'=\''.$value.'\'';
			}
		}

		$chaine = $chaine.'/>';

		return $chaine;
	}

	function debutFichier(string $titre,array $params=null) : string

	{
		$s = '<!DOCTYPE html>'."\n".'<html>'."\n".'<head>'."\n".'<meta charset="utf-8">'."\n".'<title>'.$titre.'</title>'."\n";

		if ($params != null)

		{
			for ($i = 0; $i < count($params); ++$i)

			{
				$s = $s.'<link rel="stylesheet" type="text/css" href="'.$params[$i].'"/>'."\n";
			}
		}

		$s = $s.'</head>'."\n".'<body class = "text-center">'."\n";

		return $s;
	}

	function finFichier () : string

	{
		return ('</body>'."\n".'</html>');
	}

	function curlResultat (string $lien) : array
	
	{
		$resultat = curl_init($lien);

		curl_setopt($resultat, CURLOPT_RETURNTRANSFER, true);

		$dataResultat = curl_exec($resultat);

		$dataResultat = json_decode($dataResultat,true);

		return $dataResultat;
	}
?>