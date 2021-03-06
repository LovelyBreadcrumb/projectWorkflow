<html>
    <head>
        <title>Working Title | All Projects</title>
        <?php include '/modules/head.php'; ?>
    </head>
    <body class="very-light">
        <?php
            // == INCLUDES START ==
            include 'modules/database.php';
            // == INCLUDES END ==


            // == FORM SUBMISSION START ==
            $show_cancel_button = false;
            $search_parameters = '';

            if ( isset($_GET['search']) and $_GET['search']!="" ) {
                $search_string = $_GET['search'];
                $search_parameters = ' WHERE PROJECT_NAME LIKE("%' . $search_string . '%")';

                $show_cancel_button = true;
            }

            if ( isset($_GET['tag']) and $_GET['tag']!="" ) {
                $search_string = urldecode($_GET['tag']);
                $query = 'SELECT PROJECT_ID FROM tags WHERE TAG_TEXT="' .$search_string . '"';
                $tagged_projects = $db->query($query);
                $id_array = array();
                while ( $project_id = $tagged_projects->fetchArray() ) {
                    array_push($id_array, $project_id[0]);
                }
                $search_parameters = implode(', ', $id_array);
                $search_parameters = ' WHERE PROJECT_ID IN (' . $search_parameters . ')';

                $show_cancel_button = true;
            }

            if ( isset($_GET['user']) and $_GET['user']!="" ) {
                $search_string = urldecode($_GET['user']);
                $query = 'SELECT PROJECT_ID FROM assigned WHERE USER_USERNAME="' .$search_string . '"';
                $assigned_projects = $db->query($query);
                $id_array = array();
                while ( $project_id = $assigned_projects->fetchArray() ) {
                    array_push($id_array, $project_id[0]);
                }
                $search_parameters = implode(', ', $id_array);
                $search_parameters = ' WHERE PROJECT_ID IN (' . $search_parameters . ')';

                $show_cancel_button = true;
            }
            // == FORM SUBMISSION END ==


            // == MAIN QUERIES START ==
            $query = 'SELECT PROJECT_ID, PROJECT_NAME, PROJECT_TYPE FROM projects' . $search_parameters;
            $all_projects = $db->query($query);

            $all_users = $db->query('SELECT USER_USERNAME, USER_NAME FROM users ORDER BY USER_NAME');

            $all_tags = $db->query('SELECT FLAG_TEXT FROM flags WHERE FLAG_TYPE="TAG" OR FLAG_TYPE="CATEGORY" ORDER BY FLAG_TEXT');
            // == MAIN QUERIES END ==
        ?>
        <?php include "modules/nav.php"; ?>
        <div class="search_menu">
            <div class="search">
                <!-- Search by title -->
                <form action="index.php" method="get">
                    <input class="form_input" style="display: none" id="search_input" type="text" name="search" placeholder="Search by project title..." value="<?php echo (isset($_GET['search']))? $_GET['search'] : '' ;?>"/>
                    <button id="search_button" style="display: none" class="button accent" action="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    <button id="search_toggle" type="button" class="button accent" title="Search by project title" onclick="document.getElementById('search_input').style.display='inline-block'; document.getElementById('search_button').style.display='inline-block'; document.getElementById('search_toggle').style.display='none';"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="search">
                <!-- Search by assigned user -->
                <form action="index.php" method="get">
                    <select name="user" id="user_input" class="form_input" style="display: none">
                        <option value="">Search by assigned team member</option>
                        <?php 
                            while ( $user = $all_users->fetchArray() ) {
                                echo '<option value="' . $user[0] . '">' . $user[1] . '</option>';
                            }
                        ?>
                    </select>
                    <button id="user_button" style="display: none" class="button accent" action="submit"><i class="fa fa-user" aria-hidden="true"></i></button>
                    <button id="user_toggle" type="button" class="button accent" title="Seach by assigend team member" onclick="document.getElementById('user_input').style.display='inline-block'; document.getElementById('user_button').style.display='inline-block'; document.getElementById('user_toggle').style.display='none';"><i class="fa fa-user" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="search">
                <!-- Search by tag -->
                <form action="index.php" method="get">
                    <select name="tag" id="tag_input" class="form_input" style="display: none">
                        <option value="">Search by tag</option>
                        <?php 
                            while ( $tag = $all_tags->fetchArray() ) {
                                echo '<option value="' . $tag[0] . '">' . $tag[0] . '</option>';
                            }
                        ?>
                    </select>
                    <button id="tag_button" style="display: none" class="button accent" action="submit"><i class="fa fa-tag" aria-hidden="true"></i></button>
                    <button id="tag_toggle" type="button" title="Search by tag" class="button accent"onclick="document.getElementById('tag_input').style.display='inline-block'; document.getElementById('tag_button').style.display='inline-block'; document.getElementById('tag_toggle').style.display='none';"><i class="fa fa-tag" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="search" <?php echo ($show_cancel_button)? '' : 'style="display: none"' ; ?>>
                <!-- Clear search filters -->
                <form action="index.php" method="get">
                    <a href="index.php"><button title="Clear search filters" id="tag_toggle" type="button" class="button medium"><i class="fa fa-times" aria-hidden="true"></i></button></a>
                </form>
            </div>
        </div>

        <div class="container">

            <?php
                // == MAIN LOOP START ==
                while ( $project = $all_projects->fetchArray() ) {
                    $project_id = intval($project[0]);
                    $project_name = $project[1];
                    $project_type = $project[2];

                    $all_tags = $db->query('SELECT TAG_TEXT FROM tags WHERE PROJECT_ID=' . $project_id);

                    // -- project tile heading --
                    echo '
                        <div class="tile white">
                            <div class="name accent-border">
                                <a href="project.php?id=' .  $project_id . '">
                                    <h2>' . $project_name . '</h2>
                                </a>
                            </div>
                            <div class="body">
                                <div class="progress system">';

                    // -- status balls --
                    $status_history = $db->query('SELECT STATUS_TEXT FROM status WHERE PROJECT_ID=' . $project_id . ' ORDER BY STATUS_DATE ASC;');
                    $status_history_array = array();
                    while ( $past_status = $status_history->fetchArray() ){
                        array_push($status_history_array, $past_status[0]);
                    }

                    $status_filter = ($project_type=='PRINT')? 'STATUS" OR FLAG_TYPE="PRINT_STATUS' : 'STATUS';
                    $query = 'SELECT FLAG_TEXT FROM flags WHERE FLAG_TYPE="' . $status_filter . '"';
                    
                    $available_status =  $db->query($query);
                    while ( $status = $available_status->fetchArray() ) {
                        if ( in_array($status[0], $status_history_array) ) {
                            echo '<div title="' . $status[0] . '" class="not-quite-that-dark"></div>';
                        } else {
                        echo '<div title="' . $status[0] . '" class="light"></div>';
                        }
                    }
                    echo '
                                </div>';

                    // -- assigned team members --
                    echo '
                                <div class="assigned">';
                    $assigned_array = $db->query('SELECT assigned.USER_USERNAME, users.USER_NAME FROM assigned INNER JOIN users ON assigned.USER_USERNAME=users.USER_USERNAME WHERE assigned.PROJECT_ID=' . $project_id);
                    while ( $assigned = $assigned_array->fetchArray() ) {
                            echo '<a href="index.php?assigned=' .  $assigned[0] . '"><div><span><i class="fa fa-user" aria-hidden="true"></i>&nbsp;' . $assigned[1] . '</div></a>';
                        }
                    echo '      </div>';

                    //  -- tags --
                    echo '
                                <div class="tags">';
                    while ( $tag = $all_tags->fetchArray() ) {
                        $tag_text = $tag[0];
                        echo '<a href="index.php?tag=' . $tag_text . '"><div><span><i class="fa fa-tag" aria-hidden="true"></i> ' . $tag_text  . '</span></div></a>';
                    }
                    echo '
                                </div>
                            </div>
                        </div>';
                }
                // == MAIN LOOP END ==
            ?>

        </div>
    </body>
</html>