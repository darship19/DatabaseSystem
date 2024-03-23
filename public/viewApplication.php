<?php

if (isset($_GET['appId'])) {
    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM application
                        WHERE appId = :appId";

        $appId = $_GET['appId'];

        $statement = $connection->prepare($sql);
        $statement->bindValue(':appId', $appId);
        $statement->execute();

        $application = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php require "templates/header.php"; ?>

<?php
    if ($application) { ?>
        <h2>Application Details</h2>
        <p><b>Application Name</b>: <?php echo escape($application["applicationName"]); ?></p>
        <p><b>Developer Name</b>: <?php echo escape($application["developerName"]); ?></p>
        <p><b>Size (GB)</b>: <?php echo escape($application["sizeInGB"]); ?></p>
        <p><b>Average Rating</b>: <?php echo escape($application["averageRating"]); ?></p>
        <p><b>Date</b>: <?php
            $applicationDate = new DateTime($application["date"]);
            echo $applicationDate->format('Y-m-d');
        ?></p>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_GET['appId']); ?>.</blockquote>
    <?php }
?>

<a href="editApplication.php?appId=<?php echo escape($application["appId"]); ?>">Edit </a><br>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
