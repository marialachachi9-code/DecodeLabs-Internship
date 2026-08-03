<?php
require 'connexion.php';

// Nom sélectionné dans le menu déroulant (vide si la page vient d'être ouverte)
$eleveChoisi = $_GET['nom'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter les devoirs</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="sheet">
        <h1>Consulter les devoirs</h1>

        <form method="GET">
            <label for="nom">Nom de l'élève</label>
            <select name="nom" id="nom" onchange="this.form.submit()">
                <?php
                $eleves = $conn->query("SELECT DISTINCT nom FROM devoir ORDER BY nom");
                echo '<option value="">Sélectionnez un élève</option>';
                while ($eleve = $eleves->fetch_assoc()) {
                    $selected = ($eleve['nom'] === $eleveChoisi) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($eleve['nom']) . '" ' . $selected . '>'
                       . htmlspecialchars($eleve['nom']) . '</option>';
                }
                ?>
            </select>
        </form>

        <hr>

        <h2>Devoirs enregistrés</h2>

        <?php if ($eleveChoisi === ''): ?>

            <p>Choisis un élève dans la liste pour voir ses devoirs.</p>

        <?php else: ?>

            <table>
                <tr>
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

                <?php
                $stmt = $conn->prepare("SELECT * FROM devoir WHERE nom = ? ORDER BY date_devoir DESC");
                $stmt->bind_param("s", $eleveChoisi);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
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
                <?php else: ?>
                    <tr><td colspan="9">Aucun devoir trouvé pour cet élève.</td></tr>
                <?php endif; ?>
            </table>

            <?php $stmt->close(); ?>

        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>