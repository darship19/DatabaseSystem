<?php

if (isset($_GET['categoryId'])) {
    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *  FROM category
                        WHERE categoryId = :categoryId";

        $categoryId = $_GET['categoryId'];

        $statement = $connection->prepare($sql);
        $statement->bindValue(':categoryId', $categoryId);
        $statement->execute();

        $category = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php require "templates/header.php"; ?>
<?php
    if ($category) { ?>
        <h2>Category Details</h2>
        <p><b>Category Type</b>: <?php echo escape($category["categoryName"]); ?></p>
        <p><b>Description</b>: <?php echo escape($category["description"]); ?></p>
        <p><b>Created Date</b>: <?php
            $categoryDate = new DateTime($category["createdDate"]);
            echo $categoryDate->format('Y-m-d');
        ?></p>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_GET['categoryId']); ?>.</blockquote>
    <?php }
?>

<a href="editCategory.php?categoryId=<?php echo escape($category["categoryId"]); ?>">Edit </a><br>
<a href="index.php">Back to home</a>


<?php require "templates/footer.php"; ?>
