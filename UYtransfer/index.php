<?php 
include 'header.php'; 
?>

<h2>Comparteix un arxiu</h2>

<?php if (isset($_GET['error_mail'])): ?>
    <div style="background:#fdecea; border:1px solid red; color:red; padding:10px; border-radius:4px; margin-bottom:15px;">
        ❌ L'adreça de correu electrònic introduïda no és vàlida.
    </div>
<?php endif; ?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="username">El teu nom (opcional):</label>
        <input type="text" id="username" name="username" placeholder="Ex. Manolo">
    </div>

    <div class="form-group">
        <label for="file">Tria l'arxiu que vols pujar:</label>
        <input type="file" id="file" name="file" required>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="enviar_mail" id="enviar_mail" value="1"
                onchange="document.getElementById('mail-opcions').style.display = this.checked ? 'block' : 'none'">
            Vull rebre l'enllaç per correu electrònic
        </label>
    </div>

    <div id="mail-opcions" style="display:none;">
        <div class="form-group">
            <label for="email">Correu electrònic:</label>
            <input type="text" id="email" name="email" placeholder="exemple@correu.com">
        </div>
        <div class="form-group">
            <label for="cos_missatge">Cos del missatge (opcional):</label>
            <input type="text" id="cos_missatge" name="cos_missatge" placeholder="Escriu un missatge personalitzat...">
        </div>
    </div>

    <button type="submit">Pujar arxiu</button>
</form>

</div> </body>
</html>
