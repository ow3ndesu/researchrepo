$(document).ready(function () {
    loadEverything();
});

var student_id = null;

function loadEverything() {
    loadStudentID();
    loadProfile();
}

function loadStudentID() {
    $.ajax({
        url: "../routes/auth.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadProfile",
        },
        beforeSend: function () {
            console.log("loading ID...");
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function loadProfile() {
    $.ajax({
        url: "../routes/profile.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadProfile",
        },
        beforeSend: function () {
            console.log("loading profile...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "PROFILE_LOADED") {
                response.PROFILE.forEach((element) => {
                    student_id = element.student_id;

                    if (element.firstname == "" || element.lastname == "") {
                        $("#profileIdentity").empty().text(element.student_id);
                    } else {
                        $("#profileIdentity")
                            .empty()
                            .text(element.firstname + " " + element.lastname);
                    }

                    if (element.is_completed == 0) {
                        $("#status").empty().text("Incomplete");
                        $("#eligible").empty().text("No");

                        $("#profileActionButton").empty().append(`
                            <a href="#" onclick="openCompleteProfileModal()">Complete Profile</a>
                        `);
                        $("#profileRemarks")
                            .empty()
                            .text(
                                "You Haven't Completed Your Account yet. Go Complete It By Clicking The Button Below."
                            );
                        $("#student_id").val(element.student_id);
                        $("#firstname").val(element.firstname);
                        $("#middlename").val(element.middlename);
                        $("#lastname").val(element.lastname);
                        $("#address").val(element.address);
                        $("#contact_no").val(element.contact_no);
                        $("#messageopener").removeAttr('data-bs-target').text('Disabled').css('cursor', 'default');

                        // loadBorrowedBooks(element.student_id);
                    } else {
                        $("#status").empty().text("Completed");
                        $("#eligible").empty().text("Yes");

                        $("#profileActionButton").empty().append(`
                            <a href="browse.page.php">Browse Researches</a>
                        `);
                        $("#profileRemarks")
                            .empty()
                            .text(
                                "Browse through our research papers using button below."
                            );
                    }
                });
            } else {
                console.log("sus! how did u get in?");
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function updateProfile(
    student_id,
    firstname,
    middlename,
    lastname,
    address,
    contact_no
) {
    $.ajax({
        url: "../routes/profile.route.php",
        type: "POST",
        data: {
            action: "UpdateProfile",
            student_id: student_id,
            firstname: firstname,
            middlename: middlename,
            lastname: lastname,
            address: address,
            contact_no: contact_no,
        },
        beforeSend: function () {
            console.log("updating profile...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

// TRIGGERED FUNCCTIONS
function openCompleteProfileModal() {
    $("#completeProfileModal").modal("show"),
        $("#contact_no").on("input", function (e) {
            $(this).val(
                $(this)
                    .val()
                    .replace(/[^0-9]/g, "")
            );
        }),
        $("#completeProfileForm")
            .unbind("submit")
            .submit(function () {
                const student_id = $("#student_id").val();
                const firstname = $("#firstname").val();
                const middlename = $("#middlename").val();
                const lastname = $("#lastname").val();
                const address = $("#address").val();
                const contact_no = $("#contact_no").val();

                if (
                    student_id == "" ||
                    firstname == "" ||
                    lastname == "" ||
                    address == "" ||
                    contact_no == ""
                ) {
                    Swal.fire("Eek!", "Please complete the form!", "error");
                } else {
                    Swal.fire({
                        title: "Update Profile?",
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
                            return updateProfile(
                                student_id,
                                firstname,
                                middlename,
                                lastname,
                                address,
                                contact_no
                            );
                        },
                    }).then((result) => {
                        if (result.isDismissed) {
                            Swal.fire(
                                "Backin' out?",
                                "Nothing Changes!",
                                "info"
                            );
                        } else {
                            if (result.value != true) {
                                Swal.fire(
                                    "Eek!",
                                    "Something went wrong?",
                                    "error"
                                );
                            } else {
                                Swal.fire(
                                    "Hooray!",
                                    "Profile Updated!",
                                    "success"
                                ).then(() => {
                                    $("#completeProfileModal").modal("hide"),
                                        loadEverything();
                                });
                            }
                        }
                    });
                }
            });
}

$("input[type=text]").on('input', function () {
    this.value = this.value.toUpperCase();
});
