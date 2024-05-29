document.getElementById('editButton').addEventListener('click', function() {
    document.getElementById('displayInfo').style.display = 'none';
    document.getElementById('editForm').style.display = 'block';
});

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Format the start and end times
    var stime = document.getElementById('start_time').value;
    const etime = document.getElementById('end_time').value;
    var formattedStartTime = formatStartTime(stime);
    var formattedEndTime = formatEndTime(etime);

    // Append formatted times to formData
    var formattedStartTime = formatStartTime(stime); 
    var formattedEndTime = formatEndTime(etime);

    fetch('edit_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'view.php'; // Redirect to view page
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

function formatStartTime(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]);
    var formattedStartTime = (hours < 10 ? '0' : '') + hours + ':00:00';
    return formattedStartTime;
}

function formatEndTime(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]);
    var formattedEndTime = (hours < 10 ? '0' : '') + hours + ':59:59';
    return formattedEndTime;
}