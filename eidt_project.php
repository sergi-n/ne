<?php
    // require_once('config.php');
    
    require_once('connect.php');

    if (isset($_POST['submit'])) {

        if (isset($_POST['project_id'])) {
            $project['project_id'] = $_POST['project_id'];
        } else {
            exit;
        }

        // Project title validation
        if (isset($_POST['project_title']) && !empty($_POST['project_title'])) {
            $project['project_title'] = $_POST['project_title'];
        } else {
            $errors['project_title'] = 'ველის შევსება სავალდებულოა';
        }
    
        // Project description validation 
        if (isset($_POST['project_description']) && !empty($_POST['project_description'])) {
            $project['project_description'] = $_POST['project_description'];
        } else {
            $errors['project_description'] = 'ველის შევსება სავალდებულოა';
        }
    
        // Project images validation
        for ($i = 0; $i < 5; $i++) {
            $key = 'project_photo_'.$i;
    
            if (isset($_FILES[$key]) && !empty($_FILES[$key]['tmp_name'])) {
                if (!isset($project['photos'])) {
                    $project['photos'] = [];
                }
                array_push($project['photos'], $_FILES[$key]);
            }
        }
    
        if (isset($_FILES) && !isset($project['photos'])) {
            $errors['project_photos'] = 'გთხოვთ ატვირთოთ პროექტის სურათი/სურათები';
        }

    }

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


            <!-- Project title -->
            <div id="project_title_error">
                <?php echo (isset($errors['project_title']) ? $errors['project_title'] : '') ?>
            </div>
            <label for="project_title">Project title</label>
            <input id="project_title" type="text" name="project_title" value="<?php echo (isset($reply['project_title']) ? $reply['project_title'] : ''); ?>">


            <!-- Project Description -->
            <div id="project_description_error">
                <?php echo (isset($errors['project_title']) ? $errors['project_title'] : '') ?>
            </div>
            <label for="project_description">Project description</label>
            <textarea id="project_description" name="project_description" cols="30" rows="10"><?php echo (isset($reply['project_description']) ? $reply['project_description'] : ''); ?></textarea>


            <!-- Project photos -->
            <div id="project_description_error">
                <?php echo (isset($errors['project_photos']) ? $errors['project_photos'] : ''); ?>
            </div>
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


            <!-- Submit -->
            <input type="submit" name="submit" value="პროექტის რედაქტირება">
        </form>
    </body>

    </html>