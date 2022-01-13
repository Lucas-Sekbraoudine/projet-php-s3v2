<?php
    foreach ($tab_g as $g) {
        echo '<p style="text-align:center;"> Lunettes ' . htmlspecialchars($g->getId()) . ' '.  htmlspecialchars($g->getTitle()) . ' ' . htmlspecialchars($g->getPrice()) . '€' . '<a href=?action=read&controller=glasses&glassesid=' . rawurlencode($g->getId()) . "> Plus d'info ici</a>.</p>";
    }
