document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('appointmentDate');
    const timeContainer = document.getElementById('time-container');
    const timeOptions = document.getElementById('time-options');

    dateInput.addEventListener('change', function() {
        if (dateInput.value) {
            fetchAvailableTimeSlots(dateInput.value);
            timeContainer.classList.remove('hidden');
        } else {
            timeContainer.classList.add('hidden');
        }
    });

    async function fetchAvailableTimeSlots(date) {
        try {
            const response = await fetch(`getUnavailableTimes.php?date=${date}`);
            const data = await response.json();
            updateTimeOptions(data.unavailableTimes);
        } catch (error) {
            console.error('Error fetching time slots:', error);
        }
    }

    function updateTimeOptions(unavailableTimes) {
        timeOptions.innerHTML = '<option value="">Select a time</option>'; // Clear existing options and add default

        const timeSlots = [
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

        timeSlots.forEach(slot => {
            const option = document.createElement('option');
            option.value = slot;
            option.textContent = slot;

            if (unavailableTimes.includes(slot)) {
                option.disabled = true; // Disable booked slots
                option.classList.add('dot-red'); // Add red dot
            } else {
                option.classList.add('dot-green'); // Add green dot
            }

            timeOptions.appendChild(option);
        });
    }
});


// Function to update summary
function updateSummary() {
    // Get values from form
    var carPlateNo = document.getElementById("carPlateNo").value;
    var carBrand = document.getElementById("carBrand").value;
    var carModel = document.getElementById("carModel").value;
    var carYear = document.getElementById("carYear").value;
    var services = document.querySelectorAll('input[name="services"]:checked');
    var selectedServices = [];
    services.forEach(function(service) {
        selectedServices.push(service.nextElementSibling.textContent);
    });
    var remarks = document.getElementById("remark").value;
    var appointmentDate = document.getElementById("appointmentDate").value;
    var appointmentTime = document.getElementById("appointmentTime").value;
    var serviceCenter = document.querySelector('input[name="serviceCenter"]:checked').value;

    // Construct summary HTML
    var summaryHTML = "<div class='summary-box'>";
    summaryHTML += "<h4>SERVICE APPOINTMENT DATE & TIME</h4>";
    summaryHTML += "<p>" + appointmentDate + ", " + appointmentTime + "</p>";
    summaryHTML += "<h4>SERVICE CENTER LOCATION</h4>";
    summaryHTML += "<p> Service Center " + serviceCenter + " <br> " + getSelectedAddress(serviceCenter) + "</p>";
    summaryHTML += "<h4>CAR DETAILS</h4>";
    summaryHTML += "<p> " + carYear + ", " + carModel + ", " + carBrand + ", " + carPlateNo + "</p>";
    summaryHTML += "<h4>OTHER SERVICES PREFERENCE</h4>";
    summaryHTML += "<p>" + selectedServices.join(", ") + "</p>";
    summaryHTML += "<h4>REMARKS</h4>";
    summaryHTML += "<p>" + remarks + "</p>";
    summaryHTML += "</div>";

    // Update summary content
    document.getElementById("summary-content").innerHTML = summaryHTML;
}

// Get selected service center's address
function getSelectedAddress(serviceCenter) {
    if (serviceCenter === "Rawang") {
        return "G-1 & 1-1, Jalan 1, <br> Taman Bukit Rawang Jaya 2, <br> 48000 Rawang, <br> Selangor.";
    } else if (serviceCenter === "Puncak Alam") {
        return "17B, Jalan Tiaj 2/1, <br> Taman Industri Alam Jaya, <br> 42300 Puncak Alam,<br> Selangor.";
    }
}

// Attach event listener to form elements for updating summary
var formElements = document.querySelectorAll("#step-1 input, #step-1 select, #step-2 input[type=checkbox], #step-3 input[type=radio], #step-3 input[type=date], #step-3 select");
formElements.forEach(function(element) {
    element.addEventListener("change", updateSummary);
});

// Initially update summary
updateSummary();
