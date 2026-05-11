<?php
include 'db_connect.php'; // mysqli connection

?>

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
                </div>
            </div>
        </div> <!-- Row end  -->

        <div class="row align-items-stretch">
            <div class="col-md-9 d-flex">
                <div class="card mb-3 h-100 w-100">
                    <div class="card-body d-flex flex-column p-3">
                        <table id="recentTask" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Previous PIN</th>
                                    <th>Name of Owner</th>
                                    <th>Location of Property</th>
                                    <th>Lot #</th>
                                    <th>Building</th>
                                    <!-- <th>Trancode</th> -->
                                    <!-- <th>Date</th> -->
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM faas_property  WHERE `property_municipality` = $mun_code ORDER BY previous_pin ASC";
                                $result = $conn->query($sql);
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr class="text-center">
                                        <td><?= $counter++ ?></td>
                                        <td class="fw-bold text-secondary"><?= $row['previous_pin'] ?></td>
                                        <td><?= $row['owner_name'] ?></td>
                                        <td><?= $row['property_brgy'] ?></td>
                                        <td><?= $row['lot_no'] ?></td>
                                        <!-- <td><?= $row['transaction_code'] ?></td> -->
                                        <td class="text-center">
                                            <i class="icofont-home fs-2 text-success home-icon buildin_display"></i>
                                        </td>

                                        <style>
                                            .home-icon:hover {
                                                text-shadow: 0 0 10px #f6ff79, 0 0 10px #b0ff48;
                                                transition: 0.2s ease;
                                                cursor: pointer;
                                            }
                                        </style>
                                        <!-- <td><?= date('m/d/Y', strtotime($row['recording_date'])) ?></td> -->
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="faas_form.php?FAAS_ID=<?= $row['FAAS_ID'] ?>">
                                                            <i class="icofont-edit text-success"></i> Edit
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item" href="printable_property.php?faas_id=<?= $row['FAAS_ID'] ?>">
                                                            <i class="icofont-eye-alt text-info"></i> View
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <button type="button"
                                                            class="dropdown-item delete_property"
                                                            data-id="<?= $row['FAAS_ID']; ?>">
                                                            <i class="icofont-ui-delete text-danger"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
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
            <div class="col-md-3 d-flex">
                <div class="card mb-3 h-100 w-100">
                    <div class="card-body p-3">
                        <div class="planned_task client_task">
                            <div class="dd" data-plugin="nestable">
                                <ol class="dd-list d-none" id="building_list" style="list-style:none; margin-left: 0; padding-left:0">
                                    <?php

                                    for ($i = 0; $i < 3; $i++) { ?>
                                        <li class="dd-item mb-4">
                                            <div class="dd-handle">
                                                <div class="task-info d-flex align-items-center justify-content-between">
                                                    <h6 class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">040-11-0009-003-18(1001)</h6>
                                                    <div class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            <i class="icofont-home fs-1 text-success"></i>
                                                        </div>
                                                        <span class="badge bg-warning text-end mt-1">4051</span>
                                                    </div>
                                                </div>
                                                <p class="py-2 mb-0">Name of Owner: Juan Dela Cruz</p>
                                                <p>Address: 123 Main Street</p>
                                                <p class="py-2 mb-0">Name of Owner: Juan Dela Cruz</p>
                                                <p class="">Address: 123 Main Street</p>
                                                <p class="py-2 mb-0">TD No: 0000-000-00</p>
                                                <div class="tikit-info row g-3 align-items-center">
                                                    <div class="col-sm">
                                                    </div>
                                                    <div class="col-sm text-end">

                                                        <div class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                            <div class="btn-group" role="group" aria-label="Basic outlined example"> <a href="faas_form.php?FAAS_ID=<?= $row['FAAS_ID'] ?>" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a> <a href="printable_property.php?faas_id=<?= $row['FAAS_ID'] ?>" class="btn btn-outline-secondary"><i class="icofont-eye-alt text-info"></i></a> <button type="button" class="btn btn-outline-secondary delete_property" data-id="<?= $row['FAAS_ID']; ?>"><i class="icofont-ui-delete text-danger"></i></button> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>

                                </ol>
                                <script>
                                    $(document).ready(function() {

                                        $(".buildin_display").click(function() {
                                            $("#building_list").toggleClass("d-none");
                                        });

                                    });
                                </script>
                            </div>
                        </div>
                        <!-- <i class="icofont-home" style="font-size: 6rem;"></i> -->
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