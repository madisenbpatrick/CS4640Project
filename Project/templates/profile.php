<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./styles/main.css" />
  <link rel="stylesheet" href="./styles/profile.css" />
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="author" content="define author of the page -- Madisen Patrick and Kevin Qi" />
  <meta name="description" content="Home page for UVA moves" />
  <meta name="keywords" content="define keywords for search engines" />
  <title>UVA MOVES</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet/less" type="text/css" href="styles/indexstyles.less" />
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
            <a href="?command=profile">Profile</a>
            <a href="?command=logout">Logout</a>
            <input type="text" placeholder="Search Here" />
          </div>
        </div>
      </nav>
    </header>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>


  <div class="profileHeaders">
    <h4> Profile</h4>
    <a href="?command=yourReviews">
      <p> Your Reviews</p>
    </a>
    <div class="col col-md-6 col-sm-auto right">
      <div class="row">
        <form action="?command=editProfile" method="post">
          <center>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="<?= $user["name"] ?>" />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="<?= $user["email"] ?>" />
            </div>
            <button type="submit" class="btn btn-primary" id="update"> Update </button>
          </center>
        </form>
      </div>
    </div>

  </div>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
  </script>

  <script>
    $(document).ready(function() {
      $("#update").click(function(event) {
        event.preventDefault();
        // JS OBJECTS
        let userDetails = {
          email: $("#email").val(),
          name: $("#name").val(),
        };
        let email = userDetails.email;
        let name = userDetails.name;
        console.log(email);
        let text;
        if (!email && !name) {
          alert("nothing to update");
        } else if (!email) {
          alert("nothing to update, please add your email");
        } else if (!name) {
          alert("please add your name");
        } else {
          $("#name").attr('placeholder', name);
          $("#email").attr('placeholder', email);
          $("#update").unbind('click').click();
        }



      });
    });
  </script>
</body>

</html>