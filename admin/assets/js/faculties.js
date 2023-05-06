$(document).ready(function () {
    $("#facultiestable").DataTable({
        pageLength: 5,
    });
    loadEverything();
});

function loadEverything() {
    loadFaculties();
}

$("#addFacultyModalBtn").click(function () {
    $("#addFacultyModal").modal("show");
});

function loadFaculties() {
    $.ajax({
        url: "../routes/faculties.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadFaculties",
        },
        beforeSend: function () {
            console.log("loading faculties...");
            if ($.fn.DataTable.isDataTable("#facultiestable")) {
                $("#facultiestable").DataTable().clear();
                $("#facultiestable").DataTable().destroy();
            }
            $("#facultiesTableBody")
                .empty()
                .append(
                    "<tr><td colspan='6'>Loading! Please wait...</td></tr>"
                );
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "FACULTIES_LOADED") {
                $("#facultiesTableBody").empty();
                response.FACULTIES.forEach((element) => {
                    $("#facultiesTableBody").append(
                        `
                        <tr>
                            <td>` +
                            element.faculty_id +
                            `</td>
                            <td>` +
                            (element.firstname != ""
                                ? element.firstname
                                : "-") +
                            `</th>
                            <td>` +
                            (element.middlename != ""
                                ? element.middlename
                                : "-") +
                            `</td>
                            <td>` +
                            (element.lastname != "" ? element.lastname : "-") +
                            `</td>
                            <td>` +
                            (element.contact_no != ""
                                ? element.contact_no
                                : "-") +
                            `</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary me-2" onclick="viewFaculty(\'` +
                            element.faculty_id +
                            `\')"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteFaculty(\'` +
                            element.faculty_id +
                            `'\)"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                      `
                    );
                });

                $("#facultiestable").DataTable({
                    pageLength: 5,
                });
            } else {
                $("#facultiesTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='6'>Oops! No faculty found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

$('#addFacultyForm').unbind('submit').submit(function() {
    
    let formdata = new FormData();
    formdata.append('action', 'AddFaculty');

    if ($('#password').val() != $('#confirm').val()) {
        Swal.fire({
            icon: "error",
            title: "Incorrect Password.",
            text: "Password and Confirm should be the same.",
        })
        return;
    }
    
    $('#addFacultyForm *').find(':input:not(button)').each((index, element) => {
        if (element.required && element.value == '') {
            Swal.fire({
                icon: "error",
                title: "Complete Fields.",
                text: "Please complete required fields.",
            })
            return;
        }

        formdata.append(element.id, element.value)
    });

    Swal.fire({
        title: 'Proceed Add?',
        text: `This action will add ${formdata.get('lastname')} as faculty. Proceed?`,
        icon: 'question',
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonColor: '#435ebe',
        confirmButtonText: 'Yes, proceed!',
        allowOutsideClick: false,
        preConfirm: (e) => {
            return $.ajax({
                url: "../routes/faculties.route.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    console.log(`updating ${formdata.get('lastname')}...`)
                },
                success: function(response) {
                    return response;
                },
                error: function(err) {
                    console.log(err);
                }
            });
        },
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value == 'ADD_SUCCESSFUL') {
                Swal.fire({
                    icon: "success",
                    text: `${formdata.get('lastname')} Successfuly Added!`,
                });

                loadFaculties();
                $("#addFacultyModal").modal("hide");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error Adding Faculty.",
                    text: result.value,
                })
            }
        }
    });
});

