
let existingNotifications = new Set();

// Function to fetch notifications
function fetchNotifications() {
    $.ajax({
        url: 'http://localhost/New-HRMIS/fetch/check_5_years.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                // Update notification badge count
                $('#notification-badge').text(data.length);

                let notificationList = '';
                data.forEach(function(notification) {
                    // Check if the notification is new
                    if (!existingNotifications.has(notification)) {
                        existingNotifications.add(notification);

                        // Highlight new notifications
                        notificationList += `
                            <a href="#" class="dropdown-item font-weight-bold text-wrap">
                                <i class="fas fa-info-circle mr-2"></i> ${notification}
                            </a>
                            <div class="dropdown-divider"></div>`;
                    } else {
                        // Display existing notifications
                        notificationList += `
                            <a href="#" class="dropdown-item text-wrap">
                                <i class="fas fa-info-circle mr-2"></i> ${notification}
                            </a>
                            <div class="dropdown-divider"></div>`;
                    }
                });

                // Update the notification list dynamically
                $('#notification-list').html(`
                    <span class="dropdown-item dropdown-header">${data.length} Notifications</span>
                    <div class="dropdown-divider"></div>
                    ${notificationList}`);
            } else {
                // No notifications case
                $('#notification-badge').text(0);
                $('#notification-list').html(`
                    <span class="dropdown-item dropdown-header">0 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-item text-muted">No notifications</span>`);

                // Clear the existing notification set
                existingNotifications.clear();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching notifications: ' + error);
        }
    });
}

// Initial load of notifications
fetchNotifications();

// Periodically check for new notifications every 10 seconds
setInterval(fetchNotifications, 10000);

// Function to fetch employees with 5+ years of service
function fetchEmployees() {
    $.ajax({
        url: 'http://localhost/New-HRMIS/fetch/fetch_employees.php', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const employeeList = $('#employee-list');
            const noEmployeesMessage = $('#no-employees');

            // Clear the existing employee list
            employeeList.empty();

            if (data.length > 0) {
                // Show the employee list
                data.forEach(function(employee) {
                    const listItem = `
                        <li class="list-group-item">
                            <strong>${employee.name}</strong>
                            (${employee.years_of_service} years)
                        </li>
                    `;
                    employeeList.append(listItem);
                });

                // Hide the "No employees" message
                noEmployeesMessage.hide();
            } else {
                // If no employees, show the "No employees" message
                noEmployeesMessage.show();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching employees: ' + error);
        }
    });
}

// Fetch employees initially
fetchEmployees();

// Periodically fetch employees every 10 seconds
setInterval(fetchEmployees, 10000);
