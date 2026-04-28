<?php
include 'db_connect.php';

$sql = "SELECT * FROM `user` ORDER BY name ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 
        $current_uid = $row['user_ID'];

        $totalSql = "SELECT COUNT(*) AS total FROM faas_property WHERE recording_person_id = '$current_uid'";
        $totalRes = $conn->query($totalSql);
        $totalData = $totalRes->fetch_assoc();

        $todaySql = "SELECT COUNT(*) AS today FROM faas_property 
                    WHERE recording_person_id = '$current_uid' 
                    AND DATE(recording_date) = CURDATE()";
        $todayRes = $conn->query($todaySql);
        $todayData = $todayRes->fetch_assoc();

        $recentSql = "SELECT faas_property.property_brgy, municipality.mun_desc AS municipality_name FROM faas_property JOIN municipality ON faas_property.property_municipality = municipality.mun_ID WHERE faas_property.recording_person_id = '$current_uid' AND DATE(faas_property.recording_date) = CURDATE() ORDER BY faas_property.recording_date DESC LIMIT 1";

        $recentRes = $conn->query($recentSql);
        $recentData = $recentRes->fetch_assoc();

        $workingOn = ($recentData) 
        ? $recentData['property_brgy'] . ", " . $recentData['municipality_name']
    : "No Recent Activity";
?>

<style>
.team-ribbon-cut {
    width: 150px;
    position: absolute;
    top: 0;
    left: 0;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: #fff;
    padding: 6px 20px;
    font-size: 12px;
    font-weight: 600;
    clip-path: polygon(0% 0%, 100% 0%, 75% 100%, 0% 100%);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
</style>

<div class="col-md-4 col-sm-6 mb-4">
    <div class="card border-success h-100 shadow-sm">
        <div class="team-ribbon-cut"> TEAM:
            <?= htmlspecialchars($row['team']) ?>
        </div>
        <div class="card-body text-center position-relative">
            <span class="position-absolute top-0 end-0 m-2 badge bg-success">Online</span>

            <img src="<?= !empty($row['picture']) ? 'php/uploads/'.$row['picture'] : 'https://ui-avatars.com/api/?name='.urlencode($row['name']).'&background=random' ?>" 
                 class="rounded-circle shadow-sm mb-3"
                 style="width:80px;height:80px;object-fit:cover;">

            <h6 class="fw-bold"><?= htmlspecialchars($row['name']) ?></h6>
            <small class="text-muted fw-bold"><?= htmlspecialchars($row['role']) ?></small>

            <div class="card mt-3 border-0 shadow-sm mb-3">
                <div class="card-body p-3">

                    <!-- Working On -->
                    <div class="mb-3 d-flex flex-column align-items-start">
                        <small class="text-muted d-block">Working on</small>
                        <div class="fw-semibold text-truncate">
                            <?= htmlspecialchars($workingOn) ?>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="row text-center">

                        <div class="col-6 border-end">
                            <div class="text-muted small">Total</div>
                            <div class="fw-bold text-success fs-5">
                                <?= number_format($totalData['total']) ?>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="text-muted small">Today</div>
                            <div class="fw-bold text-primary fs-5">
                                <?= number_format($todayData['today']) ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <a href="user-transaction-records.php?user_id=<?php echo $row['user_ID']; ?>" class="btn btn-primary w-100">View Transactions</a>
        </div>
    </div>
</div>

<?php
    }
} else {
    echo "<div class='col-12 text-center'>No users found.</div>";
}

$conn->close();
?>