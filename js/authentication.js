//////////////////////////////////////////////////////////////
// login section
const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('togglePassword');
const eyeIcon = document.getElementById('eyeIcon');
const loginButton = document.querySelector('.login-button');
const emailInput = document.querySelector('.email');

// Toggle password visibility
togglePassword.addEventListener('click', () => {
  const isPassword = passwordInput.type === 'password';
  passwordInput.type = isPassword ? 'text' : 'password';
  eyeIcon.src = isPassword
    ? 'https://cdn-icons-png.flaticon.com/512/709/709620.png'
    : 'https://cdn-icons-png.flaticon.com/512/709/709612.png';
});

// Enable login button only if both fields are filled
function updateLoginButtonState() {
  const isEmailFilled = emailInput.value.trim() !== '';
  const isPasswordFilled = passwordInput.value.trim() !== '';
  if (isEmailFilled && isPasswordFilled) {
    loginButton.classList.remove('inactive');
    loginButton.disabled = false;
  } else {
    loginButton.classList.add('inactive');
    loginButton.disabled = true;
  }
}

emailInput.addEventListener('input', updateLoginButtonState);
passwordInput.addEventListener('input', updateLoginButtonState);

// Allow Enter key to trigger login
passwordInput.addEventListener('keydown', (event) => {
  if (event.key === 'Enter' && !loginButton.disabled) {
    loginButton.click();
  }
});

document.querySelector('.sign-up-ui').addEventListener('click',() => {
  document.querySelectorAll(".main-content").forEach(content => {
    content.classList.remove("active");
  })
  document.querySelector('.signup-section').classList.add("active");
});

document.querySelector('.forgot-ui').addEventListener('click', () => {
  document.querySelectorAll(".main-content").forEach(content => {
    content.classList.remove("active");
  })
  document.querySelector('.forgot-section').classList.add("active");
});

loginButton.addEventListener('click', () => {
  const username = emailInput.value.trim();
  const password = passwordInput.value.trim();

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "models/login.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onload = function () {
    if (this.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success === true) {
        if (response.admin === true) {
          window.location.href = 'admin.php';
        } else {
          window.location.href = "index.php";
        }
      } else {
        alert("Wrong Username or Password!");
        emailInput.value = '';
        passwordInput.value = '';
        updateLoginButtonState();
      }
    }
  };

  const data = { username, password };
  xhr.send(JSON.stringify(data));
});


//////////////////////////////////////////////////////////
// Sign up section
const form = document.querySelector(".signup-box");

function togglePasswordVisibility(inputId, iconId) {
  const passwordInput = document.getElementById(inputId);
  const eyeIcon = document.getElementById(iconId);

  eyeIcon.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    // Change the eye icon based on the state
    eyeIcon.src = isPassword
      ? 'https://cdn-icons-png.flaticon.com/512/709/709620.png'  // Eye with slash (Hide)
      : 'https://cdn-icons-png.flaticon.com/512/709/709612.png'; // Eye (Show)
  });
}

// Apply toggle function to both password fields
togglePasswordVisibility('password1', 'eyeIcon1');
togglePasswordVisibility('password2', 'eyeIcon2');

const signUpEmailInput = document.querySelector(".signup-email"); 
const passwordInput1 = document.getElementById('password1');
const passwordInput2 = document.getElementById('password2');
const displayMessage = document.querySelector('.signup-display-message');

let passMatch = false;

function checkPasswordMatch() {
  if (passwordInput1.value && passwordInput2.value && document.querySelector('.signup-email').value) {
    if (passwordInput1.value === passwordInput2.value) {
      passMatch = true;
    } else {
      passMatch = false;
      displayMessage.textContent = "Password does not match!";
    }
  } else {
    displayMessage.textContent = "";
  }
}

function checkUsernameValid() {
  const username = signUpEmailInput.value;
  // Kiểm tra độ dài
  const lengthValid = username.length >= 8 && username.length <= 20;
  if (!lengthValid) {
    signUpEmailInput.setCustomValidity("Length must be 8-20 characters")
  } else {
    signUpEmailInput.setCustomValidity("")
  }
}

signUpEmailInput.addEventListener('input', checkUsernameValid);

function checkPasswordValid() {
  const password = passwordInput1.value;
  // Kiểm tra độ dài
  const lengthValid = password.length >= 10 && password.length <= 20;
  // Kiểm tra có ít nhất 1 số
  const hasNumber = /\d/.test(password);
  // Kiểm tra có ít nhất 1 chữ in hoa
  const hasUpperCase = /[A-Z]/.test(password);
  if (!lengthValid) {
    passwordInput1.setCustomValidity("Length must be 10-20 characters")
  } else if (!hasNumber) {
    passwordInput1.setCustomValidity("Must contains at least 1 number")
  } else if (!hasUpperCase) {
    passwordInput1.setCustomValidity("Must contains at least 1 uppercase letter")
  } else {
    passwordInput1.setCustomValidity("")
  }
}



