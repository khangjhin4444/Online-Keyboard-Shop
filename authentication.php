<?php 
session_set_cookie_params([
  'httponly' => true,  // Ngăn JavaScript truy cập session cookie
  'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
  'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
$_SESSION = [];

session_unset();
session_destroy();
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="css/authentication.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
  <style>
    body {
      font-family: Roboto;
    }
  </style>
  
</head>

<body>
  <div class="container-fluid" style="height: 100vh;">
    <div class="row h-100">
      <div class="left-side p-0 col-lg-5 d-none d-lg-block h-100">
          <img class="background-image img-fluid h-100" style="object-fit: cover;" src="images/taco-01-796855b0-20a3-45b8-874.webp">
      </div> 
         
      <div class="right-side p-0 col-lg-7 col-12 h-100" style="padding-left: 20px; padding-right:20px;">
        <section class="login-section main-content active h-100">
          <div class="login-box container-fluid h-100 d-flex flex-column justify-content-center" >
            <div class="d-flex flex-column align-items-center">
              <h2 style="font-weight: 700;">Welcome back</h2>
              <div class="d-flex gap-2 align-items-center">
                <p style="color: #878787; font-family: Roboto; font-size: 15px;">New to App?</p>
                <a class="sign-up-ui" style="font-size: 15px; cursor: pointer; color: var(--primary, #3B9AB8); text-decoration: underline;">Sign up</a>
              </div>
            </div>

            <div class="d-flex flex-column align-items-start gap-2" >
              <p style="color: #000; font-size: 20px;">User name</p>
              <input class="email" placeholder="User name" style="width: 100%; padding: 14px; border-radius: 10px; border: 1px solid #B6B6B8;">
            </div>

            <div class="d-flex flex-column align-items-start gap-2">
              <p style="color: #000; font-size: 20px;">Your password</p>
              <div style="position: relative; width: 100%;">
                <input class="password" id="password" type="password" placeholder="Enter password" style="width: 100%; padding: 14px; border-radius: 10px; border: 1px solid #B6B6B8;">
                <button id="togglePassword" type="button" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: none; border: none; cursor: pointer;" tabindex="-1">
                  <img id="eyeIcon" src="https://cdn-icons-png.flaticon.com/512/709/709612.png" alt="Show" style="width: 20px; height: 20px;">
                </button>
              </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px; width: 100%; align-items: center;">
              <button class="login-button inactive" disabled>Login</button>
              <a class="forgot-ui" style="font-size: 15px; cursor: pointer; color: var(--primary, #3B9AB8); text-decoration: underline;">Forgot password?</a>

              <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                <p>Or log in with</p>
                <div class="last-row">
                  <button disabled style='cursor: not-allowed;'><img style="width: 22px;" src="images/google.png"></button>
                  <button disabled style='cursor: not-allowed;'><img style="width: 22px;" src="images/Facebook.png"></button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="signup-section main-content h-100">
          <form class="login-box signup-box container d-flex align-items-center justify-content-center h-100" action="" method="post">
            <div class="d-flex flex-column align-items-center justify-content-center" style="width: 100%;">
              <h2 style="font-size: 34px; font-weight: bold;">Hey there</h2>
              <div class="d-flex align-items-center justify-content-center gap-2">
                <p style="font-size: 15px; color: #878787;">Already know App?</p>
                <a class="log-in-ui" style="font-size: 15px;
                  cursor: pointer;
                  color: var(--primary, #3B9AB8);
                  text-decoration-line: underline;
                  text-decoration-style: solid;">Log In</a>
              </div>
            </div>

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="color: #000; font-size: 20px; font-weight: 400;">User name</p>
              <input required class="signup-email" placeholder="User name" style="
              width: 100%;
              padding-left: 14px;
              padding-top: 14px;
              padding-bottom: 16px;
              align-items: center;
              border-radius: 10px;
              border: 1px solid #B6B6B8;">
              <div class="email-notification">
              </div>
              <ul>
                <li>Contain 8-20 characters</li>
              </ul>
            </div>

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="color: #000; font-size: 20px; font-weight: 400;">Your password</p>
              <div style="position: relative; width: 100%;">
                <input required id="password1" 
                      type="password" 
                      placeholder="Enter password" 
                      style="display: flex;
                              width: 100%;
                              padding-left: 14px;
                              padding-top: 14px;
                              padding-bottom: 16px;
                              align-items: center;
                              gap: 10px;
                              border-radius: 10px;
                              border: 1px solid #B6B6B8;">
                <button id="togglePassword1" 
                        type="button" 
                        style="position: absolute;
                              top: 50%;
                              right: 10px;
                              transform: translateY(-50%);
                              background: none;
                              border: none;
                              cursor: pointer;" tabindex="-1">
                  <img id="eyeIcon1" 
                      src="https://cdn-icons-png.flaticon.com/512/709/709612.png" 
                      alt="Show" 
                      style="width: 20px; height: 20px;">
                </button>
              </div>
              <ul>
                <li>Contain 10-20 characters</li>
                <li>At least 1 Uppercase letter and 1 Number</li>
              </ul>
            </div>

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="color: #000; font-size: 20px; font-weight: 400;">Confirm your password</p>
              <div style="position: relative; width: 100%;">
                <input required id="password2" 
                      type="password" 
                      placeholder="Enter password" 
                      style="display: flex;
                              width: 100%;
                              padding-left: 14px;
                              padding-top: 14px;
                              padding-bottom: 16px;
                              align-items: center;
                              gap: 10px;
                              border-radius: 10px;
                              border: 1px solid #B6B6B8;">
                <button id="togglePassword2" 
                        type="button" 
                        style="position: absolute;
                              top: 50%;
                              right: 10px;
                              transform: translateY(-50%);
                              background: none;
                              border: none;
                              cursor: pointer;" tabindex="-1">
                  <img id="eyeIcon2" 
                      src="https://cdn-icons-png.flaticon.com/512/709/709612.png" 
                      alt="Show" 
                      style="width: 20px; height: 20px;">
                </button>
              </div>
              <p class="signup-display-message" style="color: red; font-size: 14px; margin: 4px 0 0;"></p>
            </div>
            

            <div style="display: flex;
                  flex-direction: column;
                  gap: 16px;
                  width: 100%;
                  align-items: center;
                  justify-content: center;">
              <button class="login-button" type="submit">Continue</button>

              <div style="display: flex;
              flex-direction: column;
              align-items: center;
              gap: 12px;
              align-self: stretch;">
                <p>Or log in with</p>
                <div class="last-row">
                  <button disabled style="cursor:not-allowed"><img style="width: 22px;" src="images/google.png"></button>
                  <button disabled style="cursor:not-allowed"><img style="width: 22px;" src="images/Facebook.png"></button>
                </div>
              </div>
            </div>
          </form>
        </section>

        <section class="information-section main-content h-100">
          <form class="login-box info-box container d-flex align-items-center justify-content-center h-100">
            <div class="d-flex flex-column align-items-center justify-content-center gap-2" style="width: 100%;">
              <h2 style="font-size: 35px; font-weight: 700;">Hey there</h2>
              <div class="d-flex align-items-center justify-content-center gap-2">
                <p style="color: #878787; font-size: 15px; font-weight: 400;">Already know App?</p>
                <a class="log-in-ui" style="font-size: 15px;
                  cursor: pointer;
                  color: var(--primary, #3B9AB8);
                  text-decoration-line: underline;">Log In</a>

                <a class="go-back" style="font-size: 15px;
                  cursor: pointer;
                  margin-left: 5px;
                  color: var(--primary, #3B9AB8);
                  text-decoration-line: underline;">Go back</a>
              </div>
            </div>

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="font-size: 20px; font-weight: 400;">Full name</p>
              <input required class="name" placeholder="Name" style="
              width: 100%;
              padding-left: 14px;
              padding-top: 14px;
              padding-bottom: 16px;
              align-items: center;
              border-radius: 10px;
              border: 1px solid #B6B6B8;">
            </div>

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="font-size: 20px; font-weight: 400;">Phone Number</p>
              <div required style="position: relative; width: 100%;">
                <input class="phone" id="phone" 
                      type="id" 
                      placeholder="Enter Phone Number" 
                      style="display: flex;
                              width: 100%;
                              padding-left: 14px;
                              padding-top: 14px;
                              padding-bottom: 16px;
                              align-items: center;
                              gap: 10px;
                              border-radius: 10px;
                              border: 1px solid #B6B6B8;">
              </div>
            </div>

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="font-size: 20px; font-weight: 400;">Address</p>
              <div style="position: relative; width: 100%;">
                <input class="address" required id="address" 
                      type="text" placeholder="Enter Address"
                      style="display: flex;
                              width: 100%;
                              padding-left: 14px;
                              padding-top: 14px;
                              padding-bottom: 16px;
                              align-items: center;
                              gap: 10px;
                              border-radius: 10px;
                              border: 1px solid #B6B6B8;">
              </div>
            </div>
            <div style="display: flex;
            flex-direction: column;
            gap: 16px;
            width:100%;
            align-items: center;
            justify-content: center;">
              <button class="login-button" type="submit">Sign Up</button>
            </div>
          </form>
        </section>

        <section class="forgot-section main-content h-100">
          <form class="login-box forgot-box container d-flex align-items-center justify-content-center h-100" action="" method="post">
            <div class="d-flex flex-column align-items-center justify-content-center gap-2" style="width: 100%;">
              <h2 style="font-size: 35px; font-weight: 700;">Forgot Password</h2>
              <div class="d-flex align-items-center justify-content-center gap-2">
                <p style="color: #878787; font-size: 15px; font-weight: 400;">Already know App?</p>
                <a class="log-in-ui" style="font-size: 15px;
                  cursor: pointer;
                  color: var(--primary, #3B9AB8);
                  text-decoration-line: underline;">Log In</a>
              </div>
            </div>

        

            <div class="d-flex flex-column align-items-start justify-content-center gap-1" style="width: 100%;">
              <p style="font-size: 20px; font-weight: 400;">Enter your phone number</p>
              <div style="position: relative; width: 100%;">
                <input required id="phone-input" 
                      type="text" 
                      placeholder="Enter phone number" 
                      style="display: flex;
                              width: 100%;
                              padding-left: 14px;
                              padding-top: 14px;
                              padding-bottom: 16px;
                              align-items: center;
                              gap: 10px;
                              border-radius: 10px;
                              border: 1px solid #B6B6B8;">
              </div>
              <div class="display-message" style="color: red; font-size: 14px; margin: 4px 0 0;"></div>
            </div>
            

            <div style="display: flex;
                  margin-top: 30px;
                  flex-direction: column;
                  gap: 16px;
                  width:100%;
                  align-items: center;
                  justify-content: center;">
              <button class="login-button continue-button" type="submit">Continue</button>
            </div>
          </form>
        </section>

        <section class="reset-section main-content h-100">
          <form class="login-box reset-box container d-flex align-items-center justify-content-center h-100" action="" method="post">
            <div class="d-flex flex-column align-items-center justify-content-center gap-2" style="width: 100%;">
              <h2 style="font-size: 35px; font-weight: 700;">Forgot Password</h2>
              <div class="d-flex align-items-center justify-content-center gap-2">
                <p style="color: #878787; font-size: 15px; font-weight: 400;">Already know App?</p>
                <a class="log-in-ui" href="#" style="font-size: 15px; cursor: pointer; color: #3B9AB8; text-decoration: underline;">Log In</a>
              </div>
            </div>

            <div id="otp-section" class="w-100" style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
              <p style="font-size: 20px; font-weight: 400;">Enter OTP</p>
              <div style="display: flex; gap: 10px;">
                <input type="text" maxlength="1" class="otp-input" data-index="0" style="width: 40px; height: 40px; text-align: center; border: 1px solid #B6B6B8; border-radius: 5px; font-size: 20px;">
                <input type="text" maxlength="1" class="otp-input" data-index="1" style="width: 40px; height: 40px; text-align: center; border: 1px solid #B6B6B8; border-radius: 5px; font-size: 20px;">
                <input type="text" maxlength="1" class="otp-input" data-index="2" style="width: 40px; height: 40px; text-align: center; border: 1px solid #B6B6B8; border-radius: 5px; font-size: 20px;">
                <input type="text" maxlength="1" class="otp-input" data-index="3" style="width: 40px; height: 40px; text-align: center; border: 1px solid #B6B6B8; border-radius: 5px; font-size: 20px;">
                <input type="text" maxlength="1" class="otp-input" data-index="4" style="width: 40px; height: 40px; text-align: center; border: 1px solid #B6B6B8; border-radius: 5px; font-size: 20px;">
                <input type="text" maxlength="1" class="otp-input" data-index="5" style="width: 40px; height: 40px; text-align: center; border: 1px solid #B6B6B8; border-radius: 5px; font-size: 20px;">
              </div>
              <div class="display-message" style="color: red; font-size: 14px; margin: 4px 0 0;"></div>
              <button id="resend-otp" type="button" style="width: 100px; padding: 8px; margin-top: 10px; background: #3B9AB8; color: white; border: none; border-radius: 5px; cursor: not-allowed;" disabled>Resend OTP</button>
            </div>

            <div id="password-section" class="w-100" style="display: none; flex-direction: column; gap: 10px; margin-top: 20px;">
              <div style="position: relative; width: 100%;">
                <input required id="password-reset-1" class="pass" type="password" placeholder="Enter new password"
                  style="display: flex; width: 100%; padding-left: 14px; padding-top: 14px; padding-bottom: 16px; align-items: center; gap: 10px; border-radius: 10px; border: 1px solid #B6B6B8;">
                <button id="togglePassword-reset-1" type="button" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: none; border: none; cursor: pointer;" tabindex="-1">
                  <img id="eyeIcon-reset-1" src="https://cdn-icons-png.flaticon.com/512/709/709612.png" alt="Show" style="width: 20px; height: 20px;">
                </button>
              </div>
              <ul>
                <li>Contain 10-20 characters</li>
                <li>At least 1 Uppercase letter and 1 Number</li>
              </ul>
              <div style="position: relative; width: 100%;">
                <input required id="password-reset-2" class="re-pass" type="password" placeholder="Re-enter new password"
                  style="display: flex; width: 100%; padding-left: 14px; padding-top: 14px; padding-bottom: 16px; align-items: center; gap: 10px; border-radius: 10px; border: 1px solid #B6B6B8;">
                <button id="togglePassword-reset-2" type="button" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: none; border: none; cursor: pointer;" tabindex="-1">
                  <img id="eyeIcon-reset-2" src="https://cdn-icons-png.flaticon.com/512/709/709612.png" alt="Show" style="width: 20px; height: 20px;">
                </button>
              </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px; width: 100%; align-items: center; justify-content: center; margin-top: 20px;">
              <button disabled class="disabled login-button confirm-button" type="submit" style="width: 100%; padding: 14px; background: #3B9AB8; color: white; border: none; border-radius: 10px;">Confirm</button>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>

  <script src="js/authentication.js" type="module"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>
