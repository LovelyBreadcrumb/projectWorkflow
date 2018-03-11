<html>
    <head>
        <title>Working Title | Project #<?php echo sprintf('%04d', $_GET['id']); ?></title>
        <?php include '/modules/head.php'; ?>
    </head>
    <body class="very-light">
        <?php
            // == INCLUDES START ==
            include 'modules/database.php';
            // == INCLUDES END ==

            $project_id = intval($_GET['id']);


            // == FORM SUBMISSION START ==
            
            // == FORM SUBMISSION END ==


            // == MAIN QUERIES START ==
            $project_array = $db->query('SELECT PROJECT_NAME, PROJECT_BODY, PROJECT_TYPE FROM projects WHERE PROJECT_ID=' . $project_id);
            $project_array = $project_array->fetchArray();

            $project_name = $project_array[0];
            $project_body = $project_array[1];
            $project_type = $project_array[2];
            
            // == MAIN QUERIES END ==
        ?>
        <?php include "modules/nav.php"; ?>
         <div class="search_menu">
            <div class="search">
                <!-- Search by title -->
                <form method="post">
                    <button id="search_button" class="button accent" action="submit"><i class="far fa-save fa-2x" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <div class="container">

            <!-- @Dec: Put all your code here -->

            <div class="tile white" style="width: 100%">   
                <div class="accent-border" style="width: 100%; height: 2em; border-bottom: 1px solid #cecece">

                    <a href="project.php?id=' .  $project_id . '">
                        <h2 style="font-size: 1.2em; line-height: 0.2em; margin-left: 0.5em;">
                            <?php
                                echo $project_name;
                            ?>        
                        </h2>
                    </a>
                </div>

                <table class="summary_table" >
                    <tr>
                        <td style="width: 45%;">&nbsp;Status</td>
                        <td style="width: 15%;">&nbsp;Deadline
                        </td>
                        <td style="width: 20%;">&nbsp;Assigned</td>
                        <td style="width: 20%;">&nbsp;Tags</td>
                    </tr>
                    <tr>
                        <td>
                            <!-- status -->
                        </td>
                        <td>
                            <!-- deadline -->
                        </td>
                        <td>
                            <div style="height: 100%; overflow-y: auto">
                                <?php
                                    $assigned_array = $db->query('SELECT assigned.USER_USERNAME, users.USER_NAME FROM assigned INNER JOIN users ON assigned.USER_USERNAME=users.USER_USERNAME WHERE assigned.PROJECT_ID=' . $project_id);
                                    while ( $assigned = $assigned_array->fetchArray() ) {
                                            echo '<div class="icons system"><i class="fa fa-user" aria-hidden="true"></i><span>' . $assigned[1] . '</span></div>';
                                    }
                                ?>
                                <div class="icons system"><i class="fas fa-plus"></i> Add...</div>
                            </div>
                        </td>

                        <td style="width: 20%;">
                            <div style="height: 100%; overflow-y: auto">
                                <?php
                                    $all_tags = $db->query('SELECT TAG_TEXT FROM tags WHERE PROJECT_ID=' . $project_id);
                                    while ( $tag = $all_tags->fetchArray() ) {
                                        $tag_text = $tag[0];
                                        echo '<div class="icons system"><i class="fa fa-tag" aria-hidden="true"></i><span>' . $tag_text  . '</span></div>';
                                    }
                                ?>
                                <div class="icons system"><i class="fas fa-plus"></i> Add...</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="tile white accent-border" style="height: 22em; width: 100%">
                <div style="margin: 0 0.5em">
                    <textarea id="brief_markdown" style="width: 100%; height: 25.55em; border: none; resize: none; display: none"><?php echo $project_body; ?></textarea>
                    
                    <div id="brief_html" style="width: 100%; height: 20em; border: none; overflow-y: auto; display: block">
                        <img src="http://via.placeholder.com/350x150" onload="convert('brief_markdown', 'brief_html')">
                    </div>

                    <div class="confirm_cancel_buttons">
                        <span style="float: right; margin-right: 1em; cursor: pointer;" id="edit_link" onclick="
                            document.getElementById('brief_markdown').style.display = 'block';
                            document.getElementById('brief_html').style.display = 'none';
                            document.getElementById('edit_link').style.display = 'none';
                            document.getElementById('preview_link').style.display = 'block'"
                            >Edit</span>
                        <span style="float: right; margin-top: -1.5em; margin-right: 1em; display: none; cursor: pointer;" id="preview_link" onclick="
                            document.getElementById('brief_markdown').style.display = 'none';
                            document.getElementById('brief_html').style.display = 'block';
                            document.getElementById('preview_link').style.display = 'none';
                            document.getElementById('edit_link').style.display = 'inline-block';
                            convert('brief_markdown', 'brief_html');">Preview</span>
                    </div>
                </div>
            </div>


            <!-- == COMMENTS START == -->
            <?php include '/modules/comments.php'; ?>
            <!-- == COMMENTS END == -->

            <div class="footer">
            </div> <!-- footer -->
        </div> <!-- /container -->
    </body>
</html>