<?php 
// Exercici 2: Importem la part superior comuna
include 'header.php'; 
?>

<h2>Comparteix un arxiu</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="username">El teu nom (opcional):</label>
        <input type="text" id="username" name="username" placeholder="Ex. Manolo">
    </div>

    <div class="form-group">
        <label for="file">Tria l'arxiu que vols pujar:</label>
        <input type="file" id="file" name="file" required>
    </div>

    <button type="submit">Pujar arxiu</button>
</form>

</div> </body>
</html>