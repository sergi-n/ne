<?php
// require_once('config.php');
require_once('connect.php');

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $sql_request = 'SELECT * FROM projects WHERE id=:project_id';
    $prepared_sql_request = $connect -> prepare($sql_request);
    $prepared_sql_request -> bindValue(':project_id', $project_id);
    $prepared_sql_request -> execute();
    $reply = $prepared_sql_request -> fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Edit project</title>
</head>
<body>
    <form action="add_project.php" method="POST" enctype="multipart/form-data">

        <label for="project_title">Project title</label>
        <input id="project_title" type="text" name="project_title" value="<?php echo ($reply['project_title'] ? $reply['project_title'] : '') ?>">
        <div id="project_title_error">
            <?php echo ($errors['project_title'] ? $errors['project_title'] : '') ?>
        </div>

        <label for="project_description">Project description</label>
        <textarea id="project_description" name="project_description" cols="30" rows="10"><?php echo ($reply['project_description'] ? $reply['project_description'] : '') ?></textarea>
        <div id="project_description_error">
            <?php echo ($errors['project_title'] ? $errors['project_title'] : '') ?>
        </div>

        <?php
            if (isset($errors['project_photos'])) {
                echo($errors['project_photos']);
            }
        ?>
        <label for="project_photo_0">Project photo 0</label>
        <input id="project_photo_0" type="file" name="project_photo_0">

        <label for="project_photo_1">Project photo 1</label>
        <input id="project_photo_1" type="file" name="project_photo_1">

        <label for="project_photo_2">Project photo 2</label>
        <input id="project_photo_2" type="file" name="project_photo_2">

        <label for="project_photo_3">Project photo 3</label>
        <input id="project_photo_3" type="file" name="project_photo_3">

        <label for="project_photo_4">Project photo 4</label>
        <input id="project_photo_4" type="file" name="project_photo_4">

        <input type="submit" name="submit" value="პროექტის რედაქტირება">
    </form>
</body>
</html>