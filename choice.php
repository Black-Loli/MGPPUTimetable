<div id="profile_selection_overlay" class="overlay">
    <div class="modal">
        <div class="tab-list">
            <input type="radio" name="profile_selector" id="student_tab" class="tab_selector" checked>
            <label for="student_tab" class="tab_selector_label">
                Студент
            </label>
            <input type="radio" name="profile_selector" id="professor_tab" class="tab_selector">
            <label for="professor_tab" class="tab_selector_label">
                Преподаватель
            </label>
        </div>
        <div class="tab-content">
            <div id="student_tab_content" class="active">
                <select name="type" required="" id="faculty_selector">
                    <option class="op" selected> Выберите факультет </option>
                    <option class="op" selected> Информационные технологии </option>

                </select>

                <select class="choice_group" name="type" required="" id="group_choice">
                    <option class="name_group" selected> Выберите группу </option>
                </select>

<!--                <button type="submit" class="btn"> Показать </button>-->
            </div>
            <div id="professor_tab_content">
                <select name="type" class="professor_tab" required="">
                    <option class="op" selected> Выберите преподавателя </option>
                    <option class="op"> Попков </option>
                </select>

            </div>
            <button type="submit" class="btn" id="showTimetable"> Показать </button>
        </div>
    </div>
</div>