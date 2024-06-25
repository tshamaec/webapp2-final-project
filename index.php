<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('secret123' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: posts.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

    <style>

      body {
        font-family: 'Times New Roman', Times, serif;
        background: url(p15.jpg) no-repeat;
        background-position: center;
        background-size: cover;
        width: 100%;
        backdrop-filter: blur(5px);
      }

      .login_container {
        width: 550px;
        height: 450px;
        border: 2px solid rgba(255, 255, 2550.5);
        border-radius: 45px;
        backdrop-filter: blur(15px);
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .login_container h2 {
        color: #fff;
        text-align: center;
        font-size: 25px;
      }

      .form {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
      }

      .login_container .input_box {
        position: relative;
        margin: 35px 0;
        width: 250px;
        border-bottom: 2px solid gray;
      }

      .login_container .input_box input {
        width: 100%;
        height: 40px;
        background: transparent;
        border: none;
        padding: 0 20px 0 50px;
        color: #fff;
        font-size: 15px;
      }
      
      .btn {
        color: #fff;
        background: rgb(0, 0, 0);
        width: 100%;
        height: 50px;
        border-radius: 5px;
        font-size: 15px;
      }

      .btn:hover {
        background: rgb(255, 8, 0);
      }

      i {
        position: absolute;
        color: #fff;
        top: 15px;
        right: 0;
      }

      .popup {
        position: absolute;
        transform: translate(-50%, -50%) scale(0);
        visibility: hidden;
        text-align: center;
        color: #000;
      }

      .popup button {
        padding: 10px 0;
        margin-top: 50px;
        font-size: 18px;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
      }

      .popup h2 {
        color: #000;
      }

    </style>
  </head>
  <body>
    <div class="form">
      <div class="login_container">
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <h2>Login</h2>
          <div class="input_box">
            <input type="text" id="username" placeholder="Username" name="username" required />
            <i class="bx bxs-user"></i>
          </div>
          <div class="input_box">
            <input type="password" id="password" placeholder="Password" name="password" required/>
            <i class="bx bxs-lock-alt"></i></div>
          <div class="button">
            <input type="submit" id="submit" class="btn" value="Login" />
          </div>
          </div>
        </form>
      </div>
    </div>

    <!-- <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script> -->
  <!-- <script>
    document
      .getElementById("loginForm")
      .addEventListener("submit", function (event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        fetch("https://jsonplaceholder.typicode.com/users")
          .then((response) => response.json())
          .then((users) => {
            const user = users.find((user) => user.username === username);

            if (user) {
              if (password === "secret123") {
                window.location.href = "posts.html";
              } else {
                alert("Incorrect password!");
              }
            } else {
              alert("User not found!");
            }
          })
          .catch((error) => alert("Error fetching users:", error));
      });

    function validation() {
      if (
        document.Formfill.Cpassword.value == document.Formfill.Password.value
      ) {
        popup.classList.add("open-slide");
        return f;
      }
    }
  </script> -->
  </body>
</html>