function UpdateFaculty(
    faculty_id,
    firstname,
    middlename,
    lastname,
    address,
    contact_no,
    created_at
) {
    $.ajax({
        url: "../routes/faculties.route.php",
        type: "POST",
        data: {
            action: "UpdateFaculty",
            faculty_id: faculty_id,
            firstname: firstname,
            middlename: middlename,
            lastname: lastname,
            address: address,
            contact_no: contact_no,
            created_at: created_at,
        },
        beforeSend: function () {
            console.log("updating faculty...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function DeleteFaculty(faculty_id) {
    $.ajax({
        url: "../routes/faculties.route.php",
        type: "POST",
        data: {
            action: "DeleteFaculty",
            faculty_id: faculty_id,
        },
        beforeSend: function () {
            console.log("deleting Faculty...");
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
$("#addBookForm")
    .unbind("submit")
    .submit(function () {
        const title = $("#title").val();
        const author = $("#author").val();
        const description = $("#description").val();
        const quantity = $("#quantity").val();
        const status = $("#status").val();

        Swal.fire({
            title: "Add Book?",
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
                return addBook(title, author, description, quantity, status);
            },
        }).then((result) => {
            if (result.isDismissed) {
                Swal.fire("Backin' out?", "Nothing Changes!", "info");
            } else {
                if (result.value != true) {
                    Swal.fire("Eek!", "Something went wrong?", "error");
                } else {
                    Swal.fire("Hooray!", "Book Added!", "success").then(() => {
                        $("#addFacultyModal").modal("hide"), loadFaculties();
                    });
                }
            }
        });
    });

function addFaculty(user_id) {
    Swal.fire({
        title: "Add as Faculty?",
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
            return AddFaculty(user_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Faculty Added!", "success").then(() => {
                    loadUsers(),
                        loadFaculties(),
                        $("#addFacultyModal").modal("hide");
                });
            }
        }
    });
}

function viewFaculty(faculty_id) {
    $("#faculty_id").val(faculty_id);
    $.ajax({
        url: "../routes/faculties.route.php",
        type: "POST",
        data: {
            action: "LoadFaculty",
            faculty_id: faculty_id,
        },
        dataType: "JSON",
        beforeSend: function () {
            console.log("fetching faculty...");
        },
        success: function (response) {
            response.FACULTY.forEach((element) => {
                console.log(element);
                element.faculty_id != ""
                    ? $("#newfaculty_id")
                          .val(element.faculty_id)
                          .prop("required", true)
                    : $("#newfaculty_id").prop("disabled", true);
                element.firstname != ""
                    ? $("#newfirstname")
                          .val(element.firstname)
                          .prop("required", true)
                    : $("#newfirstname").prop("disabled", true);
                element.middlename != ""
                    ? $("#newmiddlename")
                          .val(element.middlename)
                          .prop("required", true)
                    : $("#newmiddlename").prop("disabled", true);
                element.lastname != ""
                    ? $("#newlastname")
                          .val(element.lastname)
                          .prop("required", true)
                    : $("#newlastname").prop("disabled", true);
                element.address != ""
                    ? $("#newaddress")
                          .val(element.address)
                          .prop("required", true)
                    : $("#newaddress").prop("disabled", true);
                element.contact_no != ""
                    ? $("#newcontact_no")
                          .val(element.contact_no)
                          .prop("required", true)
                    : $("#newcontact_no").prop("disabled", true);
                element.created_at != ""
                    ? $("#date").val(element.created_at).prop("disabled", true)
                    : $("#date").prop("disabled", true);
            }),
                $("#updateFacultyModal").modal("show");

            $("#updateFacultyForm")
                .unbind("submit")
                .submit(function () {
                    const faculty_id = $("#newfaculty_id").val() || "";
                    const firstname = $("#newfirstname").val() || "";
                    const middlename = $("#newmiddlename").val() || "";
                    const lastname = $("#newlastname").val() || "";
                    const address = $("#newaddress").val() || "";
                    const contact_no = $("#newcontact_no").val() || "";
                    const created_at = $("#date").val() || "";

                    Swal.fire({
                        title: "Update Faculty?",
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
                            return UpdateFaculty(
                                faculty_id,
                                firstname,
                                middlename,
                                lastname,
                                address,
                                contact_no,
                                created_at
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
                                    "Book Updated!",
                                    "success"
                                ).then(() => {
                                    $("#updateFacultyModal").modal("hide"),
                                        loadFaculties();
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

function deleteFaculty(faculty_id) {
    Swal.fire({
        title: "Delete Faculty?",
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
            return DeleteFaculty(faculty_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Faculty Deleted!", "success").then(() => {
                    loadFaculties();
                });
            }
        }
    });
}
