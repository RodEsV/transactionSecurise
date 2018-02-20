<h1>Mon site web</h1>
<?php
session_start();

if (isset($_SESSION['id'])){
    echo "<h2>Bienvenue dans l'espace personnel</h2><a href='deco.php'>Se deconnecter</a>";
}
else {
        ?>
        <form action="client2.php" method="post" >
            <input type="text" name="username" />
            <input type="submit" value="Se connecter" />
        </form>

        <?php

 
    
}

?>

