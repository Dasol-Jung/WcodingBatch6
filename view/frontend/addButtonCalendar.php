<form action="index.php" method="POST">
Title<br>
<input type="text" name="title" id="title"><br>
Description<br>
<textarea rows="4" cols="25"name="description" id="description"></textarea><br>
Date<br>
<input type="date" name="date" id="date"><br>
Priority<br>
<input type="radio" name="priority" value="high" checked>High<br>
<input type="radio" name="priority" value="medium">Medium<br>
<input type="radio" name="priority" value="low">Low<br>
Done<br>
<input type="radio" name="done" value="done">Done<br>
<input type="radio" name="done" value="not">Not done<br>
<input type="submit" value="Add">
</form>