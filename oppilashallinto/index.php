<?php
$pdo = new PDO("mysql:host=localhost;dbname=oppilashallinto;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

if (isset($_GET['poista'])) {
    $stmt = $pdo->prepare("DELETE FROM oppilaat WHERE id = ?");
    $stmt->execute([$_GET['poista']]);
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    
    if ($id) {
        $sql = "UPDATE oppilaat SET etunimi=?, sukunimi=?, katuosoite=?, postinumero=?, kaupunki=?, sahkoposti=?, puhelin=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['etunimi'], $_POST['sukunimi'], $_POST['katuosoite'], $_POST['postinumero'], $_POST['kaupunki'], $_POST['sahkoposti'], $_POST['puhelin'], $id]);
    } else {
        $sql = "INSERT INTO oppilaat (etunimi, sukunimi, katuosoite, postinumero, kaupunki, sahkoposti, puhelin) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['etunimi'], $_POST['sukunimi'], $_POST['katuosoite'], $_POST['postinumero'], $_POST['kaupunki'], $_POST['sahkoposti'], $_POST['puhelin']]);
    }
    header("Location: index.php");
    exit;
}

$muokattava = null;
if (isset($_GET['muokkaa'])) {
    $stmt = $pdo->prepare("SELECT * FROM oppilaat WHERE id = ?");
    $stmt->execute([$_GET['muokkaa']]);
    $muokattava = $stmt->fetch();
}

$oppilaat = $pdo->query("SELECT * FROM oppilaat")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oppilashallinto</title>
</head>
<body>

<h1>Oppilaat</h1>

<form method="POST">
    <input type="hidden" name="id" value="<?= $muokattava['id'] ?? '' ?>">
    
    <label>Etunimi:</label><br>
    <input type="text" name="etunimi" value="<?= $muokattava['etunimi'] ?? '' ?>" required><br>
    
    <label>Sukunimi:</label><br>
    <input type="text" name="sukunimi" value="<?= $muokattava['sukunimi'] ?? '' ?>" required><br>
    
    <label>Katuosoite:</label><br>
    <input type="text" name="katuosoite" value="<?= $muokattava['katuosoite'] ?? '' ?>"><br>
    
    <label>Postinumero:</label><br>
    <input type="text" name="postinumero" value="<?= $muokattava['postinumero'] ?? '' ?>"><br>
    
    <label>Kaupunki:</label><br>
    <input type="text" name="kaupunki" value="<?= $muokattava['kaupunki'] ?? '' ?>"><br>
    
    <label>Sähköposti:</label><br>
    <input type="email" name="sahkoposti" value="<?= $muokattava['sahkoposti'] ?? '' ?>"><br>
    
    <label>Puhelin:</label><br>
    <input type="text" name="puhelin" value="<?= $muokattava['puhelin'] ?? '' ?>"><br><br>

    <button type="submit"><?= $muokattava ? 'Päivitä' : 'Lisää' ?></button>
    <?php if ($muokattava): ?>
        <a href="index.php">Peruuta</a>
    <?php endif; ?>
</form>

<hr>

<table border="1">
    <tr>
        <th>Nimi</th>
        <th>Osoite</th>
        <th>Sähköposti</th>
        <th>Puhelin</th>
        <th>Toiminnot</th>
    </tr>
    <?php foreach ($oppilaat as $o): ?>
    <tr>
        <td><?= htmlspecialchars($o['etunimi'] . ' ' . $o['sukunimi']) ?></td>
        <td><?= htmlspecialchars($o['katuosoite'] . ', ' . $o['postinumero'] . ' ' . $o['kaupunki']) ?></td>
        <td><?= htmlspecialchars($o['sahkoposti']) ?></td>
        <td><?= htmlspecialchars($o['puhelin']) ?></td>
        <td>
            <a href="index.php?muokkaa=<?= $o['id'] ?>">Muokkaa</a>
            <a href="index.php?poista=<?= $o['id'] ?>" onclick="return confirm('Poistetaanko?')">Poista</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>