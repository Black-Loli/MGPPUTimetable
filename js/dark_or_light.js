const themeLinkObject = document.getElementById('themeLink')

function setTheme(dark) {
    localStorage.setItem('theme_link', `css/style_${dark ? 'dark' : 'light'}.css`)
    if (dark) {
        themeLinkObject.href = "css/style_dark.css";
    } else {
        themeLinkObject.href = "css/style_light.css";
    }
}

$('#themeToggleCheckbox').change(function (e) {
    setTheme(e.target.checked)
    console.log("toggled", e.target.checked)
})

$(document).ready(function () {
    themeLinkObject.href = localStorage.getItem('theme_link');
})