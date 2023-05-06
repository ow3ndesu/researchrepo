$(document).ready(function () {
    $("#studentstable").DataTable({
        pageLength: 5,
    });
    loadEverything();
});

function loadEverything() {
    loadStudents();
}

$("#addStudentModalBtn").click(function () {
    $("#addStudentModal").modal("show"), loadUsers();
});

function loadStudents() {
    $.ajax({
        url: "../routes/students.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadStudents",
        },
        beforeSend: function () {
            console.log("loading students...");
            if ($.fn.DataTable.isDataTable("#studentstable")) {
                $("#studentstable").DataTable().clear();
                $("#studentstable").DataTable().destroy();
            }
            $("#studentsTableBody")
                .empty()
                .append(
                    "<tr><td colspan='6'>Loading! Please wait...</td></tr>"
                );
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "STUDENTS_LOADED") {
                $("#studentsTableBody").empty();
                response.STUDENTS.forEach((element) => {
                    $("#studentsTableBody").append(
                        `
                        <tr>
                            <td>` +
                            element.student_id +
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
                                <button type="button" class="btn btn-primary me-2" onclick="viewStudent(\'` +
                            element.student_id +
                            `\')"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteStudent(\'` +
                            element.student_id +
                            `'\)"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                      `
                    );
                });

                $("#studentstable").DataTable({
                    pageLength: 5,
                });
            } else {
                $("#studentsTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='6'>Oops! No available book found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function loadUsers() {
    $.ajax({
        url: "../routes/users.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadNonEnabledUsers",
        },
        beforeSend: function () {
            console.log("loading users...");
            $("#usersTableBody")
                .empty()
                .append(
                    "<tr><td colspan='3'>Loading! Please wait...</td></tr>"
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
                            `</td>` +
                            `<td class="text-center">
                                <button type="button" class="btn btn-primary me-2" onclick="addStudent(` +
                            element.user_id +
                            `)"><i class="fa-solid fa-plus"></i></button>
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
                        "<tr><td colspan='3'>Oops! No registered users found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function AddStudent(user_id) {
    $.ajax({
        url: "../routes/students.route.php",
        type: "POST",
        data: {
            action: "AddStudent",
            user_id,
            user_id,
        },
        beforeSend: function () {
            console.log("adding student...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function UpdateStudent(
    student_id,
    firstname,
    middlename,
    lastname,
    address,
    contact_no,
    created_at
) {
    $.ajax({
        url: "../routes/students.route.php",
        type: "POST",
        data: {
            action: "UpdateStudent",
            student_id: student_id,
            firstname: firstname,
            middlename: middlename,
            lastname: lastname,
            address: address,
            contact_no: contact_no,
            created_at: created_at,
        },
        beforeSend: function () {
            console.log("updating student...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function DeleteStudent(student_id) {
    $.ajax({
        url: "../routes/students.route.php",
        type: "POST",
        data: {
            action: "DeleteStudent",
            student_id: student_id,
        },
        beforeSend: function () {
            console.log("deleting Student...");
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
                        $("#addStudentModal").modal("hide"), loadStudents();
                    });
                }
            }
        });
    });

function addStudent(user_id) {
    Swal.fire({
        title: "Add as Student?",
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
            return AddStudent(user_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Student Added!", "success").then(() => {
                    loadUsers(),
                        loadStudents(),
                        $("#addStudentModal").modal("hide");
                });
            }
        }
    });
}

function viewStudent(student_id) {
    $("#student_id").val(student_id);
    $.ajax({
        url: "../routes/students.route.php",
        type: "POST",
        data: {
            action: "LoadStudent",
            student_id: student_id,
        },
        dataType: "JSON",
        beforeSend: function () {
            console.log("fetching student...");
        },
        success: function (response) {
            response.STUDENT.forEach((element) => {
                console.log(element);
                element.student_id != ""
                    ? $("#newstudent_id")
                          .val(element.student_id)
                          .prop("required", true)
                    : $("#newstudent_id").prop("disabled", true);
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
                $("#updateStudentModal").modal("show");

            $("#updateStudentForm")
                .unbind("submit")
                .submit(function () {
                    const student_id = $("#newstudent_id").val() || "";
                    const firstname = $("#newfirstname").val() || "";
                    const middlename = $("#newmiddlename").val() || "";
                    const lastname = $("#newlastname").val() || "";
                    const address = $("#newaddress").val() || "";
                    const contact_no = $("#newcontact_no").val() || "";
                    const created_at = $("#date").val() || "";

                    Swal.fire({
                        title: "Update Student?",
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
                            return UpdateStudent(
                                student_id,
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
                                    $("#updateStudentModal").modal("hide"),
                                        loadStudents();
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

function deleteStudent(student_id) {
    Swal.fire({
        title: "Delete Student?",
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
            return DeleteStudent(student_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Student Deleted!", "success").then(() => {
                    loadStudents();
                });
            }
        }
    });
}
