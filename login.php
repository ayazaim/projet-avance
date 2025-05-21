

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'Basededonnees.php'; // Connexion MySQLi

// Vérifie que le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Requête pour trouver l'utilisateur par email
    $stmt = $conn->prepare("SELECT id, mot_de_passe, role FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Comparer le mot de passe entré (avec SHA256)
        if (hash('sha256', $password) === $user['mot_de_passe']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirection selon le rôle
            switch ($user['role']) {
                case 'etudiant':
                    header("Location: student/dashboard.php");
                    break;
                case 'enseignant':
                    header("Location: teacher/dashboard.php");
                    break;
                case 'admin':
                    header("Location: admin/dashboard.php");
                    break;
            }
            exit();
        }
    }
    // Si erreur
    echo "Email ou mot de passe incorrect.";
} else {
    // Accès direct sans POST, on redirige vers la page de login
    header("Location: login.html");
    exit();
}
?>
