let slideId = 0;

showSlides(slideId);


function nextSlide() {
	showSlides(slideId += 1);
}


function previousSlide() {
	showSlides(slideId -= 1);
}


function showSlides(n)
{
	let slides = document.getElementsByClassName("img");
	let miniImages = document.getElementsByClassName("mini-img");

	if (n > slides.length-1) {
		slideId = 0
	}
	if (n < 0) {
		slideId = slides.length-1
	}

	for (let slide of slides) {
		slide.style.display = "none";
	}
	slides[slideId].style.display = "block";

	for (let i = 0; i < miniImages.length; i++)
	{

		if (i === slideId)
		{
			miniImages[i].style.border = "1px solid rgba(0, 0, 0, 0.6)";
			miniImages[i].style.borderRadius = "10px";
		}

		else
		{
			miniImages[i].style.border = "none";
		}

		miniImages[i] = miniImages[i].onclick = function() {
			slides[slideId].style.display = "none";
			slides[i].style.display = "block";
			miniImages[i].style.border = "1px solid rgba(0, 0, 0, 0.6)";
			miniImages[i].style.borderRadius = "10px";
			miniImages[slideId].style.border = "none";
			slideId = i;
		}
	}

}