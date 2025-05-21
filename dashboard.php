<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../style.css">
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
<div class="container">
  <div class="form-title">Bienvenue dans l’espace administrateur !</div>
  <p style="text-align:center;">Gérez les projets, utilisateurs et statistiques de la plateforme.</p>
  <div style="text-align:center; margin-top:2rem;">
    <a href="projects_list.php" class="btn">Voir tous les projets</a>
  </div>
</div>
</body>
</html>
