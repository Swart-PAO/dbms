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
                            <h6 class="mb-0 fw-bold">Project Information</h6>
                        </div>
                    </div>

                    <div class="card-body">

                        <!-- Search Form -->
                        <form id="searchForm" class="row g-2 mb-3">
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

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            <div class="col-md-2">
                                <a href="your_page.php" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </form>

                    </div>


                    <!-- Data Table -->
                    <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>PIN</th>
                                <th>Name of Owner</th>
                                <th>Municipality</th>
                                <!-- <th>Barangay</th>
                                    <th>Location of Property</th> -->
                                <th>Lot #</th>
                                <th>Date of Transaction</th>
                                <th>Trancode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `property information` LIMIT 100";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row['PIN'] ?></td>
                                    <td><?= $row['NAME OF OWNER'] ?></td>
                                    <!-- <td><?= $row['MUNICIPALITY'] ?></td> -->
                                    <!-- <td><?= $row['BARANGAY'] ?></td> -->
                                    <td><?= $row['LOCATION OF PROPERTY'] ?></td>
                                    <td><?= $row['CADASTRAL LOT NUMBER'] ?></td>
                                    <td><?= $row['DATE OF TRANSACTION'] ?></td>
                                    <td><?= $row['TRANCODE'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div><!-- Row End -->
</div>
</div>

<?php $conn->close(); ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $("#searchForm").on("submit", function(e) {
            e.preventDefault(); // prevent page reload

            var mun_code = $("#mun_code").val();

            $.ajax({
                url: "php/search_project.php",
                type: "POST",
                data: {
                    mun_code: mun_code
                },
                success: function(response) {
                    $("#myProjectTable tbody").html(response);
                }
            });
        });
    });
</script>