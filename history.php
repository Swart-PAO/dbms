<?php
date_default_timezone_set('Asia/Manila');
require_once 'php/php_class.php';
// includes/property_functions.php
$barangays = getBarangayProgress($mun_code);
$activities = getRecentActivities();

?>

<body>

    <div id="mytask-layout" class="theme-indigo">

        <div class="main px-lg-4 px-md-4">

            <!-- Body: Body -->
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-5">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Task Activity</h3>
                                <!-- <div class="col-auto d-flex w-sm-100">
                                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#createtask"><i class="icofont-plus-circle me-2 fs-6"></i>Create Task</button>
                                </div> -->
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-5">
                        <div class="col-md-12">
                            <div class="card light-danger-bg">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">Top Perfrormers</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-2">
                                            <p>You have 140 <span class="fw-bold">influencers </span> in your company.</p>
                                            <div class="d-flex  justify-content-between text-center">
                                                <div class="">
                                                    <h3 class="fw-bold">350</h3>
                                                    <span class="small">New Task</span>
                                                </div>
                                                <div class="">
                                                    <h3 class="fw-bold">130</h3>
                                                    <span class="small">Task Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-10 mt-5">
                                            <div class="row g-3 row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-6 row-deck top-perfomer">
                                                <div class="col">
                                                    <div class="card shadow">
                                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                                            <img class="avatar lg rounded-circle img-thumbnail mx-auto" src="assets/images/lg/avatar2.jpg" alt="profile">
                                                            <h6 class="fw-bold my-2 small-14">Luke Short</h6>
                                                            <span class="text-muted mb-2">@Short</span>
                                                            <h4 class="fw-bold text-primary fs-3">80%</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card shadow">
                                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                                            <img class="avatar lg rounded-circle img-thumbnail mx-auto" src="assets/images/lg/avatar5.jpg" alt="profile">
                                                            <h6 class="fw-bold my-2 small-14">John Hard</h6>
                                                            <span class="text-muted mb-2">@rdacre</span>
                                                            <h4 class="fw-bold text-primary fs-3">70%</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card shadow">
                                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                                            <img class="avatar lg rounded-circle img-thumbnail mx-auto" src="assets/images/lg/avatar8.jpg" alt="profile">
                                                            <h6 class="fw-bold my-2 small-14">Paul Rees</h6>
                                                            <span class="text-muted mb-2">@Rees</span>
                                                            <h4 class="fw-bold text-primary fs-3">77%</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card shadow">
                                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                                            <img class="avatar lg rounded-circle img-thumbnail mx-auto" src="assets/images/lg/avatar9.jpg" alt="profile">
                                                            <h6 class="fw-bold my-2 small-14">Rachel Parr</h6>
                                                            <span class="text-muted mb-2">@Parr</span>
                                                            <h4 class="fw-bold text-primary fs-3">85%</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card shadow">
                                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                                            <img class="avatar lg rounded-circle img-thumbnail mx-auto" src="assets/images/lg/avatar12.jpg" alt="profile">
                                                            <h6 class="fw-bold my-2 small-14">Eric Reid</h6>
                                                            <span class="text-muted mb-2">@Eric</span>
                                                            <h4 class="fw-bold text-primary fs-3">95%</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card shadow">
                                                        <div class="card-body text-center d-flex flex-column justify-content-center">
                                                            <img class="avatar lg rounded-circle img-thumbnail mx-auto" src="assets/images/lg/avatar3.jpg" alt="profile">
                                                            <h6 class="fw-bold my-2 small-14">Jan Ince</h6>
                                                            <span class="text-muted mb-2">@Ince</span>
                                                            <h4 class="fw-bold text-primary fs-3">97%</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->


                    <div class="row clearfix  g-3 mb-3">
                        <div class="col-lg-12 col-md-12 flex-column">
                            <div class="row g-3 row-deck">
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-header py-3">
                                            <h6 class="mb-0 fw-bold ">Brgy</h6>
                                        </div>
                                        <div class="card-body mem-list">
                                            <?php while ($row = $barangays->fetch_assoc()):
                                                $faas = (int)$row['faas_total'];
                                                $info = (int)$row['info_total'];
                                                $percentage = ($info > 0) ? ($faas / $info) * 100 : 0;

                                                $barClass = match (true) {
                                                    $percentage >= 80 => 'bg-lightgreen',
                                                    $percentage >= 60 => 'light-success-bg',
                                                    $percentage >= 40 => 'light-orange-bg',
                                                    default => 'bg-lightyellow'
                                                };
                                            ?>
                                                <div class="progress-count mb-4">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <h6 class="fw-bold"><?= htmlspecialchars($row['barangay']) ?></h6>
                                                        <span class="small text-muted"><?= $faas ?>/<?= $info ?></span>
                                                    </div>
                                                    <div class="progress" style="height:10px">
                                                        <div class="progress-bar <?= $barClass ?>"
                                                            style="width: <?= round($percentage, 2) ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>


                                            <div class="progress-count mb-4">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold d-flex align-items-center">Quality Assurance</h6>
                                                    <span class="small text-muted">02/07</span>
                                                </div>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar light-success-bg"
                                                        role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="progress-count mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold d-flex align-items-center">Development</h6>
                                                    <span class="small text-muted">01/05</span>
                                                </div>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar light-orange-bg" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="progress-count mb-4">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold d-flex align-items-center">Testing</h6>
                                                    <span class="small text-muted">01/08</span>
                                                </div>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-lightyellow" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-header py-3">
                                            <h6 class="mb-0 fw-bold">Recent Activity</h6>
                                        </div>
                                        <div class="card-body mem-list">
                                            <?php
                                            include 'db_connect.php'; // DB connection

                                            // time ago function
                                            function timeAgo($datetime)
                                            {
                                                $time = strtotime($datetime);
                                                $diff = time() - $time;

                                                if ($diff < 60) return $diff . " Sec ago";
                                                elseif ($diff < 3600) return floor($diff / 60) . " Min ago";
                                                elseif ($diff < 86400) return floor($diff / 3600) . " Hr ago";
                                                elseif ($diff < 604800) return floor($diff / 86400) . " Day ago";
                                                else return date("M d, Y", $time);
                                            }

                                            // Fetch recent activities with user info
                                            $sql = "SELECT user_history.*, user.name FROM user_history JOIN user ON user.user_id = user_history.user_id ORDER BY created_at DESC LIMIT 10";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    // Get first letter of username
                                                    $initial = strtoupper(substr($row['name'], 0, 1));

                                                    // Timeline class based on action
                                                    $actionClass = "ti-info"; // default
                                                    switch (strtolower($row['action'])) {
                                                        case "delete":
                                                            $actionClass = "ti-danger";
                                                            break;
                                                        case "add":
                                                            $actionClass = "ti-info";
                                                            break;
                                                        case "insert":
                                                            $actionClass = "ti-success";
                                                            break;
                                                        case "update":
                                                            $actionClass = "ti-warning";
                                                            break;
                                                    }

                                                    // Avatar bg color based on target_table
                                                    $avatarClass = "bg-light"; // default
                                                    switch (strtolower($row['target_table'])) {
                                                        case "faas_property":
                                                            $avatarClass = "light-success-bg";
                                                            break;
                                                        case "user":
                                                            $avatarClass = "bg-careys-pink";
                                                            break;
                                                    }
                                            ?>
                                                    <div class="timeline-item <?= $actionClass ?> border-bottom ms-2">
                                                        <div class="d-flex">
                                                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle <?= $avatarClass ?>">
                                                                <?= $initial ?>
                                                            </span>
                                                            <div class="flex-fill ms-3">
                                                                <div class="mb-1">
                                                                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                                                                    <span class="text-muted"> - <?= htmlspecialchars($row['action']) ?></span>
                                                                    <?php if (!empty($row['description'])): ?>
                                                                        <div class="text-muted small"><?= htmlspecialchars($row['description']) ?></div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <span class="d-flex text-muted"><?= timeAgo($row['created_at']) ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } else {
                                                echo "<p class='text-muted ms-2'>No recent activity</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
                                    <div class="card">
                                        <div class="card-header py-3">
                                            <h6 class="mb-0 fw-bold ">Allocated Task Members</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="flex-grow-1 mem-list">
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar6.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Lucinda Massey</h6>
                                                            <span class="small text-muted">Ui/UX Designer</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end" data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                                </div>
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar4.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Ryan Nolan</h6>
                                                            <span class="small text-muted">Website Designer</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end" data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                                </div>
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar9.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Oliver Black</h6>
                                                            <span class="small text-muted">App Developer</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end" data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                                </div>
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar10.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Adam Walker</h6>
                                                            <span class="small text-muted">Quality Checker</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end">Remove</button>
                                                </div>
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar4.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Brian Skinner</h6>
                                                            <span class="small text-muted">Quality Checker</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end" data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                                </div>
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar11.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Dan Short</h6>
                                                            <span class="small text-muted">App Developer</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end" data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                                </div>
                                                <div class="py-2 d-flex align-items-center border-bottom">

                                                    <div class="d-flex ms-2 align-items-center flex-fill">
                                                        <img src="assets/images/xs/avatar3.jpg" class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                        <div class="d-flex flex-column ps-2">
                                                            <h6 class="fw-bold mb-0">Jack Glover</h6>
                                                            <span class="small text-muted">Ui/UX Designer</span>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn light-danger-bg text-end" data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- .card: My Timeline -->
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>

</body>

</html>