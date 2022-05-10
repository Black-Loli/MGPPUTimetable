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
                <select name="type" required="">
                    <option class="op" selected> Выберите факультет </option>
                    <option class="op" selected> Информационные технологии </option>

                </select>

                <select name="type" required="">
                    <option class="op" selected> Выберите группу </option>
                    <option class="op" selected> 19ИТ-ПИ(б/о)ПИП-1 </option>

                </select>

                <button type="submit" class="btn"> Показать </button>
            </div>
            <div id="professor_tab_content">
                <select name="type" class="professor_tab" required="">
                    <option class="op" selected> Выберите преподавателя </option>
                    <option class="op"> Попков </option>
                </select>

                <button type="submit" class="btn"> Показать </button>
            </div>
        </div>
    </div>
</div>