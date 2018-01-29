<div class="previous">
    
    <table>
        <tr>
            <td style="text-align: center; height: 3em;">
                <span class="user" title="Gareth Murden" style="background-color: #45B21F">GM</span>
            </td>
            <td rowspan="2">
                This is the requested floor tool:
                <br /><img src="http://via.placeholder.com/100x50&text=Placeholder" alt="image">
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 3vw; vertical-align: top;" class="system small">15/01/2018</td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: center; height: 3em;">
                <span class="user" title="Declan Jordan" style="background-color: #207EAF">DJ</span>
            </td>
            <td rowspan="2">
                Required steps to complete:
                <ul>
                    <li class="task-list-item" style="list-style-type: none;">
                        <input type="checkbox" disabled="" style="margin: 0px 0.35em 0.25em -1.6em; vertical-align: middle;" checked="checked"> Step 1
                    </li>
                    <li class="task-list-item" style="list-style-type: none;">
                        <input type="checkbox" disabled="" style="margin: 0px 0.35em 0.25em -1.6em; vertical-align: middle;" checked="checked"> Step 2
                    </li>
                    <li class="task-list-item" style="list-style-type: none;">
                        <input type="checkbox" disabled="" style="margin: 0px 0.35em 0.25em -1.6em; vertical-align: middle;"> Step 3
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 3vw; vertical-align: top;" class="system small">15/01/2018</td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: center; height: 3em;">
                <span class="user" title="Gareth Murden" style="background-color: #45B21F">GM</span>
            </td>
            <td rowspan="2">
                Task <a href="/detail.php?task=3">#3</a> is related.
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 3vw; vertical-align: top;" class="system small">17/01/2018</td>
        </tr>
    </table>

</div>
<div class="new grey">
    <table>
        <tr>
            <td rowspan="2" class="new_comment" style="min-width: 80%">
                <textarea id="comment_input" placeholder="Add a comment" oninput="convert('comment_input', 'comment_preview')"  style="display:block"></textarea>
                <div id="comment_preview" style="display:none"></div>
            </td>
            <td style="width: 5em;vertical-align:bottom"><div class="button grey" onclick="toggle('comment_input', 'comment_preview')">Preview</div></td>
        </tr>
        <tr>
            <td style="vertical-align:top"><div class="button red">Submit</div></td>
    </table>
</div>
<script type="text/javascript">
    showdown.setFlavor('github');
    showdown.setOption('openLinksInNewWindow', 'true');
    showdown.setOption('ghMentionsLink', '/detail.php?task={u}');
    
    function convert(source, target) {
        var converter = new showdown.Converter();
        markdownContent = document.getElementById(source).value;
        htmlContent = converter.makeHtml(markdownContent);
        document.getElementById(target).innerHTML = htmlContent;
    }

    function toggle_tab(show_me, hide_me, select_me, deselect_me) {
        document.getElementById(show_me).style.display = 'block';
        document.getElementById(hide_me).style.display = 'none';
        document.getElementById(select_me).className = 'active_tab';
        document.getElementById(deselect_me).className = '';
    }
</script>
