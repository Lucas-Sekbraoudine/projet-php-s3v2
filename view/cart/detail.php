<p>Votre panier contient :</p>

<?php
    $total = 0;

    foreach ($tab as $t) {
        // $glassesId = htmlspecialchars($c->getIdGlasses());
        // $glassesQuantity = $c->getQuantity(); 
        // $glassesPrice = 0;
        // $glassesTotal = $glassesQuantity * $tab_price[$c];
        $glassesTotal = $t['quantity'] * $t['price'];
        
        echo "<p>" . $t['quantity'] . " x " . $t['id_glasses'] . " = " . $glassesTotal . "</p>";
        $total += $glassesTotal;
    }

    echo "Total de la commande = " . $total;
?>
