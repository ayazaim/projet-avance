
<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../login.html");
    exit();
}

$id_etudiant = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM projets WHERE id_etudiant = ?");
$stmt->bind_param("i", $id_etudiant);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Projets</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .project-list {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .project-item {
            border-bottom: 1px solid #ddd;
            padding: 1rem 0;
        }
        .project-item:last-child {
            border-bottom: none;
        }
        .project-item h3 {
            color: #1e3c72;
            margin-bottom: 0.3rem;
        }
        .status {
            font-weight: bold;
            color: green;
        }
        .status.pending {
            color: orange;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Portail Étudiant</div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Accueil</a></li>
            <li><a href="submit_project.php">Soumettre un projet</a></li>
            <li><a href="my_projects.php">Mes projets</a></li>
            <li><a class="btn-connexion" href="../logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<div class="project-list">
    <h2 style="text-align:center; margin-bottom: 2rem; color:#1e3c72;">Mes Projets</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="project-item">
                <h3><?= htmlspecialchars($row['titre']) ?></h3>
                <p><strong>Catégorie :</strong> <?= htmlspecialchars($row['categorie']) ?></p>
                <p><strong>Type :</strong> <?= htmlspecialchars($row['type_projet']) ?></p>
                <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <p><strong>Statut :</strong> 
                    <span class="status <?= $row['valide'] ? '' : 'pending' ?>">
                        <?= $row['valide'] ? 'Validé' : 'En attente' ?>
                    </span>
                </p>
                <?php if (!$row['valide']): ?>
    <div style="margin-top: 15px;">
        <a href="edit_project.php?id=<?= $row['id'] ?>" class="btn secondary">Modifier</a>
    </div>
<?php endif; ?>

                
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Aucun projet soumis pour le moment.</p>
    <?php endif; ?>
</div>

</body>
</html>
