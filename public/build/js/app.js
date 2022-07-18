const mobileMenu = document.querySelector('.menu');
const sidebar = document.querySelector('.sidebar');


if(mobileMenu){

    mobileMenu.addEventListener('click', function(){
        sidebar.classList.toggle('mostrar');
    });

}
