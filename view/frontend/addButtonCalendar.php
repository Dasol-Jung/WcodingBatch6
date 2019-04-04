<div class="modalTarget detailedSchedule">
    <div class="modal-content">
        <form id="addEditScheduleForm" action="http://localhost:8888/index.php?action=addEditAppointment" method="POST">
            <section id="left">
            <input type="hidden" name="scheduleId">
                <div id="firstBlockForm">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title">
                    <label for="description">Description</label>
                    <textarea rows="4" cols="25" name="description" id="description"></textarea>
                    <label for="date">Date :</label>
                    <input type="date" name="eventDate" id="date">
                </div>
            </section>
            <section id="right">
                <div id="secondBlockForm">            
                    <label>Priority</label>
                        <div class="priorityContainer">
                            <label for="high"><div class='priorityColor high'></div><span>High</span></label>
                            <input type="radio" name="priority" class="priority" id="high" value="high"/>
                            <label for="medium"><div class='priorityColor medium'></div><span>Medium</span></label>
                            <input type="radio" name="priority" class="priority" id="medium" value="medium"/>
                            <label for="low"><div class='priorityColor low'></div><span>Low</span></label>
                            <input type="radio" name="priority" class="priority" id="low" value="low"/>
                        </div>
                    <label>Done</label>
                    <div class="isDoneContainer">
                        <label for="done"><div class="iconBg doneIcon"><img src="public/images/Done.svg" alt=""></div></label>
                        <input type="radio" name="done" value="1" class="status" id="done"/>
                        
                        <label for="notDone"><div class="iconBg notDoneIcon"><img src="public/images/notDone.svg" alt=""></div></label>
                        <input type="radio" name="done" value="0" class="status" id="notDone"/>
                    </div>
                </div>
                <div class="btns">
                    <button id='discard' type="button">Discard</button>
                    <button id="submit" type="submit">Add</button>
                </div>
            </section> 
        </form>
    </div>
</div>