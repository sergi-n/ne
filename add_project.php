<?php

    // require_once('config.php');
    require_once('connect.php');
    $number_of_photos = 5;

    // Project title validation
    if (isset($_POST['project_title'])) {
        if (!empty($_POST['project_title'])) {
            $project['project_title'] = $_POST['project_title'];
        } else {
            $errors['project_title'] = 'ველის შევსება სავალდებულოა';
        }
    }

    // Project description validation
    if (isset($_POST['project_description'])) {
        if (!empty($_POST['project_description'])) {
            $project['project_description'] = $_POST['project_description'];
        } else {
            $errors['project_description'] = 'ველის შევსება სავალდებულოა';
        }
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

    if (isset($project)  && !array_key_exists('photos', $project)) {
        $errors['photos'] = 'გთხოვთ ატვირთოთ პროექტის სურათი/სურათები';
    }
    print_r($project);
    // final
    if(isset($project) && !isset($errors)) {

        $sql_request = 'SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = \'projector_studio\' AND TABLE_NAME = \'projects\'';
        $dbreply = $connect -> query($sql_request);
        $project_id = $dbreply -> fetch(PDO::FETCH_NUM);
        $project_id = $project_id[0];

        $upload_folder = 'project_images/';
        $project_images_folder = $upload_folder.$project_id;
        if (!file_exists($project_images_folder)) {
            $create_folder = mkdir($project_images_folder);
            if (!$create_folder) {
                exit;
            }
        }
        
        for ($i = 0; $i < count($project['photos']); $i++) {
            $project_image_new_location = $project_images_folder.'/'.$project['photos'][$i]['name'];
            $move_image = move_uploaded_file($project['photos'][$i]['tmp_name'], $project_image_new_location);
            $project['photos'][$i] = $project_image_new_location;
        }
        
    }


    // print_r($errors);
    // print_r($_FILES);
    // print_r($project);
    // Project photos validation
    // if (isset($project['project_title']) && isset($project['project_description'])) {
    //     $upload_folder = 'projects_images/'.$project['project_title'];
    //     $project['photos'] = [];

    //     for ($i = 0; $i < 5; $i++ ) {
    //         $key = 'project_photo_'.$i;
            
    //         if (isset($_FILES[$key]) && !empty($_FILES[$key]['tmp_name'])) {                

    //             if (!file_exists($upload_folder)) {
    //                 mkdir($upload_folder);
    //             }

    //             $uploaded_file_name = $upload_folder.'/ '.$_FILES[$key]['name'];
    //             move_uploaded_file($_FILES[$key]['tmp_name'], $uploaded_file_name);
    //             array_push($project['photos'], $uploaded_file_name);
    //         }
    //     }

    //     if (!file_exists($upload_folder)) {
    //         $errors['project_photo'] = 'პროექტისთვის მინიმუმ ერთი ფოტოს ატვირთვა სავალდებულოა';
    //     }

    // } else {
    //     for ($i = 0; $i < 5; $i++) {
    //         $key = 'project_photo_'.$i;

    //         if(isset($_FILES[$key]) && !empty($_FILES[$key]['tmp_name'])) {
    //             break;
    //         } else if ($i == 4) {
    //             $errors['project_photos'] = 'პროექტისთვის მინიმუმ ერთი ფოტოს ატვირთვა სავალდებულოა';
    //         }
    //     }
    // }

    if (isset($project['project_title']) && isset($project['project_description']) && isset($project['photos'])) {
        $sql_request = 'INSERT INTO projects (project_title, project_description, project_photo_0, project_photo_1, project_photo_2, project_photo_3, project_photo_4) VALUES (:project_title, :project_description, :project_photo_0, :project_photo_1, :project_photo_2, :project_photo_3, :project_photo_4)';
        $prepared_sql_request = $connect -> prepare($sql_request);
        $prepared_sql_request -> bindValue(':project_title', $project['project_title']);
        $prepared_sql_request -> bindValue(':project_description', $project['project_description']);
        
        for ($i = 0; $i < 5; $i++) {
            if (isset($project['photos'][$i])) {
                $prepared_sql_request -> bindValue(':project_photo_'.$i, $project['photos'][$i]);
            } else {
                $prepared_sql_request -> bindValue(':project_photo_'.$i, '');
            }
        }

        $prepared_sql_request -> execute();

    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="./css/styles.css">
        <title>Add project</title>
    </head>

    <body>
        <form action="add_project.php" method="POST" enctype="multipart/form-data">

            <label for="project_title">Project title</label>
            <input id="project_title" type="text" name="project_title">

            <label for="project_description">Project description</label>
            <textarea id="project_description" name="project_description" cols="30" rows="10"></textarea>
            
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
            <input type="submit" value="პროექტის დამატება">
        </form>
    </body>

    </html>