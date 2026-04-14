<style>
    .side-loading {
        display: none;
        text-align: center;
        padding: 20px;
    }

    .side-loading .spinner-border {
        width: 2.5rem;
        height: 2.5rem;
    }

    .export-result {
        display: none;
        font-size: 0.9rem;
    }
</style>
<div class="card-body">
    <div class="row g-4">

        <!-- LEFT: EXPORT FORM -->
        <div class="col-md-4">
            <div class="border rounded p-4 shadow-sm">

            </div>
            <div class="border rounded p-4 h-100 shadow-sm">
                <form id="exportForm">
                    <div class="mt-2">
                        <label class="form-label fw-bold">Municipality</label>
                        <select name="mun_code" id="mun_code" class="form-select">
                            <option value="">-- Select Municipality --</option>
                            <?php

                            $sql1 = "SELECT * FROM municipality";
                            $result1 = $conn->query($sql1);

                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {

                                    echo '<option value="' . $row1['mun_code'] . '">' . $row1['mun_desc'] . '</option>';
                                }
                            }
                            ?>

                        </select>
                    </div>
                    <div class="mt-2">
                        <h6 class="fw-bold mb-3 text-success">
                            <i class="bi bi-download"></i> Export Data
                        </h6>

                        <select name="export_type" class="form-select mb-3" required>
                            <option value="">Select Format</option>
                            <option value="csv">CSV</option>
                            <option value="sql">SQL</option>
                        </select>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-arrow-down-circle"></i> Export
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <!-- RIGHT: STATUS PANEL -->
        <div class="col-md-4">
            <div class="border rounded p-4 h-100 shadow-sm">
                <h6 class="fw-bold mb-3 text-primary">
                    <i class="bi bi-info-circle"></i> Export Status
                </h6>

                <!-- Loading -->
                <div class="side-loading" id="sideLoading">
                    <div class="spinner-border text-success mb-2"></div>
                    <div>Exporting data…</div>
                </div>

                <!-- Result -->
                <div class="export-result alert alert-success" id="exportResult"></div>
            </div>
        </div>


    </div>


</div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    $(function() {
        $('#exportForm').on('submit', function(e) {
            e.preventDefault();

            $('#exportResult').hide();
            $('#sideLoading').fadeIn();

            $.ajax({
                url: 'php/export.php',
                type: 'GET',
                data: $(this).serialize(),
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, status, xhr) {

                    $('#sideLoading').hide();

                    const filename = xhr.getResponseHeader('X-Filename') || 'export.dat';
                    const rows = xhr.getResponseHeader('X-Row-Count') || 0;

                    $('#exportResult')
                        .html(`<strong>Export complete!</strong><br>Rows exported: <b>${rows}</b>`)
                        .fadeIn();

                    const blob = new Blob([data], {
                        type: 'application/octet-stream'
                    });
                    const url = window.URL.createObjectURL(blob);

                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();

                    a.remove();
                    window.URL.revokeObjectURL(url);
                },
                error: function() {
                    $('#sideLoading').hide();
                    alert('Export failed.');
                }
            });
        });
    });
</script>