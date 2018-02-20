<!DOCTYPE HTML>
<html>

<head>
        <title>Page Publique</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
</head>

<body>
    <h1>Authentification XCA - PHP</h1>
	<p>PHASE IDENTIFICATION</p>
	<p>
		Identifiez-vous
		<form action="#" method="POST">
			ID (e-mail) : <input type="text" name="mail" size="70" maxlength="70" value="utilisateur@mondomaine.com" /><input type="submit" value="Envoyer" /><br>
		</form>
	<?php
		// Lorsque l'utilisateur tente de se connecter
		if(isset($_POST['mail'])){

		$mail = htmlspecialchars($_POST['mail']);

		$wsdl = "http://ntx.pcscloud.net/XCASERVER_WEB/awws/XCAServer.awws?wsdl";
		$client = new SoapClient($wsdl);

		// L'identifiant existe-t-il pour le service INSACVL ?
		$param = array("sServiceName" => "INSACVL", "sElementName" => $mail, "sSessionVar" => "groupe1");
		$results = $client->__soapCall("ISEXIST_ELEMENTSERVICE_XCAJAX", $param);

		// L'identifiant existe-t-il ?
		if($results == 1) {
			// L'identifiant existe
			// Demande du Défi
			$param = array("sServiceName" => "INSACVL", "sElementName" => $mail);
			$results = $client->__soapCall("GET_SERVER_CHALLENGE", $param);

			// CALCUL DE LA REPONSE AU DEFI
				echo '<script> var mat=localStorage.getItem(\'INSACVL\');
						var chal = \''.$results.'\';
						var mail = \''.$mail.'\';
						var result = "";

						chal = chal.split(" ");

					    for(var i=0; i< chal.length-1; i++)
						{
							result += mat[chal[i]];
						}

						// ça marche bien ! :)
						//alert(result);

					// Pour sortir la réponse au défi du javascript et le donner au PHP afin de l envoyer,
					// on envoie via POST le mail et la réponse au défi à une autre page PHP qui enverra la réponse
					var form = document.createElement("form");
					form.setAttribute("method", "POST");
					form.setAttribute("action", "./challenge.php");

					var hiddenField = document.createElement("input");
            				hiddenField.setAttribute("type", "hidden");
            				hiddenField.setAttribute("name", "mail");
            				hiddenField.setAttribute("value", mail);
            				form.appendChild(hiddenField);
					var hiddenField = document.createElement("input");
            				hiddenField.setAttribute("type", "hidden");
            				hiddenField.setAttribute("name", "response");
            				hiddenField.setAttribute("value", result);
            				form.appendChild(hiddenField);

					document.body.appendChild(form);
					form.submit();
				</script>';

		// L'identifiant n'existe pas
		} else
			echo "<br> Utilisateur inconnu.";

		}
	?>
	</p>

	<p>.</p>
	<p>.</p>
	<a href="matrix.php">Télécharger la matrice</a>
	<p>.</p>
	<p>.</p>
	<p>INSA CVL - GROUPE 1 (BICHARA Soukaïna, CHARRIER Etienne, GENAUX Luc, GEVEAUX Damien, MAHE Romain, MALBOIS Fabien)</p>

</body>
</html>
