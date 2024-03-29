<?php
include_once './connexion.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kitsuthèque</title>
    <link rel="stylesheet" href="./asset/css/style-header.css">
    
    <link rel="stylesheet" href="./asset/css/style-catalogue.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="row-limit-size">
        <div id="icon">
                <a id="logo" href="./index.php"><img src="./asset/img/icon/Logo.svg" alt="logo"></a>
                <a id="catalogue" href="./catalogue.php"><img src="./asset/img/icon/icons8-livre-ouvert-50.png" alt="catalogue"></a>
                <?php
                if (isset($_SESSION['connected']) && $_SESSION['connected'] == true) {
                ?>
                    <a id="connected" href="./model/deconnexion.php">
                        <img src="./asset/img/icon/renard-orange-deconnexion.svg" alt="connected" title=" <?= $_SESSION['pseudo'];  ?> vous êtes connecter"></a>
                    <a id="pseudo" href="./dashboard-reader.php"><?= $_SESSION['pseudo'] ?></a>
                <?php } else { ?>
                    <a id="connexion" href="#"><img src="./asset/img/icon/renard-noir.svg" alt="connexion"></a>
                <?php } ?>
            </div>
            <?php
            $research= null;
            $id=1;
            
            if (isset($_GET["search"]) ) {
                $_GET["search"] = htmlspecialchars($_GET["search"]);
                
                $research = $_GET['search'];
                $research = trim($research);
                $research = strip_tags($research);
                
            } 
                if (!empty($research)) {
                    $research = strtolower($research);
                    $search_term = '%' . $research . '%';
                    $select_research = $db->prepare("SELECT DISTINCT `manga`.`id`,`manga`.`volume`,`manga`.`extract`,`manga`.`title`,`manga`.`cover` FROM `manga` 
                    INNER JOIN `genre` ON `manga`.`id_genre`=`genre`.`id`
                    INNER JOIN `public` ON `manga`.`id_public`=`public`.`id`
                    INNER JOIN `manga_category` ON `manga_category`.`id_manga`= `manga`.`id`
                    INNER JOIN `category` ON `manga_category`.`id_category`= `category`.`id`             
                    WHERE `manga`.`volume` LIKE :search_term OR `manga`.`author` LIKE :search_term OR `manga`.`title` LIKE  :search_term 
                    OR  `genre`.`slug` LIKE  :search_term OR`category`.`slug` LIKE  :search_term OR `public`.`slug` LIKE   :search_term 
                    ORDER BY id ;");
                    $select_research->bindValue(':search_term', $search_term, PDO::PARAM_STR);
                    
                    $select_research->execute();
                } else {
                    $message = "Vous devez entrer votre requete dans la barre de recherche";
                }
                
            ?>
            <div class="search-container">
                <form action="./result-search.php" method="GET">
                    <input type="search" placeholder="Rechercher" name="search">
                    <button type="submit" name='research' value="rechercher"><img src="./asset/img/icon/🦆 icon _search_.svg" alt="icon loupe"></button>
                </form>

            </div>
        </div>
    </header>
    <main>
        <section id="check_box">
            <div class="row-limit-size">
                <article class="titleDiv">
                    <h1 class="title"> &nbsp&nbsp&nbsp Résultat</h1>
                </article>        
            </div>
        </section>
        <section id="catalogues">
            <div id="articles">
                <?php               
     while($research_find = $select_research->fetch()) { ?>
        <article>
            <figure>
                <a href="./post.php?id=<?= $research_find['id'] ?>"><img src="./asset/img/premiere-page/<?= $research_find['cover'] ?>" alt="premièrepage"></a>
            </figure>
            <div class="article-content">
                <h2 class="article-title"><?= $research_find['title'] ?></h2>
                <p class="article-tome">Tome <?= $research_find['volume'] ?></p>
                
            </div>
        </article>
    <?php } ?>
    

        </section>
    </main>
    <?php
   require_once './footer.php';
   ?>
    <script src="./asset/js/ajax.js"></script>
</body>

