<?php
session_start();
require_once '../Basededonnees.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../login.html");
    exit();
}

$id_projet = $_GET['id'] ?? null;

$stmt = $conn->prepare("SELECT * FROM projets WHERE id = ? AND id_etudiant = ? AND valide = 0");
$stmt->bind_param("ii", $id_projet, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$projet = $result->fetch_assoc();

if (!$projet) {
    echo "Projet introuvable ou déjà validé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier le projet</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
  <div class="logo">Portail Étudiant</div>
  <nav>
    <ul>
      <li><a href="dashboard.php">Accueil</a></li>
      <li><a href="submit_project.php">Soumettre</a></li>
      <li><a href="my_projects.php">Mes projets</a></li>
      <li><a class="btn-connexion" href="../logout.php">Déconnexion</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <div class="form-title">Modifier le projet</div>
  <form action="edit_project_process.php" method="POST">
    <input type="hidden" name="id" value="<?= $projet['id'] ?>">

    <div class="input-group">
      <input type="text" name="titre" value="<?= htmlspecialchars($projet['titre']) ?>" required placeholder=" ">
      <label>Titre du projet</label>
    </div>

    <div class="input-group">
      <input type="text" name="categorie" value="<?= htmlspecialchars($projet['categorie']) ?>" required placeholder=" ">
      <label>Catégorie</label>
    </div>

    <div class="input-group">
      <select name="type_projet" required>
        <option value="stage" <?= $projet['type_projet'] === 'stage' ? 'selected' : '' ?>>Stage</option>
        <option value="module" <?= $projet['type_projet'] === 'module' ? 'selected' : '' ?>>Module</option>
      </select>
      <label>Type de projet</label>
    </div>

    <div class="input-group">
      <textarea name="description" rows="4" style="width:100%; padding:10px;"><?= htmlspecialchars($projet['description']) ?></textarea>
      <label style="top:-20px; left:10px;">Description</label>
    </div>
    <div class="input-group">
  <label style="color:#1e3c72;">Ajouter des livrables :</label><br><br>
  <input type="file" name="livrables[]" multiple>
</div>

    <button type="submit" class="btn">Enregistrer les modifications</button>
  </form>
</div>

</body>
</html>
