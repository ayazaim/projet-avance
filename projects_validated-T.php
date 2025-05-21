<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../login.html");
    exit();
}

// Récupérer tous les projets validés ou refusés
$sql = "SELECT p.*, u.nom AS nom_etudiant,
               (SELECT remarque FROM evaluations WHERE id_projet = p.id AND id_enseignant = ? ORDER BY id DESC LIMIT 1) as remarque
        FROM projets p
        JOIN utilisateurs u ON p.id_etudiant = u.id
        WHERE p.valide = 1
        ORDER BY p.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Projets validés</title>
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
  <div class="form-title">Projets validés</div>
  <table>
    <tr>
      <th>Titre</th>
      <th>Étudiant</th>
      <th>Type</th>
      <th>Catégorie</th>
      <th>Remarque</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['titre']) ?></td>
          <td><?= htmlspecialchars($row['nom_etudiant']) ?></td>
          <td><?= htmlspecialchars($row['type_projet']) ?></td>
          <td><?= htmlspecialchars($row['categorie']) ?></td>
          <td><?= htmlspecialchars($row['remarque']) ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center;">Aucun projet validé pour l’instant.</td></tr>
    <?php endif; ?>
  </table>
</div>
</body>
</html>
