<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>EXPORT COMP8870</h1>
    <h3>Please provide your name and customer ID to begin.</h3>
    <form action="customer.php" method="post">
        <h4>
        <label for="name">Name:</label><br>
        </h4>
            <input type="text" id="name" name="name" value="Sally Smith" required><br><br>
        <h4>
            <label for="identifier">Customer Identifier:</label><br>
        </h4>    
        <input type="number" id="identifier" name="identifier" value="" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
