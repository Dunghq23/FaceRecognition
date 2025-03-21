document.addEventListener('DOMContentLoaded', function() {
    const sidebarTitles = document.querySelectorAll('.sidebar-title');
    
    sidebarTitles.forEach(title => {
        title.addEventListener('click', function() {
            const parentGroup = this.parentNode;
            parentGroup.classList.toggle('collapsed');
        });
    });
});