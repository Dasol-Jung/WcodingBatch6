<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeForm()">&times;</span>
        <form action="http://localhost:8888/index.php?action=addEditAppointment" method="POST">
            <div id="firstBlockForm">
                <span class="red_star">* </span><label for="title">Title :<br>
                <input type="text" name="title" id="title"><br>
                <span class="red_star">* </span><label for="description">Description :<br>
                <textarea rows="4" cols="25"name="description" id="description"></textarea><br>
                <span class="red_star">* </span><label for="date">Date :<br>
                <input type="date" name="eventDate" id="date"><br>
            </div>
            <div id="secondBlockForm">            
                <span class="red_star">* </span>Priority :<br>
                <span class="radiobtn">
                    <input type="radio" name="priority" class="priority" id="high" value="high"><label for="high">High</label><br>
                </span>
                <span class="radiobtn">
                    <input type="radio" name="priority" class="priority" id="medium" value="medium" checked><label for="medium">Medium</label><br>
                </span>
                <span class="radiobtn">
                    <input type="radio" name="priority" class="priority" id="low" value="low"><label for="low">Low</label><br>
                </span>
                <span class="red_star">* </span>Done :<br>
                <input type="radio" name="done" value="1" class="status" id="done"><label for="done">Done<br>
                <input type="radio" name="done" value="0" class="status" id="not" checked><label for="not">Not done<br>
            </div>
            <button id="submit" type="submit">Add</button>
            <button type="button" onclick="modifyInfo($modWeekly)">Modify</button><br>
            <div id="error_message"></div>
        </form>
    </div>
</div>