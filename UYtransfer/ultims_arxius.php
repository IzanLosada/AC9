<?php
include 'header.php';

$links = isset($_COOKIE['ultims_arxius']) ? json_decode($_COOKIE['ultims_arxius'], true) : [];
if (!is_array($links)) $links = [];
// Mostrem els més recents primer
$links = array_reverse($links);
?>

<h2>Els meus últims arxius</h2>

<?php if (empty($links)): ?>
    <p style="color:#777;">No has pujat cap arxiu durant l'última setmana.</p>
<?php else: ?>
    <ul style="list-style:none; padding:0;">
        <?php foreach ($links as $i => $url): ?>
            <li style="margin-bottom:12px; padding:12px; background:#f9f9f9; border:1px solid #ddd; border-radius:4px;">
                📄 <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" style="color:#2c3e50; word-break:break-all;">
                    <?php echo htmlspecialchars($url); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p style="margin-top:20px;">
    <a href="index.php">← Torna a l'inici</a>
</p>

</div> </body>
</html>
