<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Official_Seal_of_Antique.svg/3840px-Official_Seal_of_Antique.svg.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>

<?php
include 'db_connect.php';

$user_id = intval($_GET['user_id'] ?? 0);

$barLabels = [];
$barData = [];

for ($i = 6; $i >= 0; $i--) {

    $date = date('Y-m-d', strtotime("-$i days"));

    $sql = "SELECT COUNT(*) AS total
            FROM faas_property
            WHERE recording_person_id = $user_id
            AND DATE(recording_date) = '$date'";

    $res = $conn->query($sql);
    $row = $res ? $res->fetch_assoc() : ['total' => 0];

    $barLabels[] = date('D', strtotime($date)); // Mon, Tue
    $barData[] = (int)$row['total'];
}

$pieLabels = [];
$pieData = [];

$sqlPie = "SELECT m.mun_desc, COUNT(*) AS total
           FROM faas_property f
           JOIN municipality m 
             ON f.property_municipality = m.mun_ID
           GROUP BY m.mun_ID
           ORDER BY total DESC";

$resPie = $conn->query($sqlPie);

if ($resPie) {
    while ($row = $resPie->fetch_assoc()) {
        $pieLabels[] = $row['mun_desc'];
        $pieData[] = (int)$row['total'];
    }
}


if (!isset($_GET['user_id'])) {
    die("No user selected.");
}

$user_id = intval($_GET['user_id']);

$UserInfo = "SELECT faas_property.recording_person_id, user.name, user.department FROM faas_property JOIN user ON faas_property.recording_person_id = user.user_ID WHERE faas_property.recording_person_id = $user_id LIMIT 1";
$UserInfoResult = $conn->query($UserInfo);
$UserInfoData = $UserInfoResult->fetch_assoc();

?>


