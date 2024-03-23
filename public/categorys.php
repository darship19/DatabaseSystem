<?php include "templates/header.php"; ?>

<ul>
	<li><a href="createCategory.php"><strong>Create Category</strong></a> - add Category</li>
	<li><a href="readCategory.php"><strong>Read Category</strong></a> - find Category</li>
</ul>

<?php

try {
    require "../config.php";


    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM category ";

    $result = $connection->query($sql);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Recent Categories</title>
</head>
<body>
    <h2>Recently Created Categories</h2>
    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Type</th>
            <th>Description</th>
            <th>Created Date</th>
            <th>View</th>
        </tr>
        <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo $row["categoryId"]; ?></td>
            <td><?php echo $row["categoryName"]; ?></td>
            <td><?php echo $row["description"]; ?></td>
            <td><?php echo $row["createdDate"]; ?></td>
            <td><a href="viewCategory.php?categoryId=<?php echo $row["categoryId"]; ?>">View</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<a href="index.php">Back to home</a>
<?php include "templates/footer.php"; ?>