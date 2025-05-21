<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

// Statistiques utilisateurs
$nbEtudiants   = $conn->query("SELECT COUNT(*) AS n FROM utilisateurs WHERE role = 'etudiant'")->fetch_assoc()['n'];
$nbEnseignants = $conn->query("SELECT COUNT(*) AS n FROM utilisateurs WHERE role = 'enseignant'")->fetch_assoc()['n'];
$nbAdmins      = $conn->query("SELECT COUNT(*) AS n FROM utilisateurs WHERE role = 'admin'")->fetch_assoc()['n'];

// Statistiques projets
$nbProjets        = $conn->query("SELECT COUNT(*) AS n FROM projets")->fetch_assoc()['n'];
$nbProjetsValides = $conn->query("SELECT COUNT(*) AS n FROM projets WHERE valide = 1")->fetch_assoc()['n'];
$nbProjetsAttente = $conn->query("SELECT COUNT(*) AS n FROM projets WHERE valide = 0")->fetch_assoc()['n'];

// Projets par type (stage/module)
$types = [];
$req = $conn->query("SELECT type_projet, COUNT(*) as n FROM projets GROUP BY type_projet");
while ($row = $req->fetch_assoc()) {
    $types[$row['type_projet']] = $row['n'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .stats-box { display: flex; gap:30px; flex-wrap:wrap; justify-content:center; margin:2rem 0;}
    .stat { background:white; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.08); padding:30px; min-width:210px; text-align:center;}
    .stat h2 { margin:0 0 12px 0; color:#1e3c72; }
    .stat p { font-size:1.7em; font-weight:bold; margin:0;}
    .stat span { color:#888; font-size:0.95em;}
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
<div class="container" style="max-width:1100px;">
  <div class="form-title">Statistiques générales</div>
  <div class="stats-box">
    <div class="stat">
      <h2>Étudiants</h2>
      <p><?= $nbEtudiants ?></p>
      <span>Inscrits</span>
    </div>
    <div class="stat">
      <h2>Enseignants</h2>
      <p><?= $nbEnseignants ?></p>
      <span>Inscrits</span>
    </div>
    <div class="stat">
      <h2>Admins</h2>
      <p><?= $nbAdmins ?></p>
      <span>Administrateurs</span>
    </div>
    <div class="stat">
      <h2>Projets</h2>
      <p><?= $nbProjets ?></p>
      <span>Total</span>
    </div>
    <div class="stat">
      <h2>Validés</h2>
      <p><?= $nbProjetsValides ?></p>
      <span>Projets validés</span>
    </div>
    <div class="stat">
      <h2>En attente</h2>
      <p><?= $nbProjetsAttente ?></p>
      <span>Projets à valider</span>
    </div>
    <?php foreach ($types as $type => $nb): ?>
      <div class="stat">
        <h2><?= ucfirst($type) ?></h2>
        <p><?= $nb ?></p>
        <span>Projets</span>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
