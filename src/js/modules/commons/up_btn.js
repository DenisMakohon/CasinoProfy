export default (function(selector = ".up-btn"){

	let up_btn = document.querySelector(selector);

	if(up_btn){

		window.addEventListener('scroll', scrollFunction)

		function scrollFunction() {
			document.body.scrollTop > 20 || document.documentElement.scrollTop > 20 ?
				up_btn.classList.add("show") :
				up_btn.classList.remove("show");
		}

		function topFunction(e) {
			e.preventDefault(); // На всякий случай. А вдруг ссылка?

			window.scrollTo({
                 top: 0,
                 behavior: "smooth"
            });
		}	

		up_btn.addEventListener('click', topFunction)
		scrollFunction()
	}else{
		console.log(`Node with name ${selector} is not found!`)
	}
})();