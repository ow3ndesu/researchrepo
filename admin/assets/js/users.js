$(document).ready(function () {
    $("#userstable").DataTable({
        pageLength: 5,
    });
    loadEverything();
});

function loadEverything() {
    loadUsers();
}

function loadUsers() {
    $.ajax({
        url: "../routes/users.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadUsers",
        },
        beforeSend: function () {
            console.log("loading users...");
            if ($.fn.DataTable.isDataTable("#userstable")) {
                $("#userstable").DataTable().clear();
                $("#userstable").DataTable().destroy();
            }
            $("#usersTableBody")
                .empty()
                .append(
                    "<tr><td colspan='6'>Loading! Please wait...</td></tr>"
                );
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "USERS_LOADED") {
                $("#usersTableBody").empty();
                response.USERS.forEach((element) => {
                    $("#usersTableBody").append(
                        `
                        <tr>
                            <td>` +
                            element.user_id +
                            `</td>
                            <td>` +
                            element.username +
                            `</th>
                            <td>` +
                            element.user_type +
                            `</td>
                            <td>` +
                            element.status +
                            `</td>
                            <td>` +
                            element.created_at +
                            `</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary me-2" onclick="viewUser(` +
                            element.user_id +
                            `)"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteUser(` +
                            element.user_id +
                            `)"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                      `
                    );
                });

                $("#userstable").DataTable({
                    pageLength: 5,
                });
            } else {
                $("#usersTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='6'>Oops! No registered users found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function EditUserStatus(user_id, status) {
    $.ajax({
        url: "../routes/users.route.php",
        type: "POST",
        data: {
            action: "EditUserStatus",
            user_id: user_id,
            status: status,
        },
        beforeSend: function () {
            console.log("editing status...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function DeleteUserAccount(user_id) {
    $.ajax({
        url: "../routes/users.route.php",
        type: "POST",
        data: {
            action: "DeleteUserAccount",
            user_id: user_id,
        },
        beforeSend: function () {
            console.log("deleting user account...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

// TRIGERED FUNCTIONS
function viewUser(user_id) {
    $("#user_id").val(user_id);
    $.ajax({
        url: "../routes/users.route.php",
        type: "POST",
        data: {
            action: "LoadUser",
            user_id: user_id,
        },
        dataType: "JSON",
        beforeSend: function () {
            console.log("fetching user...");
        },
        success: function (response) {
            response.USER.forEach((element) => {
                console.log(element);
                $("#proof").empty().append(`<img src="../assets/uploaded/proofs/` + element.proof + `" width="relative" height="200px" alt="` + element.proof + `">`)
                $("#email").val(element.username);
                $("#user_type").val(element.user_type);
                $("#status").val(element.status);
                $("#created_at").val(element.created_at);

                if (element.status == "ENABLED") {
                    $("#enablebtn").prop("disabled", true);
                } else if (element.status == "DISABLED") {
                    $("#disablebtn").prop("disabled", true);
                }
            }),
                $("#viewUserModal").modal("show");

            $("#disablebtn").click(function () {
                Swal.fire({
                    title: "Disable Account?",
                    icon: "question",
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    allowOutsideClick: false,
                    customClass: {
                        input: "text-center",
                    },
                    preConfirm: (e) => {
                        return EditUserStatus(user_id, "DISABLED");
                    },
                }).then((result) => {
                    if (result.isDismissed) {
                        Swal.fire("Backin' out?", "Nothing Changes!", "info");
                    } else {
                        if (result.value != true) {
                            Swal.fire("Eek!", "Something went wrong?", "error");
                        } else {
                            Swal.fire(
                                "Hooray!",
                                "Status Updated!",
                                "success"
                            ).then(() => {
                                $("#viewUserModal").modal("hide"), loadUsers();
                            });
                        }
                    }
                });
            });

            $("#enablebtn").click(function () {
                Swal.fire({
                    title: "Enable Account?",
                    icon: "question",
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    allowOutsideClick: false,
                    customClass: {
                        input: "text-center",
                    },
                    preConfirm: (e) => {
                        return EditUserStatus(user_id, "ENABLED");
                    },
                }).then((result) => {
                    if (result.isDismissed) {
                        Swal.fire("Backin' out?", "Nothing Changes!", "info");
                    } else {
                        if (result.value != true) {
                            Swal.fire("Eek!", "Something went wrong?", "error");
                        } else {
                            Swal.fire(
                                "Hooray!",
                                "Status Updated!",
                                "success"
                            ).then(() => {
                                $("#viewUserModal").modal("hide"), loadUsers();
                            });
                        }
                    }
                });
            });
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function deleteUser(user_id) {
    Swal.fire({
        title: "Delete Account?",
        icon: "question",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        allowOutsideClick: false,
        customClass: {
            input: "text-center",
        },
        preConfirm: (e) => {
            return DeleteUserAccount(user_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Account Deleted!", "success").then(() => {
                    loadUsers();
                });
            }
        }
    });
}
