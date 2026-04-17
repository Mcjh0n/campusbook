<?php
session_start();

$defaultUser = [
    'full_name' => 'John Mark Fuentes',
    'student_id' => '2024-00123',
    'email' => 'johnmark.student@example.com',
    'contact' => '09123456789',
    'program' => 'BS Information Technology',
    'year_level' => '1st Year',
    'college' => 'College of Information Sciences and Computing'
];

$defaultAppointments = [
    [
        'id' => 'SA-001',
        'client_name' => 'John Mark Fuentes',
        'student_id' => '2024-00123',
        'email' => 'johnmark.student@example.com',
        'contact' => '09123456789',
        'program' => 'BS Information Technology',
        'year_level' => '1st Year',
        'date' => '2026-04-20',
        'time' => '09:00',
        'service' => 'Registrar Document Request',
        'personnel' => 'Ms. Carla Reyes',
        'notes' => 'Request for certificate of enrollment.',
        'status' => 'Pending'
    ],
    [
        'id' => 'SA-002',
        'client_name' => 'Nestor Benitez',
        'student_id' => '2024-00456',
        'email' => 'nestor.benitez@example.com',
        'contact' => '09987654321',
        'program' => 'BS Biology',
        'year_level' => '2nd Year',
        'date' => '2026-04-21',
        'time' => '10:30',
        'service' => 'Guidance Counseling',
        'personnel' => 'Mr. Daniel Cruz',
        'notes' => 'Academic counseling session.',
        'status' => 'Confirmed'
    ],
    [
        'id' => 'SA-003',
        'client_name' => 'Christian Mancao',
        'student_id' => '2023-01875',
        'email' => 'christian.mancao@example.com',
        'contact' => '09112223333',
        'program' => 'BS Information Technology',
        'year_level' => '3rd Year',
        'date' => '2026-04-22',
        'time' => '13:00',
        'service' => 'Dean Consultation',
        'personnel' => 'Dr. Elena Gomez',
        'notes' => 'Discussion about academic concerns.',
        'status' => 'Completed'
    ],
    [
        'id' => 'SA-004',
        'client_name' => 'Angela Ramos',
        'student_id' => '2025-01092',
        'email' => 'angela.ramos@example.com',
        'contact' => '09556667777',
        'program' => 'BS Agribusiness',
        'year_level' => '1st Year',
        'date' => '2026-04-23',
        'time' => '14:30',
        'service' => 'Scholarship Office Assistance',
        'personnel' => 'Ms. Teresa Tan',
        'notes' => 'Submission of scholarship requirements.',
        'status' => 'Pending'
    ]
];

if (!isset($_SESSION['demo_user'])) {
    $_SESSION['demo_user'] = $defaultUser;
}

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

if (!isset($_SESSION['appointments'])) {
    $_SESSION['appointments'] = $defaultAppointments;
}

function require_login(): void
{
    if (empty($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit;
    }
}

function appointment_counts(): array
{
    $appointments = $_SESSION['appointments'] ?? [];

    $counts = [
        'total' => count($appointments),
        'pending' => 0,
        'confirmed' => 0,
        'completed' => 0,
    ];

    foreach ($appointments as $appointment) {
        $status = strtolower($appointment['status']);
        if (isset($counts[$status])) {
            $counts[$status]++;
        }
    }

    return $counts;
}

function generate_appointment_id(): string
{
    $count = count($_SESSION['appointments'] ?? []) + 1;
    return 'SA-' . str_pad((string)$count, 3, '0', STR_PAD_LEFT);
}

function active_page(string $page, string $current): string
{
    return $page === $current ? 'active' : '';
}

function school_services(): array
{
    return [
        'Registrar Document Request',
        'Enrollment Concern',
        'Guidance Counseling',
        'Dean Consultation',
        'Scholarship Office Assistance',
        'Admission Inquiry'
    ];
}

function school_personnel(): array
{
    return [
        'Ms. Carla Reyes',
        'Mr. Daniel Cruz',
        'Dr. Elena Gomez',
        'Ms. Teresa Tan',
        'Mrs. Ana Lopez',
        'Mr. Mark Villanueva',
        'Dr. Sophia Lee'
    ];
}

function month_calendar_details(array $appointments): array
{
    $firstDate = !empty($appointments) ? $appointments[0]['date'] : date('Y-m-d');
    $monthStart = strtotime(date('Y-m-01', strtotime($firstDate)));
    $month = (int) date('n', $monthStart);
    $year = (int) date('Y', $monthStart);
    $daysInMonth = (int) date('t', $monthStart);

    $markedDays = [];
    foreach ($appointments as $appointment) {
        $appointmentMonth = (int) date('n', strtotime($appointment['date']));
        $appointmentYear = (int) date('Y', strtotime($appointment['date']));
        if ($appointmentMonth === $month && $appointmentYear === $year) {
            $markedDays[] = (int) date('j', strtotime($appointment['date']));
        }
    }

    return [
        'month_label' => date('F Y', $monthStart),
        'days_in_month' => $daysInMonth,
        'marked_days' => array_values(array_unique($markedDays))
    ];
}
