document.querySelector("html").setAttribute("data-theme", localStorage.getItem('theme') || 'light'); document.querySelector("html").setAttribute('data-sidebar', localStorage.getItem('sidebarTheme') || 'light'); document.querySelector("html").setAttribute('data-color', localStorage.getItem('color') || 'primary'); document.querySelector("html").setAttribute('data-topbar', localStorage.getItem('topbar') || 'white'); let themesettings =               
    document.addEventListener("DOMContentLoaded", function () { $(".main-wrapper").append(themesettings) }); document.addEventListener("DOMContentLoaded", function (event) {
        const darkModeToggle = document.getElementById('dark-mode-toggle'); const lightModeToggle = document.getElementById('light-mode-toggle'); const darkMode = localStorage.getItem('darkMode'); function enableDarkMode() { document.documentElement.setAttribute('data-theme', 'dark'); darkModeToggle.classList.remove('activate'); lightModeToggle.classList.add('activate'); localStorage.setItem('darkMode', 'enabled'); }
        function disableDarkMode() { document.documentElement.setAttribute('data-theme', 'light'); lightModeToggle.classList.remove('activate'); darkModeToggle.classList.add('activate'); localStorage.removeItem('darkMode'); }
        if (darkModeToggle && lightModeToggle) {
            if (darkMode === 'enabled') { enableDarkMode(); } else { disableDarkMode(); }
            darkModeToggle.addEventListener('click', enableDarkMode); lightModeToggle.addEventListener('click', disableDarkMode);
        }
    }); 