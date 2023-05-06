<?php 
    session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <!-- Material Font -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="assets/css/global-swal2.css">
    <title>RRS - Welcome</title>
</head>

<body class="text-center">
    <input type="hidden" name="attempts" id="attempts" value="<?php echo ((isset($_SESSION['attempts'])) ? $_SESSION['attempts'] : $_SESSION['attempts'] = 3); ?>">
    <div class="main">

        <!-- Sign up form -->
        <section class="signup hidden">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" id="email" placeholder="Username" minlength="4" />
                            </div>
                            <div class="form-group">
                                <label for="email2"><i class="zmdi zmdi-inbox"></i></label>
                                <input type="email" id="email2" placeholder="Email" minlength="4" />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" id="pass" placeholder="Password" minlength="8" />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" id="re_pass" placeholder="Repeat your password" minlength="8" />
                            </div>
                            <div class="form-group">
                                <label for="image_proof"><i class="zmdi zmdi-image-o"></i></label>
                                <input type="file" id="image_proof" accept="image/*"/>
                            </div>
                            <small><b>Please upload your ID to use as proof.</b></small>
                            <div class="form-group form-button submit-btn" role="status">
                                <input type="button" id="signupbtn" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/signup-image.png" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link signin-link">I have an account</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sign in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="assets/img/signin-image.png" alt="sign up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" id="logemail" placeholder="Username" minlength="4" />
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" id="logpassword" placeholder="Password" minlength="8" />
                            </div>

                            <div class="form-group form-button submit-btn" role="status">
                                <input type="button" <?php if (!isset($_SESSION['attempts']) || ($_SESSION['attempts'] > 0)) { ?> id="signinbtn" class="form-submit" <?php } else { ?> class="form-submit-disabled" disabled <?php } ?> value="Log in"/>
                            </div>
                            <a href="#" class="signup-image-link forgot-link">Forgot Password?</a>
                            <a href="#" class="signup-image-link signup-link">Create an account</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Forgot pass form -->
        <section class="forgot hidden">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form"  style="padding-top: 50px;">
                        <h3 class="form-title">Forgot Password</h3>
                        <form class="forgot-form" id="forgot-form">
                            <div class="form-group">
                                <label for="forgotpasswordusername"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" id="forgotpasswordusername" placeholder="Username" minlength="4" />
                            </div>
                            <div class="form-group">
                                <label for="forgotpasswordemail"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" id="forgotpasswordemail" placeholder="Email" minlength="4" />
                            </div>
                            <small><b>We need your username to ensure your email ownership.</b></small>
                            <div class="form-group form-button forgotsubmit-btn" role="status">
                                <input type="button" id="forgotbtn" class="form-submit" value="Submit" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/signup-image.png" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link signin-link">I have an account</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Verify otp pass form -->
         <section class="verifyotp hidden">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form"  style="padding-top: 50px;">
                        <h3 class="form-title">Verify OTP</h3>
                        <form class="verifyotp-form" id="verifyotp-form">
                            <div class="form-group">
                                <label for="verifyotpemail"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" id="verifyotpemail" value="UNAVAILABLE" placeholder="Email" minlength="4" disabled/>
                            </div>
                            <div class="form-group">
                                <label for="verifyotpotp"><i class="zmdi zmdi-code"></i></label>
                                <input type="text" id="verifyotpotp" placeholder="OTP" />
                            </div>
                            
                            <div class="form-group form-button verifyotpsubmit-btn" role="status">
                                <input type="button" id="verifyotpbtn" class="form-submit" value="Submit" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/signup-image.png" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link signin-link">I have an account</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reset form -->
        <section class="resetpassword hidden">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form"  style="padding-top: 50px;">
                        <h3 class="form-title">Password Reset</h3>
                        <form class="resetpassword-form" id="resetpassword-form">
                            <div class="form-group">
                                <label for="resetpasswordemail"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" id="resetpasswordemail" value="UNAVAILABLE" placeholder="Email" minlength="4" disabled/>
                            </div>
                            <div class="form-group">
                                <label for="resetpasswordpassword"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" id="resetpasswordpassword" placeholder="Password" minlength="4" />
                            </div>
                            <div class="form-group">
                                <label for="resetconfirmpassword"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" id="resetconfirmpassword" placeholder="Confirm Password" />
                            </div>
                            
                            <div class="form-group form-button resetpasswordsubmit-btn" role="status">
                                <input type="button" id="resetpasswordbtn" class="form-submit" value="Submit" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/signup-image.png" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link signin-link">I have an account</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.32/dist/sweetalert2.all.min.js"></script>
    <script src="assets/js/auth.js"></script>
</body>

</html>