<?php
require_once 'php/php_class.php';
// $stats = getPropertyStats($mun_code, $brgy_session);
$noTodayTransaction = totalTodayTransaction($_SESSION['user_ID']);

$totalPrev      = $stats['total_rows'] ?? 0;
$totalMun       = $stats['total_mun_rows']  ?? 0;
$totalBrgy      = $stats['total_mun_brgy_rows']  ?? 0;
$totalCompleted = $stats['total_faas_rows']  ?? 0;
$totalTodayTransaction = $noTodayTransaction['total_today'] ?? 0;

?>

<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row g-3 mb-3 row-deck">
            <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar lg  rounded-1 no-thumbnail bg-lightyellow color-defult"><i class="bi bi-journal-check fs-4"></i></div>
                            <div class="flex-fill ms-4">
                                <div class="">Today's Task</div>
                                <h5 class="mb-0 ">100</h5>
                            </div>
                            <a href="task.html" title="view-members" class="btn btn-link text-decoration-none  rounded-1"><i class="icofont-hand-drawn-right fs-2 "></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar lg  rounded-1 no-thumbnail bg-lightblue color-defult"><i class="bi bi-list-check fs-4"></i></div>
                            <div class="flex-fill ms-4">
                                <div class="">Completed Task</div>
                                <h5 class="mb-0 ">76</h5>
                            </div>
                            <a href="task.html" title="space-used" class="btn btn-link text-decoration-none  rounded-1"><i class="icofont-hand-drawn-right fs-2 "></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar lg  rounded-1 no-thumbnail bg-lightgreen color-defult"><i class="bi bi-clipboard-data fs-4"></i></div>
                            <div class="flex-fill ms-4">
                                <div class="">Pending Task</div>
                                <h5 class="mb-0 ">574</h5>
                            </div>
                            <a href="task.html" title="renewal-date" class="btn btn-link text-decoration-none  rounded-1"><i class="icofont-hand-drawn-right fs-2 "></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row End -->

        <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 row-cols-xxl-4">
            <div class="col">
                <div class="card bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <i class="icofont-data fs-3"></i>
                        <div class="d-flex flex-column ms-3">
                            <h6 class="mb-0">Previous (2022)</h6>
                            <span class="text-white"><?= $totalPrev ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <i class="icofont-chart-flow fs-3"></i>
                        <div class="d-flex flex-column ms-3">
                            <h6 class="mb-0"><?= $mun_desc ?></h6>
                            <span class="text-white"><?= $totalMun ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <i class="icofont-chart-flow-2 fs-3"></i>
                        <div class="d-flex flex-column ms-3">
                            <h6 class="mb-0">Brgy. <?= $brgy_session ?></h6>
                            <span class="text-white"><?= $totalBrgy ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <i class="icofont-tasks fs-3"></i>
                        <div class="d-flex flex-column ms-3">
                            <h6 class="mb-0">Revision (2026)</h6>
                            <span class="text-white"><?= $totalCompleted ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-3 row-deck">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <div class="info-header">
                            <h6 class="mb-0 fw-bold ">Project Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PIN</th>
                                    <th>Name of Owner</th>
                                    <th>Location of Property</th>
                                    <th>Lot #</th>
                                    <th>Date of Transaction</th>
                                    <th>Trancode</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $results = getPropertiesByBarangay($mun_code, $brgy_session, 1);
                                $counter = 1;
                                while ($row = $results->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= htmlspecialchars($row['PIN']) ?></td>
                                        <td><?= htmlspecialchars($row['NAME OF OWNER']) ?></td>
                                        <td><?= htmlspecialchars($row['LOCATION OF PROPERTY'] . ' ' . $mun_desc) ?></td>
                                        <td><?= htmlspecialchars($row['CADASTRAL LOT NUMBER']) ?></td>
                                        <td><?= htmlspecialchars($row['DATE OF TRANSACTION']) ?></td>
                                        <td><?= htmlspecialchars($row['TRANCODE']) ?></td>
                                        <td>
                                            <a href="../building_faas/building_form.php?property_ID=<?= $row['property_ID'] ?>"
                                                class="btn btn-outline-secondary">
                                                <i class="icofont-bubble-right text-success"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <div class="card bg-primary">
                            <div class="card-body row">
                                <div class="col">
                                    <span
                                        class="avatar lg bg-white rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                            class="icofont-file-text fs-5"></i></span>
                                    <h1 class="mt-3 mb-0 fw-bold text-white"><?= $totalTodayTransaction ?> </h1>
                                    <span class="text-white">Transactions</span>
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="assets/images/interview.svg"
                                        alt="interview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="recentTask" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lot #</th>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM building_desc WHERE DATE(recording_date) = CURDATE() AND recording_person_ID = ? ORDER BY recording_date DESC";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $_SESSION['user_ID']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td>
                                            <a href="ticket-detail.html" class="fw-bold text-secondary"><?= $row['ID_2022'] ?></a></a>
                                        </td>
                                        <td><?= $row['pin'] ?></a></td>
                                        <td><?= date('m/d/Y', strtotime($row['recording_date'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                <a href="../building_faas/building_form.php?building_ID=<?= $row['building_id'] ?>" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                                <a href="printable_property.php?faas_id=<?= $row['building_id'] ?>" class="btn btn-outline-secondary"><i class="icofont-eye-alt text-info"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php }

                                $conn->close(); ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Row End -->
    </div>
</div>