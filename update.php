<link rel="stylesheet" type="text/css" href="styles.css">

<?php

session_start(); 
$CID = $_SESSION['identifier'];
$host = 'dragon.ukc.ac.uk';
$dbname = 'br322';
$user = 'br322';
$pwd = 'hn!alib';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $updatedOrdersCount = 0; 

    if (isset($_GET['orderNo']) && isset($_GET['quantity'])) {
        
        $orderNos = $_GET['orderNo'];
        $quantities = $_GET['quantity'];
        $updateQuantitylist = $_GET['quantities'];

        for ($i = 0; $i < count($orderNos); $i++) {
            $orderNo = intval($orderNos[$i]);
            $quantity = intval($quantities[$i]);
            $updateQuantity = intval($updateQuantitylist[$i]);
            $updated = $quantity + $updateQuantity;
            $sql = "UPDATE orders SET quantity = $updated WHERE OrderNo = $orderNo";
            $handle = $conn->prepare($sql);
            $handle->execute();
            $updatedOrdersCount += $handle->rowCount(); 
        }

        if ($updatedOrdersCount > 0) {
            header("Location: confirmation.php?count=$updatedOrdersCount"); //If a user updates a products, they get redirected to confirmation.php
            exit();
        } else {
            echo "No orders were updated. Please choose which order you want to increase or decrease.";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<form method="post" action="customer.php"> 
    <input type="hidden" name="identifier" value="<?php echo $CID; ?>"> 
    <input type="submit" value="Back"> 
</form>
<input type='button' onclick="location.href='index.php';" value='Exit'>
</body>
</html>