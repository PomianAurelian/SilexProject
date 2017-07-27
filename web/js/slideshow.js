var slideIndex = 1;
var clk = 1;
var changed = false;
var play = false;

showDivs(slideIndex);

setInterval(function() {
    if (play) {
        clk++;
        if (clk == 20) {
            plusDivs(1);
        }
    }
}, 100);


function plusDivs(n) {
    showDivs(slideIndex += n);
    changed = true;
    clk = 1;
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");

    if (n > x.length) {
        slideIndex = 1
    }

    if (n < 1) {
        slideIndex = x.length;
    }

    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    x[slideIndex - 1].style.display = "block";
}
