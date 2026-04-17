<?php
require_once 'includes/bootstrap.php';
require_login();

$counts = appointment_counts();
$user = $_SESSION['demo_user'];
$recentAppointments = array_slice(array_reverse($_SESSION['appointments']), 0, 3);

$pageTitle = 'CampusBook | Dashboard';
$currentPage = 'dashboard';
include 'includes/header.php';
?>
<section class="section dashboard-top">
    <div class="container">
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>

        <div class="page-header">
            <div>
                <span class="eyebrow">Student Dashboard</span>
                <h1>Welcome back, <?= htmlspecialchars(explode(' ', $user['full_name'])[0]) ?></h1>
                <p>Here is a summary of your school appointment activity, pending requests, and campus service schedule.</p>
            </div>
            <a class="btn btn-primary" href="appointments.php">Book a School Appointment</a>
        </div>
        <br>

        <div class="card-grid four stats">
            <article class="stat-box">
                <span>Total Requests</span>
                <strong><?= $counts['total'] ?></strong>
            </article>
            <article class="stat-box">
                <span>Pending Approval</span>
                <strong><?= $counts['pending'] ?></strong>
            </article>
            <article class="stat-box">
                <span>Confirmed</span>
                <strong><?= $counts['confirmed'] ?></strong>
            </article>
            <article class="stat-box">
                <span>Completed</span>
                <strong><?= $counts['completed'] ?></strong>
            </article>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Quick Actions</h3>
                <div class="quick-links">
                    <a href="appointments.php">New Request</a>
                    <a href="appointments.php#records">Appointment List</a>
                    <a href="appointments.php#calendar">Calendar View</a>
                    <a href="appointments.php#schedule">Schedule</a>
                </div>
            </div>

            <div class="card profile-card">
                <h3>Student Profile</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
                <p><strong>Student ID:</strong> <?= htmlspecialchars($user['student_id'] ?? 'N/A') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($user['contact']) ?></p>
                <p><strong>Program:</strong> <?= htmlspecialchars($user['program'] ?? 'N/A') ?></p>
                <p><strong>Year Level:</strong> <?= htmlspecialchars($user['year_level'] ?? 'N/A') ?></p>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-title-row">
                <h3>Recent School Appointments</h3>
                <a href="appointments.php">View All</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Office Service</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentAppointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['id']) ?></td>
                                <td><?= htmlspecialchars($appointment['client_name']) ?></td>
                                <td><?= htmlspecialchars(date('F d, Y', strtotime($appointment['date']))) ?></td>
                                <td><?= htmlspecialchars(date('g:i A', strtotime($appointment['time']))) ?></td>
                                <td><?= htmlspecialchars($appointment['service']) ?></td>
                                <td><span class="status <?= strtolower($appointment['status']) ?>"><?= htmlspecialchars($appointment['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
