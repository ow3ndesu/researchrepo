$(document).ready(function () {
    loadEverything();
});

var student_id = null;
var is_completed = 0;

function loadEverything() {
    loadStudentID();
    loadProfile();
    loadBooks();
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
                    is_completed = element.is_completed;
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

function loadBooks() {
    $.ajax({
        url: "../routes/books.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadBooks",
        },
        beforeSend: function () {
            console.log("loading books...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "BOOKS_LOADED") {
                $("#allbooks").empty();
                response.BOOKS.forEach((element) => {
                    const divhead = (is_completed != 0) ? `<div class="col-lg-3 col-sm-6" <?php ($_SESSION['isCompleted'] == 1) ? (echo 'role="button" onclick="borrowBook(\'`+ element.book_id +`\', \'` + element.title + `\')"') : '' ?> >` : `<div class="col-lg-3 col-sm-6">`;;
                    $("#allbooks").append(
                        ``+ divhead +`
                        
                            <div class="item">
                            <div class="thumb">
                                <img src="../assets/uploaded/images/`+ ((element.image != "") ? element.image : 'no-image.svg') +`" alt="" width="171px" height="171px">
                                <div class="hover-effect">
                                <div class="content">
                                    <div class="live">
                                    <a href="#">` +
                            element.book_id +
                            `</a>
                                    </div>
                                    <ul>
                                    <li><a href="#"><i class="fa fa-book"></i> ` +
                            element.quantity +
                            `pcs</a></li>
                                    <li><a href="#"><i class="fa fa-calendar"></i> ` +
                            element.inserted_at +
                            `</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div class="down-content">
                                <div class="avatar">
                                <img src="../assets/images/avatar-01.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                                </div>
                                <span><i class="fa fa-check"></i> ` +
                            element.author +
                            `</span>
                                <h4>` +
                            element.title +
                            `</h4>
                            </div>
                            </div>
                        </div>
                    `
                    );
                });
            } else {
                $("#allbooks")
                    .empty()
                    .append(
                        `
                        <div class="col-lg-3 col-sm-6 text-center">
                            Nothing to show in here!
                        </div>
                    `
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function loadBorrowedBooks() {
    $.ajax({
        url: "../routes/borrowals.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadMyBorrowals",
            student_id: student_id,
        },
        beforeSend: function () {
            console.log("loading borrowals...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "BORROWALS_LOADED") {
                $("#libraysection").empty();
                response.BORROWALS.forEach((element) => {
                    const actionbtn =
                        element.status == "PENDING"
                            ? '<a href="#" onclick="cancelBorrowal(\'' +
                              element.borrow_id +
                              "')\">Cancel</a>"
                            : '<a href="#" onclick="returnBorrowal(\'' +
                              element.borrow_id +
                              "')\">Return</a>";
                    $("#libraysection").append(
                        `
                        <div class="item">
                            <ul>
                            <li><img src="../assets/images/game-01.jpg" alt="" class="templatemo-item"></li>
                            <li>
                                <h4>` +
                            element.title +
                            `</h4><span>Sandbox</span>
                            </li>
                            <li>
                                <h4>Date Filed</h4><span>` +
                            element.filed +
                            `</span>
                            </li>
                            <li>
                                <h4>Due Date</h4><span>` +
                            element.due +
                            `</span>
                            </li>
                            <li>
                                <h4>Currently</h4><span>` +
                            element.status +
                            `</span>
                            </li>
                            <li>
                                <div class="main-border-button border-no-active">` +
                            actionbtn +
                            `</div>
                            </li>
                            </ul>
                        </div>
                    `
                    );
                });
            } else {
                $("#libraysection")
                    .empty()
                    .append(
                        `
                    <div class="item">
                        <ul class="text-center">
                        <li>Nothing in here!</li>
                        </ul>
                    </div>
                `
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

// TRIGGERED FUNCCTIONS
function borrowBook(book_id, title) {
    Swal.fire({
        title: "Borrow "+ title +"?",
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
            return $.ajax({
                url: "../routes/borrowals.route.php",
                type: "POST",
                data: {
                    action: "BorrowBook",
                    book_id: book_id,
                },
                beforeSend: function () {
                    console.log("borrowing book...");
                },
                success: function (response) {
                    // return (response != 'BOOK_BORROWED') ? false : true;
                    return response;
                },
                error: function (err) {
                    console.log(err);
                },
            }).then((result) => {
                if (!result.isDismissed) {
                    if (result.value != true) {
                        Swal.fire("Eek!", "Something went wrong?", "error");
                    } else {
                        Swal.fire("Hooray!", "Your book will be delivered to you after approval!", "success").then(() => {
                            loadBooks();
                            loadBorrowedBooks();
                        });
                    }
                }
            });
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Your book will be delivered to you after approval!", "success").then(() => {
                    loadBooks();
                    loadBorrowedBooks();
                });
            }
        }
    });
}

function cancelBorrowal(borrow_id) {
    Swal.fire({
        title: "Cancel Borrowal?",
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
            return EditBorrowalStatus(borrow_id, "CANCELED", student_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Status Updated!", "success").then(() => {
                    loadBorrowedBooks();
                });
            }
        }
    });
}

function returnBorrowal(borrow_id) {
    Swal.fire({
        title: "Return This Book?",
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
            return EditBorrowalStatus(borrow_id, "RETURNING", student_id);
        },
    }).then((result) => {
        if (result.isDismissed) {
            Swal.fire("Backin' out?", "Nothing Changes!", "info");
        } else {
            if (result.value != true) {
                Swal.fire("Eek!", "Something went wrong?", "error");
            } else {
                Swal.fire("Hooray!", "Status Updated!", "success").then(() => {
                    loadBorrowedBooks();
                });
            }
        }
    });
}