<div class="">
    <div class="row g-0">

        <div class="col-md">
            <!-- HEADER -->
            <div class="p-3 d-flex align-items-center bg-success bg-opacity-50">
                <a class="btn btn-outline-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px; height:40px;" href="index.php">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Official_Seal_of_Antique.svg/3840px-Official_Seal_of_Antique.svg.png" class="rounded-circle me-3" width="60">
                <div>
                    <div class="fw-bold"><?= htmlspecialchars($UserInfoData['name']) ?></div>
                    <small><?= htmlspecialchars($UserInfoData['department']) ?></small>
                </div>
            </div>

            <div class="p-3">
                <div class="row g-3">
                    <!-- LEFT CONTENT -->
                    <div class="col-md-9">
                        <!-- INFO CARDS -->
                        <div class="row g-3 mb-3">

                            <?php
                            $totalSql = "SELECT COUNT(*) AS total FROM faas_property WHERE recording_person_id = '$user_id'";
                            $totalRes = $conn->query($totalSql);
                            $totalData = $totalRes->fetch_assoc();
                            ?>

                            <?php
                            $todaySql = "SELECT COUNT(*) AS today FROM faas_property WHERE recording_person_id = '$user_id' AND DATE(recording_date) = CURDATE()";

                            $todayRes = $conn->query($todaySql);
                            $todayData = $todayRes->fetch_assoc();
                            ?>

                            <div class="col-md-4 d-flex">
                                <div class="card p-3 shadow-sm w-100 h-100">
                                    <div class="d-flex justify-content-between align-items-center h-100">
                                        <div>
                                            <div class="fw-bold">Total Made Transactions</div>
                                            <h3 class="text-success mb-0"><?= number_format($totalData['total']) ?></h3>
                                        </div>
                                        <img src="https://static.vecteezy.com/system/resources/thumbnails/036/396/022/small/ai-generated-office-record-file-on-transparent-background-ai-generated-free-png.png" style="width: 60px;" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex">
                                <div class="card p-3 shadow-sm w-100 h-100">
                                    <div class="d-flex justify-content-between align-items-center h-100">
                                        <div>
                                            <div class="fw-bold">Today's Transactions</div>
                                            <h3 class="text-primary mb-0"><?= number_format($todayData['today']) ?></h3>
                                        </div>
                                        <img src="https://static.vecteezy.com/system/resources/thumbnails/048/363/552/small/success-payment-paper-receipt-document-complete-financial-money-transaction-3d-icon-realistic-png.png" style="width: 60px;" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex">
                                <div class="card p-3 shadow-sm w-100 h-100">
                                    <div class="d-flex justify-content-between align-items-center h-100">
                                        <div>
                                            <div class="fw-bold">Some Data</div>
                                            <h3 class="text-danger mb-0">----</h3>
                                        </div>
                                        <img src="https://static.vecteezy.com/system/resources/thumbnails/022/353/826/small/3d-file-icon-illustration-png.png" style="width: 60px;" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- <div class="card shadow-sm mb-3 p-3">
                            <h6>Transaction Map</h6>
                            <div id="map" style="height: 300px;"></div>
                        </div> -->
                        
                        <!-- FILTERS -->
                        <div class="card shadow-sm p-3 mb-3">
                            <div class="row g-2">
                                <div class="col-md">
                                    <label class="small fw-semibold">Municipality</label>
                                    <select class="form-select">
                                        <option selected disabled>Select</option>
                                        <option>San Jose</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label class="small fw-semibold">Barangay</label>
                                    <select class="form-select">
                                        <option selected disabled>Select</option>
                                        <option>Barangay 8</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label class="small fw-semibold">GR Type</label>
                                    <select class="form-select">
                                        <option selected disabled>Select</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label class="small fw-semibold">Date From</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label class="small fw-semibold">Date To</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label class="small fw-semibold">User</label>
                                    <select class="form-select">
                                        <option selected disabled>Select</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>

                        <!-- TABLE -->
                        <div class="card shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead class="table-success">
                                        <tr>
                                            <th>#</th>
                                            <th>PIN</th>
                                            <th>OWNER</th>
                                            <th>PROPERTY LOCATION</th>
                                            <th>LOT NO.</th>
                                            <th>TRANSACTION DATE</th>
                                            <th>TRANCODE</th>
                                            <th style="width:120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider small">
                                        <?php
                                            $Transactions = "SELECT faas_property.*, municipality.mun_desc AS municipality_name FROM faas_property JOIN municipality ON faas_property.property_municipality = municipality.mun_ID WHERE faas_property.recording_person_id = $user_id ORDER BY faas_property.recording_date DESC";
                                            $TransactionsResult = $conn->query($Transactions);
                                        ?>
                                        <?php if ($TransactionsResult && $TransactionsResult->num_rows > 0): ?>
                                            <?php $i = 1; ?>
                                            <?php while ($transaction = $TransactionsResult->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= htmlspecialchars($transaction['previous_pin']) ?></td>
                                                    <td><?= htmlspecialchars($transaction['owner_name']) ?></td>
                                                    <td><?= htmlspecialchars($transaction['property_brgy'] . ", " . $transaction['municipality_name']) ?></td>
                                                    <td><?= htmlspecialchars($transaction['lot_no']) ?></td>
                                                    <td><?= htmlspecialchars(date("Y-m-d H:i", strtotime($transaction['recording_date']))) ?></td>
                                                    <td><?= htmlspecialchars($transaction['transaction_code']) ?></td>
                                                    <td><a href="" class="btn btn-sm btn-primary">View</a></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No transactions found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT PANEL -->
                    <div class="col-md-3">
                        <!-- CHART -->
                        
                        <div class="card shadow-sm p-3 mb-3">
                            <h6>Weekly Transaction Report</h6>
                            <canvas id="chart"></canvas>
                        </div>

                        <div class="card shadow-sm p-3">
                            <h6>Municipality Overview</h6>
                            <canvas id="pie_chart"></canvas>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
window.dashboardData = {
    barLabels: <?= json_encode($barLabels) ?>,
    barData: <?= json_encode($barData) ?>,
    pieLabels: <?= json_encode($pieLabels) ?>,
    pieData: <?= json_encode($pieData) ?>
};
</script>
<script src="./assets/index.js"></script>

</body>
</html>