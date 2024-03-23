<?php
/**
 * Function to query information based on
 * a parameter: in this case, developerName.
 *
 */

if (isset($_POST['submit'])) {
    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);



        $sql = "SELECT *
                        FROM application
                        WHERE developerName = :developerName";

        $developerName = $_POST['developerName'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':developerName', $developerName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>App Id</th>
                    <th>Application Name</th>
                    <th>Developer Name</th>
                    <th>Size of App</th>
                    <th>averageRating</th>
                    <th>Date</th>

                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["appId"]); ?></td>
                <td><?php echo escape($row["applicationName"]); ?></td>
                <td><?php echo escape($row["developerName"]); ?></td>
                <td><?php echo escape($row["sizeInGB"]); ?></td>
                <td><?php echo escape($row["averageRating"]); ?> </td>
                <td><?php echo escape($row["date"]); ?> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for base on Developer : <?php echo escape($_POST['developerName' ]); ?>.</blockquote>
    <?php }
} ?>

<h2>Find application based on Developer Name </h2>

<form method="post">
    <label for="developerName">Developer Name</label>
    <input type="text" id="developerName" name="developerName">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="apps.php">Back to apps Home</a>

<?php require "templates/footer.php"; ?>
