<?php
require "templates/header.php";

require "../config.php";

if (isset($_GET['appId'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $appId = $_GET['appId'];
        $sql = "SELECT * FROM application WHERE appId = :appId";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':appId', $appId);
        $statement->execute();

        $application = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_POST['submit'])) {
    try {
        $applicationName = $_POST['applicationName'];
        $developerName = $_POST['developerName'];
        $sizeInGB = $_POST['sizeInGB'];
        $averageRating = $_POST['averageRating'];
        $newDate = $_POST['date'];

        $existingDateTime = new DateTime($application['date']);
        $existingTime = $existingDateTime->format('H:i:s');
        $updatedDateTime = new DateTime($newDate . ' ' . $existingTime);
        $updatedDate = $updatedDateTime->format('Y-m-d H:i:s');

        $sql = "UPDATE application
                SET applicationName = :applicationName,
                    developerName = :developerName,
                    sizeInGB = :sizeInGB,
                    averageRating = :averageRating,
                    date = :date
                WHERE appId = :appId";

       $statement = $connection->prepare($sql);
        $statement->bindValue(':applicationName', $applicationName);
        $statement->bindValue(':developerName', $developerName);
        $statement->bindValue(':sizeInGB', $sizeInGB);
        $statement->bindValue(':averageRating', $averageRating);
        $statement->bindValue(':date', $updatedDate); // Use the updated datetime
        $statement->bindValue(':appId', $appId);

        $statement->execute();

        // Refresh the application data
        $application['applicationName'] = $applicationName;
        $application['developerName'] = $developerName;
        $application['sizeInGB'] = $sizeInGB;
        $application['averageRating'] = $averageRating;
        $message = "Update successful!";
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Application</title>
</head>


<body>
    <?php if ($application) : ?>
        <h2>Edit application</h2>
        <?php if (!empty($message)) : ?>
            <div style="color: green;"><?php echo $message; ?></div>
        <?php endif; ?>
<form method="post" action="editApplication.php?appId=<?php echo $application['appId']; ?>">
    <input type="hidden" name="appId" value="<?php echo $application['appId']; ?>">
    <label for="applicationName">Application Name</label>
    <input type="text" name="applicationName" id="applicationName" value="<?php echo $application['applicationName']; ?>">
    <label for="developerName">Developer Name</label>
    <input type="text" name="developerName" id="developerName" value="<?php echo $application['developerName']; ?>">
    <label for="sizeInGB">Size (GB)</label>
    <input type="text" name="sizeInGB" id="sizeInGB" value="<?php echo $application['sizeInGB']; ?>">
    <label for="averageRating">averageRating</label>
    <input type="int" name="averageRating" id="averageRating" value="<?php echo $application['averageRating']; ?>">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" value="<?php echo date('Y-m-d', strtotime($application['date'])); ?>">
    <input type="submit" name="submit" value="Save">
</form>
    <?php else : ?>
        <blockquote>No application found with the specified ID</blockquote>
    <?php endif; ?>
</body>
</html>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

