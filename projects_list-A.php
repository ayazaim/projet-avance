

<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

$sql = "SELECT p.*, u.nom AS nom_etudiant, u.email AS email_etudiant FROM projets p
        JOIN utilisateurs u ON p.id_etudiant = u.id
        ORDER BY p.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tous les projets</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    table { width: 100%; border-collapse: collapse; margin: 2rem 0;}
    th, td { 
    padding: 15px; 
    border: 1px solid #ddd; 
    text-align: left;
    font-size: 1.08em;
}
    th { background: #1e3c72; color: white;}
    tr:nth-child(even) { background: #f4f4f4;}
  </style>
</head>
<body>
<header>
  <div class="logo">Espace Admin</div>
  <nav>
    <ul>
      <li><a href="dashboard.php">Accueil</a></li>
      <li><a href="projects_list.php">Tous les projets</a></li>
      <li><a href="users_list.php">Utilisateurs</a></li>
      <li><a href="stats.php">Statistiques</a></li>
      <li><a class="btn-connexion" href="../logout.php">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<div class="container" style="max-width:100vw; width:95vw;">

  <div class="form-title">Tous les projets étudiants</div>
  <table>
    <tr>
      <th>Titre</th>
      <th>Catégorie</th>
      <th>Type</th>
      <th>Étudiant</th>
      <th>Email</th>
      <th>Statut</th>
      <th>Action</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['titre']) ?></td>
          <td><?= htmlspecialchars($row['categorie']) ?></td>
          <td><?= htmlspecialchars($row['type_projet']) ?></td>
          <td><?= htmlspecialchars($row['nom_etudiant']) ?></td>
          <td><?= htmlspecialchars($row['email_etudiant']) ?></td>
          <td>
            <?php if ($row['valide']): ?>
              <span style="color:green;font-weight:bold;">Validé</span>
            <?php else: ?>
              <span style="color:orange;font-weight:bold;">En attente</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="project_details.php?id=<?= $row['id'] ?>" class="btn secondary">Détails</a>
            <!-- On pourra ajouter ici des actions admin, comme supprimer ou exporter -->
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;">Aucun projet trouvé.</td></tr>
    <?php endif; ?>
  </table>
</div>
</body>
</html>
