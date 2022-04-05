<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./styles/main.css" />
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
        margin-bottom: 5%;
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


  <div class="container" style="margin-top: 15px;"">
    <div><h2>Write a Review Below</h2></div>
    <form action="?command=review" method="post">
      <div class="mb-3">
        <label for="r_name" class="form-label">Name of Place</label>
        <input type="text" class="form-control" id="r_name" name="r_name" autofocus />
      </div>

      <div class="mb-3">
        <label for="review" class="form-label">Review</label>
        <input type="text" class="form-control" id="review" name="review" />
      </div>

      <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select name="rating" id="rating">
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category" id="category">
          <option value="r_restaurant">Restaurant</option>
          <option value="r_activities">Activity</option>
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary"> Submit </button>
      </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>

</body>

</html>