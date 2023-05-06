function loadEverything() {
    loadDashboard();
    loadBooks();
    loadBorrowals();
    loadReturns();
    loadStudents();

    // $(window).on('load', function () {
    //     downloadThis();
    // });
}

function loadDashboard() {
    $.ajax({
        url: "../routes/dashboard.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadDashboard",
        },
        beforeSend: function () {
            console.log("loading dashboard...");
        },
        success: function (response) {
            $('#books').text(response.BOOKS);
            $('#borrowed').text(response.BORROWED);
            $('#returned').text(response.RETURNED);
            $('#students').text(response.STUDENTS);
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
                $("#booksTableBody").empty();
                response.BOOKS.forEach((element) => {
                    $("#booksTableBody").append(
                        `
                        <tr>
                            
                            <td>` +
                            element.title +
                            `</th>
                            <td>` +
                            element.author +
                            `</td>
                            <td>` +
                            element.quantity +
                            `</td>
                            <td>` +
                            element.status +
                            `</td>
                        </tr>
                      `
                    );
                });
            } else {
                $("#booksTableBody")
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

function loadBorrowals() {
    $.ajax({
        url: "../routes/borrowals.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadBorrowed",
        },
        beforeSend: function () {
            console.log("loading borrowals...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "BORROWALS_LOADED") {
                $("#borrowalsTableBody").empty();
                response.BORROWALS.forEach((element) => {
                    $("#borrowalsTableBody").append(
                        `
                        <tr>
                            
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
                            element.due +
                            `</td>
                        </tr>
                      `
                    );
                });
            } else {
                $("#borrowalsTableBody")
                    .empty()
                    .append(
                        "<tr><td colspan='5'>Oops! No successful borrowals found.</td></tr>"
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
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
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "RETURNS_LOADED") {
                $("#returnsTableBody").empty();
                response.RETURNS.forEach((element) => {
                    $("#returnsTableBody").append(
                        `
                        <tr>
                            
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
                            element.due +
                            `</td>
                        </tr>
                      `
                    );
                });
            } else {
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
                        </tr>
                      `
                    );
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

function downloadThis() {
    var element = document.getElementById('page-top');
    var opt = {
        margin:       1,
        filename:     'RRS-REPORTS.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak:    { before: '.beforeClass', after: ['#after1', '#after2'], avoid: ['img', 'table'] }
    };

    // New Promise-based usage:
    html2pdf().set(opt).from(element).save();
}