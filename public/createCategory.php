<?php



/**

 * Use an HTML form to create a new entry in the

 * apps table.

 *

 */

require "../config.php";

require "../common.php";



// check if the app table is empty

$appSelectionOptions = "";



try {

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM application";

    $result = $connection -> query($sql);



    if($result->rowCount()>0){

        foreach($result as $row){

            $appId = $row["appId"];

            $applicationName = escape($row["applicationName"]);

            $appSelectionOptions .= "<option value='$appId'>$applicationName</option>";

        }

    } else {

        //Handle case when apps table is empty

        $appSelectionOptions = "<option value='0'>No apps available</option>";

    }

} catch (PDOException $error) {

    echo $sql . "<br>" . $error->getMessage();

}





if (isset($_POST['submit'])) {
    try  {

        $connection = new PDO($dsn, $username, $password, $options);
        $new_category = array(
            "categoryName"  => $_POST['categoryName'],
            "description"     => $_POST['description']
        );
        $sql = sprintf(

                "INSERT INTO %s (%s) values (%s)",

                "category",

                implode(", ", array_keys($new_category)),

                ":" . implode(", :", array_keys($new_category))

        );



        $statement = $connection->prepare($sql);

        $statement->execute($new_category);



        //Get the categoryId of the newly created albums

        $categoryId = $connection ->lastInsertId();

        if(!empty($_POST['selected_apps'])){
            foreach($_POST['selected_apps'] as $appId){
                $sql = "INSERT INTO application_category(CategoryId,ApplicationId) VALUES (:categoryId,:appId)";
                $statement = $connection -> prepare($sql);
                $statement -> execute(array(':categoryId' => $categoryId ,':appId' => $appId));

            }

        }



    } catch(PDOException $error) {

        echo $sql . "<br>" . $error->getMessage();

    }

}

?>

<?php require "templates/header.php";?>

<?php if (isset($_POST['submit']) && $statement) {?>

    <blockquote><strong><?php echo $_POST['categoryName']; ?> </strong>successfully added.</blockquote>

<?php }?>



<h2>Add a Category</h2>



<form method="post">

    <label for="categoryName">Category Type</label>
    <input type="text" name="categoryName" id="categoryName"><br><br>

    <label for="description">Description</label>
    <input type="text" name="description" id="description"><br><br>

    <label for="selected_apps">Select Apps for the Album (Hold Ctrl/Cmd to select multiple songs)</label><br>

    <select multiple name="selected_apps[]" id="selected_apps">

        <?php echo $appSelectionOptions; ?>

    </select>



    <input type="submit" name="submit" value="Add">



</form>



<a href="categorys.php">Back to Category Home</a>



<?php require "templates/footer.php";?>