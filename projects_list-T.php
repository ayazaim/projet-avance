<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../login.html");
    exit();
}

// Récupérer tous les projets non validés
$sql = "SELECT p.*, u.nom AS nom_etudiant FROM projets p JOIN utilisateurs u ON p.id_etudiant = u.id WHERE p.valide = 0 ORDER BY p.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Projets à valider</title>
  <link rel="stylesheet" href="../style.css">
  
  <style>
    table { width: 100%; border-collapse: collapse; margin: 2rem 0;}
    th, td { padding: 12px; border: 1px solid #ddd; text-align: left;}
    th { background: #1e3c72; color: white;}
    tr:nth-child(even) { background: #f4f4f4;}
  </style>
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

<div class="container" style="max-width:1100px;">
  <div class="form-title">Liste des projets à valider</div>
  <table>
    <tr>
      <th>Titre</th>
      <th>Catégorie</th>
      <th>Type</th>
      <th>Étudiant</th>
      <th>Action</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['titre']) ?></td>
          <td><?= htmlspecialchars($row['categorie']) ?></td>
          <td><?= htmlspecialchars($row['type_projet']) ?></td>
          <td><?= htmlspecialchars($row['nom_etudiant']) ?></td>
          <td><a class="btn secondary" href="project_details.php?id=<?= $row['id'] ?>">Détails</a></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center;">Aucun projet à valider.</td></tr>
    <?php endif; ?>
  </table>
</div>

</body>
</html>
