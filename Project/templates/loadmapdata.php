<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="./styles/main.css" />
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
      rel="stylesheet/less"
      type="text/css"
      href="styles/indexstyles.less"
    />
    <link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
			crossorigin="anonymous"
		/>
		<script
			src="https://code.jquery.com/jquery-3.6.0.js"
			integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			crossorigin="anonymous"
		></script>
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

    
  <script type="text/javascript">
    $(document).ready(function () {
      // prompt user to get current location, else default?
      // 1. load home page content
      load_homepage();
      $("#nextPage").on("click", function(){
        //request next page
        // time out for couple second
        
        load_nextpage();
      });
    });

   
    function load_homepage(){
      // $.get( "ajax/test.html", function( data ) {

        $.get("../?command=searchMap", { lat: "0", lon: "0", width: $(window).width()}, function(data){
        var hp_result = data;
        // parsing results to 
        for (var i = 0; i < hp_result.length-1; i++){
          $("#hpContent").append(hp_result[i]);
        }
        // assign token data to next page
        $("#nextPage").data("token", hp_result[hp_result.length-1]);
      });
    }
    function load_nextpage(){
        // get token 
        var token = $("#nextPage").data();
        // alert(token);
        $.get("../?command=searchMap", { next_page: token.token, width: $(window).width()}, function(data){
        var hp_result = data;
        // parsing results to 
        // remove current stuff
        $("#hpContent").empty();
        for (var i = 0; i < hp_result.length-1; i++){
          $("#hpContent").append(hp_result[i]);
        }
        $("#nextPage").data("token", hp_result[hp_result.length=1]);
      })
      .fail(function() {
        alert( "your next page token is corrupted, try refreshing your page!" );
      });
    }
    // if user clicks next page, will display previous button
    // create table uvamoves_users ( id int not null, homepage text not null, email text not null, name text not null, password text not null, PRIMARY KEY (id) );
    
  </script>

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
      <img
        src="./styles/pictures/uvaMapArt.jpeg"
        alt="uvaMapArt"
        id="uvaMapArt"
      />
      <button><a href="?command=what"> Random Move </a></button>
    </div>

    <div class="container">
      <!-- display at 5 restaurants and 4 activities? -->
      <div class="row" id="hpContent">
        
      </div>
    </div>
    <div class="container">
      <div>

        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#" id="nextPage">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    
    <script type="text/javascript">
      
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJKHyxTsg6-mlXDK-ahlEv7bSziy63oCY&callback=initMap">
    </script>
  </body>
</html>


