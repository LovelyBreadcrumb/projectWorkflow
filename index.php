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
            $search_parameters = '';

            if ( isset($_GET['search']) ) {
                $search_string = $_GET['search'];
                $search_parameters = ' WHERE PROJECT_NAME LIKE("%' . $search_string . '%")';
            }

            if ( isset($_GET['tag']) ) {
                $search_string = urldecode($_GET['tag']);
                $query = 'SELECT PROJECT_ID FROM tags WHERE TAG_TEXT="' .$search_string . '"';
                error_log($query);
                $tagged_projects = $db->query($query);
                $id_array = array();
                while ( $project_id = $tagged_projects->fetchArray() ) {
                    array_push($id_array, $project_id[0]);
                }
                $search_parameters = implode(', ', $id_array);
                $search_parameters = ' WHERE PROJECT_ID IN (' . $search_parameters . ')';
            }
            // == FORM SUBMISSION END ==


            // == MAIN QUERIES START ==
            $query = 'SELECT PROJECT_ID, PROJECT_NAME, PROJECT_TYPE FROM projects' . $search_parameters;
            $all_projects = $db->query($query);
            
            // == MAIN QUERIES END ==
        ?>
        <div class="nav very-dark">
            <h1 class="accent-font"><a href="/" style="text-decoration: none; color: inherit;">Working Title</a> <span class="white-font">|</span> <span class="medium-font">All Projects</span></h1>
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

                    error_log(' >> Latest status: ' . end($status_history_array));

                    $status_filter = ($project_type=='PRINT')? 'STATUS" OR FLAG_TYPE="PRINT_STATUS' : 'STATUS';
                    $query = 'SELECT FLAG_TEXT FROM flags WHERE FLAG_TYPE="' . $status_filter . '"';
                    
                    $available_status =  $db->query($query);
                    while ( $status = $available_status->fetchArray() ) {
                        // if ( $status[0] == end($status_history_array) ) {
                        //     echo '<div title="' . $status[0] . '" class="not-quite-that-dark"><span>' . $status[0] . '</span></div>';
                        // } else {
                            if ( in_array($status[0], $status_history_array) ) {
                                echo '<div title="' . $status[0] . '" class="not-quite-that-dark"></div>';
                            } else {
                            echo '<div title="' . $status[0] . '" class="grey"></div>';
                            }
                        // } 
                    }
                    echo '
                                </div>';

                    // -- assigned team members --
                    echo '
                                <div class="assigned">
                                    <div><span><i class="fa fa-user" aria-hidden="true"></i>&nbsp;GM</div>
                                    <div><span><i class="fa fa-user" aria-hidden="true"></i>&nbsp;DJ</div>
                                </div>';

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

            <div class="footer">
                <div id="search" class="search">
                    <form action="index.php" method="get">
                        <input type="text" name="search" placeholder="Search by project title..." value="<?php echo (isset($_GET['search']))? $_GET['search'] : '' ;?>"/>
                        <button class="accent" action="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>