<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

$sql = "SELECT id, nom, email, role FROM utilisateurs ORDER BY role, nom";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Utilisateurs</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    table { width: 100%; border-collapse: collapse; margin: 2rem 0;}
    th, td { padding: 12px; border: 1px solid #ddd; text-align: left;}
    th { background: #1e3c72; color: white;}
    tr:nth-child(even) { background: #f4f4f4;}
    .btn-danger { background: #e74c3c; color: white; padding: 5px 10px; border-radius: 5px; border:none;}
    .btn-danger:hover { background: #c0392b; }
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
  <div class="form-title">Liste des utilisateurs</div>
  <table>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Rôle</th>
      <th>Action</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nom']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
          <td>
            <?php if ($row['role'] !== 'admin'): // ne pas supprimer un admin depuis ici ?>
            <form method="post" action="delete_user.php" onsubmit="return confirm('Supprimer cet utilisateur ?');" style="display:inline;">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button type="submit" class="btn-danger">Supprimer</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4" style="text-align:center;">Aucun utilisateur trouvé.</td></tr>
    <?php endif; ?>
  </table>
  <div style="text-align:right; margin-bottom:15px;">
  <a href="add_user.php" class="btn">Ajouter un utilisateur</a>
</div>

</div>
</body>
</html>