passwordInput1.addEventListener('input', checkPasswordValid);
// passwordInput2.addEventListener('input', checkPasswordMatch);




document.querySelectorAll('.log-in-ui').forEach(link => {
  link.addEventListener('click', () => {
    document.querySelectorAll(".main-content").forEach(content => {
      content.classList.remove("active");
    })
    document.querySelector('.login-section').classList.add("active");
  });
})

let savedUserName = '';
let savedPassword = '';

form.addEventListener('submit', async (e) => {
  checkPasswordMatch();
  if (!signUpEmailInput.checkValidity() || !passMatch || !passwordInput1.checkValidity()) {
    e.preventDefault();
    return;
  }


  savedUserName = signUpEmailInput.value;
  savedPassword = passwordInput1.value;
  e.preventDefault();
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "models/register.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  let data = "username=" + encodeURIComponent(savedUserName) + "&password=" + encodeURIComponent(savedPassword);

  xhr.onload = function() { 
    if (xhr.status == 200) {  
      let response = JSON.parse(xhr.responseText);
      if (response.exist == true) {
        window.alert("Existing username, please choose other username!");
      } else if (response.passCheck == true) {
        window.alert("Invalid Password!");
      } else {
        document.querySelectorAll(".main-content").forEach(content => {
          content.classList.remove("active");
        })
        document.querySelector('.information-section').classList.add("active");
      }
    }
  };
  xhr.send(data);
  
})


//////////////////////////////////////////////////////////
// Information section
document.querySelector('.go-back').addEventListener('click', () => {
  document.querySelectorAll(".main-content").forEach(content => {
    content.classList.remove("active");
  })
  document.querySelector('.signup-section').classList.add("active");
  // signUpEmailInput.value = '';
  // passwordInput1.value = '';
  // passwordInput2.value = '';
});


const infoForm = document.querySelector(".info-box");

const nameInput = document.querySelector(".name");
const phoneInput = document.querySelector(".phone");
const addressInput = document.querySelector(".address");

function checkPhone() {
  if (phoneInput.value.length === 10 && /^[0][1-9][0-9]{8}$/.test(phoneInput.value)) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "models/register.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    let data = "phone=" + encodeURIComponent(phoneInput.value);
    xhr.onload = function() { 
      if (xhr.status == 200) {  
        let response = JSON.parse(xhr.responseText);
        if (response.exist == true) {
          phoneInput.setCustomValidity("Existing Phone Number, please choose other Phone Number!");
        } else if (response.passCheck == true) {
          phoneInput.setCustomValidity("Invalid Phone Number!");
        } else {
          phoneInput.setCustomValidity("");
        }
      }
    };
    xhr.send(data);
  } else {
    phoneInput.setCustomValidity("Phone Number must contains 10 numbers")
  }
}

phoneInput.addEventListener("input", checkPhone)
infoForm.addEventListener('submit', async (e) => {
  
  if (!phoneInput.checkValidity()) {
    e.preventDefault();
    return;
  }
  e.preventDefault();
  const fullName = nameInput.value;
  const phone = phoneInput.value;
  const address = addressInput.value;
  let userData = {
    name: fullName,
    phone: phone,
    address: address,
    username: savedUserName,
    password: savedPassword
  };
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "models/add_user_to_db.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onload = function() {
    if (xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      if (!response.invalid) {
        setTimeout(
          alert("Sign up successful")
          , 1000)
        document.querySelectorAll(".main-content").forEach(content => {
          content.classList.remove("active");
        })
        document.querySelector('.login-section').classList.add("active");
        emailInput.value = savedUserName;
      }
    }
  };
  xhr.send(JSON.stringify(userData));
})



//////////////////////////////////////////////////////////
// Forgot password section

const forgotForm = document.querySelector(".forgot-box")
const forgotPhoneInput = document.getElementById("phone-input")
const continueBtn = document.querySelector(".continue-button")
forgotPhoneInput.addEventListener('input', () => {
  if (forgotPhoneInput.value.length !== 10 ||  isNaN(forgotPhoneInput.value)) {
    forgotPhoneInput.setCustomValidity("Phone must contains 10 numbers")
  } else {
    forgotPhoneInput.setCustomValidity("")
  }
})

