<?php
require_once 'includes/bootstrap.php';
require_login();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientName = trim($_POST['client_name'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $yearLevel = trim($_POST['year_level'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $personnel = trim($_POST['personnel'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    if ($clientName === '' || $studentId === '' || $email === '' || $contact === '' || $program === '' || $yearLevel === '' || $date === '' || $time === '' || $service === '' || $personnel === '') {
        $error = 'Please complete all required school appointment fields.';
    } else {
        $_SESSION['appointments'][] = [
            'id' => generate_appointment_id(),
            'client_name' => $clientName,
            'student_id' => $studentId,
            'email' => $email,
            'contact' => $contact,
            'program' => $program,
            'year_level' => $yearLevel,
            'date' => $date,
            'time' => $time,
            'service' => $service,
            'personnel' => $personnel,
            'notes' => $notes,
            'status' => 'Pending'
        ];

        $_SESSION['flash_success'] = 'School appointment request submitted successfully.';
        header('Location: appointments.php');
        exit;
    }
}

$appointments = $_SESSION['appointments'];
usort($appointments, function ($a, $b) {
    return strtotime($a['date'] . ' ' . $a['time']) <=> strtotime($b['date'] . ' ' . $b['time']);
});
$calendar = month_calendar_details($appointments);

$pageTitle = 'CampusBook | Appointments';
$currentPage = 'appointments';
include 'includes/header.php';
?>
<section class="section">
    <div class="container">
        <div class="page-header">
            <div>
                <span class="eyebrow">School Appointment Management</span>
                <h1>Student Booking Form, Schedule, Records, and Calendar</h1>
                <p>Use this page to request school appointments and review all student booking information in one place.</p>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>

        <div class="appointments-layout">
            <div class="card form-card" id="booking-form">
                <h3>Book a School Appointment</h3>
                <form method="POST" action="">
                    <div class="grid-two">
                        <div>
                            <label>Full Name</label>
                            <input type="text" name="client_name" value="<?= htmlspecialchars($_SESSION['demo_user']['full_name']) ?>">
                        </div>
                        <div>
                            <label>Student ID</label>
                            <input type="text" name="student_id" value="<?= htmlspecialchars($_SESSION['demo_user']['student_id'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="grid-two">
                        <div>
                            <label>School Email Address</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['demo_user']['email']) ?>">
                        </div>
                        <div>
                            <label>Contact Number</label>
                            <input type="text" name="contact" value="<?= htmlspecialchars($_SESSION['demo_user']['contact']) ?>">
                        </div>
                    </div>

                    <div class="grid-two">
                        <div>
                            <label>Program / Course</label>
                            <input type="text" name="program" value="<?= htmlspecialchars($_SESSION['demo_user']['program'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Year Level</label>
                            <select name="year_level">
                                <option value="">Select year level</option>
                                <?php foreach (['1st Year', '2nd Year', '3rd Year', '4th Year'] as $level): ?>
                                    <option value="<?= htmlspecialchars($level) ?>" <?= (($_SESSION['demo_user']['year_level'] ?? '') === $level) ? 'selected' : '' ?>><?= htmlspecialchars($level) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grid-two">
                        <div>
                            <label>Appointment Date</label>
                            <input type="date" name="date">
                        </div>
                        <div>
                            <label>Appointment Time</label>
                            <input type="time" name="time">
                        </div>
                    </div>

                    <div class="grid-two">
                        <div>
                            <label>Office Service</label>
                            <select name="service">
                                <option value="">Select school service</option>
                                <?php foreach (school_services() as $service): ?>
                                    <option value="<?= htmlspecialchars($service) ?>"><?= htmlspecialchars($service) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label>Assigned Staff / Officer</label>
                            <select name="personnel">
                                <option value="">Select personnel</option>
                                <?php foreach (school_personnel() as $personnel): ?>
                                    <option value="<?= htmlspecialchars($personnel) ?>"><?= htmlspecialchars($personnel) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <label>Notes / Reason for Appointment</label>
                    <textarea name="notes" rows="4" placeholder="Enter your concern, request, or purpose of visit"></textarea>

                    <button type="submit" class="btn btn-primary full">Submit Appointment Request</button>
                </form>
            </div>

            <div class="right-stack">
                <div class="card" id="schedule">
                    <div class="card-title-row">
                        <h3>Upcoming School Schedule</h3>
                        <span class="tag">Preview</span>
                    </div>
                    <div class="schedule-list">
                        <?php foreach (array_slice($appointments, 0, 4) as $appointment): ?>
                            <div class="schedule-item">
                                <div>
                                    <strong><?= htmlspecialchars(date('g:i A', strtotime($appointment['time']))) ?></strong>
                                    <p><?= htmlspecialchars($appointment['client_name']) ?></p>
                                </div>
                                <span><?= htmlspecialchars($appointment['service']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card" id="calendar">
                    <div class="card-title-row">
                        <h3>School Appointment Calendar</h3>
                        <span class="tag"><?= htmlspecialchars($calendar['month_label']) ?></span>
                    </div>
                    <div class="calendar-grid">
                        <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day): ?>
                            <div class="calendar-day-label"><?= $day ?></div>
                        <?php endforeach; ?>
                        <?php for ($i = 1; $i <= $calendar['days_in_month']; $i++): ?>
                            <?php $marked = in_array($i, $calendar['marked_days'], true); ?>
                            <div class="calendar-cell <?= $marked ? 'has-event' : '' ?>">
                                <?= $i ?>
                                <?php if ($marked): ?><span class="dot"></span><?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card table-card" id="records">
            <div class="card-title-row">
                <h3>Student Appointment Records</h3>
                <span class="tag"><?= count($appointments) ?> Total</span>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Office Service</th>
                            <th>Assigned Personnel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['id']) ?></td>
                                <td><?= htmlspecialchars($appointment['client_name']) ?></td>
                                <td><?= htmlspecialchars($appointment['student_id'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars(date('F d, Y', strtotime($appointment['date']))) ?></td>
                                <td><?= htmlspecialchars(date('g:i A', strtotime($appointment['time']))) ?></td>
                                <td><?= htmlspecialchars($appointment['service']) ?></td>
                                <td><?= htmlspecialchars($appointment['personnel']) ?></td>
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
