<?php
session_start();

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$gameEndedMessage = '';

if (isset($_SESSION['id'])) {
    // Initialiser les scores et le joueur actuel si ce n'est pas déjà fait
    if (!isset($_SESSION['scores']) || !is_array($_SESSION['scores'])) {
        $_SESSION['scores'] = [0, 0];
    }

    if (!isset($_SESSION['current_player']) || !is_int($_SESSION['current_player'])) {
        $_SESSION['current_player'] = 0; // 0 pour le joueur 1, 1 pour le joueur 2
    }

    if (!isset($_SESSION['created_at'])) {
        $_SESSION['created_at'] = date('Y-m-d H:i:s'); // Enregistre l'heure de début de la partie
    }

    // Gérer les actions du joueur
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['roll'])) {
            // Lancer le dé et mettre à jour le score
            $roll = rand(1, 6);
            $_SESSION['scores'][$_SESSION['current_player']] += $roll;
            $_SESSION['current_roll'] = $roll;
        } elseif (isset($_POST['pass'])) {
            // Le joueur passe son tour et obtient un score de 0 pour ce tour
            $_SESSION['current_roll'] = 0;
        } elseif (isset($_POST['reset'])) {
            // Réinitialiser le jeu
            $_SESSION['scores'] = [0, 0];
            $_SESSION['current_player'] = 0;
            unset($_SESSION['current_roll']);
            unset($_SESSION['created_at']);
        } elseif (isset($_POST['save'])) {
            // Sauvegarder les scores dans la base de données
            $player1_score = $_SESSION['scores'][0];
            $player2_score = $_SESSION['scores'][1];
            $created_at = $_SESSION['created_at'];
            $finished_at = date('Y-m-d H:i:s'); // Enregistre l'heure de fin de la partie

            // Préparer la requête d'insertion
            $stmt = $bdd->prepare("INSERT INTO dice_game_results (player1_score, player2_score, created_at, finished_at) VALUES (:player1_score, :player2_score, :created_at, :finished_at)");
            $stmt->bindParam(':player1_score', $player1_score, PDO::PARAM_INT);
            $stmt->bindParam(':player2_score', $player2_score, PDO::PARAM_INT);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':finished_at', $finished_at);

            // Exécuter la requête
            if ($stmt->execute()) {
                $gameEndedMessage = "Partie terminée. Scores sauvegardés avec succès dans la base de données.";
            } else {
                echo "Erreur lors de l'enregistrement des résultats.";
                print_r($stmt->errorInfo()); // Afficher les erreurs SQL
            }

            // Réinitialiser les scores après avoir enregistré dans la base de données
            $_SESSION['scores'] = [0, 0];
            $_SESSION['current_player'] = 0;
            unset($_SESSION['current_roll']);
            unset($_SESSION['created_at']);
        }

        // Passer au joueur suivant sauf si on réinitialise ou sauvegarde
        if (!isset($_POST['reset']) && !isset($_POST['save'])) {
            $_SESSION['current_player'] = 1 - $_SESSION['current_player'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu de dés</title>
    <style>
         h1{
                font-size: 30px;
                color: #fff;
                border-bottom: 3px solid #60a3bc;
                display: inline;
                text-decoration: none;
            }
           p{
            font-size: 30px;
            text-align:left;
            color: #fff;

           }
            button{
                color: #fff;
                text-decoration: none;
                padding: 5px 20px;
                background: #60a3bc;
                border-radius: 4px;
                font-size: large;
                border: 2px solid #60a3bc;
                font-weight: 500;
                transition: all 0.3 ease-in-out;
                
                
            }
            button:hover{
                color: #60a3bc;
                background: transparent;
                cursor: pointer;
            }

            body{
                background: url('https://c.pxhere.com/photos/39/47/cube_eyes_fall-1405107.jpg!d') center no-repeat;
                width: auto;
                height:100dvh;
                top :0;
                left :0;
                background-size:cover;
                opacity: 1;
            }
            .button-link {
            padding: 5px 20px;
            font-size: large;
            color: #fff;
            background-color: #60a3bc;
            border: 2px solid #60a3bc;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            transition: all 0.3 ease-in-out;
             }
            .button-link:hover {
                color: #60a3bc;
                background: transparent;
                cursor: pointer;
            }
            </style>
</head>
<body>
    <h1>Jeu de dés</h1><br><br><br>
    <p>Score du joueur 1 : <?php echo $_SESSION['scores'][0]; ?></p><br>
    <p>Score du joueur 2 : <?php echo $_SESSION['scores'][1]; ?></p><br>

    <div class="current-player">
        <p>C'est le tour du joueur <?php echo $_SESSION['current_player'] + 1; ?></p><br>
    </div>

    <?php if (isset($_SESSION['current_roll'])): ?>
        <p>Résultat du lancer : <?php echo $_SESSION['current_roll']; ?></p><br>
    <?php endif; ?>

    <?php if ($gameEndedMessage): ?>
        <p><?php echo $gameEndedMessage; ?></p>
    <?php endif; ?>

    <form method="post">
        <button type="submit" name="roll">Lancer le dé</button>
        <button type="submit" name="pass">Passer</button>
        <button type="submit" name="reset">Réinitialiser le jeu</button>
        <button type="submit" name="save">Sauvegarder</button><br><br><br>
        <a href="http://localhost:8888/3ICP/PFE/Acceuil.php" class="button-link">Quitter</a>
    </form>
</body>
</html>











