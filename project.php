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

                <table style="height: 5em; width: 100%;" >
                <tbody>
                <tr>
                <td style="width: 45%; border-right: 1px solid #cecece;">&nbsp;</td>
                <td style="width: 15%; border-right: 1px solid #cecece;">
                    <div style="margin: -0.5em 0 0.5em 0.5em;">Deadline</div>
                </td>
                <td style="width: 20%; border-right: 1px solid #cecece;">
                    <div style="margin: -0.5em 0 0.5em 0.5em;">Product owners</div>
                    <?php
                        echo '
                                    <div class="assigned" style="padding-top: 0;">';
                        $assigned_array = $db->query('SELECT assigned.USER_USERNAME, users.USER_NAME FROM assigned INNER JOIN users ON assigned.USER_USERNAME=users.USER_USERNAME WHERE assigned.PROJECT_ID=' . $project_id);
                        while ( $assigned = $assigned_array->fetchArray() ) {
                                echo '<a href="index.php?assigned=' .  $assigned[0] . '"><div><span><i class="fa fa-user" aria-hidden="true"></i>&nbsp;' . $assigned[1] . '</div></a>';
                            }
                        echo '      </div>';
                    ?>
                    <div style="float: right; font-size: 0.8em; margin: 2em 0.8em 0em 0em;">Add another..</div>
                </td>

                <td style="width: 20%;">
                    <div style="margin: -0.5em 0 0.5em 0.5em;">Tags</div>
                    <?php

                    $all_tags = $db->query('SELECT TAG_TEXT FROM tags WHERE PROJECT_ID=' . $project_id);

                        echo '
                                    <div class="tags" style="padding-top: 0;">';
                        while ( $tag = $all_tags->fetchArray() ) {
                            $tag_text = $tag[0];
                            echo '<a href="index.php?tag=' . $tag_text . '"><div><span><i class="fa fa-tag" aria-hidden="true"></i> ' . $tag_text  . '</span></div></a>';
                        }
                        echo '
                                    </div>
                                </div>
                            </div>';
                    ?>
                    <div style="float: right; font-size: 0.8em; margin: 2em 0.8em 0em 0em;">Add another..</div>
                </td>
                </tr>
                </tbody>
                </table>

            </div>

            <div class="tile white accent-border" style="height: 20em; width: 100%">
                
                <!-- <div class="accent-border" style="width: 100%; height: 2em; border-bottom: 1px solid #969696;">

                <table style="height: 1.5em; width: 100%;" >
                    <tbody>
                    <tr>
                    <td style="width: 70%; border-right: 1px solid #cecece;">
                        <h2 style="hover:none; font-size: 1.2em; line-height: 1.4em; margin: 0 0 0 0.5em;">Brief</h2>
                        </a>
                    </td>

                    <td>
                        <div style="line-height: 1.4em; margin: 0 0.5em 0 0.5em;">Select print preset, test preset, or test preset.</div>
                    </td>

                    </tr>
                    </tbody>
                </table>

                </div> -->

                <div>

                <textarea id="brief_markdown" style="width: 100%; height: 21em; border: none; resize: none; display: none"><?php echo $project_body; ?></textarea>
                
                <div id="brief_html" style="width: 100%; height: 19em; border: none; overflow-y: auto; display: block">
                    <img src="http://via.placeholder.com/350x150" onload="convert('brief_markdown', 'brief_html')">
                </div>

                <a style="float: right; margin-top: -3em; margin-right: 1em; cursor: pointer;" id="edit_link" onclick="
                    document.getElementById('brief_markdown').style.display = 'block';
                    document.getElementById('brief_html').style.display = 'none';
                    document.getElementById('edit_link').style.display = 'none';
                    document.getElementById('preview_link').style.display = 'block'"
                    >Edit</a>
                <a style="float: right; margin-top: -1.5em; margin-right: 1em; display: none; cursor: pointer;" id="preview_link" onclick="
                    document.getElementById('brief_markdown').style.display = 'none';
                    document.getElementById('brief_html').style.display = 'block';
                    document.getElementById('preview_link').style.display = 'none';
                    document.getElementById('edit_link').style.display = 'inline-block';
                    convert('brief_markdown', 'brief_html');">Preview</a>
                    

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