<?php
// Incloem la capçalera comuna (Exercici 2)
include 'header.php';

// Inicialització de variables
$nom_usuari = isset($_POST['username']) ? trim($_POST['username']) : '';
$missatge = "";
$enllaç_descarrega = "";

// Verifiquem si s'ha pujat un arxiu correctament
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    
    // 1. Obtenir l'extensió de l'arxiu original
    $nom_original = $_FILES['file']['name'];
    $extensio = pathinfo($nom_original, PATHINFO_EXTENSION);

    // 2. Generar el nou nom: Any Actual + Mes Actual + Dia Actual + Nombre aleatori de 5 dígits
    $data_actual = date('Ymd'); // Genera format YYYYMMDD (Ex: 20260517)
    $num_aleatori = rand(10000, 99999);
    $nou_nom_arxiu = $data_actual . $num_aleatori . '.' . $extensio;

    // 3. Ruta de destí dins del directori 'files'
    $directori_desti = 'files/';
    
    // Creem el directori automàticament si no existeix per evitar errors
    if (!is_dir($directori_desti)) {
        mkdir($directori_desti, 0755, true);
    }

    $ruta_final = $directori_desti . $nou_nom_arxiu;

    // 4. Moure l'arxiu temporal a la carpeta definitiva
    if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta_final)) {
        
        // Generem la URL absoluta per compartir el link
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $enllaç_descarrega = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $ruta_final;

        // 5. Definir el missatge personalitzat segons si l'usuari ha posat el seu nom o no
        if (!empty($nom_usuari)) {
            $missatge = "Hola " . htmlspecialchars($nom_usuari) . ", usa aquest enllaç per compartir el teu arxiu:";
        } else {
            $missatge = "Ei tu!! Usa aquest enllaç per compartir el teu arxiu:";
        }
    } else {
        $missatge = "S'ha produït un error al moure l'arxiu al servidor.";
    }
} else {
    $missatge = "No s'ha rebut cap arxiu o s'ha produït un error en la pujada.";
}
?>

<div style="text-align: center; padding: 20px;">
    
    <div style="font-size: 60px; color: #2ecc71; margin-bottom: 20px;">
        ✔️
    </div>
    
    <h2>Arxiu pujat amb èxit!</h2>
    
    <p style="font-size: 16px; color: #555; margin-bottom: 25px;">
        <?php echo $missatge; ?>
    </p>

    <?php if (!empty($enllaç_descarrega)): ?>
        <div style="background-color: #e8f8f5; border: 2px dashed #2ecc71; padding: 15px; border-radius: 5px; word-break: break-all; font-weight: bold;">
            <a href="<?php echo $enllaç_descarrega; ?>" target="_blank" style="color: #1abc9c; text-decoration: none;">
                <?php echo $enllaç_descarrega; ?>
            </a>
        </div>
    <?php endif; ?>

    <p style="margin-top: 30px;">
        <a href="index.php" style="color: #34495e; text-decoration: underline; font-weight: bold;">Pujar un altre arxiu</a>
    </p>
</div>

</div> </body>
</html>