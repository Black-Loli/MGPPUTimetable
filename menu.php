<input type="checkbox" id="ham-menu">
<label for="ham-menu" class="menu" id="button_menu">
    <div class="hide-des">
        <span class="menu-line"></span>
        <span class="menu-line"></span>
        <span class="menu-line"></span>
        <span class="menu-line"></span>
        <span class="menu-line"></span>
        <span class="menu-line"></span>
    </div>
</label>

<div id="overlay_menu"></div>
<div class="ham-menu" id="menu">
    <ul class="centre-text bold-text">
        <li>
            <input type="radio" name="left_submenu" id="time_table_01"/>
            <label for="time_table_01" class="time">
                Расписание
                <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <line y1="-2" x2="19.3367" y2="-2"
                          transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                          stroke-width="4"/>
                    <line y1="-2" x2="19.3375" y2="-2"
                          transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                </svg>
            </label>

            <ul class="sub-items">
                <li>
                    <div id="time_today"> На сегодня
                        <div>
                            <a href="schedule_group_day.php" data-tab-target="student_tab">На группу</a>
                            <a href="schedule_teacher_day.php" data-tab-target="professor_tab">Преподу</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div id="time_week"> На неделю
                        <div>
                            <a href="schedule_group_week.php" data-tab-target="student_tab">На группу</a>
                            <a href="schedule_teacher_week.php" data-tab-target="professor_tab">Преподу</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div id="time_term"> На семестр
                        <div>
                            <a href="schedule_group_month.php" data-tab-target="student_tab">На группу</a>
                            <a href="schedule_teacher_month.php" data-tab-target="professor_tab">Преподу</a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <input type="radio" name="left_submenu" id="time_table_02"/>
            <label for="time_table_02" class="time">
                Преподаватели в корпусе
                <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <line y1="-2" x2="19.3367" y2="-2"
                          transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                          stroke-width="4"/>
                    <line y1="-2" x2="19.3375" y2="-2"
                          transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                </svg>
            </label>

            <ul class="sub-items">
                <li>
                    <a href="professor_day.php"> На сегодня</a>
                </li>
                <li>
                    <a href="professor_week.php"> На неделю</a>
                </li>
                <li>
                    <a href="professor_month.php"> На семестр </a>
                </li>
            </ul>
        </li>

        <li>
            <input type="radio" name="left_submenu" id="time_table_03"/>
            <label for="time_table_03" class="time">
                Группы в корпусе
                <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <line y1="-2" x2="19.3367" y2="-2"
                          transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                          stroke-width="4"/>
                    <line y1="-2" x2="19.3375" y2="-2"
                          transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                </svg>
            </label>

            <ul class="sub-items">
                <li>
                    <a href="groups_day.php"> На сегодня</a>
                </li>
                <li>
                    <a href="groups_week.php"> На неделю</a>
                </li>
                <li>
                    <a href="groups_month.php"> На семестр </a>
                </li>
            </ul>
        </li>

        <li>
            <input type="radio" name="left_submenu" id="time_table_04"/>
            <label for="time_table_04" class="time">
                Кабинеты
                <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <line y1="-2" x2="19.3367" y2="-2"
                          transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                          stroke-width="4"/>
                    <line y1="-2" x2="19.3375" y2="-2"
                          transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                </svg>
            </label>

            <ul class="sub-items">
                <li>
                    <a href="rooms_day.php"> На сегодня</a>
                </li>
                <li>
                    <a href="rooms_week.php"> На неделю</a>
                </li>
                <li>
                    <a href="rooms_month.php"> На семестр </a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="color">
        <h2> Включить тёмную тему </h2>
        <input type="checkbox" class="checkbox" id="themeToggleCheckbox"/>
        <label for="themeToggleCheckbox"></label>
    </div>
</div>