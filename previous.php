<style>
    .barangay-folder {
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: .2s;
    }

    .barangay-folder:hover {
        background: #f5f5f5;
    }

    .barangay-folder.active {
        background: #0d6efd;
        color: white;
    }

    .barangay-folder.active i {
        color: #ffd54f !important;
    }
</style>

<div class="row">

    <!-- LEFT SIDE -->
    <div class="col-lg-4">

        <div class="card shadow-sm h-100">

            <div class="card-header">
                <h6 class="mb-0">Location</h6>
            </div>

            <div class="card-body">

                <!-- Municipality -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Municipality
                    </label>

                    <select class="form-select" id="mun_code">
                        <option value="">Select Municipality</option>

                        <?php
                        $sql = "SELECT * FROM municipality_list ORDER BY mun_name";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                        ?>

                            <option value="<?= $row['mun_code'] ?>">
                                <?= $row['mun_name'] ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

                <hr>

                <h6 class="mb-3">
                    Barangays
                </h6>

                <div class="row g-2" id="barangay-list">

                    <!-- Loaded by AJAX -->

                </div>

            </div>

        </div>

    </div>


    <!-- RIGHT SIDE -->
    <div class="col-lg-8">

        <div class="card shadow-sm">

            <div class="card-header pb-0">

                <ul class="nav nav-tabs tab-body-header rounded ms-3 prtab-set w-sm-100" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#land-tab" role="tab">Land</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#building-tab" role="tab">Building</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#machineries-tab" role="tab">Machineries</a></li>
                </ul>

            </div>

            <div class="card-body">

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="land-tab">


                        <div class="card mb-3">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <div class="info-header">
                                    <h6 class="mb-0 fw-bold ">Land Field Appraisal and Assessment Records</h6>
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
                                            <!-- <th>Date of Transaction</th>
                                    <th>Trancode</th> -->
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $results = getPropertiesByBarangay($mun_code, $brgy_session, 0, false, null);
                                        $counter = 1;
                                        while ($row = $results->fetch_assoc()):
                                        ?>
                                            <tr>
                                                <td><?= $counter++ ?></td>
                                                <td><?= htmlspecialchars($row['PIN']) ?></td>
                                                <td><?= htmlspecialchars($row['NAME OF OWNER']) ?></td>
                                                <td><?= htmlspecialchars($row['LOCATION OF PROPERTY'] . ' ' . $mun_name) ?></td>
                                                <td><?= htmlspecialchars($row['CADASTRAL LOT NUMBER']) ?></td>
                                                <!-- <td><?= htmlspecialchars($row['DATE OF TRANSACTION']) ?></td> -->
                                                <!-- <td><?= htmlspecialchars($row['TRANCODE']) ?></td> -->
                                                <td>
                                                    <a href="faas_form.php?property_ID=<?= $row['property_ID'] ?>&mode=old">
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

                    <div class="tab-pane fade" id="building-tab">
                        <div class="card mb-3">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <div class="info-header">
                                    <h6 class="mb-0 fw-bold ">Building Field Appraisal and Assessment Records</h6>
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
                                            <!-- <th>Date of Transaction</th>
                                    <th>Trancode</th> -->
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $results = getPropertiesByBarangay($mun_code, $brgy_session, 1, false, null);
                                        $counter = 1;
                                        while ($row = $results->fetch_assoc()):
                                        ?>
                                            <tr>
                                                <td><?= $counter++ ?></td>
                                                <td><?= htmlspecialchars($row['PIN']) ?></td>
                                                <td><?= htmlspecialchars($row['NAME OF OWNER']) ?></td>
                                                <td><?= htmlspecialchars($row['LOCATION OF PROPERTY'] . ' ' . $mun_desc) ?></td>
                                                <td><?= htmlspecialchars($row['CADASTRAL LOT NUMBER']) ?></td>
                                                <!-- <td><?= htmlspecialchars($row['DATE OF TRANSACTION']) ?></td> -->
                                                <!-- <td><?= htmlspecialchars($row['TRANCODE']) ?></td> -->
                                                <td>
                                                    <a href="faas_form.php?property_ID=<?= $row['property_ID'] ?>&mode=old">
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

                    <div class="tab-pane fade" id="machineries-tab">

                        <!-- MACHINERIES TABLE -->

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    $("#mun_code").change(function() {

        let mun_code = $(this).val();

        $.post("municipal/load_barangays.php", {
            mun_code: mun_code
        }, function(html) {

            $("#barangay-list").html(html);

        });

    });
    $(document).on("click", ".barangay-folder", function() {

        $(".barangay-folder").removeClass("active");
        $(this).addClass("active");

        let brgy = $(this).data("brgy");
        let mun = $("#mun_code").val();

        loadTable(mun, brgy);

    });

    function loadTable(mun_code, barangay) {

        $.post("municipal/load_table.php", {
            mun_code: mun_code,
            barangay: barangay,
            land_type: 0,
            faas: false
        }, function(html) {

            $("#myProjectTable tbody").html(html);

        });

    }
</script>