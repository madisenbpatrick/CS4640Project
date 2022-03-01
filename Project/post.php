<!DOCTYPE html>
<html>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rname = $_POST['rname'];
        $review = $_POST['review'];

        echo "Thanks for the Review on, $rname <br/>";
        echo "<i> $review</i> <br/>";
    }
    ?>
</body>

</html>