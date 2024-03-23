<?php

try {
    require "../config.php";
    require "templates/header.php";

    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM application ORDER BY date DESC LIMIT 3"; // query to retrieve the last 3 created entries

    $result = $connection->query($sql);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Recent Applications</title>

</head>
<body>
    <h2>Recently Created Applications</h2>
<div class="n">
    <table class="applications-table" >
        <tr>
            <th>App ID</th>
            <th>Application Name</th>
            <th>Developer Name</th>
            <th>Size (GB)</th>
            <th>Date</th>
            <th>averageRating</th>
            <th>View</th>
        </tr>
        <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo $row["appId"]; ?></td>
            <td><?php echo $row["applicationName"]; ?></td>
            <td><?php echo $row["developerName"]; ?></td>
            <td><?php echo $row["sizeInGB"]; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["averageRating"]; ?></td>
            <td><a href="viewApplication.php?appId=<?php echo $row["appId"]; ?>">View</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

<?php

try {
    require "../config.php";


    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM category ORDER BY createdDate DESC LIMIT 3"; // query to retrieve the last 3 created entries

    $result = $connection->query($sql);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Recent Applications Category</title>
</head>
<body>
    <h2>Recently Created Category</h2>
    <table class="categories-table">
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