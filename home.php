<?php

$stats = getPropertyStats($mun_code, $brgy_session);
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
                                <div class="">Land Records</div>
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
                                <div class="">Building Records</div>
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
                                <div class="">Machinery Records</div>
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
                            <h6 class="mb-0">Property (2022)</h6>
                            <span class="text-white"><?= $totalPrev ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <i class="icofont-tasks fs-3"></i>
                        <div class="d-flex flex-column ms-3">
                            <h6 class="mb-0">Property (2026)</h6>
                            <span class="text-white"><?= $totalCompleted ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary">
                    <div class="card-body text-white d-flex align-items-center">
                        <i class="icofont-chart-flow fs-3"></i>
                        <div class="d-flex flex-column ms-3">
                            <h6 class="mb-0"><?= $mun_name ?></h6>
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

        </div>
        <div class="row g-3 mb-3 row-deck">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                        <h6 class="m-0 fw-bold">Field Apraisal and Assessment Records</h6>
                    </div>
                    <div class="card-body">
                        <div id="apex-basic-column"></div>
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
                                    <span class="text-white">Records</span>
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
                                $sql = "SELECT * FROM property_info WHERE DATE(recording_date) = CURDATE() AND recording_person_ID = ? ORDER BY recording_date DESC";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $_SESSION['user_ID']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td>
                                            <a href="ticket-detail.html" class="fw-bold text-secondary"><?= $row['lot_no'] ?></a></a>
                                        </td>
                                        <td><?= $row['revision_code'] ?></a></td>
                                        <td><?= date('m/d/Y', strtotime($row['recording_date'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                <a href="faas_form.php?new_property_ID=<?= $row['FAAS_ID'] ?>" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                                <a href="printable_property.php?property_ID=<?= $row['FAAS_ID'] ?>" class="btn btn-outline-secondary"><i class="icofont-eye-alt text-info"></i></a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php }

                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Row End -->
    </div>
</div>

<?php
// Get all municipalities
$sql = "SELECT mun_code, mun_name FROM municipality_list ORDER BY mun_code ASC";
$result = $conn->query($sql);

$categories = [];
$data2022 = [];
$data2026 = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['mun_name'];

    // Initialize all municipalities to 0
    $data2022[$row['mun_code']] = 0;
    $data2026[$row['mun_code']] = 0;
}

// 2022 data (old database)
$sql = "
    SELECT
        `MUNICIPALITY CODE` AS mun_code,
        COUNT(*) AS total_properties
    FROM `property information`
    GROUP BY `MUNICIPALITY CODE`
";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data2022[$row['mun_code']] = (int)$row['total_properties'];
}

// 2026 data (new database)
$sql = "
    SELECT
        property_municipality AS mun_code,
        COUNT(*) AS total_properties
    FROM property_info
    GROUP BY property_municipality
";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data2026[$row['mun_code']] = (int)$row['total_properties'];
}

// Convert associative arrays to indexed arrays
$data2022 = array_values($data2022);
$data2026 = array_values($data2026);
?>
<script>
    var munCategories = <?= json_encode($categories); ?>;
    var data2022 = <?= json_encode($data2022); ?>;
    var data2026 = <?= json_encode($data2026); ?>;

    var options = {
        chart: {
            height: 450,
            type: 'bar'
        },
        colors: ['#007bff', 'var(--chart-color2)'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: '2026',
            data: data2026
        }, {
            name: '2022',
            data: data2022
        }],
        xaxis: {
            categories: munCategories
        },
        yaxis: {
            title: {
                text: 'No. of Records'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " records";
                }
            }
        }
    };

    var chart = new ApexCharts(
        document.querySelector("#apex-basic-column"),
        options
    );

    chart.render();
</script>