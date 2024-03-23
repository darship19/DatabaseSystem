<?php
require "templates/header.php";

require "../config.php";

if (isset($_GET['categoryId'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $categoryId = $_GET['categoryId'];
        $sql = "SELECT * FROM category WHERE categoryId = :categoryId";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':categoryId', $categoryId);
        $statement->execute();

        $category = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_POST['submit'])) {
    try {
        $categoryName = $_POST['categoryName'];
        $description = $_POST['description'];
        $newDate = $_POST['createdDate'];


        $existingDateTime = new DateTime($category['createdDate']);
        $existingTime = $existingDateTime->format('H:i:s');
        $updatedDateTime = new DateTime($newDate . ' ' . $existingTime);
        $updatedDate = $updatedDateTime->format('Y-m-d H:i:s');

        $sql = "UPDATE category
                SET categoryName = :categoryName,
                    description = :description,
                    createdDate = :createdDate
                WHERE categoryId = :categoryId";

       $statement = $connection->prepare($sql);
        $statement->bindValue(':categoryName', $categoryName);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':createdDate', $updatedDate); // Use the updated datetime
        $statement->bindValue(':categoryId', $categoryId);

        $statement->execute();

        // Refresh the application data
        $category['categoryName'] = $categoryName;
        $category['description'] = $description;
        $message = "Update successful!";
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>


<body>
    <?php if ($category) : ?>
        <h2>Edit category</h2>
        <?php if (!empty($message)) : ?>
            <div style="color: green;"><?php echo $message; ?></div>
        <?php endif; ?>
<form method="post" action="editCategory.php?categoryId=<?php echo $category['categoryId']; ?>">
    <input type="hidden" name="categoryId" value="<?php echo $category['categoryId']; ?>">
    <label for="categoryName">Category Type</label>
    <input type="text" name="categoryName" id="categoryName" value="<?php echo $category['categoryName']; ?>">
    <label for="description">Description</label>
    <input type="text" name="description" id="description" value="<?php echo $category['description']; ?>">
    <label for="createdDate">Date</label>
    <input type="createdDate" name="createdDate" id="createdDate" value="<?php echo date('Y-m-d', strtotime($category['createdDate'])); ?>">
    <input type="submit" name="submit" value="Save">
</form>
    <?php else : ?>
        <blockquote>No category found with the specified ID</blockquote>
    <?php endif; ?>
</body>
</html>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

