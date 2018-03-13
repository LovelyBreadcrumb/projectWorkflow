<?php
	if ( isset($_POST['edit_body']) ) {
		$previous_body = addslashes(str_replace('"', "'", $_POST['previous_body']));
		$new_body = addslashes(str_replace('"', "'", $_POST['edit_body']));

		if ( $previous_body != $new_body ) {
			$db->exec('UPDATE projects SET PROJECT_BODY="' . $new_body . '" WHERE PROJECT_ID=' . $project_id);

			$db->exec('INSERT INTO comments (PROJECT_ID, COMMENT_TYPE, COMMENT_BY, COMMENT_DATE, COMMENT_CONTENT) VALUES (' . $project_id . ', "system", "' . $my_username . '", "' . date('Y-m-d H:i:s') . '", "Previous breif:
				
```
' . $previous_body . '
```
New breif:
```
' . $new_body . '
```")');
		}
    }
?>