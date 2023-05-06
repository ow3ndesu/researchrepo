$(document).ready(function () {
	const attempts = $("#attempts").val();
	if (attempts <= 0) {
		let interval = 30;
		setInterval(function () {
			interval--;
			$('.form-submit-disabled').val(interval);
		}, 1000);

		setTimeout(function () {
			$.ajax({
				url: "routes/auth.route.php",
				type: "POST",
				data: {
					action: "Logout",
				},
				success: function () {
					window.location.reload();
				}
			});
		}, 30000);
	}
});

$("#signinbtn").click(function () {
	const attempts = $("#attempts").val();
	const email = $("#logemail").val();
	const password = $("#logpassword").val();

	if (email === "" || password === "") {
		Swal.fire("Where you goin?", "Please fill all fields!", "error");
	} else if (password.length < 8) {
		Swal.fire(
			"Where you goin?",
			"Passwords must be at least 8 characters!",
			"error"
		);
	} else {
		let formdata = new FormData();
		formdata.append("action", "Login");
		formdata.append("email", email);
		formdata.append("password", password);
		$.ajax({
			url: "routes/auth.route.php",
			type: "POST",
			dataType: "JSON",
			processData: false,
			contentType: false,
			data: formdata,
			beforeSend: function () {
				$(".submit-btn").addClass("spinner-border");
			},
			success: function (res) {
				$("#logpassword").val("");
				if (res.MESSAGE === "LOGIN_SUCCESS") {
					Swal.fire({
						title: "Welcome to RRS!",
						text: "Login Success",
						icon: "success",
						preConfirm: function () {
							$("#login-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");

							window.location = res.URL;
						},
					});
				} else if (res.MESSAGE === "ACCOUNT_INACTIVE") {
					Swal.fire({
						title: "Oopps!",
						text: "Account is still inactive.",
						icon: "error",
						preConfirm: function () {
							$("#login-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
						},
					});
				} else if (res.MESSAGE === "INCORRECT_COMBINATION") {
					$("#attempts").val(res.ATTEMPTS);
					Swal.fire({
						title: "Authentication Error!",
						text: "Username or password do not match! " + res.ATTEMPTS + " attempt/s left.",
						icon: "error",
						preConfirm: function () {
							$("#login-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
						},
					}).then(() => {
						if (res.ATTEMPTS == 0) {
							window.location.reload();
						}
					});
				} else if (res.MESSAGE === "NO_USER_FOUND") {
					Swal.fire({
						title: "This account do not exist.",
						text: "Create account first.",
						icon: "error",
						preConfirm: function () {
							$("#login-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
						},
					});
				} else if (res.MESSAGE === "ACCOUNT_DEACTIVATED") {
					Swal.fire({
						title: "Oopps!",
						text: "Account is deactivated!",
						icon: "error",
						preConfirm: function () {
							$("#login-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
						},
					});
				} else {
					Swal.fire({
						title: "Hey?",
						text: "Something went really wrong.",
						icon: "error",
						preConfirm: function () {
							$("#login-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
						},
					});
				}
			},
			error: function (err) {
				console.log(err);
				Swal.fire({
					title: "Hey?",
					text: "Something went really wrong.",
					icon: "error",
					preConfirm: function () {
						$("#login-form")[0].reset();
						$(".submit-btn").removeClass("spinner-border");
					},
				});
			},
		});
	}
});

$("#signupbtn").click(function () {
	const email = $("#email").val();
	const email2 = $("#email2").val();
	const password = $("#pass").val();
	const re_password = $("#re_pass").val();
	const proof = $("#image_proof")[0].files;
	console.log(proof)
	if (email === "" || email2 === "" || password === "" || re_password === "" || proof.length === 0) {
		Swal.fire("Where you goin?", "Please fill all fields!", "error");
	} else if (password !== re_password) {
		Swal.fire(
			"Could you check that again?",
			"Password is not the same!",
			"error"
		);
	} else if (password.length < 8) {
		Swal.fire(
			"Where you goin?",
			"Passwords must be at least 8 characters!",
			"error"
		);
	} else {
		let formdata = new FormData();
		formdata.append("action", "Register");
		formdata.append("email", email);
		formdata.append("email2", email2);
		formdata.append("password", password);
		formdata.append("proof", proof[0]);

		$.ajax({
			url: "routes/auth.route.php",
			type: "POST",
			processData: false,
			contentType: false,
			data: formdata,
			beforeSend: function () {
				$(".submit-btn").addClass("spinner-border");
			},
			success: function (res) {
				if (res === "REGISTER_SUCCESS") {
					Swal.fire({
						title: "Registered Successfully!",
						text: "Please wait for account approval.",
						icon: "success",
						preConfirm: function () {
							$("#register-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
							showSignIn();
						},
					});
				} else if (res === "EMAIL_ALREADY_IN_USE") {
					Swal.fire({
						title: "Oopps!",
						text: "Sounds like this email is already associated on an account.",
						icon: "error",
						preConfirm: function () {
							$("#register-form")[0].reset();
							$(".submit-btn").removeClass("spinner-border");
						},
					});
				} else {
					Swal.fire("Hey?", "Something went really wrong.", "error");
				}
			},
			error: function (err) {
				console.log(err);
				Swal.fire("Hey?", "Something went really wrong.", "error");
			},
		});
	}
});

$("#logoutbtn").click(function () {
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

$("#forgotbtn").click(function () {
	const username = $("#forgotpasswordusername").val();
	const email = $("#forgotpasswordemail").val();

	if (username === "" || email === "") {
		Swal.fire("Where you goin?", "Please fill all fields!", "error");
	} else {
		let formdata = new FormData();
		formdata.append("action", "ForgotPassword");
		formdata.append("username", username);
		formdata.append("email", email);
		$.ajax({
			url: "routes/auth.route.php",
			type: "POST",
			processData: false,
			contentType: false,
			data: formdata,
			beforeSend: function () {
				$(".forgotsubmit-btn").addClass("spinner-border");
			},
			success: function (res) {
				if (res == "EMAIL_NOTEXIST") {
					Swal.fire({
						title: "Oopps!",
						text: "Email or Username does not exists.",
						icon: "error",
						preConfirm: function () {
							$(".forgotsubmit-btn").removeClass("spinner-border");
						},
					});

					return;
				}

				if (res == "VERIFIER_SENT") {
					Swal.fire({
						title: "Verification Sent!",
						text: "Continue resetting your password.",
						icon: "success",
						preConfirm: function () {
							$(".forgotsubmit-btn").removeClass("spinner-border");
							$('#verifyotpemail').val(email);
							showVerifyOtp();
						},
					});
					return;
				}

				Swal.fire({
					title: "Hey?",
					text: "Something went really wrong.",
					icon: "error",
					preConfirm: function () {
						$(".forgotsubmit-btn").removeClass("spinner-border");
					},
				});
			},
			error: function (err) {
				console.log(err);
				Swal.fire({
					title: "Hey?",
					text: "Something went really wrong.",
					icon: "error",
					preConfirm: function () {
						$(".forgotsubmit-btn").removeClass("spinner-border");
					},
				});
			},
		});
	}
});

$("#verifyotpbtn").click(function () {
	const email = $("#verifyotpemail").val();
	const otp = $("#verifyotpotp").val();

	if ((email === "" || email === "UNAVAILABLE") || otp === "") {
		Swal.fire("Where you goin?", "Please fill all fields!", "error");
	} else {
		let formdata = new FormData();
		formdata.append("action", "VerifyOTP");
		formdata.append("email", email);
		formdata.append("otp", otp);
		$.ajax({
			url: "routes/auth.route.php",
			type: "POST",
			processData: false,
			contentType: false,
			data: formdata,
			beforeSend: function () {
				$(".resetpassword-btn").addClass("spinner-border");
			},
			success: function (res) {
				if (res == "WRONG_CODE") {
					Swal.fire({
						title: "Oopps!",
						text: "Wrong OTP code.",
						icon: "error",
						preConfirm: function () {
							$(".resetpassword-btn").removeClass("spinner-border");
						},
					});

					return;
				}

				if (res == "EXPIRED_CODE") {
					Swal.fire({
						title: "Oopps!",
						text: "OTP already expired.",
						icon: "error",
						preConfirm: function () {
							$(".resetpassword-btn").removeClass("spinner-border");
						},
					});

					return;
				}

				if (res == "CODE_ACCEPTED") {
					Swal.fire({
						title: "OTP Accepted!",
						text: "Proceed resetting your password.",
						icon: "success",
						preConfirm: function () {
							$(".resetpassword-btn").removeClass("spinner-border");
							$('#resetpasswordemail').val(email);
							showResetPassword();
						},
					});
					return;
				}

				Swal.fire({
					title: "Hey?",
					text: "Something went really wrong.",
					icon: "error",
					preConfirm: function () {
						$(".resetpassword-btn").removeClass("spinner-border");
					},
				});
			},
			error: function (err) {
				console.log(err);
				Swal.fire({
					title: "Hey?",
					text: "Something went really wrong.",
					icon: "error",
					preConfirm: function () {
						$(".resetpassword-btn").removeClass("spinner-border");
					},
				});
			},
		});
	}
});

$("#resetpasswordbtn").click(function () {
	const email = $("#resetpasswordemail").val();
	const password = $("#resetpasswordpassword").val();
	const confirm = $("#resetconfirmpassword").val();

	if ((email === "" || email === "UNAVAILABLE") || password === "" || confirm === "") {
		Swal.fire("Where you goin?", "Please fill all fields!", "error");
	} else if (password != confirm) {
		Swal.fire("Password should be equal!", "Please make that sure.", "error");
	} else {
		let formdata = new FormData();
		formdata.append("action", "ResetPassword");
		formdata.append("email", email);
		formdata.append("password", password);
		$.ajax({
			url: "routes/auth.route.php",
			type: "POST",
			processData: false,
			contentType: false,
			data: formdata,
			beforeSend: function () {
				$(".resetpassword-btn").addClass("spinner-border");
			},
			success: function (res) {
				if (res != "PASSWORD_CHANGED") {
					Swal.fire({
						title: "Hey?",
						text: "Something went really wrong.",
						icon: "error",
						preConfirm: function () {
							$(".resetpassword-btn").removeClass("spinner-border");
						},
					});

					return;
				}

				Swal.fire({
					title: "Password Changed!",
					text: "Proceed on log-in.",
					icon: "success",
					preConfirm: function () {
						$(".resetpassword-btn").removeClass("spinner-border");
						showSignIn();
					},
				});
				
			},
			error: function (err) {
				console.log(err);
				Swal.fire({
					title: "Hey?",
					text: "Something went really wrong.",
					icon: "error",
					preConfirm: function () {
						$(".resetpassword-btn").removeClass("spinner-border");
					},
				});
			},
		});
	}
});

function showSignIn() {
	$(".sign-in").show(500);
	$(".forgot").hide(500);
	$(".signup").hide(500);
	$(".verifyotp").hide(500);
	$(".resetpassword").hide(500);
}

function showSignUp() {
	$(".signup").show(500);
	$(".forgot").hide(500);
	$(".sign-in").hide(500);
	$(".verifyotp").hide(500);
	$(".resetpassword").hide(500);
}

function showForgot() {
	$(".forgot").show(500);
	$(".signup").hide(500);
	$(".sign-in").hide(500);
	$(".verifyotp").hide(500);
	$(".resetpassword").hide(500);
}

function showVerifyOtp() {
	$(".forgot").hide(500);
	$(".signup").hide(500);
	$(".sign-in").hide(500);
	$(".verifyotp").show(500);
	$(".resetpassword").hide(500);
}

function showResetPassword() {
	$(".forgot").hide(500);
	$(".signup").hide(500);
	$(".sign-in").hide(500);
	$(".verifyotp").hide(500);
	$(".resetpassword").show(500);
}

$(".signin-link").on("click", function () {
	showSignIn();
});

$(".signup-link").on("click", function () {
	showSignUp();
});

$(".forgot-link").on("click", function () {
	showForgot();
});
