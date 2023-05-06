$(".logoutbtn").click(function () {
    Swal.fire({
        title: "Are you sure you want to logout ?",
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
                url: "../routes/auth.route.php",
                type: "POST",
                data: {
                    action: "Logout",
                },
                success: function (response) {
                    if (response != "LOGOUT_SUCCESS") {
                        Swal.showValidationMessage(`SOMETHING WENT WRONG.`);
                    }
                },
            });
        },
    }).then((result) => {
        if (result.value == "LOGOUT_SUCCESS") {
            window.location.href = "../index.php";
        }
    });
});
