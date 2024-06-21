<!DOCTYPE html>
<html>
<head>
    <title>Order confirmation</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Export COMP8870 </h1>
    <?php
    
    session_start();
    $CID = $_SESSION['identifier'];
    
    $updatedOrdersCount = isset($_GET['count']) ? intval($_GET['count']) : 0;
    echo "<p>Orders that were successfully updated: $updatedOrdersCount</p>";
    ?>
    <form method="post" action="customer.php"> 
    <input type="hidden" name="identifier" value="<?php echo $CID; ?>"> 
    <input type="submit" value="Back"> 
</form>

    <input type="button" onclick="location.href='index.php';" value="Exit">
    
</body>
</html>