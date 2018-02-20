<?php

	$wsdl = "http://ntx.pcscloud.net/XCASERVER_WEB/awws/XCASERVER.awws?wsdl";
	$service = new SoapClient($wsdl);

	$isService = $service->__soapCall("ISEXIST_SERVICE", array("ThisServiceName" =>"INSACVL"));

	if($isService)
	{
		$isElement = $service->__soapCall("ISEXIST_ELEMENT", array("ThisElementID" =>"mohammed.el_khadiri@insa-cvl.fr"));
    
		if($isElement)
		{
			$downloadClientMatrix=$service->__soapCall("DOWNLOAD_CLIENTMATRIX", array("sServiceName" =>"INSACVL", "sElementName" =>"mohammed.el_khadiri@insa-cvl.fr", "sActivationCode"=>"TJQPJQ15QFWP"));
		
			if($downloadClientMatrix)
			{
				echo "Telechargement de la matrice reussi. <p> ";
				echo "Matrice : <p> ";
				echo "$downloadClientMatrix <p>";

				$key = "18 76 64 32 5 24";
				echo "Secret key ??? : <p>";
				echo "$key <p>";

				$secretPosition = explode(" ", $key, 7);
			
				for ($i = 0; $i<=5; $i++)
				{
					$secretMatrix[$i] = $downloadClientMatrix[(int) ($secretPosition[$i])];
				}

				$secretMatrix = implode("", $secretMatrix);
				echo "Reponse au defi : <p> $secretMatrix <p> ";
				$secretMatrix = hash("sha256", $secretMatrix);
				echo "Empreinte de la reponse : <p> $secretMatrix <p>";

				$service->__soapCall("SEND_CLIENT_RESPONSE", array("sSessionVar" => "groupe2", "sServiceName" => "INSACVL", "sElementName" => "mohammed.el_khadiri@insa-cvl.fr", "sClientResponse" => $secretMatrix));
			}
			else
			{
				echo "Echec du telechargement de la matrice !";
			}
		}
	}

?>

<html>
<body>

<button id="writeMatrix" onClick="writeMatrix()">Enregistrer la matrice dans le navigateur</button>

<script type="text/javascript">
	function writeMatrix()
	{
		var matrix='<?php echo $downloadClientMatrix; ?>';
		localStorage.setItem('INSACVL2', matrix);
	}
</script>

<button id="read" onClick="read()">Lire la matrice depuis le navigateur</button>
<script type="text/javascript">
	function read()
	{
		var matrix = localStorage.getItem('INSACVL2');
		window.confirm(matrix);
	}
</script>

</body>
</html>
