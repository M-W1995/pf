//////////////////
// navbar
//////////////////
//sticky 
var navbar = document.querySelector(".main-nav");
var sticky = navbar.offsetTop;
function navbarCheck() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
window.onscroll=()=>{ navbarCheck() };
// burger menu
const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
if ($navbarBurgers.length > 0) {
	$navbarBurgers.forEach( el => {
	  el.addEventListener('click', () => {
	    const target = el.dataset.target;
	    const $target = document.getElementById(target);
	    el.classList.toggle('is-active');
	    $target.classList.toggle('is-active');
	  });
	});
}