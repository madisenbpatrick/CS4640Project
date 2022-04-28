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

    <div>
    <form action="?command=login" method="post">
    <div class="text-center">                
            <button type="submit" class="btn btn-primary" id="restRevBut"> Write a Review </button>
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
 <?php 
 if(isset($_SESSION['email'])){
  echo "<input id='email' type = 'hidden' value = '".$_SESSION['email']."'></input>" ;
 }
 else{
  echo "<input id='email' type = 'hidden' value = ''></input>" ;
 }
   ?>

 
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

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
  </script>

<script type = "text/javascript" language = "javascript">
$(document ).ready(function() {
    $("#restRevBut").click(function(event){
      event.preventDefault();
      var email = document.getElementById("email").value;
      
      
      console.log(email);

      if(email == ''){
        alert("Need to sign in to write a review. Press OK to continue to Login Page")
      }
      $("#restRevBut").unbind('click').click()
       
    });
});
</script>
  </body>
</html>
