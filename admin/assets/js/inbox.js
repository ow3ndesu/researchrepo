$(document).ready(function () {
    loadEverything();
});

function loadEverything() {
    loadInbox();
}

function loadInbox() {
    $.ajax({
        url: "../routes/messages.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadInbox",
        },
        beforeSend: function () {
            console.log("loading inbox...");
        },
        success: function (response) {
            $("#inboxcontainer").empty();
            response.INBOX.forEach(element => {
                $("#inboxcontainer").append(`
                    <div class="item border mb-2 p-2 d-flex justify-content-between" style=" border-radius: 20px; margin: auto;" role="button" onclick="openMessage(\'`+ element.student_id +`\')">
                        <div class="d-flex justify-content-between align-items-center">
                            <img src="../assets/images/avatar-0`+ (Math.floor(Math.random() * (4 - 1 + 1) + 1)) +`.jpg" alt="avatar" class="avatar mr-4" style="border-radius: 50%; width="50px" height="50px">
                            <div>
                                <div><b>`+ capitalizeFirstLetter((element.firstname) + ' ' + capitalizeFirstLetter(element.middlename) + ' ' + capitalizeFirstLetter(element.lastname)) +`</b></div>
                                <div>`+ element.message +`</div>
                            </div>
                            
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <div>`+ element.created_at +`</div>
                        </div>
                    </div>
                `);
            });
        },
        error: function (error) {
            console.log(error);
            $("#inboxcontainer").empty().append(`
                <div class="item border mb-2 p-2 d-flex justify-content-center align-items-center" style=" border-radius: 20px; margin: auto;" role="button">
                    <div>No Messages Yet.</div>
                </div>
            `);
        },
    });
}

function loadMessages(student_id) {
    $.ajax({
        url: "../routes/messages.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadMessages",
            student_id: student_id
        },
        beforeSend: function () {
            console.log("loading messages...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "MESSAGES_LOADED") {
                $('.message-box').empty();
                response.MESSAGES.forEach((element) => {
                    if (element.isAdmin == 1) {
                        $('.message-box').append(`
                            <div class="row sent mt-2">
                                <div class="col text-end" style="text-align: -webkit-right !important;">
                                <span style=" display: flex; border: 1px solid #3f72af; border-radius: 10px; width: fit-content; padding: .2rem 1rem .2rem 1rem; flex-wrap: wrap; background-color: #3f72af; color: #fff;">`+ element.message +`</span>
                                <small class="text-secondary" style="font-size: .7rem; margin-right: 2%;">`+ element.created_at +`</small>
                                </div>
                            </div>
                        `)
                    } else {
                        $('.message-box').append(`
                            <div class="row recieved">
                                <div class="col">
                                <span style=" display: flex; border: 1px solid rgb(219 226 239); border-radius: 10px; width: fit-content; padding: .2rem 1rem .2rem 1rem; flex-wrap: wrap; background-color: rgb(219 226 239);">`+ element.message +`</span>
                                <small class="text-secondary" style="font-size: .7rem; margin-left: 2%;">`+ element.created_at +`</small>
                                </div>
                            </div>
                        `)
                    }
                    $("#reply_to").val(element.id)
                });

                $("#student_id").val(student_id);
            } else {
                console.log(response);
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function openMessage(student_id) {
    loadMessages(student_id);
    $("#messagesModal").modal('show');
}

$(document).on('input', '#message-input', function () {
    if ($(this).val() === "") {
        $("#sendMessageBtn").prop('disabled', true);
    } else {
        $("#sendMessageBtn").prop('disabled', false);
    }
})

$('#closeMessageModalBtn').click(function () {
    $("#messagesModal").modal('hide');
})

$("#sendMessageBtn").click(function () {
    const message = $('#message-input').val();
    const reply_to = $('#reply_to').val();

    if (message == "") {
        Swal.fire("Nothing there?", "Please input message!", "error");
    } else {
        $.ajax({
            url: "../routes/messages.route.php",
            type: "POST",
            data: {
                action: "SendMessage",
                message: message,
                reply_to: reply_to,
                student_id: $('#student_id').val()
            },
            beforeSend: function () {
                console.log("sending message...");
            },
            success: function (response) {
                if (response == "SENT_SUCCESSFUL") {
                    Swal.fire("Yeeey!", "Message Successfully Sent!", "success").then(() => {
                        $('#message-input').val("");
                        loadInbox();
                        loadMessages($('#student_id').val());
                    }).catch((err) => {
                        console.log(err)
                    });
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

})

const capitalizeFirstLetter = ([ first, ...rest ], locale = navigator.language) =>
  first === undefined ? '' : first.toLocaleUpperCase(locale) + rest.join('');
