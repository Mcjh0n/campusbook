<?php
require_once 'includes/bootstrap.php';
$calendar = month_calendar_details($_SESSION['appointments']);
$pageTitle = 'CampusBook | Home';
$currentPage = 'home';
include 'includes/header.php';
?>
<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">School Appointment Booking System</span>
            <h1>Manage student appointments with offices, staff, and schedules in one campus platform.</h1>
            <p>CampusBook helps students request appointments with the registrar, guidance office, dean, scholarship office, and other campus services through one organized interface.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="login.php">Get Started</a>
                <a class="btn btn-outline" href="appointments.php">View Demo Records</a>
            </div>
        </div>
        <div class="hero-card">
            <div class="stat-card">
                <h3>Campus Services</h3>
                <ul class="feature-list compact">
                    <li>Student Booking Form</li>
                    <li>Office Schedule Overview</li>
                    <li>Appointment List</li>
                    <li>Monthly School Calendar</li>
                </ul>
            </div>
            <div class="mini-calendar">
                <div class="mini-calendar-header"><?= htmlspecialchars($calendar['month_label']) ?></div>
                <div class="calendar-grid small">
                    <?php foreach (['Su','Mo','Tu','We','Th','Fr','Sa'] as $day): ?>
                        <div class="calendar-day-label"><?= $day ?></div>
                    <?php endforeach; ?>
                    <?php for ($i = 1; $i <= $calendar['days_in_month']; $i++): ?>
                        <div class="calendar-cell <?= in_array($i, $calendar['marked_days'], true) ? 'has-event' : '' ?>"><?= $i ?></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">System Overview</span>
            <h2>Built for organized school appointment handling</h2>
            <p>CampusBook is a prototype school appointment booking system designed for students to easily request and track appointments with various campus offices. The platform features a student-friendly interface for submitting appointment requests, viewing office schedules, and monitoring appointment statuses.</p>
        </div>

        <div class="card-grid four">
            <article class="info-card">
                <h3>Student Booking</h3>
                <p>Students can submit appointment requests using school-based fields such as student ID, course, year level, and service type.</p>
            </article>
            <article class="info-card">
                <h3>Office Schedule</h3>
                <p>Display scheduled student visits for registrar, guidance, dean, and scholarship-related services.</p>
            </article>
            <article class="info-card">
                <h3>Request Tracking</h3>
                <p>Review all appointment requests in a table with service category, assigned personnel, and status.</p>
            </article>
            <article class="info-card">
                <h3>School Calendar</h3>
                <p>Highlight appointment dates for campus transactions in a clear monthly calendar view.</p>
            </article>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
