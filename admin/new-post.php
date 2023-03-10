<?php
include_once '../connexion.php';
include_once './header-admin.php';

if (isset($_POST['submit'])) {
    $genre = $_POST['genre'];
    $public = $_POST['public'];
    $title = $_POST['title'];
    $volume = $_POST['volume'];
    $editor = $_POST['editor'];
    $published_at = $_POST['published_at'];
    $author = $_POST['author'];
    $extract = $_POST['extract'];

    $manga = $db->prepare("INSERT INTO `manga`( `id_genre`, `id_public`, `title`, `volume`, `editor`, `published_at`, `author`, `extract` )VALUES (:genre, :public, :title, :volume, :editor, :published_at, :author, :extract)");
    $manga->bindParam(':genre', $genre, PDO::PARAM_INT);
    $manga->bindParam(':public', $public, PDO::PARAM_INT);
    $manga->bindParam(':title', $title, PDO::PARAM_STR);
    $manga->bindParam(':volume', $volume, PDO::PARAM_INT);
    $manga->bindParam(':editor', $editor, PDO::PARAM_STR);
    $manga->bindParam(':published_at', $published_at, PDO::PARAM_STR);
    $manga->bindParam(':author', $author, PDO::PARAM_STR);
    $manga->bindParam(':extract', $extract, PDO::PARAM_STR);

    $manga->execute();
    header('Location: ./list.php');
}
?>

<section class="new-post">
        <form action="#" method="POST">
            <fieldset class="manga-info">
                <legend>Nouveau manga</legend>
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
                    <input type="text" name="title" id="title">
                </div>
                <br>
                <div>
                    <label for="volume">Tome</label>
                    <input type="text" name="volume" id="volume">
                </div>
                <br>
                <div>
                    <label for="editor">Editeur</label>
                    <input type="text" name="editor" id="editor">
                </div>
                <br>
                <div>
                    <label for="published_at">Date de publication</label>
                    <input type="date" name="published_at" id="published_at">
                </div>
                <br>
                <div>
                    <label for="author">Auteur</label>
                    <input type="text" name="author" id="author">
                </div>
                <br>
                <div>
                    <label for="extract">R??sum??</label>
                    <textarea name="extract" id="extract" cols="50" rows="5"></textarea>
                </div>
            </fieldset>
            <input type="reset" name="reset" value=" Reset ">
            <input type="submit" name="submit" value="Envoyer">
        </form>
</section>
</main>
<script src="../asset/js/header-admin.js"></script>
</body>

</html>