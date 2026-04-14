<?php
include 'db_connect.php'; // mysqli connection

?>

<div class="body d-flex py-3">
    <div class="container-xxl">

        <div class="row g-3 mb-3 row-deck">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <div class="info-header">
                            <h6 class="mb-0 fw-bold ">Project Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form method="GET" class="row g-2 mb-3">
                                <div class="col-md-4">

                                    <select name="mun_code" id="mun_code" class="form-select">
                                        <option value="">-- Select Municipality --</option>
                                        <?php
                                        $sql = "SELECT mun_code, mun_desc FROM municipality ORDER BY mun_desc ASC";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['mun_code'] . '">' . $row['mun_desc'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select name="brgy" id="brgy" class="form-select">
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

                        <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Previous PIN</th>
                                    <th>Name of Owner</th>
                                    <th>Location of Property</th>
                                    <th>Lot #</th>
                                    <th>Trancode</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM faas_property  WHERE `property_municipality` = $mun_code ORDER BY previous_pin ASC";
                                $result = $conn->query($sql);
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $row['previous_pin'] ?></td>
                                        <td><?= $row['owner_name'] ?></td>
                                        <td><?= $row['property_brgy'] ?></td>
                                        <td><?= $row['lot_no'] ?></td>
                                        <td><?= $row['transaction_code'] ?></td>
                                        <td><?= date('m/d/Y', strtotime($row['recording_date'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                <a href="faas_form.php?FAAS_ID=<?= $row['FAAS_ID'] ?>" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                                <a href="printable_property.php?faas_id=<?= $row['FAAS_ID'] ?>" class="btn btn-outline-secondary"><i class="icofont-eye-alt text-info"></i></a>
                                                <button type="button" class="btn btn-outline-secondary delete_property" data-id="<?= $row['FAAS_ID']; ?>"><i class="icofont-ui-delete text-danger"></i></button>
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
        </div>
    </div><!-- Row End -->

</div>

<script>
    $(document).ready(function() {
        $("#mun_code").change(function() {
            var mun_code = $(this).val();
            if (mun_code !== "") {
                $.ajax({
                    url: "php/get_barangay.php",
                    type: "POST",
                    data: {
                        mun_code: mun_code
                    },
                    success: function(data) {
                        $("#brgy").html(data);
                    }
                });
            } else {
                $("#brgy").html('<option value="">-- Select Barangay --</option>');
            }
        });
    });
</script>