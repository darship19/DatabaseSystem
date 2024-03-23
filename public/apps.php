<?php include "templates/header.php"; ?>

<ul>
	<li><a href="createApplication.php"><strong>Create</strong></a> - add  application in PlayStore</li>
	<li><a href="read.php"><strong>Read</strong></a> - find the application</li>
</ul>

<?php

try {
    require "../config.php";


    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM application ";

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
    <table>
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
</body>
</html>

<a href="index.php">Back to home</a>
<?php include "templates/footer.php"; ?>