forgotForm.addEventListener('submit', (e) => {
  if (!forgotPhoneInput.checkValidity()) {
    e.preventDefault()
  }
  fetch(`models/check_phone.php?phone=${forgotPhoneInput.value}`).then(res => res.json())
  .then(data => {
    if (data.status == 'failed') {
      document.querySelector(".display-message").innerHTML = "Phone number not register!"
    } else {
      fetch(`models/create_otp.php?phone=${forgotPhoneInput.value}`).then(res => res.json())
      .then(data => {
        if (data.status == 'failed') {
          document.querySelector(".display-message").innerHTML = "Phone number not register!"
        } else {
          document.querySelectorAll(".main-content").forEach(content => {
            content.classList.remove("active");
          })
          document.querySelector('.reset-section').classList.add("active");
          timeLeft = 60;
          canResend = false;
        }
        
      })
      
    }
  })
  e.preventDefault()
})


//////////////////////////////////////////////////
// Reset section
let otpValues = Array(6).fill(''); // Lưu giá trị OTP
let otpTimer = 60; // Biến để theo dõi timer resend OTP
let canResend = false; // Trạng thái nút resend
togglePasswordVisibility('password-reset-1', 'eyeIcon-reset-1');
togglePasswordVisibility('password-reset-2', 'eyeIcon-reset-2');


const resendButton = document.getElementById('resend-otp');
let timeLeft = 60;
resendButton.textContent = `Resend OTP (${timeLeft}s)`;
otpTimer = setInterval(() => {
  timeLeft--;
  resendButton.textContent = `Resend OTP (${timeLeft}s)`;
  if (timeLeft <= 0) {
    clearInterval(otpTimer);
    canResend = true;
    resendButton.disabled = false;
    resendButton.style.cursor = 'pointer';
    resendButton.textContent = 'Resend OTP';
  }
}, 1000);

const otpInputs = document.querySelectorAll('.otp-input');
document.addEventListener('DOMContentLoaded', () => {
  otpInputs[0].focus();
})
otpInputs.forEach((input, index) => {
  input.addEventListener('input', (e) => {
    const value = e.target.value;
    if (/^\d$/.test(value)) {
      otpValues[index] = value;
      if (index < 5 && value) {
        otpInputs[index + 1].focus();
      }
      if (index === 5 && value) {
        checkOTP(otpValues.join(''), forgotPhoneInput.value);
      }
    } else {
      e.target.value = '';
    }
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && !input.value && index > 0) {
      otpInputs[index - 1].focus();
    }
  });
});

resendButton.addEventListener('click', () => {
  if (canResend) {
    canResend = false;
    resendButton.disabled = true;
    resendButton.style.cursor = 'not-allowed';
    resendOTP(forgotPhoneInput.value);

    let timeLeft = 60;
    resendButton.textContent = `Resend OTP (${timeLeft}s)`;
    otpTimer = setInterval(() => {
      timeLeft--;
      resendButton.textContent = `Resend OTP (${timeLeft}s)`;
      if (timeLeft <= 0) {
        clearInterval(otpTimer);
        canResend = true;
        resendButton.disabled = false;
        resendButton.style.cursor = 'pointer';
        resendButton.textContent = 'Resend OTP';
      }
    }, 1000);
  }
});

function checkOTP(otp, phone) {
  fetch(`models/create_otp.php?otp=${otp}&phone=${phone}`).then(res => res.json())
  .then(data => {
    const displayMessage = document.querySelector('.display-message');
    const passwordSection = document.getElementById('password-section');
    const confirmBtn = document.querySelector(".confirm-button")
    const passwordInput = document.querySelector(".pass")
    const passwordReInput = document.querySelector(".re-pass")

    function validatePasswords() {
      const pass1 = passwordInput.value;
      const pass2 = passwordReInput.value;
      const validLength = pass1.length >= 10 && pass1.length <= 20;
      const hasDigit = /\d/.test(pass1);
      const hasUpper = /[A-Z]/.test(pass1);
      const passwordsMatch = pass1 === pass2;
    
      if (validLength && hasDigit && hasUpper && passwordsMatch) {
        confirmBtn.disabled = false;
        confirmBtn.classList.remove("disabled");
      } else {
        confirmBtn.disabled = true;
        confirmBtn.classList.add("disabled");
      }
    }

    if (data.status === 'success') {
      displayMessage.textContent = '';
      passwordSection.style.display = 'flex';
      passwordInput.addEventListener('input', validatePasswords);
      passwordReInput.addEventListener('input', validatePasswords);

      confirmBtn.addEventListener('click', () => {
        if (!confirmBtn.disabled) {
          try {
            fetch('models/change_password.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                phone: phone,
                password: passwordReInput.value
              })
            })
              .then(() => {
                window.alert("Password Changed!")
                // window.location.href = "authentication.php"
              });
          } catch (error) {
            console.error('Error:', error);
          }
        }
      })
    } else {
      displayMessage.textContent = 'Invalid OTP';
      passwordSection.style.display = 'none';
    }
  })

  
}

function resendOTP(phone) {
  fetch(`models/create_otp.php?phone=${phone}`).then(res => res.json())
  .then(data => {
    console.log("Resend otp")
    // console.log(data)
  })
}