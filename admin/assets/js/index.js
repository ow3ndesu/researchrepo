const audio = document.getElementById("audioNotification");

function loadEverything() {
    loadProfile();
    loadDashboard();
    loadNotifications();
}

function loadProfile() {
    $.ajax({
        url: "../routes/auth.route.php",
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
        },
        error: function (error) {
            console.log(error);
        },
    });
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

function loadNotifications() {
    $.ajax({
        url: "../routes/dashboard.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadNotifications",
        },
        beforeSend: function () {
            console.log("loading notifications...");
        },
        success: function (response) {
            const notifications = response.NOTIFICATIONS;
            $('#notifications').empty();
            if (notifications.length > 0) {
                new Promise((resolve, reject) => {
                    notifications.forEach(element => {
                        console.log(element);
                        if (element.id) {
                            $('#notifications').append(`
                                <div class="row" onclick="` + ((element.status == 'PENDING' ? 'toBorrowals()' : 'toReturns()')) + `" style="cursor: pointer" title="View Borrowals">
                                    <div class="col mb-2">
                                    <div class="card border-left-` + ((element.status == 'PENDING' ? 'info' : 'primary')) + ` shadow h-100">
                                        <div class="notification card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase">
                                                ` + element.firstname + ` is ` + ((element.status == 'PENDING' ? 'borrowing' : 'returning')) + ` a book! ID (` + element.book_id + `)
                                            </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fas fa-bell text-gray-300"></i>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            `);
                            
                        } else {
                            $('#notifications').append(`
                                <div class="row" onclick="toUsers()" style="cursor: pointer" title="View Users">
                                    <div class="col mb-2">
                                    <div class="card border-left-warning shadow h-100">
                                        <div class="notification card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase">
                                                A student has registered, check it out! Username (` + element.username + `)
                                            </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fas fa-bell text-gray-300"></i>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            `);
                        }
                        resolve();
                        // audio.play();
                    });
                }).then(() => {
                    audio.play();
                })
            } else {
                $('#notifications').append(`
                    <div class="row">
                        <div class="col mb-2 text-center">
                            No Notifications.
                        </div>
                    </div>
                `);
            }
            
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function toUsers() {
    window.location.href = "./users.php";
}

function toBorrowals() {
    window.location.href = "./borrowals.php";
}

function toReturns() {
    window.location.href = "./returns.php";
}
