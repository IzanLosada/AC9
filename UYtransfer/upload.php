<?php
include 'header.php';

$nom = $_POST['username'];
$arxiu_temporal = $_FILES['file']['tmp_name'];
$nom_original = $_FILES['file']['name'];

$extensio = pathinfo($nom_original, PATHINFO_EXTENSION);

$nom_nou = date('Ymd') . rand(10000, 99999) . '.' . $extensio;

$ruta_desti = 'files/' . $nom_nou;
move_uploaded_file($arxiu_temporal, $ruta_desti);

if (!empty($nom)) {
    $missatge = "Hola " . htmlspecialchars($nom) . ", usa aquest enllaç per compartir el teu arxiu:";
} else {
    $missatge = "Ei tu!! Usa aquest enllaç per compartir el teu arxiu:";
}
?>

<div style="text-align: center; padding: 20px;">
    
    <div style="font-size: 50px; color: green; margin-bottom: 15px;">✔️</div>
    
    <h2>Arxiu pujat amb èxit!</h2>
    
    <p><?php echo $missatge; ?></p>
    
    <p style="background: #e8f8f5; padding: 15px; border: 1px dashed green; font-weight: bold;">
        <a href="<?php echo $ruta_desti; ?>" target="_blank" style="color: green;">
            <?php echo $ruta_desti; ?>
        </a>
    </p>

    <p style="margin-top: 30px;">
        <a href="index.php">Torna a l'inici per pujar un altre arxiu</a>
    </p>
</div>

</div> </body>
</html>