<html>
    <head>
        <title>Working Title | Projects</title>
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
            $query = 'SELECT PROJECT_ID, PROJECT_NAME FROM projects' . $search_parameters;
            error_log($query);
            $all_projects = $db->query($query);
            
            // == MAIN QUERIES END ==
        ?>
        <div class="nav very-dark">
            <h1 class="accent-font">Working Title <span class="white-font">|</span> <span class="medium-font">All Projects</span></h1>
        </div>
        <div class="container">

            <?php
                // == MAIN LOOP START ==
                while ( $project = $all_projects->fetchArray() ) {
                    $project_id = intval($project[0]);
                    $project_name = $project[1];

                    $all_tags = $db->query('SELECT TAG_TEXT FROM tags WHERE PROJECT_ID=' . $project_id);

                    echo '<!-- Project Tile start -->
                        <div class="tile white">
                            <div class="name medium">
                                <a href="project.php?id=' .  $project_id . '">
                                    <h2>' . $project_name . '</h2>
                                </a>
                            </div>';
                    echo '
                            <div class="body">
                                <div class="progress system">
                                    <div class="medium"></div>
                                    <div class="medium"></div>
                                    <div class="medium"><span>In progress</span></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>';
                    echo '
                                <div class="assigned">
                                    <div class="light">GM</div>
                                    <div class="light">DJ</div>
                                </div>';
                    echo '
                                <div class="tags">';
                    while ( $tag = $all_tags->fetchArray() ) {
                        $tag_text = $tag[0];
                        echo '<a href="index.php?tag=' . $tag_text . '"><div style="background-color: #' . stringToColorCode($tag_text) . '"><span><i class="fa fa-tag" aria-hidden="true"></i> ' . $tag_text  . '</span></div></a>';
                    }
                    echo '
                                </div>';
                    echo '
                            </div>
                        </div>
                        <!-- Project Tile end -->';
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