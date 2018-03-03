<?php
    $comment_array = $db->query('SELECT COMMENT_ID, COMMENT_TYPE, users.USER_NAME, COMMENT_DATE, COMMENT_CONTENT, COMMENT_DISMISSED FROM comments INNER JOIN users ON comments.COMMENT_BY==users.USER_USERNAME WHERE PROJECT_ID=' . $project_id . ' ORDER BY COMMENT_DATE ASC');
?>

<div class="comments">
    <div class="comment_list">
        <?php
            while ( $comment = $comment_array->fetchArray() ) {
                $comment_id = intval($comment[0]);
                $comment_type = $comment[1];
                $comment_type_phrase = ($comment_type == 'comment')? 'left a comment' : 'attached a file' ;
                $comment_by = $comment[2];
                $comment_date = $comment[3];
                $comment_content = $comment[4];
                $comment_dismissed = $comment[5];

                $dismiss = '';
                if ( $comment_dismissed == "FALSE" ) {
                    if ( strpos($comment_content, '@' . $my_username) !== false or strpos($comment_content, '@' . $my_name) !== false ) {
                        $dismiss = '<span title="Dismiss notification"><i class="fas fa-bell-slash"></i></span>';
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
        <div class="inputs">
            <textarea name="message_content"></textarea>
            <div class="buttons">
                <button>Submit</button>
            </div>
        </div>
    </div>
</div>