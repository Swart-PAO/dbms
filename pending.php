<?php
// include 'db_connect.php'; // mysqli connection
require_once 'php/php_class.php';

?>
<div class="body d-flex py-3">
    <div class="container-xxl">

        <div class="card-body">

            <!-- Search Form -->
            <form class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="faas" class="form-select">
                        <option value="">-- Select Type --</option>

                        <option value="Land">
                            Land
                        </option>
                        <option value="Building">
                            Building
                        </option>

                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Search</button>
                </div>

                <div class="col-md-2">
                    <a href="index.php" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>


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
                                    <a href="land/faas_form.php?property_ID=<?= $row['property_ID'] ?>&mode=old">
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
</div>


<script>
    $(document).ready(function() {
        // $("#mun_code").change(function() {
        //     var mun_code = $(this).val();
        //     if (mun_code !== "") {
        //         $.ajax({
        //             url: "php/get_barangay.php",
        //             type: "POST",
        //             data: {
        //                 mun_code: mun_code
        //             },
        //             success: function(data) {
        //                 $("#brgy").html(data);
        //             }
        //         });
        //     } else {
        //         $("#brgy").html('<option value="">-- Select Barangay --</option>');
        //     }
        // });
        // $("#searchForm").on("submit", function(e) {
        //     e.preventDefault(); // prevent page reload

        //     var mun_code = $("#mun_code").val();

        //     $.ajax({
        //         url: "php/search_project.php",
        //         type: "POST",
        //         data: {
        //             mun_code: mun_code
        //         },
        //         success: function(response) {
        //             $("#myProjectTable tbody").html(response);
        //         }
        //     });
        // });
    });
</script>