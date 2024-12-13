
setInterval(function() {
    // Send an AJAX request to check for notifications
    $.ajax({
        url: 'http://localhost/New-HRMIS/fetch/check_5_years.php', 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                // Update notification badge count
                $('#notification-badge').text(data.length);

                // Update notification list
                let notificationList = '';
                data.forEach(function(notification) {
                    notificationList += `<a href="#" class="dropdown-item">${notification}</a><div class="dropdown-divider"></div>`;
                });

                $('#notification-list').html(`<span class="dropdown-item dropdown-header">${data.length} Notifications</span><div class="dropdown-divider"></div>${notificationList}`);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching notifications: ' + error);
        }
    });
}, 10000); // Check every 10 seconds
