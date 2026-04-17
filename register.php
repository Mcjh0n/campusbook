<?php
require_once 'includes/bootstrap.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $yearLevel = trim($_POST['year_level'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($fullName === '' || $studentId === '' || $email === '' || $contact === '' || $program === '' || $yearLevel === '' || $password === '' || $confirmPassword === '') {
        $error = 'Please complete all student registration fields.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Password and confirm password do not match.';
    } else {
        $_SESSION['demo_user'] = [
            'full_name' => $fullName,
            'student_id' => $studentId,
            'email' => $email,
            'contact' => $contact,
            'program' => $program,
            'year_level' => $yearLevel,
            'college' => 'Student Account'
        ];

        $_SESSION['flash_success'] = 'Registration successful. You can now log in using your school email.';
        header('Location: login.php');
        exit;
    }
}

$pageTitle = 'CampusBook | Register';
$currentPage = 'register';
include 'includes/header.php';
?>
<section class="section auth-section">
    <div class="container auth-grid register-layout">
        <div class="auth-info card">
            <span class="eyebrow">Create Student Account</span>
            <h2>Register to request school appointments</h2>
            <p>Create your student profile to access the campus dashboard and appointment booking form.</p>
        </div>

        <div class="card form-card">
            <h3>Student Registration Form</h3>
            <p class="muted">Fill in all required student information below.</p>

            <?php if ($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="grid-two">
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="Enter full name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Student ID</label>
                        <input type="text" name="student_id" placeholder="Enter student ID" value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>">
                    </div>
                </div>

                <div class="grid-two">
                    <div>
                        <label>School Email Address</label>
                        <input type="email" name="email" placeholder="Enter school email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Contact Number</label>
                        <input type="text" name="contact" placeholder="Enter contact number" value="<?= htmlspecialchars($_POST['contact'] ?? '') ?>">
                    </div>
                </div>

                <div class="grid-two">
                    <div>
                        <label>Program / Course</label>
                        <input type="text" name="program" placeholder="Enter program or course" value="<?= htmlspecialchars($_POST['program'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Year Level</label>
                        <select name="year_level">
                            <option value="">Select year level</option>
                            <?php foreach (['1st Year', '2nd Year', '3rd Year', '4th Year'] as $level): ?>
                                <option value="<?= htmlspecialchars($level) ?>" <?= (($_POST['year_level'] ?? '') === $level) ? 'selected' : '' ?>><?= htmlspecialchars($level) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid-two">
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter password">
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary full">Create Account</button>
            </form>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
