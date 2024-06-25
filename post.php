<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Post Page</title>

    <style>
      body {
        font-family: Georgia, 'Times New Roman', Times, serif; 
        background: url(p12.jpg) no-repeat;
        background-position: center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      h1 {
        color: #ffffff;
      }

      .post_container {
        max-width: 300px;
        padding: 150px;
        border: 1.5px solid gray;
        border-radius: 50px;
        font-family: Georgia, 'Times New Roman', Times, serif
      }

      #postDetails p {
        color: #1f1e1e;
      }

    </style>
  </head>
  <body>
    <div class="box">
      <div class="post_container">
        <h1>Post Page</h1>
        <div id="postDetails"></div>

        <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . $post['title'] . '</h3>';
                            echo '<p>Body: ' . $post['body'] . '</p>';
                        } else {
                            echo "No post found with ID $id!";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>
</body>

</html>
      </div>
    </div>
  </body>

  <script>
    // Post Page
    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const postId = urlParams.get("id");

      fetch(`https://jsonplaceholder.typicode.com/posts/${postId}`)
        .then((response) => response.json())
        .then((post) => {
          const postDetails = document.getElementById("postDetails");
          postDetails.innerHTML = `
                    <h3>Title: ${post.title}</h3>
                    <p>Body: ${post.body}</p>
                `;
        })
        .catch((error) => console.error("Error fetching posts:", error));
    });
  </script>
</html>