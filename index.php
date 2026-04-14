<?php
include 'db_connect.php'; // make sure this has your mysqli connection
session_start();
if (empty($_SESSION['user_ID']) && empty($_SESSION['mun_code']) && empty($_SESSION['brgy'])) {
    header("Location: error.html");
}
$mun_code = $_SESSION['mun_code'];
$brgy_session = $_SESSION['brgy'];
$mun_desc = $_SESSION['mun_desc'];
?>

<!doctype html>

<?php
include 'header_link.php';
?>

<body>

    <div id="mytask-layout" class="theme-indigo">

        <?php include 'sidebar.php'; ?>


        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <?php include 'topbar.php'; ?>

            <?php
            $home = 'home';

            // if ($user_id == '1') {
            // $home = 'home';
            // } else {
            //   $home = 'incoming';
            // }
            $page = isset($_GET['page']) ? $_GET['page'] : $home;
            if (!file_exists($page . ".php")) {
                include '404.html';
            } else {
                include $page . '.php';
            }
            ?>

            <!-- Modal Members-->

        </div>
    </div>



</body>

</html>

<?php
// include 'footer_script.php';
?>
<script>
    $(document).on("click", ".delete_property", function() {
        let record_id = $(this).data("id");

        if (!confirm("Are you sure you want to delete this record?")) return;

        $.ajax({
            url: "ajax.php?action=delete_property",
            type: "POST",
            data: {
                id: record_id
            },
            success: function(response) {
                alert(response); // ✅ shows success/error message
                location.reload(); // refresh table or remove row dynamically
            },
            error: function() {
                alert("❌ AJAX error occurred");
            }
        });
    });
</script>