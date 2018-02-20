<!DOCTYPE HTML>
<html>

<head>
    <title>Page publique</title>
    <meta charset="utf-8">
    <meta name="description" content="165c. uniques">
</head>

<body>
	<h1>Authentification XCA - PHP</h1>
	<p>TELECHARGEMENT MATRICE</p>
    <p>
        Télécharger ma matrice
        <form action="#" method="POST">
			ID (email) : <input type="text" name="mail" size="70" maxlength="70" value="utilisateur@mondomaine.com" /><br /><br />
			Code d'activation : <input type="text" name="code" size="30" maxlength="30" /><br /><br />
            <input type="submit" value="Télécharger"/><br>
        </form>
		
        <?php

                if(isset($_POST['mail']) && isset($_POST['code']))
				{

					$mail = htmlspecialchars($_POST['mail']);
					$code = htmlspecialchars($_POST['code']);

					$wsdl = "http://ntx.pcscloud.net/XCASERVER_WEB/awws/XCAServer.awws?wsdl";

					$client = new SoapClient($wsdl);
					$param = array("sServiceName" => "INSACVL", "sElementName" => $mail, "sActivationCode" => $code);

					$results = $client->__soapCall("DOWNLOAD_CLIENTMATRIX", $param);

					if($results)
					{
						//echo $results;
						echo "Téléchargement de la matrice réussi.";
					}
					else
					{
						echo "<br>Echec du téléchargement de la matrice !";
					}
                }

	echo '<br /><br/><button onclick="localStorage.setItem(\'INSACVL\', \''.$results.'\')">Enregistrer ma matrice dans le navigateur</button>
	<br /><br />
	<button onclick="alert(localStorage.getItem(\'INSACVL\'))">Voir ma matrice</button> ';

        ?>
        </p>
	
	<a href="index.php">Retour à l'accueil</a>
</body>
</html>

