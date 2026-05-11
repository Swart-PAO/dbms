<?php
date_default_timezone_set('Asia/Manila');
require_once 'php/php_class.php';
// includes/property_functions.php
// $barangays = getBarangayProgress($mun_code);
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
                                    <h6 class="mb-0 fw-bold ">Top Encoder</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-2">
                                            <p>You have 50 <span class="fw-bold">Encoder </span> registered in this system.</p>
                                            <div class="d-flex  justify-content-between text-center">
                                                <div class="">
                                                    <h3 class="fw-bold">350</h3>
                                                    <span class="small">Highest Record</span>
                                                </div>
                                                <div class="">
                                                    <h3 class="fw-bold">130</h3>
                                                    <span class="small">FAAS Encoded</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-10 mt-5">

                                            <style>
                                                .top-performer-wrapper {
                                                    position: relative;
                                                    overflow: hidden;
                                                }

                                                /* LEFT SHADOW */
                                                .top-performer-wrapper::before,
                                                .top-performer-wrapper::after {
                                                    content: "";
                                                    position: absolute;
                                                    top: 0;
                                                    width: 20px;
                                                    height: 100%;
                                                    z-index: 5;
                                                    pointer-events: none;
                                                }

                                                .top-performer-wrapper::before {
                                                    left: 0;
                                                    background: linear-gradient(to right,
                                                            rgba(255, 255, 255, 1),
                                                            rgba(255, 255, 255, 0));
                                                }

                                                /* RIGHT SHADOW */
                                                .top-performer-wrapper::after {
                                                    right: 0;
                                                    background: linear-gradient(to left,
                                                            rgba(255, 255, 255, 1),
                                                            rgba(255, 255, 255, 0));
                                                }

                                                .top-performer-carousel {
                                                    display: flex;
                                                    overflow-x: auto;
                                                    gap: 1rem;
                                                    scroll-behavior: smooth;
                                                    padding-bottom: 10px;

                                                    /* hide scrollbar */
                                                    scrollbar-width: none;
                                                    cursor: grab;
                                                    user-select: none;
                                                }

                                                .top-performer-carousel.active {
                                                    cursor: grabbing;
                                                }

                                                .top-performer-carousel::-webkit-scrollbar {
                                                    display: none;
                                                }

                                                /* 6 cards visible */
                                                .top-performer-card {
                                                    flex: 0 0 calc(100% / 6 - 1rem);
                                                    min-width: 180px;
                                                }

                                                .top-performer-card .card {
                                                    transition: transform 0.3s ease;
                                                }

                                                .top-performer-card .card:hover {
                                                    transform: translateY(-5px);
                                                }

                                                @media (max-width: 1400px) {
                                                    .top-performer-card {
                                                        flex: 0 0 calc(100% / 4 - 1rem);
                                                    }
                                                }

                                                @media (max-width: 992px) {
                                                    .top-performer-card {
                                                        flex: 0 0 calc(100% / 3 - 1rem);
                                                    }
                                                }

                                                @media (max-width: 768px) {
                                                    .top-performer-card {
                                                        flex: 0 0 calc(100% / 2 - 1rem);
                                                    }
                                                }

                                                @media (max-width: 576px) {
                                                    .top-performer-card {
                                                        flex: 0 0 100%;
                                                    }
                                                }
                                            </style>

                                            <div class="top-performer-wrapper">
                                                <div class="top-performer-carousel" id="topCarousel">

                                                    <?php for ($i = 0; $i < 6; $i++) { ?>

                                                        <div class="top-performer-card">
                                                            <div class="card shadow">
                                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                    <img class="avatar lg rounded-circle img-thumbnail mx-auto"
                                                                        src="assets/images/lg/avatar2.jpg" alt="profile">
                                                                    <h6 class="fw-bold my-2 small-14">Luke Short</h6>
                                                                    <span class="text-muted mb-2">@Short</span>
                                                                    <h4 class="fw-bold text-primary fs-3">80%</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="top-performer-card">
                                                            <div class="card shadow">
                                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                    <img class="avatar lg rounded-circle img-thumbnail mx-auto"
                                                                        src="assets/images/lg/avatar5.jpg" alt="profile">
                                                                    <h6 class="fw-bold my-2 small-14">John Hard</h6>
                                                                    <span class="text-muted mb-2">@rdacre</span>
                                                                    <h4 class="fw-bold text-primary fs-3">70%</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="top-performer-card">
                                                            <div class="card shadow">
                                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                    <img class="avatar lg rounded-circle img-thumbnail mx-auto"
                                                                        src="assets/images/lg/avatar8.jpg" alt="profile">
                                                                    <h6 class="fw-bold my-2 small-14">Paul Rees</h6>
                                                                    <span class="text-muted mb-2">@Rees</span>
                                                                    <h4 class="fw-bold text-primary fs-3">77%</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="top-performer-card">
                                                            <div class="card shadow">
                                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                    <img class="avatar lg rounded-circle img-thumbnail mx-auto"
                                                                        src="assets/images/lg/avatar9.jpg" alt="profile">
                                                                    <h6 class="fw-bold my-2 small-14">Rachel Parr</h6>
                                                                    <span class="text-muted mb-2">@Parr</span>
                                                                    <h4 class="fw-bold text-primary fs-3">85%</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="top-performer-card">
                                                            <div class="card shadow">
                                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                    <img class="avatar lg rounded-circle img-thumbnail mx-auto"
                                                                        src="assets/images/lg/avatar12.jpg" alt="profile">
                                                                    <h6 class="fw-bold my-2 small-14">Eric Reid</h6>
                                                                    <span class="text-muted mb-2">@Eric</span>
                                                                    <h4 class="fw-bold text-primary fs-3">95%</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="top-performer-card">
                                                            <div class="card shadow">
                                                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                                                    <img class="avatar lg rounded-circle img-thumbnail mx-auto"
                                                                        src="assets/images/lg/avatar3.jpg" alt="profile">
                                                                    <h6 class="fw-bold my-2 small-14">Jan Ince</h6>
                                                                    <span class="text-muted mb-2">@Ince</span>
                                                                    <h4 class="fw-bold text-primary fs-3">97%</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </div>

                                            <script>
                                                const carousel = document.getElementById('topCarousel');

                                                // DUPLICATE ITEMS FOR INFINITE EFFECT
                                                carousel.innerHTML += carousel.innerHTML;

                                                // AUTO SCROLL
                                                let autoScroll = setInterval(() => {
                                                    carousel.scrollLeft += 1;

                                                    // RESET FOR INFINITE LOOP
                                                    if (carousel.scrollLeft >= carousel.scrollWidth / 2) {
                                                        carousel.scrollLeft = 0;
                                                    }
                                                }, 20);

                                                // DRAG FUNCTIONALITY
                                                let isDown = false;
                                                let startX;
                                                let scrollLeft;

                                                carousel.addEventListener('mousedown', (e) => {
                                                    isDown = true;
                                                    carousel.classList.add('active');
                                                    startX = e.pageX - carousel.offsetLeft;
                                                    scrollLeft = carousel.scrollLeft;

                                                    clearInterval(autoScroll);
                                                });

                                                carousel.addEventListener('mouseleave', () => {
                                                    isDown = false;
                                                    carousel.classList.remove('active');
                                                    startAutoScroll();
                                                });

                                                carousel.addEventListener('mouseup', () => {
                                                    isDown = false;
                                                    carousel.classList.remove('active');
                                                    startAutoScroll();
                                                });

                                                carousel.addEventListener('mousemove', (e) => {
                                                    if (!isDown) return;

                                                    e.preventDefault();

                                                    const x = e.pageX - carousel.offsetLeft;
                                                    const walk = (x - startX) * 2;

                                                    carousel.scrollLeft = scrollLeft - walk;
                                                });

                                                // TOUCH SUPPORT
                                                carousel.addEventListener('touchstart', () => {
                                                    clearInterval(autoScroll);
                                                });

                                                carousel.addEventListener('touchend', () => {
                                                    startAutoScroll();
                                                });

                                                function startAutoScroll() {
                                                    autoScroll = setInterval(() => {
                                                        carousel.scrollLeft += 1;

                                                        if (carousel.scrollLeft >= carousel.scrollWidth / 2) {
                                                            carousel.scrollLeft = 0;
                                                        }
                                                    }, 20);
                                                }
                                            </script>

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

                                            <?php
                                            //  while ($row = $barangays->fetch_assoc()):
                                            //     $faas = (int)$row['faas_total'];
                                            //     $info = (int)$row['info_total'];
                                            //     $percentage = ($info > 0) ? ($faas / $info) * 100 : 0;

                                            //     $barClass = match (true) {
                                            //         $percentage >= 80 => 'bg-lightgreen',
                                            //         $percentage >= 60 => 'light-success-bg',
                                            //         $percentage >= 40 => 'light-orange-bg',
                                            //         default => 'bg-lightyellow'
                                            //     };
                                            ?>
                                            <!-- <div class="progress-count mb-4">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <h6 class="fw-bold"><?= htmlspecialchars($row['barangay']) ?></h6>
                                                        <span class="small text-muted"><?= $faas ?>/<?= $info ?></span>
                                                    </div>
                                                    <div class="progress" style="height:10px">
                                                        <div class="progress-bar <?= $barClass ?>"
                                                            style="width: <?= round($percentage, 2) ?>%"></div>
                                                    </div>
                                                </div> -->
                                            <?php
                                            //  endwhile; 
                                            ?>


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
                                                <?php
                                                $sql = "SELECT 
        u.name,
        GROUP_CONCAT(m.mun_desc ORDER BY m.mun_desc SEPARATOR ', ') AS municipalities
    FROM user u
    LEFT JOIN municipality m 
        ON FIND_IN_SET(m.mun_code, u.assigned_municipal)
    GROUP BY u.name
";

                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <div class="py-2 d-flex align-items-center border-bottom">

                                                            <div class="d-flex ms-2 align-items-center flex-fill">
                                                                <img src="assets/images/xs/avatar6.jpg"
                                                                    class="avatar lg rounded-circle img-thumbnail"
                                                                    alt="avatar">

                                                                <div class="d-flex flex-column ps-2">
                                                                    <h6 class="fw-bold mb-0"><?= $row['name'] ?></h6>

                                                                    <span class="small text-muted">
                                                                        <?= $row['municipalities'] ?: 'No municipality assigned'; ?>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <button type="button"
                                                                class="btn light-danger-bg text-end"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#dremovetask">
                                                                Remove
                                                            </button>
                                                        </div>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<p class='text-muted ms-2'>No members assigned</p>";
                                                }
                                                ?>

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