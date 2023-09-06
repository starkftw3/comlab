const activePage = window.location.pathname;

const navLInks = document.querySelectorAll('.sidebar-menu a').
forEach(link => {
    if(link.href.includes(`${activePage}`)){
        link.classList.add('active');
    }
});