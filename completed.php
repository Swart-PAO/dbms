<div class="body d-flex py-3">
    <div class="container-xxl">

        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header p-0 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <div class="info-header">
                        <h6 class="mb-0 fw-bold ">Project Information</h6>
                    </div>
                    <div class="d-flex py-2 project-tab flex-wrap w-sm-100">
                        <form method="GET" class="row g-2 mb-3">
                            <div class="col-md-4">

                                <select name="mun_code" id="mun_code" class="form-select">
                                    <option value="">-- Select Municipality --</option>
                                    <?php
                                    $sql = "SELECT mun_code, mun_name FROM municipality_list ORDER BY mun_name ASC";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['mun_code'] . '">' . $row['mun_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select name="brgy" id="brgy" class="form-select" required>
                                    <option value="">-- Select Barangay --</option>
                                    <!-- Options will load dynamically -->
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            <div class="col-md-2">
                                <a href="your_page.php" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->


        <!-- Land / Building Tabs -->
        <div class="row">
            <div class="col-12">

                <div class="card mb-3">
                    <div class="card-body p-3">

                        <!-- Tab Navigation -->
                        <style>
                            #propertyTabs .nav-link.active {
                                background-color: var(--bs-primary);
                                color: #fff;
                                border-color: var(--bs-primary);
                            }

                            #propertyTabs .nav-link {
                                color: var(--bs-primary);
                            }

                            #propertyTabs .nav-link:hover {
                                background-color: rgba(var(--bs-primary-rgb), 0.1);
                            }
                        </style>

                        <ul class="nav nav-tabs mb-3" id="propertyTabs" role="tablist">

                            <!-- Land Tab -->
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link active fw-bold"
                                    id="land-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#land-content"
                                    type="button"
                                    role="tab"
                                    aria-controls="land-content"
                                    aria-selected="true">
                                    <i class="icofont-landscape me-1"></i>
                                    Land
                                </button>
                            </li>

                            <!-- Building Tab -->
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link fw-bold"
                                    id="building-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#building-content"
                                    type="button"
                                    role="tab"
                                    aria-controls="building-content"
                                    aria-selected="false">
                                    <i class="icofont-building me-1"></i>
                                    Building
                                </button>
                            </li>

                        </ul>


                        <!-- Tab Contents -->
                        <div class="tab-content" id="propertyTabsContent">

                            <!-- ================================================= -->
                            <!-- LAND -->
                            <!-- ================================================= -->
                            <div
                                class="tab-pane fade show active"
                                id="land-content"
                                role="tabpanel"
                                aria-labelledby="land-tab">

                                <div class="table-responsive">

                                    <table
                                        id="landCompleted"
                                        class="table table-hover align-middle mb-0"
                                        style="width:100%">

                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Previous PIN</th>
                                                <th>Name of Owner</th>
                                                <th>Location of Property</th>
                                                <th>Lot #</th>
                                                <th>Recording Date</th>
                                                <th>Revision Code</th>
                                                <th>History</th>
                                                <th>Generate</th>
                                                <th>Update Market Value</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $results = getPropertiesByBarangayRevision(
                                                $mun_code,
                                                $brgy_session,
                                                NULL,
                                                NULL,
                                                $version = 1
                                            );

                                            $counter = 1;

                                            while ($row = $results->fetch_assoc()):
                                            ?>

                                                <tr>

                                                    <td class="text-center">
                                                        <?= $counter++ ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($row['previous_pin']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($row['owner_name']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars(
                                                            $row['property_brgy'] . ' ' .
                                                                $row['property_municipality']
                                                        ) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($row['lot_no']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($row['recording_date']) ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <span class="badge bg-secondary">
                                                            <?= htmlspecialchars($row['revision_code']) ?>
                                                        </span>
                                                    </td>

                                                    <!-- History -->
                                                    <td class="text-center">

                                                        <i
                                                            class="icofont-history fs-2 text-success home-icon property-history"
                                                            data-record-id="<?= $row['property_ID']; ?>"
                                                            style="cursor:pointer;"
                                                            title="View Property History">
                                                        </i>

                                                    </td>

                                                    <!-- Generate -->
                                                    <td class="text-center">

                                                        <div class="dropdown">

                                                            <button
                                                                class="btn btn-outline-secondary dropdown-toggle"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">

                                                                Generate

                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                <li>
                                                                    <a
                                                                        class="dropdown-item"
                                                                        href="faas.php?property_ID=<?= $row['property_ID'] ?>">

                                                                        <i class="icofont-file-document text-secondary"></i>
                                                                        FAAS

                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a
                                                                        class="dropdown-item"
                                                                        href="doc/tax_declaration.php?property_ID=<?= $row['property_ID'] ?>">

                                                                        <i class="icofont-law-document text-info"></i>
                                                                        Tax Declaration

                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a
                                                                        class="dropdown-item"
                                                                        href="land/faas_form.php?mode=gr&property_ID=<?= $row['property_ID'] ?>">

                                                                        <i class="icofont-edit text-success"></i>
                                                                        Edit

                                                                    </a>
                                                                </li>

                                                            </ul>

                                                        </div>

                                                    </td>

                                                    <td class="text-center">

                                                        <i
                                                            class="icofont-building fs-2 text-success home-icon property-history"
                                                            data-record-id="<?= $row['property_ID']; ?>"
                                                            style="cursor:pointer;"
                                                            title="View Property History">
                                                        </i>

                                                    </td>

                                                </tr>

                                            <?php endwhile; ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>


                            <!-- ================================================= -->
                            <!-- BUILDING -->
                            <!-- ================================================= -->
                            <div
                                class="tab-pane fade"
                                id="building-content"
                                role="tabpanel"
                                aria-labelledby="building-tab">

                                <div class="table-responsive">

                                    <table
                                        id="buildingCompleted"
                                        class="table table-hover align-middle mb-0"
                                        style="width:100%">

                                        <thead>

                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>PIN</th>
                                                <th>Name of Owner</th>
                                                <th>Location of Property</th>
                                                <th>Building</th>
                                                <th>Actions</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php

                                            $sql = "
                                        SELECT
                                            bd.*,
                                            ml.mun_name
                                        FROM building_desc AS bd
                                        JOIN municipality_list AS ml
                                            ON bd.municipality = ml.mun_code
                                        WHERE bd.municipality = $mun_code
                                        AND bd.version = 1
                                        ORDER BY previous_pin ASC 
                                    ";

                                            $result = $conn->query($sql);

                                            $counter = 1;

                                            while ($row = $result->fetch_assoc()):

                                            ?>

                                                <tr>

                                                    <td class="text-center">
                                                        <?= $counter++ ?>
                                                    </td>

                                                    <td class="fw-bold text-secondary">

                                                        <?= htmlspecialchars($row['pin']) ?>
                                                        -
                                                        (<?= htmlspecialchars($row['bin']) ?>)

                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($row['owner_name']) ?>
                                                    </td>

                                                    <td>
                                                        <?= htmlspecialchars($row['mun_name']) ?>,
                                                        <?= htmlspecialchars($row['baranggay']) ?>
                                                    </td>

                                                    <td class="text-center">

                                                        <i
                                                            class="icofont-building fs-3 text-success"
                                                            title="Building">
                                                        </i>

                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="text-center">

                                                        <div class="dropdown">

                                                            <button
                                                                class="btn btn-outline-secondary dropdown-toggle"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">

                                                                Actions

                                                            </button>

                                                            <ul class="dropdown-menu">

                                                                <li>
                                                                    <a
                                                                        class="dropdown-item"
                                                                        href="building/building_form.php?building_id=<?= $row['building_id'] ?>&mode=gr">

                                                                        <i class="icofont-edit text-success"></i>
                                                                        Edit

                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a
                                                                        class="dropdown-item"
                                                                        href="building/faas_building.php?building_id=<?= $row['building_id'] ?>">

                                                                        <i class="icofont-eye-alt text-info"></i>
                                                                        View

                                                                    </a>
                                                                </li>

                                                            </ul>

                                                        </div>

                                                    </td>

                                                </tr>

                                            <?php endwhile; ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>


        <!-- ========================================================= -->
        <!-- PROPERTY HISTORY MODAL -->
        <!-- ========================================================= -->

        <div class="modal fade" id="historyModal" tabindex="-1">

            <div class="modal-dialog modal-xl">

                <div class="modal-content">

                    <div class="modal-header bg-success text-white">

                        <h5 class="modal-title">
                            <i class="icofont-history"></i>
                            Property History
                        </h5>

                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div id="historyContent">

                            <div class="text-center p-4">

                                <div class="spinner-border text-success"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div><!-- Row End -->

</div>

<script>
    $(document).on("click", ".property-history", function() {

        let record_id = $(this).data("record-id");

        $("#historyModal").modal("show");

        $("#historyContent").html(`
        <div class="text-center p-4">
            <div class="spinner-border text-success"></div>
        </div>
    `);

        $.ajax({
            url: "php/get_property_history.php",
            type: "POST",
            data: {
                record_id: record_id
            },
            success: function(response) {
                $("#historyContent").html(response);
            }
        });

    });
</script>