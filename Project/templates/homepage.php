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
          <!-- need to fix it -->
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

  <div class="randomMoveButton">
    <img src="./styles/pictures/uvaMapArt.jpeg" alt="uvaMapArt" id="uvaMapArt" />
    <button><a href="?command=what"> Random Move </a></button>
  </div>

  <!-- a bunch of restaurants/ activities -->
  <!-- this will be produced using php code later -->
  <div class="container showdown">
    <div class="row restaurants">
      <div class="col col-sm-auto col-md-6 left">
        <!-- pics on left-->
        <a class="btn btn-outline-danger btn-sm" href="./del?id=" role="button">Not interested?</a>
        &nbsp;

        <!-- img will pop up after click will add this function later using bootstrap modal?-->
        <img class="img-fluid" src="https://images.squarespace-cdn.com/content/v1/5b1f11e53c3a537ba562331e/1539476146313-8G9HUCOZTO8ELTYJNZKN/front+of+the+building+.JPG" alt="villa" />
      </div>
      <div class="col col-md-6 col-sm-auto right">
        <!-- reviews and info the right, static page for now -->
        <div class="row">
          <!--  info, table -->
          <div class="card text-center">
            <div class="card-header">The Villa Diner</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <th scope="col">rating</th>
                    <th scope="col">address</th>
                    <th scope="col">contact</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>4.5</td>
                      <td>1250 Emmet Street N</td>
                      <td>434-296-9977</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer text-muted">
              <a href="https://www.thevilladiner.com/">view more on </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
</body>

</html>