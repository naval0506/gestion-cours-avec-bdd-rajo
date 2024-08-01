<?php
include 'db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $classe_id = $_POST['classe_id'];
    $date_creation = $_POST['date_creation'];
    $type_import = $_POST['type_import'];
    
    if ($type_import == 'link') {
        $contenu_video = $_POST['contenu_video_link'];
    } elseif ($type_import == 'file') {
        $target_dir = "uploads/videos/";
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["contenu_video_file"]["name"]);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array('video/mp4', 'video/avi', 'video/mov', 'video/wmv');
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES["contenu_video_file"]["tmp_name"]);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            echo "Le fichier n'est pas une vidéo.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        if ($_FILES["contenu_video_file"]["size"] > 50000000) {
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
        } else {
            if (move_uploaded_file($_FILES["contenu_video_file"]["tmp_name"], $target_file)) {
                $contenu_video = $target_file;
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                $contenu_video = null;
            }
        }
    }

    if ($contenu_video) {
        $sql = "INSERT INTO cours (titre, classe_id, date_creation, contenu_video) VALUES ('$titre', $classe_id, '$date_creation', '$contenu_video')";
        if ($conn->query($sql) === TRUE) {
            echo "Nouveau cours ajouté avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    }
}

$classes_result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un nouveau cours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h2>Ajouter un nouveau cours</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label>Titre du cours:</label>
        <input type="text" name="titre" required><br>
        
        <label>Classe:</label>
        <select name="classe_id" required>
            <?php while ($classe = $classes_result->fetch_assoc()): ?>
                <option value="<?php echo $classe['id']; ?>"><?php echo $classe['nom']; ?></option>
            <?php endwhile; ?>
        </select><br>
        
        <label>Date de création:</label>
        <input type="date" name="date_creation" required><br>
        
        <label>Type d'importation:</label>
        <select name="type_import" id="type_import" required onchange="toggleImportType()">
            <option value="link">Lien Vidéo</option>
            <option value="file">Fichier Vidéo</option>
        </select><br>
        
        <div id="link_section">
            <label>Contenu Vidéo (lien):</label>
            <input type="text" name="contenu_video_link"><br>
        </div>
        
        <div id="file_section" class="hidden">
            <label>Contenu Vidéo (fichier):</label>
            <input type="file" name="contenu_video_file" accept="video/*"><br>
        </div>
        
        <button type="submit">Ajouter</button>
    </form>

    <script>
        function toggleImportType() {
            var typeImport = document.getElementById('type_import').value;
            if (typeImport == 'link') {
                document.getElementById('link_section').style.display = 'block';
                document.getElementById('file_section').style.display = 'none';
            } else {
                document.getElementById('link_section').style.display = 'none';
                document.getElementById('file_section').style.display = 'block';
            }
        }
    </script>
</body>
</html>
