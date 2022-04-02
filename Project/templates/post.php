<!DOCTYPE html>
<html>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rname = $_POST['rname'];
        $review = $_POST['review'];

        echo "Thanks for the Review on restaurant $rname <br/>";
        echo "Your review <br/>";
        echo "<i> $review</i> <br/> is saved <br/>";
        echo "redirecting you back in 5 seconds";
    }
    ?>
    <script type="text/javascript"> 
       var num = 4;
		var URL = "index.html";
        window.setTimeout("doUpdate()", 1000);
        function doUpdate(){
			if(num != 0){
				num --;
				window.setTimeout("doUpdate()", 1000);
			}else{
				num = 4;
				window.location = URL;
			}
		}
    </script>
</body>
    
</html>