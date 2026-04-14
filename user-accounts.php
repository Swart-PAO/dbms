<!-- Body: Body -->
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card border-0 mb-4 no-bg">
                    <div class="card-header py-3 px-0 d-sm-flex align-items-center  justify-content-between border-bottom">
                        <h3 class=" fw-bold flex-fill mb-0 mt-sm-0">Employee</h3>
                        <button type="button" class="btn btn-dark me-1 mt-1 w-sm-100" data-bs-toggle="modal" data-bs-target="#add-user-modal"><i class="icofont-plus-circle me-2 fs-6"></i>Add Employee</button>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle mt-1  w-sm-100" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                Status
                            </button>
                            <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="#">All</a></li>
                                <li><a class="dropdown-item" href="#">Task Assign Members</a></li>
                                <li><a class="dropdown-item" href="#">Not Assign Members</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row End -->
        <div class="row g-3 row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2 row-deck py-1 pb-4">
            <?php
            include 'db_connect.php';
            $sql = "SELECT * FROM `user`";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="col">
                    <div class="card teacher-card">
                        <div class="card-body  d-flex">
                            <div class="profile-av pe-xl-4 pe-md-2 pe-sm-4 pe-4 text-center w220">
                                <img src="php/uploads/<?= $row['picture'] ?>" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                <div class="about-info d-flex align-items-center mt-1 justify-content-center flex-column">
                                    <h6 class="mb-0 fw-bold d-block fs-6 mt-2">CEO</h6>
                                    <div class="btn-group mt-2" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary btn-update-user"
                                            data-id="<?= $row['user_ID'] ?>"><i class="icofont-edit text-success"></i></button>
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-delete-user"
                                            data-id="<?= $row['user_ID'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#delete-user">
                                            <i class="icofont-ui-delete text-danger"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <div class="teacher-info border-start ps-xl-4 ps-md-3 ps-sm-4 ps-4 w-100">
                                <h6 class="mb-0 mt-2  fw-bold d-block fs-6"><?= $row['name'] ?></h6>
                                <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted"><?= $row['team'] ?></span>
                                <div class="video-setting-icon mt-3 pt-3 border-top">
                                    <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.Vestibulum ante ipsum primis in faucibus orci luctus et ultrices</p>
                                </div>
                                <div class="d-flex flex-wrap align-items-center ct-btn-set">
                                    <a href="chat.html" class="btn btn-dark btn-sm mt-1 me-1"><i class="icofont-ui-text-chat me-2 fs-6"></i>Chat</a>
                                    <a href="profile.html" class="btn btn-dark btn-sm mt-1"><i class="icofont-invisible me-2 fs-6"></i>Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }

            $conn->close(); ?>
        </div>

    </div>
</div>

<div class="modal fade" id="delete-user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  fw-bold" id="delete-userLabel"> Delete item Permanently?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body justify-content-center flex-column d-flex">
                <i class="icofont-ui-delete text-danger display-2 text-center mt-2"></i>
                <p class="mt-4 fs-5 text-center">You can only delete this item Permanently</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger color-fff" id="confirmDelete">Delete</button>

            </div>
        </div>
    </div>
</div>

<!-- Create Employee-->
<div class="modal fade" id="add-user-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="add-staff-form" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modal-title">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
                    <!-- Basic Info -->
                    <h6 class="fw-bold mb-3">Basic Information</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <input type="hidden" name="user_ID" id="user_ID">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="role" id="role" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input class="form-control" type="file" name="picture" id="picture">
                    </div>

                    <!-- Login Credentials -->
                    <h6 class="fw-bold mb-3">Login Credentials</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Staff ID (Username)</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                    </div>

                    <!-- Work Info -->
                    <h6 class="fw-bold mb-3">Work Information</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department" id="department">
                                <option value="OJT">OJT</option>
                                <option value="Tax Mapping">Tax Mapping</option>
                                <option value="Appraisal">Appraisal</option>
                                <option value="Record">Record</option>
                                <option value="Admin">Admin</option>
                                <option value="IT">IT</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Team</label>
                            <select class="form-select" name="team">
                                <option value="Pajarito">Pajarito</option>
                                <option value="Canalin">Canalin</option>
                                <option value="Parenno">Parenno</option>
                            </select>
                        </div>
                    </div>

                    <!-- Municipalities -->
                    <h6 class="fw-bold mb-2">Assigned Municipalities</h6>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 g-2">
                        <?php
                        include 'db_connect.php';
                        $sql = "SELECT mun_code, mun_desc FROM municipality ORDER BY mun_desc ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="municipalities[]"
                                            value="<?php echo $row['mun_code']; ?>">
                                        <label class="form-check-label"><?php echo $row['mun_desc']; ?></label>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php
include 'footer_script.php';
?>
<script>
    $(document).ready(function() {
        let deleteUserId = null;

        $('#add-user-modal').on('show.bs.modal', function() {
            $('#add-staff-form')[0].reset();
            $("#modal-title").text("Add Staff");
            $('#user_ID').val(''); // also clear hidden id
            $('input[name="municipalities[]"]').prop('checked', false);
        });
        $(document).on("click", ".btn-delete-user", function() {
            deleteUserId = $(this).data("id");
        });
        $("#confirmDelete").on("click", function() {
            if (deleteUserId) {
                $.ajax({
                    url: "ajax/ajax_delete.php?action=delete_user",
                    type: "POST",
                    data: {
                        user_id: deleteUserId
                    },
                    success: function(response) {
                        alert(response); // ✅ You can replace with toast
                        $("#delete-user").modal("hide");

                        // Option 1: Reload page
                        location.reload();

                        // Option 2: Remove the card without reload
                        // $("button[data-id='" + deleteUserId + "']").closest(".col").remove();
                    },
                    error: function() {
                        alert("❌ Failed to delete user.");
                    }
                });
            }
        });
        $("#add-staff-form").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this); // handles text + files together

            $.ajax({
                url: "ajax.php?action=insert_user",
                type: "POST",
                data: formData,
                contentType: false, // prevent jQuery from overriding
                processData: false, // prevent jQuery from serializing
                success: function(response) {
                    alert(response);
                    $("#add-user-modal").modal("hide");

                    // Option 1: Reload page
                    location.reload();

                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });

        $(document).on("click", ".btn-update-user", function() {
            userID = $(this).data("id");
            getUserInfo(userID);
            $('#add-user-modal').modal('show');
            $("#modal-title").text("Edit Staff");
        });

        function getUserInfo(userID) {
            $.ajax({
                type: 'POST',
                url: 'ajax/update_ajax.php?action=get_user_info',
                data: {
                    userID: userID
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        $('#name').val(response.name);
                        $('#user_ID').val(response.user_ID);
                        // $('[name="name"]').val(userID);
                        $('#role').val(response.role);
                        $('#username').val(response.username);
                        $('#password').val('');
                        $('#department').val(response.department);
                        $('[name="team"]').val(response.team);

                        // Assigned municipalities
                        if (response.assigned_municipal) {
                            let munis = response.assigned_municipal.split(',');
                            $('input[name="municipalities[]"]').prop('checked', false); // reset
                            munis.forEach(function(m) {
                                $('input[name="municipalities[]"][value="' + m.trim() + '"]').prop('checked', true);
                            });
                        }
                    }

                }
            });
        }
    });
</script>