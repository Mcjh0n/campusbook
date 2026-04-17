<?php
require_once 'includes/bootstrap.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Please enter both school email and password.';
    } else {
        $registeredEmail = $_SESSION['demo_user']['email'] ?? 'johnmark.student@example.com';

        if ($email === $registeredEmail) {
            $_SESSION['logged_in'] = true;
            $_SESSION['flash_success'] = 'Login successful. Welcome to your student dashboard.';
            header('Location: dashboard.php');
            exit;
        }

        $error = 'Invalid login. Use the registered school email or create a student account first.';
    }
}

$pageTitle = 'CampusBook | Login';
$currentPage = 'login';
include 'includes/header.php';
?>
<section class="section auth-section">
    <div class="container auth-grid">
        <div class="auth-info card">
            <span class="eyebrow">Student Access</span>
            <h2>Sign in to your student account</h2>
            <p>Access your student dashboard to request school appointments, review schedules, and monitor campus service records.</p>
            <ul class="feature-list">
                <li>Quick access to school services</li>
                <li>Organized student appointment records</li>
                <li>Monthly calendar of campus visits</li>
                <li>Demo account with pre-filled data</li>
            </ul>
        </div>

        <div class="card form-card">
            <h3>Student Login</h3>
            <p class="muted">Use your registered school email to continue.</p>

            <?php if ($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="alert success"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <label>School Email Address</label>
                <input type="email" name="email" placeholder="Enter your school email">

                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password">

                <button type="submit" class="btn btn-primary full">Login</button>
            </form>

            <p class="helper-text">No account yet? <a href="register.php">Create one here</a>.</p>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
