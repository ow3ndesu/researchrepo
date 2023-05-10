$(document).ready(function () {
    $("#researchestable").DataTable({
        pageLength: 5,
    });
    loadEverything();
});

function loadEverything() {
    loadResearches();
}

$("#addResearchModalBtn").click(function () {
    $("#addResearchForm")[0].reset(),
        $("#addResearchForm #research_id").val("Automatically Assigned"),
        $("#addResearchModal").modal("show");
});

function loadResearches() {
    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadResearches",
        },
        beforeSend: function () {
            console.log("loading researches...");
            if ($.fn.DataTable.isDataTable("#researchestable")) {
                $("#researchestable").DataTable().clear();
                $("#researchestable").DataTable().destroy();
            }
            $("#researchesTableBody")
                .empty()
                .append(
                    "<tr><td colspan='5'>Loading! Please wait...</td></tr>"
                );
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "RESEARCHES_LOADED") {
                $("#researchesTableBody").empty();
                response.RESEARCHES.forEach((element) => {
                    $("#researchesTableBody").append(
                        `
                        <tr>
                            <td>` +
                            element.research_id +
                            `</td>
                            <td>` +
                            element.title +
                            `</th>
                            <td>` +
                            element.author +
                            `</td>
                            <td>` +
                            element.status +
                            `</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary me-2" onclick="viewResearch(\'` +
                            element.research_id +
                            `\')"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteResearch(\'` +
                            element.research_id +
                            `'\)"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                      `
                    );
                });

                $("#researchestable").DataTable({
                    pageLength: 5,
                });
            } else {
                $("#researchesTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='5'>Oops! No available research found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function addResearch(image, copy, title, author, description, status) {
    console.log(copy)
    formData = new FormData();
    formData.append('action', 'AddResearch');
    formData.append('image', image);
    formData.append('copy', copy);
    formData.append('title', title);
    formData.append('author', author);
    formData.append('description', description);
    formData.append('status', status);

    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        contentType:false,
        cache:false,
        processData:false,
        data: formData,
        beforeSend: function () {
            console.log("adding research...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function updateResearch(research_id, title, author, description, status) {
    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        data: {
            action: "UpdateResearch",
            research_id: research_id,
            title: title,
            author: author,
            description: description,
            status: status,
        },
        beforeSend: function () {
            console.log("updating research...");
        },
        success: function (response) {
            return response;
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function DeleteResearch(research_id) {
    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        data: {
            action: "DeleteResearch",
            research_id: research_id,
        },
        beforeSend: function () {
            console.log("deleting research...");
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
$("#addResearchForm")
    .unbind("submit")
    .submit(function () {
        const image = $("#image")[0].files;
        const copy = $("#copy")[0].files;
        const title = $("#title").val();
        const author = $("#author").val();
        const description = $("#description").val();
        const status = $("#status").val();

        Swal.fire({
            title: "Add Research?",
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
                return addResearch(image[0], copy[0], title, author, description, status);
            },
        }).then((result) => {
            if (result.isDismissed) {
                Swal.fire("Backin' out?", "Nothing Changes!", "info");
            } else {
                if (result.value != true) {
                    Swal.fire("Eek!", "Something went wrong?", "error");
                } else {
                    Swal.fire("Hooray!", "Research Added!", "success").then(() => {
                        $("#addResearchModal").modal("hide"), loadResearches();
                    });
                }
            }
        });
    });

function viewResearch(research_id) {
    $("#research_id").val(research_id);
    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        data: {
            action: "LoadResearch",
            research_id: research_id,
        },
        dataType: "JSON",
        beforeSend: function () {
            console.log("fetching research...");
        },
        success: function (response) {
            response.RESEARCH.forEach((element) => {
                console.log(element);
                $("#research_image").empty().append(`<img src="../assets/uploaded/images/` + element.image + `" width="relative" height="100px" alt="` + element.image + `">`)
                $("#newresearch_id").val(element.research_id);
                $("#newtitle").val(element.title);
                $("#newauthor").val(element.author);
                $("#newdescription").val(element.description);
                $("#newstatus").val(element.status);
                $("#date").val(element.inserted_at);
                $('#viewSoftCopyViewer').empty().append(`
                    <button type="button" class="btn btn-primary" onclick="viewSoftCopyBtn(\'`+ element.copy +`\', \'`+ element.title +`\')">View</button>
                `)

                if (element.status == "ACTIVE") {
                    $("#enablebtn").prop("disabled", true);
                } else if (element.status == "INACTIVE") {
                    $("#disablebtn").prop("disabled", true);
                }
            }),
                $("#updateResearchModal").modal("show");

            $("#updateResearchForm")
                .unbind("submit")
                .submit(function () {
                    const research_id = $("#newresearch_id").val();
                    const title = $("#newtitle").val();
                    const author = $("#newauthor").val();
                    const description = $("#newdescription").val();
                    const status = $("#newstatus").val();

                    Swal.fire({
                        title: "Update Research?",
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
                            return updateResearch(
                                research_id,
                                title,
                                author,
                                description,
                                status
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
                                    "Research Updated!",
                                    "success"
                                ).then(() => {
                                    $("#updateResearchModal").modal("hide"),
                                        loadResearches();
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

function viewSoftCopyBtn(file, title) {
    // window.open('../assets/uploaded/copies/'+ file +'', '_blank');
    $("#updateResearchModal").modal("hide");
    $('#viewResearchModal').modal('show');
    $('#viewResearchModal').find('#modalResearchTitle').empty().text(title);
    $('#viewResearchModal').find('iframe').attr('src','../assets/uploaded/copies/'+ file +'');
}

function deleteResearch(research_id) {
    Swal.fire({
        title: "Delete Research?",
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
            return DeleteResearch(research_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Research Deleted!", "success").then(() => {
                    loadResearches();
                });
            }
        }
    });
}
