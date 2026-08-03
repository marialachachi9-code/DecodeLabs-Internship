<?php
require 'connexion.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $classe = $_POST['classe'] ?? '';
    $matiere = $_POST['matiere'] ?? '';
    $titre = $_POST['titre'] ?? '';
    $livre = $_POST['livre'] ?? '';
    $page = $_POST['page'] ?? '';
    $exercices = $_POST['exercices'] ?? '';
    $description = $_POST['description'] ?? '';
    $date_devoir = $_POST['dateDevoir'] ?? '';
    $date_remise = $_POST['dateRemise'] ?? '';

    $sql = "INSERT INTO devoir (nom, classe, matiere, titre, livre, page, exercices, description, date_devoir, date_remise) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $message = "Erreur de préparation : " . $conn->error;
    } else {
        $stmt->bind_param(
            "ssssssssss",
            $nom,
            $classe,
            $matiere,
            $titre,
            $livre,
            $page,
            $exercices,
            $description,
            $date_devoir,
            $date_remise
        );

        if ($stmt->execute()) {
            $message = "success:Devoir enregistré avec succès.";
        } else {
            $message = "Erreur lors de l'enregistrement du devoir : " . $stmt->error;
        }
        $stmt->close();
    }
}

// Récupère tous les devoirs enregistrés pour le tableau du bas
$tousLesDevoirs = $conn->query("SELECT * FROM devoir ORDER BY date_devoir DESC");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie d'un devoir</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="sheet">
        <h1>Saisie d'un devoir</h1>

        <?php if ($message): ?>
            <?php
            $isSuccess = str_starts_with($message, 'success:');
            $texte = $isSuccess ? substr($message, 8) : $message;
            ?>
            <div class="message <?php echo $isSuccess ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($texte); ?>
            </div>
        <?php endif; ?>

        <form id="devoirForm" action="saisir_devoir.php" method="post">
            <label for="nom">Nom de l'élève</label>
            <input type="text" name="nom" id="nom" required>

            <div class="row2">
                <div>
                    <label for="classe">Classe</label>
                    <select name="classe" id="classe">
                        <option>1ère AP</option>
                        <option>2ème AP</option>
                        <option selected>3ème AP</option>
                        <option>4ème AP</option>
                        <option>5ème AP</option>
                    </select>
                </div>
                <div>
                    <label for="matiere">Matière</label>
                    <select name="matiere" id="matiere">
                        <option selected>Mathématiques</option>
                        <option>Français</option>
                        <option>Arabe</option>
                        <option>Anglais</option>
                        <option>Sciences</option>
                        <option>Histoire-Géographie</option>
                        <option>Éducation islamique</option>
                        <option>Éducation civique</option>
                    </select>
                </div>
            </div>

            <label for="titre">Titre du devoir</label>
            <input type="text" name="titre" id="titre">

            <label for="livre">Livre</label>
            <input type="text" name="livre" id="livre">

            <div class="row2">
                <div>
                    <label for="page">Numéro de page</label>
                    <input type="text" name="page" id="page">
                </div>
                <div>
                    <label for="exercices">Exercices</label>
                    <input type="text" name="exercices" id="exercices">
                </div>
            </div>

            <label for="description">Description du devoir</label>
            <textarea name="description" id="description" rows="3"></textarea>

            <div class="dates">
                <div>
                    <label for="dateDevoir">Date du devoir</label>
                    <input type="date" name="dateDevoir" id="dateDevoir">
                </div>
                <div>
                    <label for="dateRemise">Date de remise</label>
                    <input type="date" name="dateRemise" id="dateRemise">
                </div>
            </div>

            <button type="submit">Enregistrer</button>
        </form>

        <hr>

        <div class="list">
            <h2>Devoirs enregistrés</h2>

            <?php if ($tousLesDevoirs->num_rows === 0): ?>
                <p class="empty">Aucun devoir enregistré pour le moment.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Titre</th>
                            <th>Livre</th>
                            <th>Page</th>
                            <th>Exercices</th>
                            <th>Description</th>
                            <th>Date devoir</th>
                            <th>Date remise</th>
                        </tr>
                        <?php while ($row = $tousLesDevoirs->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['classe']); ?></td>
                                <td><?php echo htmlspecialchars($row['matiere']); ?></td>
                                <td><?php echo htmlspecialchars($row['titre']); ?></td>
                                <td><?php echo htmlspecialchars($row['livre']); ?></td>
                                <td><?php echo htmlspecialchars($row['page']); ?></td>
                                <td><?php echo htmlspecialchars($row['exercices']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_devoir']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_remise']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>

<?php $conn->close(); ?>