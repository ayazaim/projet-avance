<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../login.html");
    exit();
}

$id_projet = $_GET['id'] ?? null;

// Récupérer projet + étudiant
$stmt = $conn->prepare("SELECT p.*, u.nom AS nom_etudiant FROM projets p JOIN utilisateurs u ON p.id_etudiant = u.id WHERE p.id = ?");
$stmt->bind_param("i", $id_projet);
$stmt->execute();
$projet = $stmt->get_result()->fetch_assoc();

if (!$projet) {
    echo "Projet introuvable.";
    exit();
}

// Livrables
$stmt2 = $conn->prepare("SELECT * FROM livrables WHERE id_projet = ?");
$stmt2->bind_param("i", $id_projet);
$stmt2->execute();
$livrables = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détail du projet</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
  <div class="logo">Espace Enseignant</div>
  <nav>
    <ul>
      <li><a href="dashboard.php">Accueil</a></li>
      <li><a href="projects_list.php">Projets à valider</a></li>
            <li><a href="projects_validated.php">Projets validés</a></li>
      <li><a class="btn-connexion" href="../logout.php">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <div class="form-title">Projet : <?= htmlspecialchars($projet['titre']) ?></div>
  <p><strong>Étudiant :</strong> <?= htmlspecialchars($projet['nom_etudiant']) ?></p>
  <p><strong>Catégorie :</strong> <?= htmlspecialchars($projet['categorie']) ?></p>
  <p><strong>Type :</strong> <?= htmlspecialchars($projet['type_projet']) ?></p>
  <p><strong>Description :</strong><br><?= nl2br(htmlspecialchars($projet['description'])) ?></p>
  <p><strong>Livrables :</strong>
    <ul>
      <?php while ($liv = $livrables->fetch_assoc()): ?>
        <li>
          <a href="../<?= $liv['nom_fichier'] ?>" target="_blank"><?= basename($liv['nom_fichier']) ?></a>
        </li>
      <?php endwhile; ?>
    </ul>
  </p>
  <form method="POST" action="validate_project.php">
    <input type="hidden" name="id_projet" value="<?= $projet['id'] ?>">
    <div class="input-group">
      <textarea name="remarque" rows="3" placeholder="Ajouter une remarque..." style="width:100%;padding:10px;border:1px solid #ccc;border-radius:5px;"></textarea>
      
    </div>
    <div style="margin-top:15px; display:flex; gap:20px;">
      <button type="submit" name="action" value="valider" class="btn">Valider</button>
      <button type="submit" name="action" value="refuser" class="btn secondary">Refuser</button>
    </div>
  </form>
</div>

</body>
</html>
