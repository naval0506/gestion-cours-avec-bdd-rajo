<?php
include 'db.php';

$sql = "SELECT cours.id, cours.titre, classes.nom as classe, cours.date_creation, cours.contenu_video 
        FROM cours 
        JOIN classes ON cours.classe_id = classes.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f8f8f8;
            color: #555;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .actions a {
            margin-right: 10px;
            color: #007BFF;
        }
        .actions a:hover {
            color: #0056b3;
        }
        .add-course {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .add-course:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Liste des Cours</h2>
<a class="add-course" href="create.php">Ajouter un nouveau cours</a>

<table>
    <tr>
        <th>Titre</th>
        <th>Classe</th>
        <th>Date de Création</th>
        <th>Contenu Vidéo</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['titre']); ?></td>
        <td><?php echo htmlspecialchars($row['classe']); ?></td>
        <td><?php echo htmlspecialchars($row['date_creation']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['contenu_video']); ?>">Voir la vidéo</a></td>
        <td class="actions">
            <a href="edit.php?id=<?php echo $row['id']; ?>">Modifier</a>
            <a href="delete.php?id=<?php echo $row['id']; ?>">Supprimer</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>