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
    
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $items = isset($_POST['items']) ? $_POST['items'] : array();
        $RID = isset($_POST['selected_region'])?$_POST['selected_region'] : array();
        
   
        if (!empty($items)) {
      
            $addedItems = array();
            
         
            foreach ($items as $item) {
               
                $check_sql = "SELECT COUNT(*) FROM orders WHERE PID = :PID AND RID = :RID AND CID = :CID";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bindParam(':PID', $item);
                $check_stmt->bindParam(':RID', $RID);
                $check_stmt->bindParam(':CID', $CID);
                $check_stmt->execute();
                $order_count = $check_stmt->fetchColumn();
                
                if ($order_count == 0) {
                    
                    $quantity = 1; 
                    
                   
                    $insert_sql = "INSERT INTO orders (PID, RID, CID, quantity) VALUES (:PID, :RID, :CID, :quantity)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bindParam(':PID', $item);
                    $insert_stmt->bindParam(':RID', $RID);
                    $insert_stmt->bindParam(':CID', $CID);
                    $insert_stmt->bindParam(':quantity', $quantity);
                    $insert_stmt->execute();
                    
                 
                    $addedItems[] = $item;
                } else {
                    
                    echo "<p>An order for the product with ID $item and region with ID $RID already exists.</p>";
                }
            }
            
            
            if (!empty($addedItems)) {
                echo "<p>The following items have been successfully added to the database: " . implode(', ', $addedItems) . "</p>";
            }
        } else {
            echo "<p>No items selected for order.</p>";
        }
    } else {
     
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>


<form method="post" action="new.php"> 
    <input type="hidden" name="identifier" value="<?php echo $CID; ?>"> 
  <input type="submit" value="BACK"> 
</form>
    <input type="button" onclick="location.href='index.php';" value="Exit">
</body>
</html>
