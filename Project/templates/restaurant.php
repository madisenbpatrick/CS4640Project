<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="./styles/main.css" />
    <link rel="stylesheet" href="/styles/restaurant.css" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta
      name="author"
      content="define author of the page -- Madisen Patrick and Kevin Qi"
    />
    <meta name="description" content="Home page for UVA moves" />
    <meta name="keywords" content="define keywords for search engines" />
    <title>UVA MOVES</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet/less"
      type="text/css"
      href="styles/indexstyles.less"
    />
    <style>
      .allRestReviews{
        display:flex;
        flex-direction: column;
        margin-top:5%;
        align-items: center;
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
              <a href="?command=restaurant"> Restaurants </a> |
              <a href="?command=activities"> Activities </a> |
              <a href="?command=review"> Review </a> |
              <a href="?command=what"> What Should I do? </a> |
              <!-- NEED TO MAKE A PIC LATER  -->
              <a href="?command=profile">Profile</a>
              <!-- search bar -->
              <input type="text" placeholder="Search Here" />
            </div>
          </div>
        </nav>
      </header>
    </div>

    <div>
    <form action="?command=login" method="post">
    <div class="text-center">                
            <button type="submit" class="btn btn-primary"> Write a Review </button>
            </div>
    </div>

    <section class = "allRestReviews">
    <h4>Restaurant Reviews</h4>
    <div class="col col-md-6 col-sm-auto right">
    <div class="row">
    <?php
    if(is_array($uvaMoves_restReviews)){
      $sn=1;
      foreach($uvaMoves_restReviews as $i){
        ?>
              <div class="card text-center">
                <div class="card-header"> <?php echo $i["r_name"]??'';?></div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <th scope="col">Review</th>
                        <th scope="col">Rating</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?php echo $i["review"]??'';?></td>
                          <td><?php echo $i["rating"]??'';?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php 
      $sn++;}} 
    else{?>
      <tr>
      <td> <?php echo $uvaMoves_reviews; ?>
      </td>

      <tr>
      <?php
    }?>
    </div>
    </div>

  </section>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
  </body>
</html>
