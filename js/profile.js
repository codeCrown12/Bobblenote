// Get the modal
var modal = document.getElementById("myModal");
var imgs = document.querySelectorAll('.gal-img');
var overlay = document.querySelectorAll('.overlay');
var txts = document.querySelectorAll('.text');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

for (let i = 0; i < imgs.length; i++) {
        overlay[i].addEventListener('click', ()=>{
            let src = imgs[i].getAttribute('src');
            modal.style.display = 'block';
            modalImg.setAttribute('src', src);
            captionText.innerHTML = txts[i].innerHTML;
        })
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}