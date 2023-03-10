<?php
session_start();
require_once '../connexion.php';
include_once './header-admin.php';

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $genre = $_POST['genre'];
    $public = $_POST['public'];
    $title = $_POST['title'];
    $volume = $_POST['volume'];
    $editor = $_POST['editor'];
    $published_at = $_POST['published_at'];
    $author = $_POST['author'];
    $extract = $_POST['extract'];

    $reqSend = $db->prepare("UPDATE `manga`  SET `id_genre`=:genre, `id_public`=:public, `title`=:title, `volume`=:volume, `editor`=:editor, `published_at`=:published_at, `author`=:author, `extract`=:extract WHERE `id`=:id");
    $reqSend->bindParam(':id', $id, PDO::PARAM_INT);
    $reqSend->bindParam(':genre', $genre, PDO::PARAM_INT);
    $reqSend->bindParam(':public', $public, PDO::PARAM_INT);
    $reqSend->bindParam(':title', $title, PDO::PARAM_STR);
    $reqSend->bindParam(':volume', $volume, PDO::PARAM_INT);
    $reqSend->bindParam(':editor', $editor, PDO::PARAM_STR);
    $reqSend->bindParam(':published_at', $published_at, PDO::PARAM_STR);
    $reqSend->bindParam(':author', $author, PDO::PARAM_STR);
    $reqSend->bindParam(':extract', $extract, PDO::PARAM_STR);

    $reqSend->execute();

    $_SESSION['sucess'] = "Produit éditer avec succès !";
    header('Location: ./list.php');
    exit();

}

$req = $db->prepare("SELECT `id`, `id_genre`, `id_public`, `title`, `volume`, `editor`, `published_at`, `author`,`extract` FROM `manga` WHERE `id`  = :id");
$req->bindParam('id', $id, PDO::PARAM_INT);
$req->execute();

while ($article = $req->fetch(PDO::FETCH_ASSOC)) {
?>

    <section class="new-post">
        <form action="./list.php" method="POST">
            <fieldset class="manga-info">
                <legend>Modification des informations de : <?= $article['title'] ?>, tome.<?= $article['volume'] ?></legend>
                <div>
                    <label for="genre">Genre</label>
                    <select name="genre" id="genre">
                        <?php
                        $sql = "SELECT `id`,`name` FROM `genre`";
                        $req = $db->query($sql);
                        while ($genre = $req->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $genre['id'] ?>"><?= $genre['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <div>
                    <label for="public">Publique</label>
                    <select name="public" id="public">
                        <?php
                        $sql = "SELECT `id`,`name` FROM `public`";
                        $req = $db->query($sql);
                        while ($public = $req->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $public['id'] ?>"><?= $public['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <div>
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" value="<?= $article['title'] ?>">
                </div>
                <br>
                <div>
                    <label for="volume">Tome</label>
                    <input type="text" name="volume" id="volume" value="<?= $article['volume'] ?>">
                </div>
                <br>
                <div>
                    <label for="editor">Editeur</label>
                    <input type="text" name="editor" id="editor" value="<?= $article['editor'] ?>">
                </div>
                <br>
                <div>
                    <label for="published_at">Date de publication</label>
                    <input type="text" name="published_at" id="published_at" value="<?= $article['published_at'] ?>">
                </div>
                <br>
                <div>
                    <label for="author">Auteur</label>
                    <input type="text" name="author" id="author" value="<?= $article['author'] ?>">
                </div>
                <br>
                <div>
                    <label for="extract">Résumé</label>
                    <textarea name="extract" id="extract" cols="50" rows="10"><?= $article['extract'] ?></textarea>
                    <span>N'oubliez pas de selectionner les champs "Genre" et "Publique"!</span>
                </div>
                
            </fieldset>
            <input type="reset" name="reset" value="Annuler">
            <input type="submit" name="submit" value="Envoyer">

        <?php } ?>
        </form>
        </div>
    </section>
    </main>
    <script src="../asset/js/header-admin.js"></script>
    </body>

    </html>