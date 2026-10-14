<style>
    .municipality-smv-tab {
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: .2s;
    }

    .municipality-smv-tab:hover {
        background: #f5f5f5;
    }

    .municipality-smv-tab.active {
        background: #f19828;
        color: white;
    }

    .municipality-smv-tab.active i {
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


                <hr>

                <h6 class="mb-3">
                    Municipality
                </h6>

                <div class="row g-2" id="barangay-list">
                    <?php

                    $sql = "SELECT *
        FROM municipality_list
        ORDER BY mun_name";

                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {

                    ?>

                        <div class="col-4">
                            <div class="municipality-smv-tab text-center p-2"
                                data-mun_code="<?= $row['mun_code'] ?>">

                                <i class="icofont-building-alt text-secondary fs-2"></i>

                                <div class="small mt-2">
                                    <?= $row['mun_name'] ?>
                                </div>

                            </div>
                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>

    </div>


    <!-- RIGHT SIDE -->
    <div class="col-lg-8">

        <div class="card shadow-sm">

            <div class="card-header pb-0">

                <ul class="nav nav-tabs tab-body-header rounded ms-3 prtab-set w-sm-100" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#non-agri-tab" role="tab">Non-Agricultural</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#agri-tab" role="tab">Agricultural</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#actual-use-tab" role="tab">Actual Use</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#others-tab" role="tab">Others</a></li>
                </ul>

            </div>

            <div class="card-body">


                <div class="card mb-3">
                    <div class="card-header py-3  bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">Schedule Market Value</h6>
                        <p>Use contextual classes to color tables, table rows or individual cells.</p>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="non-agri-tab">
                            <div class="card-body variants-custome-color">
                                <div class="table-responsive">
                                    <table class="table" id="classification-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="table-primary">Class</th>
                                                <th scope="col" class="table-success">Residential</th>
                                                <th scope="col" class="table-danger">Commercial</th>
                                                <th scope="col" class="table-warning">Industrial</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php for ($x = 1; $x <= 5; $x++): ?>
                                                <tr>
                                                    <th scope="row" class="table-primary">
                                                        <?php echo $x; ?>
                                                    </th>
                                                    <td class="table-success editable"></td>
                                                    <td class="table-danger editable"></td>
                                                    <td class="table-warning editable"></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Save Button -->
                                <div class="text-center mt-3 d-none" id="save-container">
                                    <button type="button" class="btn btn-primary" id="save-table">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="agri-tab">
                            <div class="card-body variants-custome-color">
                                <div class="table-responsive">
                                    <table class="table" id="agri-smv-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="table-primary">Class</th>
                                                <th scope="col" class="table-success">First</th>
                                                <th scope="col" class="table-danger">Second</th>
                                                <th scope="col" class="table-warning">Third</th>
                                                <th scope="col" class="table-secondary">Fourth</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <!-- <?php for ($x = 1; $x <= 5; $x++): ?>
                                                <tr>
                                                    <th scope="row" class="table-primary">
                                                        <?php echo $x; ?>
                                                    </th>
                                                    <td class="table-success editable"></td>
                                                    <td class="table-danger editable"></td>
                                                    <td class="table-warning editable"></td>
                                                    <td class="table-secondary editable"></td>
                                                </tr>
                                            <?php endfor; ?> -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Save Button -->
                                <div class="text-center mt-3 d-none" id="save-container">
                                    <button type="button" class="btn btn-primary" id="save-table">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="actual-use-tab">
                            <div class="card-body variants-custome-color">
                                <div class="table-responsive">
                                    <table class="table" id="actual-use-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="table-primary">#</th>
                                                <th scope="col" class="table-success">Description</th>
                                                <th scope="col" class="table-danger">Assessment Level</th>
                                                <th scope="col" class="table-warning">Taxability</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php for ($x = 1; $x <= 5; $x++): ?>
                                                <tr>
                                                    <th scope="row" class="table-primary">
                                                        <?php echo $x; ?>
                                                    </th>
                                                    <td class="table-success editable"></td>
                                                    <td class="table-danger editable"></td>
                                                    <td class="table-warning editable"></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Save Button -->
                                <div class="text-center mt-3 d-none" id="save-container">
                                    <button type="button" class="btn btn-primary" id="save-table">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade " id="others-tab">
                            <div class="card-body variants-custome-color">
                                <div class="table-responsive">
                                    <table class="table" id="others-smv-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="table-primary">Class</th>
                                                <th scope="col" class="table-success">Residential</th>
                                                <th scope="col" class="table-danger">Commercial</th>
                                                <th scope="col" class="table-warning">Industrial</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php for ($x = 1; $x <= 5; $x++): ?>
                                                <tr>
                                                    <th scope="row" class="table-primary">
                                                        <?php echo $x; ?>
                                                    </th>
                                                    <td class="table-success editable"></td>
                                                    <td class="table-danger editable"></td>
                                                    <td class="table-warning editable"></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Save Button -->
                                <div class="text-center mt-3 d-none" id="save-container">
                                    <button type="button" class="btn btn-primary" id="save-table">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    // Current selected municipality
    let mun_code = <?php echo json_encode($_SESSION['mun_code']); ?>;

    $(document).ready(function() {
        $(this).addClass("active " + mun_code);

        // Initial load using logged-in municipality
        loadSMV(mun_code);
        loadAgriSMV();
        loadActualUse();

        $('.municipality-smv-tab[data-mun_code="' + mun_code + '"]')
            .addClass("active");

        $("#classification-table").on(
            "dblclick",
            "td.editable",
            function() {
                const $cell = $(this);

                // Already editing
                if ($cell.find("input").length) return;

                const displayValue = $.trim($cell.text());

                const value = displayValue
                    .replace("₱", "")
                    .replace(/,/g, "")
                    .trim();

                const $input = $("<input>", {
                    type: "number",
                    step: "0.01",
                    class: "form-control form-control-sm",
                    value: value
                });

                $cell.empty().append($input);

                $input.focus().select();

                // Show save button
                $("#save-container").removeClass("d-none");

                // Mark row as edited
                $cell.closest("tr").addClass("edited");

                // Enter = finish editing
                $input.on("keydown", function(e) {
                    if (e.key === "Enter") {
                        finishEdit($cell, $input);
                    }

                    if (e.key === "Escape") {
                        $cell.text(value);

                        if (value === $.trim($input.val())) {
                            checkEditedRow($cell.closest("tr"));
                        }
                    }
                });

                // Blur = finish editing
                $input.on("blur", function() {
                    finishEdit($cell, $input);
                });
            }
        );

        function finishEdit($cell, $input) {
            const value = $.trim($input.val());

            $cell.text(formatPeso(value));

            $cell.closest("tr").addClass("edited");
        }

        function checkEditedRow($row) {
            if ($row.find("td.editable").length === 0) {
                $row.removeClass("edited");
            }
        }

        // Save button
        $("#save-table").on("click", function() {
            const $button = $(this);
            const data = [];

            $("#classification-table tbody tr.edited").each(function() {
                const $row = $(this);

                const row = {
                    class: $.trim($row.find("th").text())
                };

                const $residential = $row.find("td").eq(0);
                const $commercial = $row.find("td").eq(1);
                const $industrial = $row.find("td").eq(2);

                const residential = $.trim($residential.text())
                    .replace("₱", "")
                    .replace(/,/g, "")
                    .trim();

                const commercial = $.trim($commercial.text())
                    .replace("₱", "")
                    .replace(/,/g, "")
                    .trim();

                const industrial = $.trim($industrial.text())
                    .replace("₱", "")
                    .replace(/,/g, "")
                    .trim();

                if (residential !== "") {
                    row.residential_unit_value = residential;
                }

                if (commercial !== "") {
                    row.commercial_unit_value = commercial;
                }

                if (industrial !== "") {
                    row.industrial_unit_value = industrial;
                }

                data.push(row);
            });

            for (const row of data) {

                if (

                    row.residential_unit_value === "" ||

                    row.commercial_unit_value === "" ||

                    row.industrial_unit_value === ""

                ) {

                    alert("Please fill in all unit values.");

                    return;

                }

                if (

                    isNaN(row.residential_unit_value) ||

                    isNaN(row.commercial_unit_value) ||

                    isNaN(row.industrial_unit_value)

                ) {

                    alert("Unit values must be numeric.");

                    return;

                }

            }

            // Nothing changed
            if (data.length === 0) {
                alert("No changes to save.");
                return;
            }

            console.log("Municipality:", mun_code);
            console.log("Data to save:", data);

            $button.prop("disabled", true);
            $button.html(
                '<i class="fas fa-spinner fa-spin"></i> Saving...'
            );

            $.ajax({
                url: "smv_save.php",
                type: "POST",
                dataType: "json",
                data: {
                    mun_code: mun_code, // <-- send selected municipality
                    data: JSON.stringify(data)
                },

                success: function(response) {
                    if (response.success) {
                        alert(response.message);

                        $("#classification-table tbody tr")
                            .removeClass("edited");

                        $("#save-container").addClass("d-none");
                    } else {
                        alert(
                            response.message ||
                            "Unable to save changes."
                        );
                    }
                },

                error: function(xhr) {
                    console.error(xhr.responseText);

                    alert(
                        "An error occurred while saving."
                    );
                },

                complete: function() {
                    $button.prop("disabled", false);

                    $button.html(
                        '<i class="fas fa-save"></i> Save Changes'
                    );
                }
            });
        });
    });


    // Municipality tab click
    $(document).on("click", ".municipality-smv-tab", function() {

        $(".municipality-smv-tab").removeClass("active");
        $(this).addClass("active");

        // CHANGE GLOBAL mun_code
        mun_code = $(this).data("mun_code");

        // Optional: make sure it is a number
        mun_code = parseInt(mun_code, 10);

        // console.log("Selected municipality:", mun_code);

        // Load selected municipality
        loadSMV(mun_code);
    });

    function loadAgriSMV() {
        $.ajax({
            url: "municipal/loadAgriSMV.php",
            type: "POST",
            dataType: "json",

            success: function(response) {

                let tbody = "";

                if (response.success && response.data.length > 0) {

                    response.data.forEach(function(row, index) {

                        tbody += `<tr data-id="${row.agri_class_ID}">
                                <th scope="row" class="table-primary">
                                    ${row.classification}
                                </th>

                                <td class="table-success editable">
                                    ${formatPeso(row.first_C)}
                                </td>

                                <td class="table-danger editable">
                                    ${formatPeso(row.second_C)}
                                </td>

                                <td class="table-warning editable">
                                    ${formatPeso(row.third_C)}
                                </td>

                                <td class="table-secondary editable">
                                    ${formatPeso(row.fourth_C)}
                                </td>
                            </tr>
                        `;
                    });

                } else {

                    // Keep exactly 5 empty rows if there is no data
                    for (let x = 1; x <= 5; x++) {
                        tbody += `
                        <tr>
                            <th scope="row" class="table-primary">
                                ${x}
                            </th>

                            <td class="table-success editable"></td>
                            <td class="table-danger editable"></td>
                            <td class="table-warning editable"></td>
                            <td class="table-secondary editable"></td>
                        </tr>
                    `;
                    }
                }

                $("#agri-smv-table tbody").html(tbody);
            },

            error: function(xhr) {
                console.error("loadAgriSMV error:", xhr.responseText);
            }
        });
    }

    function loadActualUse() {
        $.ajax({
            url: "municipal/loadActualUse.php",
            type: "POST",
            dataType: "json",

            success: function(response) {

                let tbody = "";

                if (response.success && response.data.length > 0) {

                    response.data.forEach(function(row, index) {

                        tbody += `<tr data-id="${row.agri_class_ID}">
                                <th scope="row" class="table-primary">
                                    ${index + 1}
                                </th>

                                <td class="table-success editable">
                                    ${row.description}
                                </td>

                                <td class="table-danger editable">
                                    ${row.assessment_level}%
                                </td>

                                <td class="table-warning editable">
                                    ${row.taxability}
                                </td>

                               
                            </tr>
                        `;
                    });

                } else {

                    // Keep exactly 5 empty rows if there is no data
                    for (let x = 1; x <= 5; x++) {
                        tbody += `
                        <tr>
                            <th scope="row" class="table-primary">
                                ${x}
                            </th>

                            <td class="table-success editable"></td>
                            <td class="table-danger editable"></td>
                            <td class="table-warning editable"></td>
                        </tr>
                    `;
                    }
                }

                $("#actual-use-table tbody").html(tbody);
            },

            error: function(xhr) {
                console.error("loadActualUse error:", xhr.responseText);
            }
        });
    }

    function loadSMV(mun_code) {

        $.post("municipal/load_SMV.php", {
                mun_code: mun_code
            },
            function(html) {

                $("#classification-table tbody").html(html);

                // Format values as Philippine Peso
                $("#classification-table tbody .smv-value").each(function() {
                    const value = $.trim($(this).text());

                    if (value !== "") {
                        $(this).text(formatPeso(value));
                    }
                });

            }
        ).fail(function(xhr) {

            console.error(xhr.responseText);

            alert("Unable to load SMV data.");

        });
    }

    function formatPeso(value) {
        if (value === null || value === undefined || value === "") {
            return "";
        }

        const number = Number(value);

        if (isNaN(number)) {
            return "";
        }

        return `₱ ${number.toLocaleString("en-PH", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}`;
    }
</script>