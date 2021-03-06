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
            if ( isset($_POST['add_user']) and $_POST['add_user'] != '' ) {
                $db->exec('INSERT INTO assigned (PROJECT_ID, USER_USERNAME) VALUES (' . $project_id . ', "' . $_POST['add_user'] . '")');
                $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "system", "' . $my_username . '", "' . date('Y-m-d H:i:s') . '", "Assigned user: ' . $_POST['add_user'] . '")');
            }

            if ( isset($_POST['add_tag']) and $_POST['add_tag'] != '' ) {
                $db->exec('INSERT INTO tags (PROJECT_ID, TAG_TEXT) VALUES (' . $project_id . ', "' . $_POST['add_tag'] . '")');
                $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "system", "' . $my_username . '", "' . date('Y-m-d H:i:s') . '", "Added tag: ' . $_POST['add_tag'] . '")');
            }

            if ( isset($_POST['edit_body']) ) {
                $previous_body = addslashes(str_replace('"', "'", $_POST['previous_body']));
                $new_body = addslashes(str_replace('"', "'", $_POST['edit_body']));

                if ( $previous_body != $new_body ) {
                    $db->exec('UPDATE projects SET PROJECT_BODY="' . $new_body . '" WHERE PROJECT_ID=' . $project_id);

                    $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "system", "' . $my_username . '", "' . date('Y-m-d H:i:s') . '", "Previous brief:
                        
```
' . $previous_body . '
```
New brief:
```
' . $new_body . '
```")');
                }
            }

            if ( isset($_POST['new_status']) and $_POST['new_status'] != '' and $_POST['new_status'] != $_POST['current_status'] ) {
                $db->exec('INSERT INTO status (PROJECT_ID, STATUS_TEXT, STATUS_DATE) VALUES (' . $project_id . ', "' . $_POST['new_status'] . '", "' . date('Y-m-d') . '")');
                $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "system", "' . $my_username . '", "' . date('Y-m-d H:i:s') . '", "New stage: ' . $_POST['new_status'] . '")');
            }

            if ( isset($_POST['next_status']) and $_POST['next_status'] != '' ) {
                $db->exec('INSERT INTO status (PROJECT_ID, STATUS_TEXT, STATUS_DATE) VALUES (' . $project_id . ', "' . $_POST['next_status'] . '", "' . date('Y-m-d') . '")');
                $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "system", "' . $my_username . '", "' . date('Y-m-d H:i:s') . '", "New stage: ' . $_POST['next_status'] . '")');
            }
            // == FORM SUBMISSION END ==


            // == MAIN QUERIES START ==
            $project_array = $db->query('SELECT PROJECT_NAME, PROJECT_BODY, PROJECT_TYPE FROM projects WHERE PROJECT_ID=' . $project_id);
            $project_array = $project_array->fetchArray();

            $project_name = $project_array[0];
            $project_body = $project_array[1];
            $project_type = $project_array[2];

            $status_history = $db->query('SELECT STATUS_TEXT, STATUS_DATE FROM status WHERE PROJECT_ID=' . $project_id . ' ORDER BY STATUS_DATE ASC');
            $status_history_array = array();
            while ( $status = $status_history->fetchArray() ) {
                array_push($status_history_array, $status);
            }

            $status_filter = ($project_type=='PRINT')? 'STATUS" OR FLAG_TYPE="PRINT_STATUS' : 'STATUS';
            $query = 'SELECT FLAG_TEXT FROM flags WHERE FLAG_TYPE="' . $status_filter . '"';
            $available_status =  $db->query($query);

            // Find current status in list of possible statuses
            $available_status_array = array();
            while ( $status = $available_status->fetchArray() ) {
                array_push($available_status_array, $status[0]);
            }
            $current_key = array_search($status_history_array[count($status_history_array)-1][0], $available_status_array);
            // Get next status in the list
            $next_status = $available_status_array[$current_key+1];

            
            // == MAIN QUERIES END ==
        ?>
        <?php include "modules/nav.php"; ?>

        <div id="save_alert" class="alert bad" onclick="document.getElementById('save_alert').style.display='none';" style="display: none">
            <span><strong>Unsaved changes.</strong> Use the save button to record your changes. </span>
        </div>

         <div class="search_menu">
            <div class="search">
                <button id="search_button" class="button accent" onclick="document.getElementById('update_project').submit()"><i class="far fa-save fa-2x" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="container">
            <div class="tile white" style="width: 100%">   
                <div class="accent-border" style="width: 100%; height: 2em; border-bottom: 1px solid #cecece">
                    <h2 style="font-size: 1.2em; line-height: 0.2em; margin-left: 0.5em;">
                        <?php
                            echo $project_name;
                        ?>        
                    </h2>
                </div>

                <form id="update_project" method="post" style="margin: 0;">
                    <table class="summary_table" >
                        <tr style="height: 1em;">
                            <td style="width: 45%;">&nbsp;Status</td>
                            <td style="width: 15%;">&nbsp;Deadline
                            </td>
                            <td style="width: 20%;">&nbsp;Assigned</td>
                            <td style="width: 20%;">&nbsp;Tags</td>
                        </tr>
                        <tr>
                            <td>
                                <table class="system" style="text-align: center; font-size: 0.7em; height: 100%; width: 100%;">
                                <tbody>
                                    <tr>
                                    <td class="very-light" style="border-right: 0; width: 33.3%;">Previous stage</td>
                                    <td class="very-light"  style="border-right: 0; width: 33.3%;">Current stage</td>
                                    <td class="very-light"  style="border-right: 0; width: 33.3%;">Next stage</td>
                                    </tr>
                                    <tr>
                                    <td style="border-right: 0; font-size: 1.3em;"><?php echo $status_history_array[count($status_history_array)-2][0]; ?></td>
                                    <td style="border-right: 0; font-size: 1.3em;"><?php echo $status_history_array[count($status_history_array)-1][0]; ?>
                                        <input type="hidden" name="current_status" value="<?php echo $status_history_array[count($status_history_array)-1][0]; ?>">
                                    </td>
                                    <td id="current-next-stage" style="border-right: 0; font-size: 1.3em;"><?php echo $next_status; ?></td>
                                    </tr>
                                    <tr>
                                    <td style="border-right: 0; font-style: italic; color: grey;"><?php echo $status_history_array[count($status_history_array)-2][1]; ?></td>
                                    <td style="border-right: 0; font-style: italic; color: grey;"><?php echo $status_history_array[count($status_history_array)-1][1]; ?></td>
                                    <td id="complete-select-text" style="border-right: 0; font-style: italic; color: grey;"><span onclick="document.getElementById('complete-next-stage').style.display='block'; document.getElementById('next_status').value='<?php echo $next_status;?>'; document.getElementById('current-next-stage').style.display='none'; document.getElementById('complete-select-text').style.display='none'; document.getElementById('save_alert').style.display='block';" class="add">Complete</span> this stage,<br> or <span onclick="document.getElementById('select-next-stage').style.display='block'; document.getElementById('current-next-stage').style.display='none'; document.getElementById('complete-select-text').style.display='none';" class="add">select another</span></td>
                                        <td id="complete-next-stage" rowspan="2" style="display: none; margin-top: -1em; border-right: 0; font-style: italic; color: grey;">
                                            <input type="text" id="next_status" name="next_status" readonly>
                                        </td>
                                        <td id="select-next-stage" rowspan="2" style="display: none; margin-top: -1em; border-right: 0; font-style: italic; color: grey;">
                                            <select name="new_status"onchange="document.getElementById('save_alert').style.display='block';">
                                                <option value="">Select stage</option>
                                                <?php
                                                    
                                                    while ( $status = $available_status->fetchArray() ) {
                                                        echo '<option value="' . $status[0] . '">' . $status[0] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </td>
                            <td>
                                <input style="margin-left: 0.5em; margin-top: -2em;" type="date" name="project_due">
                            </td>
                            <td>
                                <div style="height: 100%; overflow-y: auto">
                                    <?php
                                        $assigned_array = $db->query('SELECT assigned.USER_USERNAME, users.USER_NAME FROM assigned INNER JOIN users ON assigned.USER_USERNAME=users.USER_USERNAME WHERE assigned.PROJECT_ID=' . $project_id);
                                        while ( $assigned = $assigned_array->fetchArray() ) {
                                                echo '<div class="icons system"><i class="fa fa-user" aria-hidden="true"></i><span>' . $assigned[1] . '</span></div>';
                                        }
                                    ?>
                                    <div id="add_user_link" class="icons system" onclick="document.getElementById('add_user').style.display='block';document.getElementById('add_user_link').style.display='none';"><i class="fas fa-plus"></i><span class="add">Add</span></div>
                                    <div id="add_user" class="icons system" style="display: none;">
                                        <select name="add_user" onchange="document.getElementById('save_alert').style.display='block';">
                                            <option value="">Select user</option>
                                            <?php 
                                                $all_users = $db->query('SELECT USER_USERNAME, USER_NAME FROM users WHERE USER_USERNAME NOT IN (SELECT USER_USERNAME FROM assigned WHERE PROJECT_ID=' . $project_id . ') ORDER BY USER_NAME');
                                                while ( $user = $all_users->fetchArray() ) {
                                                    echo '<option value="' . $user[0] . '">' . $user[1] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
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
                                    <div id="add_tag_link" class="icons system" onclick="document.getElementById('add_tag').style.display='block';document.getElementById('add_tag_link').style.display='none';"><i class="fas fa-plus"></i> <span class="add">Add</span></div>
                                    <div id="add_tag" class="icons system" style="display: none;">
                                        <select name="add_tag" onchange="document.getElementById('save_alert').style.display='block';">
                                            <option value="">Select tag</option>
                                            <?php 
                                                $all_tags = $db->query('SELECT FLAG_TEXT FROM flags WHERE (FLAG_TYPE="TAG" OR FLAG_TYPE="CATEGORY") AND FLAG_TEXT NOT IN (SELECT TAG_TEXT FROM tags WHERE PROJECT_ID=' . $project_id . ') ORDER BY FLAG_TEXT');
                                                while ( $tag = $all_tags->fetchArray() ) {
                                                    echo '<option value="' . $tag[0] . '">' . $tag[0] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                
                </div>

                <div class="tile white accent-border" style="height: 22em; width: 100%">
                    <div style="margin: 0 0.5em">
                        <input type="hidden" name="previous_body" value="<?php echo $project_body; ?>">
                        <textarea onchange="document.getElementById('save_alert').style.display='block';" name="edit_body" id="brief_markdown" style="width: 100%; height: 25.55em; border: none; resize: none; display: none"><?php echo $project_body; ?></textarea>
                        
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
            </form> <!-- /update_project -->


            <!-- == COMMENTS START == -->
            <?php include '/modules/comments.php'; ?>
            <!-- == COMMENTS END == -->

            <div class="footer">
            </div> <!-- footer -->
        </div> <!-- /container -->
    </body>
</html>