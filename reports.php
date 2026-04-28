<div class="container py-4">
    <div class="row g-4" id="user-container">
        <!-- Data will load here -->
    </div>
</div>

<script>
function loadUsers() {
    fetch('fetch_report_data.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('user-container').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}

loadUsers();

setInterval(loadUsers, 5000);
</script>