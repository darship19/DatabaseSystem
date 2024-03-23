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


        $sql = "SELECT c.*
                FROM category c
                INNER JOIN application_category ac ON c.categoryId = ac.CategoryId
                INNER JOIN application a ON ac.ApplicationId = a.appId
                WHERE a.applicationName = :applicationName";

        $applicationName = $_POST['applicationName'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':applicationName', $applicationName, PDO::PARAM_STR);
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
                    <th>Category Id</th>
                    <th>Category Type</th>
                    <th>description</th>
                    <th>Created Date</th>

                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["categoryId"]); ?></td>
                <td><?php echo escape($row["categoryName"]); ?></td>
                <td><?php echo escape($row["description"]); ?></td>
                <td><?php echo escape($row["createdDate"]); ?></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for base on this Application Name : <?php echo escape($_POST['applicationName' ]); ?>.</blockquote>
    <?php }
} ?>

<h2>Find categories based on Application Name </h2>

<form method="post">
    <label for="applicationName">Application Name</label>
    <input type="text" id="applicationName" name="applicationName">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="categorys.php">Back to category Home</a>

<?php require "templates/footer.php"; ?>
