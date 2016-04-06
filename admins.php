<?php ob_start();
// auth check 
require('auth.php');
// set title
$page_title = 'Admins';
require('header.php'); ?>

<?php

try {
    // connect
    require('db.php'); 

    // prepare the query
    $sql = "SELECT * FROM admins";
    $cmd = $conn -> prepare($sql);

    // run the query and store the results
    $cmd -> execute();
    $admins = $cmd -> fetchAll();

    // start the grid with HTML
    echo '<table class="table">
            <thead>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </thead>
          <tbody>';

    /* loop through the data, displaying each value in a new column
    and each registrant in a new row */
    foreach($admins as $admin) {
        echo '<tr>
                <td>' . $admin['email'] . '</td>
                <td><a href="register.php?user_id=' . $admin['user_id'] . '" title="Edit">Edit</a></td>
                <td><a href="admin-delete.php?user_id=' . $admin['user_id'] . '" title="Delete" class="confirmation">Delete</a></td>
              </tr>';
    }

    // close the HTML grid
    echo '</tbody></table>';
}

catch (Exception $e) {
    // send IT Dep. an error email
    mail('jack.grunin@gmail.com', 'Admin X ERROR', $e);
    
    // redirect to the error page
    header('location:404.php');
}

// disconnect
    $conn = null;
?>

<?php require('footer.php');

ob_flush(); ?>
