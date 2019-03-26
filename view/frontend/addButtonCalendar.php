<div class="form-popup" id="myForm">
    <form action="http://localhost:8888/index.php?action=addEditAppointment" method="POST">
        <span class="red_star">* </span><label for="title">Title :<br>
        <input type="text" name="title" id="title"><br>
        <span class="red_star">* </span><label for="description">Description :<br>
        <textarea rows="4" cols="25"name="description" id="description"></textarea><br>
        <span class="red_star">* </span><label for="date">Date :<br>
        <input type="date" name="eventDate" id="date"><br>
        <span class="red_star">* </span>Priority :<br>
        <label for="high"><input type="radio" name="priority" class="priority" id="high" value="high">High<br>
        <label for="medium"><input type="radio" name="priority" class="priority" id="medium" value="medium" checked>Medium<br>
        <label for="low"><input type="radio" name="priority" class="priority" id="low" value="low">Low<br>
        <span class="red_star">* </span>Done :<br>
        <input type="radio" name="done" value="1" class="status" id="done"><label for="done">Done<br>
        <input type="radio" name="done" value="0" class="status" id="not" checked><label for="not">Not done<br>
        <button id="submit" type="submit" onclick="parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.remove()">Add</button>
        <button type="button" onclick="modifyInfo($modWeekly)">Modify</button><br>
        <button type="button" onclick="closeForm()" id="closeForm">X</button>
        <!-- onclick="parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.remove()" -->
        <div id="error_message"></div>
    </form>
</div>