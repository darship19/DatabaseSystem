<?php
// Include your database configuration and common functions here
require "../config.php";
require "../common.php";

// Initialize variables
$applicationName = $developerName = $sizeInGB = $averageRating = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        // Initialize variables with form data
        $applicationName = $_POST['applicationName'];
        $developerName = $_POST['developerName'];
        $sizeInGB = $_POST['sizeInGB'];
        $averageRating = $_POST['averageRating'];

        // Start a transaction
        $connection->beginTransaction();

//         // Step 1: Execute the first query (insertion) for the "application" table
     $insertApplicationSql = "INSERT INTO application (applicationName, developerName, sizeInGB, averageRating)
            VALUES (:applicationName, :developerName, :sizeInGB, :averageRating)";
     $insertApplicationStatement = $connection->prepare($insertApplicationSql);

       $insertApplicationStatement->execute([
           ':applicationName' => $applicationName,
          ':developerName' => $developerName,
           ':sizeInGB' => $sizeInGB,
          ':averageRating' => $averageRating,
        ]);



        // Introduce an error by using a non-existent table name
//         $insertApplicationSql = "INSERT INTO Nonapplication (applicationName, developerName, sizeInGB, averageRating)
//               VALUES (:applicationName, :developerName, :sizeInGB, :averageRating)";
//         $insertApplicationStatement = $connection->prepare($insertApplicationSql);
//        $insertApplicationStatement->execute([
//            ':applicationName' => $applicationName,           ':developerName' => $developerName,
//            ':sizeInGB' => $sizeInGB,
//            ':averageRating' => $averageRating,
//       ]);


        // Step 2: Get the inserted Application ID
        $insertedApplicationId = $connection->lastInsertId();

        // Step 3: Execute the second query (updating) to update application_category
        $updateUserApplicationSql = "INSERT INTO application_category (CategoryId, ApplicationId) VALUES (:UserId, :ApplicationId)";
        $updateUserApplicationStatement = $connection->prepare($updateUserApplicationSql);

        // Replace with your logic to retrieve the user's ID
        $existingUserId = 1; // Replace with the correct value or logic

        $updateUserApplicationStatement->execute([
            ':UserId' => $existingUserId,
            ':ApplicationId' => $insertedApplicationId,
        ]);

        // Commit the transaction
        $connection->commit();

        // Display a success message or perform a redirect
        $successMessage = "Application '$applicationName' successfully added.";
    } catch (PDOException $error) {
        // If any query fails, roll back the transaction
        $connection->rollback();
        echo "Transaction rolled back: " . $error->getMessage();
    }
}

?>

<!-- HTML form for adding an application -->
<?php require "templates/header.php"; ?>

<h2>Add an Application</h2>

<?php if (!empty($successMessage)) { ?>
    <blockquote><?php echo $successMessage; ?></blockquote>
<?php } ?>

<form method="post">
        <label for="applicationName">Application Name</label>
        <input type="text" name="applicationName" id="applicationName" required>

        <label for="developerName">Developer Name</label>
        <input type="text" name="developerName" id="developerName" required>

        <label for="sizeInGB">Size in GB</label>
        <input type="text" name="sizeInGB" id="sizeInGB" required>

        <label for="averageRating">Average Rating</label>
        <input type="text" name="averageRating" id="averageRating" required>

        <input type="submit" name="submit" value="Add Application">
</form>

<a href="apps.php">Back to Apps Home</a>

<?php require "templates/footer.php"; ?>
