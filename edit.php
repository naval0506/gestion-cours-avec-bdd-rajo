<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM cours WHERE id=$id");
    $cours = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $classe_id = $_POST['classe_id'];
    $date_creation = $_POST['date_creation'];
    $contenu_video = $_POST['contenu_video'];

    $sql = "UPDATE cours 
            SET titre='$titre', classe_id=$classe_id, date_creation='$date_creation', contenu_video='$contenu_video' 
            WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Cours mis à jour avec succès";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$classes_result = $conn->query("SELECT * FROM classes");
?>

<h2>Modifier le cours</h2>
<form method="post" action="">
    <label>Titre du cours:</label>
    <input type="text" name="titre" value="<?php echo $cours['titre']; ?>" required><br>
    <label>Classe:</label>
    <select name="classe_id" required>
        <?php while ($classe = $classes_result->fetch_assoc()): ?>
            <option value="<?php echo $classe['id']; ?>" <?php if ($classe['id'] == $cours['classe_id']) echo 'selected'; ?>>
                <?php echo $classe['nom']; ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    <label>Date de création:</label>
    <input type="date" name="date_creation" value="<?php echo $cours['date_creation']; ?>" required><br>
    <label>Contenu Vidéo (lien):</label>
    <input type="text" name="contenu_video" value="<?php echo $cours['contenu_video']; ?>" require
