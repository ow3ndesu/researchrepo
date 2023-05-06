<html lang="en">

<head>
    <title>Oops..</title>
    <?php include_once("../includes/pages.head.include.php");?>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.32/dist/sweetalert2.all.min.js"></script>
    <script>
        Swal.fire({
            title: 'Are you an intruder?',
            text: "This page is not for you.",
            icon: 'warning',
            showLoaderOnConfirm: true,
            confirmButtonText: 'Okay',
            allowOutsideClick: false,
            preConfirm: (e) => {
                window.location.href = "../index.php"
            },
        })
    </script>

</body>

</html>