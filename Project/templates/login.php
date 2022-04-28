<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="./styles/main.css" />
  <link rel="stylesheet" href="/styles/restaurant.css" />
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="author" content="define author of the page -- Madisen Patrick and Kevin Qi" />
  <meta name="description" content="Home page for UVA moves" />
  <meta name="keywords" content="define keywords for search engines" />
  <title>UVA MOVES</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet/less" type="text/css" href="styles/indexstyles.less" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
  </script>

  <style>
    @media only screen and (max-width: 1200px) {
      [class*="col-"] {
        width: 100%;
      }

      #uvaMapArt {
        width: 200px;
      }

      .headerDiv {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
      }

      .all {
        padding: 0%;
        margin-top: 0%;
        margin: 0%;
        display: flex;
        flex-direction: column;
      }

      .headerDiv a {
        display: flex;
        flex-direction: column;
      }

      #uvaMovesHeader {
        font-size: 30px;
      }

      .test {
        padding-left: 0%;
      }
    }
  </style>
</head>

<body>
  <div class="headerDiv">
    <header>
      <nav>
        <div class="all">
          <a id="uvaMovesHeader" href="?command=homepage">UVA MOVES</a>
          <div class="test">
            <a href="?command=restaurant"> Restaurants </a>
            <a href="?command=activities"> Activities </a>
            <a href="?command=review"> Review </a>
            <a href="?command=what"> What Should I do? </a>
            <!-- NEED TO MAKE A PIC LATER  -->
            <a href="?command=profile">Profile</a>

            <!-- search bar -->
            <input type="text" placeholder="Search Here" />
          </div>
        </div>
      </nav>
    </header>
  </div>

  <div class="container" style="margin-top: 15px;">

    <div class="row justify-content-center">
      <div class="col-4">
        <h1>Log into UVA Moves</h1>
        <p> To write a review please enter a name, email and password. </p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <?php
        if (!empty($error_msg)) {
          echo "<div class='alert alert-danger'>$error_msg</div>";
        }
        ?>
        <form action="?command=login" method="post">

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" />
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" />
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary" id="loginSubmit"> Submit </button>
          </div>
        </form>

      </div>

      <!-- <p id="messageAlert"></p> -->
    </div>
  </div>


  <script type="text/javascript" language="javascript">
    $(document).ready(function() {
      $("#loginSubmit").click(function(event) {
        event.preventDefault();
        // JS OBJECTS
        let userDetails = {
          email: $("#email").val(),
          name: $("#name").val(),
          password: $("#password").val()
        };
        let email = userDetails.email;
        let name = userDetails.name;
        let password = userDetails.password;
        console.log(email);
        let text;
        if (!email && !name && !password) {
          alert("Please Enter Email, Name and Password");
        } else if (!email) {
          alert("Please Enter Email");
        } else if (!name) {
          alert("Please Enter Your Name");
        } else if (!password) {
          alert("Please Enter Your Password");
        } else {

          $("#loginSubmit").unbind('click').click()
        }

      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>