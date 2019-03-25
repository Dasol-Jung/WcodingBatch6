<div class="form-popup" id="myForm">
    <form action="http://localhost:8888/?action=weeklySchedule&add=add" method="POST">
        <span class="red_star">* </span><label for="title">Title :<br>
        <input type="text" name="title" id="title"><br>
        <span class="red_star">* </span><label for="description">Description :<br>
        <textarea rows="4" cols="25"name="description" id="description"></textarea><br>
        <span class="red_star">* </span><label for="start">Start :<br>
        <input type="datetime-local" step="1" name="start" id="start"><br>
        <span class="red_star">* </span><label for="end">End :<br>
        <input type="datetime-local" step="1" name="end" id="end"><br>
        <span class="red_star">* </span>Priority :<br>
        <label for="high"><input type="radio" name="priority" class="priority" id="high" value="high">High<br>
        <label for="medium"><input type="radio" name="priority" class="priority" id="medium" value="medium" checked>Medium<br>
        <label for="low"><input type="radio" name="priority" class="priority" id="low" value="low">Low<br>
        <span class="red_star">* </span>Done :<br>
        <input type="radio" name="done" value="1" class="status" id="done"><label for="done">Done<br>
        <input type="radio" name="done" value="0" class="status" id="not" checked><label for="not">Not done<br>
        <!-- <label for="repeat">Repeat :<input type="checkbox" name="repeat" value="Repeat" id="repeat"><br> -->
        <button id="submit" type="button" onclick="addInfo($addWeeklyz);">Add</button>
        <button type="button" onclick="modifyInfo();">Modify</button><br>
        <button type="button" onclick="closeForm();" id="closeForm">X</button>
        <div id="error_message"></div>
    </form>
</div>