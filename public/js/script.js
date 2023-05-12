const menu = document.getElementById('menu-label');
const sidebar = document.getElementsByClassName('sidebar')[0];
const maincontent = document.getElementsByClassName('main-content')[0];

menu.addEventListener('click', () => {
    sidebar.classList.toggle('hide');
    maincontent.classList.toggle('hide');

})
