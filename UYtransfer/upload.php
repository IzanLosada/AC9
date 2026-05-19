<?php
include 'header.php';

$nom = $_POST['username'] ?? '';
$arxiu_temporal = $_FILES['file']['tmp_name'];
$nom_original = $_FILES['file']['name'];
$mida_arxiu = $_FILES['file']['size'];

$extensio = strtolower(pathinfo($nom_original, PATHINFO_EXTENSION));
$extensions_permeses = array('pdf', 'png', 'jpg', 'rar', 'zip');
$mida_maxima = 10 * 1024 * 1024;

$error = null;

// Punt 4: Validació d'extensió i mida
if (!in_array($extensio, $extensions_permeses)) {
    $error = "Format no vàlid. Només es permeten arxius PDF, PNG, JPG, RAR o ZIP.";
} elseif ($mida_arxiu > $mida_maxima) {
    $error = "L'arxiu supera la mida màxima permesa de 10 MB.";
}

// Punt 5: Validació de l'email si l'usuari vol rebre correu
$enviar_mail = isset($_POST['enviar_mail']) && $_POST['enviar_mail'] == '1';
$email = trim($_POST['email'] ?? '');

if ($enviar_mail && $error === null) {
    if (strpos($email, '@') === false) {
        header('Location: index.php?error_mail=1');
        exit;
    }
}

if ($error === null) {
    $nom_nou = date('Ymd') . rand(10000, 99999) . '.' . $extensio;
    $ruta_desti = 'files/' . $nom_nou;
    move_uploaded_file($arxiu_temporal, $ruta_desti);

    // Construïm l'URL completa
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base = dirname($_SERVER['PHP_SELF']);
    $url_descarrega = $protocol . '://' . $host . rtrim($base, '/') . '/' . $ruta_desti;

    // Punt 6: Guardar l'URL en una cookie (1 setmana)
    $cookies_actuals = isset($_COOKIE['ultims_arxius']) ? json_decode($_COOKIE['ultims_arxius'], true) : [];
    if (!is_array($cookies_actuals)) $cookies_actuals = [];
    $cookies_actuals[] = $url_descarrega;
    // Limitem a les últimes 20 entrades per no sobrecarregar la cookie
    $cookies_actuals = array_slice($cookies_actuals, -20);
    setcookie('ultims_arxius', json_encode($cookies_actuals), time() + (7 * 24 * 60 * 60), '/');

    // Missatge de benvinguda
    if (!empty($nom)) {
        $missatge = "Hola " . htmlspecialchars($nom) . ", usa aquest enllaç per compartir el teu arxiu:";
    } else {
        $missatge = "Ei tu!! Usa aquest enllaç per compartir el teu arxiu:";
    }

    // Punt 5: Enviar correu si cal
    if ($enviar_mail) {
        $cos = trim($_POST['cos_missatge'] ?? '');
        if (empty($cos)) {
            $cos = "Sorpresa!! Alguien ha compartido un archivo contigo.";
        }
        $assumpte = "Arxiu compartit amb tu";
        $cos_mail = $cos . "\n\nEnllaç de descàrrega: " . $url_descarrega;
        $headers = "From: no-reply@uyTransfer.local";
        mail($email, $assumpte, $cos_mail, $headers);
    }
}
?>

<div style="text-align: center; padding: 20px;">
    <?php if ($error === null): ?>
        <div style="font-size: 50px; color: green; margin-bottom: 15px;">✔️</div>
        <h2>Arxiu pujat amb èxit!</h2>
        <p><?php echo $missatge; ?></p>
        <p style="background: #e8f8f5; padding: 15px; border: 1px dashed green; font-weight: bold;">
            <a href="<?php echo htmlspecialchars($url_descarrega); ?>" target="_blank" style="color: green;">
                <?php echo htmlspecialchars($url_descarrega); ?>
            </a>
        </p>
        <?php if ($enviar_mail): ?>
            <p style="color: #555;">📧 S'ha enviat l'enllaç a <strong><?php echo htmlspecialchars($email); ?></strong></p>
        <?php endif; ?>
    <?php else: ?>
        <div style="font-size: 50px; color: red; margin-bottom: 15px;">❌</div>
        <h2 style="color: red;">No s'ha pogut pujar l'arxiu</h2>
        <p style="font-weight: bold; color: #555;"><?php echo $error; ?></p>
    <?php endif; ?>

    <p style="margin-top: 30px;">
        <a href="index.php">Torna a l'inici per pujar un altre arxiu</a>
        &nbsp;|&nbsp;
        <a href="ultims_arxius.php">Els meus últims arxius</a>
    </p>
</div>

</div> </body>
</html>
