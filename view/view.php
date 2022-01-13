<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pagetitle; ?></title>
    </head>

    <style>
    ul>li+li {
        margin-left: 10px;
    }
    </style>

    <body>
        <header>
            <div>SUNRAY</div>
            <?php 
            if (isset($_SESSION['user'])) { ?>
                <div>Bonjour <?=$_SESSION['user']->getName()?></div>
            <?php } ?>

            <ul style="display: flex; list-style-type: none;">


                <li><a href="index.php?action=readAll&controller=glasses"> Liste des lunettes </a></li>

                <?php
                if (isset($_SESSION['user'])) { 
                    if($_SESSION['user']->getIsAdmin() == 0) { ?>
                            <li><a href="index.php?action=read&controller=cart"> Votre panier </a></li>
                        <?php
                        }
                    } ?>
                
                <!-- (ADMIN) Liste des clients -->

                <?php
                if (isset($_SESSION['user'])) {
                    if($_SESSION['user']->getIsAdmin() == 1) { ?>
                        <li><a href="index.php?action=readAll&controller=user"> Liste des clients </a></li>
                    <?php
                    }
                } ?>

                <!-- (ADMIN) Créer un article -->

                <?php
                if (isset($_SESSION['user'])) {
                    if($_SESSION['user']->getIsAdmin() == 1) { ?>
                        <li><a href="index.php?action=create&controller=glasses"> Créer un article </a></li>
                    <?php
                    }
                } ?>

                <!-- (ADMIN & VISITEUR) Créer un compte -->
                
                <?php
                if (isset($_SESSION['user'])) {
                    if($_SESSION['user']->getIsAdmin() == 1) { ?>
                        <li><a href="index.php?action=create&controller=user"> Créer un utilisateur </a></li>
                    <?php 
                    }
                } 
                else { ?>
                        <li><a href="index.php?action=create&controller=user"> S'inscrire </a></li>
                <?php 
                } ?>
                
                    
                <!-- (VISITEUR) Se connecter -->
                
                <?php
                if (!isset($_SESSION['user'])) { ?>
                    <li><a href="index.php?action=connect&controller=user"> Se connecter </a></li>
                <?php
                } 
                else { ?>
                    <li><a href="index.php?action=disconnect&controller=user"> Se déconnecter </a></li>
                <?php
                } ?>


                <!-- (CLIENT) Mon profil 
                <? /*php $isUpdating=true */?>
                <li><a href="index.php?action=update&controller=user"> Mon profil </a></li> -->

            </ul>

        </header>
        
        <?php
            require File::build_path(array("view", static::$object, "$view.php"));
        ?>

        <p style="border: 1px solid black;text-align:right;padding-right:1em;">
        Site officiel de SUNRAY
        </p>


    </body>
</html>
