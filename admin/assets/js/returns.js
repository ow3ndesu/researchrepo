$(document).ready(function () {
    $("#returnstable").DataTable({
        pageLength: 5,
    });
    loadEverything();
});

function loadEverything() {
    loadReturns();
}

function loadReturns() {
    $.ajax({
        url: "../routes/returns.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadReturns",
        },
        beforeSend: function () {
            console.log("loading returns...");
            if ($.fn.DataTable.isDataTable("#returnrequeststable")) {
                $("#returnrequeststable").DataTable().clear();
                $("#returnrequeststable").DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable("#returnstable")) {
                $("#returnstable").DataTable().clear();
                $("#returnstable").DataTable().destroy();
            }
            $("#returnRequestsTableBody")
                .empty()
                .append(
                    "<tr><td colspan='6'>Loading! Please wait...</td></tr>"
                );
            $("#returnsTableBody")
                .empty()
                .append(
                    "<tr><td colspan='6'>Loading! Please wait...</td></tr>"
                );
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "RETURNS_LOADED") {

                // REQUESTS
                $("#returnRequestsTableBody").empty();
                let deleteBtn = "";
                response.REQUESTS.forEach((element) => {
                    element.status == "RETURNED"
                        ? (deleteBtn =
                              `<button type="button" class="btn btn-danger" onclick="deleteReturn(\'` +
                              element.borrow_id +
                              `'\)"><i class="fa-solid fa-trash"></i></button>`)
                        : null;

                    $("#returnRequestsTableBody").append(
                        `
                        <tr>
                            <td>` +
                            element.borrow_id +
                            `</td>
                            <td>` +
                            element.title +
                            `</th>
                            <td>` +
                            (element.lastname != "" ? element.lastname : "-") +
                            `</td>
                            <td>` +
                            element.filed +
                            `</td>
                            <td>` +
                            element.modified_at +
                            `</td>
                            <td>` +
                            element.due +
                            `</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary me-2" onclick="viewReturn(\'` +
                            element.borrow_id +
                            `\')"><i class="fa-solid fa-eye"></i></button>
                                ` +
                            deleteBtn +
                            `
                            </td>
                        </tr>
                      `
                    );
                });

                // RETURNS
                $("#returnsTableBody").empty();
                response.RETURNS.forEach((element) => {
                    element.status == "RETURNED"
                        ? (deleteBtn =
                              `<button type="button" class="btn btn-danger" onclick="deleteReturn(\'` +
                              element.borrow_id +
                              `'\)"><i class="fa-solid fa-trash"></i></button>`)
                        : null;

                    $("#returnsTableBody").append(
                        `
                        <tr>
                            <td>` +
                            element.borrow_id +
                            `</td>
                            <td>` +
                            element.title +
                            `</th>
                            <td>` +
                            (element.lastname != "" ? element.lastname : "-") +
                            `</td>
                            <td>` +
                            element.filed +
                            `</td>
                            <td>` +
                            element.returned_at +
                            `</td>
                            <td>` +
                            element.due +
                            `</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary me-2" onclick="viewReturn(\'` +
                            element.borrow_id +
                            `\')"><i class="fa-solid fa-eye"></i></button>
                                ` +
                            deleteBtn +
                            `
                            </td>
                        </tr>
                      `
                    );
                });

                $("#returnrequeststable").DataTable({
                    pageLength: 5,
                });
                $("#returnstable").DataTable({
                    pageLength: 5,
                });
            } else {
                $("#returnRequestsTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='6'>Oops! No successful borrowals found.</td></tr>"
                    );
                $("#returnsTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='6'>Oops! No successful borrowals found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function EditReturnStatus(borrow_id, status, reason) {
    $.ajax({
        url: "../routes/returns.route.php",
        type: "POST",
        data: {
            action: "EditReturnStatus",
            borrow_id: borrow_id,
            status: status,
            reason: reason || "",
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

function DeleteReturn(borrow_id) {
    $.ajax({
        url: "../routes/returns.route.php",
        type: "POST",
        data: {
            action: "DeleteBorrowal",
            borrow_id: borrow_id,
        },
        beforeSend: function () {
            console.log("deleting return...");
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
function viewReturn(borrow_id) {
    $("#borrow_id").val(borrow_id);
    $.ajax({
        url: "../routes/returns.route.php",
        type: "POST",
        data: {
            action: "LoadReturn",
            borrow_id: borrow_id,
        },
        dataType: "JSON",
        beforeSend: function () {
            console.log("fetching return...");
        },
        success: function (response) {
            response.RETURN.forEach((element) => {
                console.log(element);
                $("#borrow_id").val(element[1]);
                $("#filed").val(element[5]);
                $("#due").val(element[6]);
                $("#status").val(element[4]);
                $("#modify_by").val(element[7] != "" ? element[7] : "-");
                $("#modify_at").val(element[8] != "" ? element[8] : "-");
                $("#student_id").val(element[22]);
                $("#user_id").val(element[23]);
                $("#fullname").val(
                    (element[24] != "" ? element[24] : "-") +
                        " " +
                        (element[25] != "" ? element[25] : "-") +
                        " " +
                        (element[26] != "" ? element[26] : "-")
                );
                $("#email").val(element[32]);
                $("#address").val(element[27] != "" ? element[27] : "-");
                $("#contact_no").val(element[28] != "" ? element[28] : "-");
                $("#registration_date").val(element[30]);
                $("#newbook_id").val(element[10]);
                $("#newtitle").val(element[13]);
                $("#newauthor").val(element[14]);
                $("#newdescription").val(element[15]);
                $("#newquantity").val(element[16]);
                $("#newstatus").val(element[17]);
                $("#date").val(element[20]);

                if (element[4] == "RETURNED") {
                    $("#disapproveReturnBtn").prop("disabled", true);
                    $("#approveReturnBtn").prop("disabled", true);
                }
            }),
                $("#updateReturnModal").modal("show");

            $("#disapproveReturnBtn").click(function () {
                $("#updateReturnModal").modal("hide"),
                    Swal.fire({
                        title: "Disapprove Return?",
                        icon: "question",
                        text: "Please input a remarks.",
                        input: "textarea",
                        showCancelButton: true,
                        confirmButtonText: "Proceed",
                        inputPlaceholder: "Reason",
                        showLoaderOnConfirm: true,
                        customClass: {
                            input: "text-center",
                        },
                        preConfirm: (reason) => {
                            if (reason == "") {
                                Swal.showValidationMessage(
                                    `Please input reason`
                                );
                            } else {
                                return EditReturnStatus(
                                    borrow_id,
                                    "BORROWED",
                                    reason
                                );
                            }
                        },
                    }).then((result) => {
                        if (result.isDismissed) {
                            Swal.fire(
                                "Backin' out?",
                                "Nothing Changes!",
                                "info"
                            );
                        } else {
                            Swal.fire(
                                "Hooray!",
                                "Status Updated!",
                                "success"
                            ).then(() => {
                                $("#updateReturnModal").modal("hide"),
                                    loadReturns();
                            });
                        }
                    });
            });

            $("#approveReturnBtn").click(function () {
                Swal.fire({
                    title: "Approve Return?",
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
                        return EditReturnStatus(borrow_id, "RETURNED", "");
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
                                $("#updateReturnModal").modal("hide"),
                                    loadReturns();
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

function deleteReturn(borrow_id) {
    Swal.fire({
        title: "Delete Return?",
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
            return DeleteReturn(borrow_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Borrowal Deleted!", "success").then(
                    () => {
                        loadReturns();
                    }
                );
            }
        }
    });
}
