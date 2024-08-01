<?php
include 'db.php';

$message = '';
$message_type = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM cours WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Cours supprimé avec succès";
        $message_type = 'success';
    } else {
        $message = "Erreur: " . $sql . "<br>" . $conn->error;
        $message_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de cours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 18px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="message <?php echo $message_type; ?>">
        <?php echo $message; ?>
    </div>
</body>         
</html>