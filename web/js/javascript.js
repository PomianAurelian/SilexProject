var slides = document.getElementsByClassName('company');

for (var i = 0; i < slides.length; i++) {
    slides[i].onmouseover = function() {
       this.classList.add('bordered-box');
    };

    slides[i].onmouseout = function() {
       this.classList.remove('bordered-box');
    };

    slides[i].onclick = function() {
       location.href = '/company';
    };
}
