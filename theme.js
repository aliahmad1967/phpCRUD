document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply initial theme
    document.documentElement.setAttribute('data-theme', currentTheme);
    updateToggleIcon(currentTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = theme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateToggleIcon(newTheme);
        });
    }
});

function updateToggleIcon(theme) {
    const icon = document.querySelector('#theme-toggle i');
    if (icon) {
        icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
    }
}
