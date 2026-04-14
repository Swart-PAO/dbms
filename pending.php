<?php
// include 'db_connect.php'; // mysqli connection
require_once 'php/php_class.php';

?>

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

    <!-- First Table -->
    <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
        <thead>
            <tr>
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
            $results = getPropertiesByBarangay($mun_code, $brgy_session,);
            while ($row = $results->fetch_assoc()):
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['PIN']) ?></td>
                    <td><?= htmlspecialchars($row['NAME OF OWNER']) ?></td>
                    <td><?= htmlspecialchars($row['LOCATION OF PROPERTY'] . ' ' . $mun_desc) ?></td>
                    <td><?= htmlspecialchars($row['CADASTRAL LOT NUMBER']) ?></td>
                    <td><?= htmlspecialchars($row['DATE OF TRANSACTION']) ?></td>
                    <td><?= htmlspecialchars($row['TRANCODE']) ?></td>
                    <td>
                        <a href="faas_form.php?property_ID=<?= $row['property_ID'] ?>"
                            class="btn btn-outline-secondary">
                            <i class="icofont-bubble-right text-success"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

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