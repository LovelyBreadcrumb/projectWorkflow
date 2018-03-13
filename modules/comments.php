<?php
    if ( isset($_POST['message_content']) ) {
        $datestamp = date('Y-m-d H:i:s', time());
        $new_comment = $_POST['message_content'];
        if ( $new_comment!='' ) {
            $new_comment = str_replace('"', "'", $new_comment);
            $new_comment = addslashes($new_comment);
            $success = $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "comment", "' . $my_username . '", "' . $datestamp . '", "' . $new_comment . '")');
            if ( !$success ) {
                echo '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>Write Error:</strong> Failed to save comment</span>
                    </div>';
            }
        }
    }

    if ( isset($_FILES['new_file']) ) {
        $datestamp = date('Y-m-d H:i:s', time());
        error_log('>>> Attachment');

        $file_name = basename($_FILES['new_file']['name']);
        $destination = '/attachments/' . $project_id;
        if (!file_exists($destination)){
            mkdir($destination, 0777, true);
        }
        $new_comment = '[' . $file_name . '](' . $destination . '/' . $file_name . ')';

        if (move_uploaded_file($_FILES['new_file']['tmp_name'], $destination . '/' . $file_name)){
            $success = $db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "attachment", "' . $my_username . '", "' . $datestamp . '", "' . $new_comment . '")');
            if ( !$success ) {
                 echo '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>Write Error:</strong> Failed to record file attachment</span>
                    </div>';
            }

        } else {
            echo '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>File Error:</strong> Failed to attach file</span>
                    </div>';
        }
    }

    if ( isset($_POST['dismiss_comment']) ) {
        $success = $db->exec('UPDATE comments SET COMMENT_DISMISSED="' . date('Y-m-d H:i:s') . '" WHERE COMMENT_ID=' . intval($_POST['dismiss_comment']));
        if ( !$success ) {
            echo '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>Database error:</strong> Failed to dismiss comment alert, please reload the page and try again.</span>
                    </div>';
        }
    }

    $comment_array = $db->query('SELECT COMMENT_ID, COMMENT_TYPE, users.USER_NAME, COMMENT_DATE, COMMENT_CONTENT, COMMENT_DISMISSED FROM comments INNER JOIN users ON comments.COMMENT_BY==users.USER_USERNAME WHERE PROJECT_ID=' . $project_id . ' ORDER BY COMMENT_DATE ASC');

?>

<div class="comments">
    <div class="comment_list">
        <?php
            while ( $comment = $comment_array->fetchArray() ) {
                $comment_id = intval($comment[0]);
                $comment_type = $comment[1];
                switch ($comment_type) {
                    case 'file':
                        $comment_type_phrase = 'attached a file';
                        break;

                    case 'system':
                        $comment_type_phrase = 'made a change';
                        break;
                    
                    default:
                        $comment_type_phrase = 'left a comment';
                        break;
                }
                $comment_by = $comment[2];
                $comment_date = $comment[3];
                $comment_content = stripslashes($comment[4]);
                $comment_dismissed = $comment[5];

                $dismiss = '';
                if ( $comment_dismissed == "FALSE" ) {
                    if ( strpos($comment_content, '@' . $my_username) !== false or strpos($comment_content, '@' . $my_name) !== false ) {
                        $dismiss = '<span class="dismiss" title="Dismiss notification" onclick="document.getElementById(\'dismiss_' . $comment_id . '\').submit()"><i class="fas fa-bell-slash"></i></span>
                            <form style="display: none;" id="dismiss_' . $comment_id . '" method="post">
                            <input type="hidden" name="dismiss_comment" value="' . $comment_id . '">
                            </form>';
                    }
                }

                echo '
                    <div class="comment">
                        <div class="data system">
                            ' . $comment_by . ' ' . $comment_type_phrase . ' - ' . $comment_date . ' ' . $dismiss . '
                        </div>
                        <div class="message"> 
                            <input id="comment_content_markdown_' . $comment_id . '" type="hidden" value="' . $comment_content . '" />
                            <img class="loading_gif" id="load_' . $comment_id . '" onload="convert(\'comment_content_markdown_' . $comment_id . '\', \'comment_content_html_' . $comment_id . '\'); document.getElementById(\'load_' . $comment_id . '\').style.display=\'none\';" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
                            <span id="comment_content_html_' . $comment_id . '">
                            </span>
                        </div>
                    </div> <!-- /comment -->';
            }
        ?>      
    </div>
    <div class="new_comment">
        <span id="add_comment_links">Leave a <span onclick="document.getElementById('write_comment').style.display='block'; document.getElementById('add_comment_links').style.display='none'">comment</span> or attach a <span onclick="document.getElementById('attach_file').style.display='block'; document.getElementById('add_comment_links').style.display='none'">file</span></span>

        <div class="inputs">
            <form method="post" id="write_comment" style="display:none;">
                <div class="note">You can format your comments with <a href="https://guides.github.com/features/mastering-markdown/" target="_blank"><em>Markdown</em></a></div>
                <textarea name="message_content"></textarea>
                <div class="confirm_cancel_buttons">
                    <span onclick="document.getElementById('write_comment').style.display='none'; document.getElementById('add_comment_links').style.display='block'">Cancel</span>
                    <button>Submit</button>
                </div>
            </form>

            <form method="post" id="attach_file" enctype="multipart/form-data" style="display:none;">
                <input name="new_file" type="file">
                <div class="confirm_cancel_buttons">
                    <span onclick="document.getElementById('attach_file').style.display='none'; document.getElementById('add_comment_links').style.display='block'">Cancel</span>
                    <button>Attach</button>
                </div>
            </form>
        </div>
    </div>
</div>