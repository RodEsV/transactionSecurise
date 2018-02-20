 <?php
	$service = new SoapClient("http://ntx.pcscloud.net/XCASERVER_WEB/awws/XCAServer.awws?wsdl");
?>

<script type="text/javascript">
    function afficher()
	{
        document.getElementById("matrice").innerHTML=localStorage.getItem("INSACVL:<?php echo $_POST['username']; ?>");
        document.getElementById('hideMatrice').style.display='block';
        document.getElementById('displayMatrice').style.display='none';
    }

    function masquer()
	{
		document.getElementById("matrice").innerHTML="";
        document.getElementById('hideMatrice').style.display='none';
        document.getElementById('displayMatrice').style.display='block';
    }

    function getMatrix()
	{ 
        <?php
			$result = $service->__soapCall("DOWNLOAD_CLIENTMATRIX", array('sServiceName' => 'INSACVL', 'sElementID' => $_POST['username'], 'sActivationCode' => 'TJQPJQ15QFWP'));
        ?>
        localStorage.setItem("INSACVL:<?php echo $_POST['username']; ?>", "<?php echo $result;?>");
        document.getElementById('displayMatrice').style.display='block';

        <?php
			$suite = "25 36 12 3 45 89";
			$response = "000000";
			$temp=explode(" ",$suite);

			$response[0] = $result[$temp[0]];

			$response[1] = $result[$temp[1]];
			$response[2] = $result[$temp[2]];
			$response[3] = $result[$temp[3]];
			$response[4] = $result[$temp[4]];
			$response[5] = $result[$temp[5]];
        ?>
        console.log("<?php echo $response; ?>");
         
		<?php
			$response = hash("sha256", $response);
			$result = $service->__soapCall("SEND_CLIENT_RESPONSE", array('sSessionVar' => 'groupe3', 'sServiceName' => 'INSACVL', 'sElementName' => $name, 'sClientResponse' => $response));
		?> 
		document.getElementById('deco').style.display='block';
		// Empreinte
        document.getElementById('hash').innerHTML="<?php echo $response;?>"; 
    }
</script>


<button type="button" id="getMatrice" onClick="getMatrix()" style="display:none">Matrice</button>
<button type="button" id="displayMatrice" onclick="afficher()" style="display:none">Afficher</button>
<button type="button" id="hideMatrice" onclick="masquer()" style="display:none">Masquer</button>

<p id="matrice"></p>
<form action="deco.php" method="post" >
    <input id="deco" type="submit" value="Se deconnecter" style="display:none" />
</form>

<p id="hash"></p>

<?php
if (isset($_POST['username'])){
     

    $result=$service->__soapCall("ISEXIST_ELEMENTSERVICE_XCAJAX", array('sServiceName' => 'INSACVL', 'sElementName' => $_POST['username'], 'sSessionVar' => 'groupe3'));
    if ($result == True){
        echo 'Identification OK';
        ?>
        <script type="text/javascript">

            document.getElementById('getMatrice').style.display='block';
        </script>
        
<?php }else {

echo 'Identification KO';

} } ?>