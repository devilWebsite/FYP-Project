<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user's phone number
$phoneQuery = "SELECT phoneNumber FROM login WHERE username = ?";
$stmt = $conn->prepare($phoneQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$phoneNumber = $user['phoneNumber'];

// Fetch appointments from carserviceapp and testdriveapp
$carServiceQuery = "SELECT serviceId, name, appointmentDate, appointmentTime, services, serviceCenter FROM carserviceapp WHERE phoneNumber = ?";
$testDriveQuery = "SELECT testDriveId, name, appointmentDate, appointmentTime FROM testdriveapp WHERE phoneNumber = ?";

$stmt1 = $conn->prepare($carServiceQuery);
$stmt1->bind_param("s", $phoneNumber);
$stmt1->execute();
$carServiceAppointments = $stmt1->get_result();

$stmt2 = $conn->prepare($testDriveQuery);
$stmt2->bind_param("s", $phoneNumber);
$stmt2->execute();
$testDriveAppointments = $stmt2->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <link rel="stylesheet" href="appoint.css">
    <style>
        .appointment {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 15px;
    margin: 10px 0;
    background-color: #f9f9f9;
    transition: box-shadow 0.3s;
}

.appointment:hover {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.appointment-details {
    list-style-type: none;
    padding: 0;
}

.appointment-details li {
    margin: 5px 0;
}

.name {
    color: #333;
    font-weight: bold;
}

.time {
    color: #666;
    font-style: italic;
}

.service {
    color: #d9534f; /* Bootstrap danger color */
}

.service-center {
    color: #5bc0de; /* Bootstrap info color */
    background-color: #e7f3f7;
    padding: 5px;
    border-radius: 3px;
}

.reschedule-button {
    background-color: #5cb85c; /* Bootstrap success color */
    color: white;
    border: none;
    border-radius: 3px;
    padding: 10px 15px;
    cursor: pointer;
    float: right;
}

.reschedule-button:hover {
    background-color: #4cae4c; /* Darker green on hover */
}

    </style>
</head>
<body>
    <header>
        <h1>Appointment Management</h1>
    </header>
    <main>
        <h2>Your Appointments</h2>
        <div id="appointments">
            <?php
            if ($carServiceAppointments->num_rows > 0) {
                echo "<h3>Car Service Appointments</h3>";
                while ($row = $carServiceAppointments->fetch_assoc()) {
                    echo "<div class='appointment' data-type='carService' data-id='" . htmlspecialchars($row['serviceId']) . "'>";
                    echo "<h4>Date: " . htmlspecialchars($row['appointmentDate']) . "</h4>";
                    echo "<ul>";
                    echo "<li>Name: " . htmlspecialchars($row['name']) . "</li>";
                    echo "<li>Time: " . htmlspecialchars($row['appointmentTime']) . "</li>";
                    echo "<li>Service: " . htmlspecialchars($row['services']) . "</li>";
                    echo "<li>Service Center: " . htmlspecialchars($row['serviceCenter']) . "</li>";
                    echo "<button id='reschedule-button'style='float: right';>Reschedule Appointment</button>";
                    echo "</ul>";
                    echo "</div>";
                    echo "<br>";
                }
            }
            
            echo "<hr>";

            if ($testDriveAppointments->num_rows > 0) {
                echo "<h3>Test Drive Appointments</h3>";
                while ($row = $testDriveAppointments->fetch_assoc()) {
                    echo "<div class='appointment' data-type='testDrive' data-id='" . $row['testDriveId'] . "'>";
                    echo "<h4>Date: " . htmlspecialchars($row['appointmentDate']) . "</h4>";
                    echo "<ul>";
                    echo "<li>Name: " . htmlspecialchars($row['name']) . "</li>";
                    echo "<li>Time: " . htmlspecialchars($row['appointmentTime']) . "</li>";
                    echo "<button id='reschedule-button'style='float: right';>Reschedule Appointment</button>";
                    echo "</div>";
                    echo "<br>";
                }
            }
            ?>
        </div>
        <button id="reschedule-button" onclick="window.location.href='index.php'" style="float: left;">Back to Home Page</button><br><br>

    </main>

    <div id="rescheduleModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h2>Reschedule Appointment</h2>
            </div>
            <div class="modal-buttons">
                <button id="rescheduleCarService">Car Service</button>
                <button id="rescheduleTestDrive">Test Drive</button>
            </div>
            <div id="rescheduleForm" style="display:none;">
                <form id="rescheduleAppointmentForm">
                    <div class="form-group">
                        <label for="appointmentType">Appointment Type</label>
                        <select id="appointmentType" name="appointmentType" required>
                            <option value="carService">Car Service</option>
                            <option value="testDrive">Test Drive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Select Date:</label>
                        <input type="date" name="newDate" id="newDate" class="date-picker" required>
                    </div>
                    <div class="form-group">
                        <label for="newTime">New Time</label>
                        <select id="newTime" name="newTime" required>
                            <!-- Time options will be populated dynamically -->
                        </select>
                    </div>
                    <input type="hidden" id="appointmentId" name="appointmentId">
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('rescheduleModal');
    const closeModal = document.getElementsByClassName('close')[0];
    const rescheduleForm = document.getElementById('rescheduleForm');
    const appointmentTypeSelect = document.getElementById('appointmentType');
    const newDateInput = document.getElementById('newDate');
    const newTimeSelect = document.getElementById('newTime');
    const appointmentIdInput = document.getElementById('appointmentId');

    const today = new Date().toISOString().split('T')[0];
    newDateInput.min = today;

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    const carServiceTimes = [
        "09:00 - 10:00",
        "10:00 - 11:00",
        "11:00 - 12:00",
        "13:00 - 14:00",
        "14:00 - 15:00",
        "15:00 - 16:00",
        "16:00 - 17:00",
        "17:00 - 18:00",
        "18:00 - 19:00"
    ];

    const testDriveTimes = [
        "09:00 - 11:00",
        "11:00 - 13:00",
        "13:00 - 15:00",
        "15:00 - 17:00"
    ];

    function populateTimeOptions(times) {
        newTimeSelect.innerHTML = '';
        times.forEach(time => {
            const option = document.createElement('option');
            option.value = time;
            option.textContent = time;
            newTimeSelect.appendChild(option);
        });
    }

    function fetchAppointmentDetails(appointmentId, appointmentType) {
        const formData = new FormData();
        formData.append('appointmentId', appointmentId);
        formData.append('appointmentType', appointmentType);

        fetch('reschedule.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const appointment = data.data;
                appointmentTypeSelect.value = appointmentType;
                newDateInput.value = appointment.appointmentDate;
                appointmentIdInput.value = appointmentId;

                if (appointmentType === 'carService') {
                    populateTimeOptions(carServiceTimes);
                } else if (appointmentType === 'testDrive') {
                    populateTimeOptions(testDriveTimes);
                }

                newTimeSelect.value = appointment.appointmentTime; // Populate the time
            } else {
                alert(`Failed to fetch appointment details: ${data.message}`);
            }
        });
    }

    document.querySelectorAll('.appointment').forEach(appointment => {
        appointment.addEventListener('click', () => {
            const type = appointment.dataset.type;
            const id = appointment.dataset.id;
            modal.style.display = 'block';
            rescheduleForm.style.display = 'block';
            fetchAppointmentDetails(id, type);
        });
    });

    document.getElementById('rescheduleAppointmentForm').addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        const appointmentType = formData.get('appointmentType');
        const newDate = formData.get('newDate');
        const newTime = formData.get('newTime');
        const appointmentId = formData.get('appointmentId');

        fetch('reschedule.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Rescheduled ${appointmentType} to ${newDate} at ${newTime}`);
                modal.style.display = 'none';
                location.reload();
            } else {
                alert(`Failed to reschedule appointment: ${data.message}`);
            }
        });
    });
});
    </script>
</body>
</html>
