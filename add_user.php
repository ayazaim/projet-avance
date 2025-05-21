<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $motdepasse = $_POST['motdepasse'];

    // Vérifier si l’email existe déjà
    $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Cet email existe déjà !";
    } else {
        // Hash du mot de passe pour la sécurité
        $hash = hash('sha256', $motdepasse);
        $stmt2 = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("ssss", $nom, $email, $hash, $role);
        $stmt2->execute();
        header("Location: users_list.php?add=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un utilisateur</title>
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

<div class="container" style="max-width:500px;">
  <div class="form-title">Ajouter un utilisateur</div>
  <?php if ($message): ?>
    <div style="background: #f8d7da; color: #721c24; padding:10px; border-radius:7px; margin-bottom:15px;">
      <?= $message ?>
    </div>
  <?php endif; ?>
  <form method="post" action="add_user.php">
    <div class="input-group">
      <input type="text" name="nom" required placeholder=" ">
      <label>Nom complet</label>
    </div>
    <div class="input-group">
      <input type="email" name="email" required placeholder=" ">
      <label>Email</label>
    </div>
    <div class="input-group">
      <select name="role" required>
        <option value="etudiant">Étudiant</option>
        <option value="enseignant">Enseignant</option>
        <option value="admin">Administrateur</option>
      </select>
      <label>Rôle</label>
    </div>
    <div class="input-group">
      <input type="text" name="motdepasse" required placeholder=" ">
      <label>Mot de passe</label>
    </div>
    <button type="submit" class="btn">Créer l'utilisateur</button>
    <a href="users_list.php" class="btn secondary" style="margin-top:12px;">Retour</a>
  </form>
</div>
</body>
</html>
