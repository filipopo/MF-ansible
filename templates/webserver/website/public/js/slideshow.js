// @license magnet:?xt=urn:btih:b8999bbaf509c08d127678643c515b9ab0836bae&dn=ISC.txt ISC
const $ = s => s[0] == '#' ? document.querySelector(s) : document.querySelectorAll(s);

const img = $('.slides img');
let i = img.length - 1, click = false;

function move(left) {
  img[i].style.display = 'none';
  i = (left ? i - 1 + img.length : i + 1) % img.length;
  img[i].style.display = 'initial';
}

function showSlides() {
  if (click) return;
  move();
  setTimeout(showSlides, 3000);
}

showSlides();
$('#left').addEventListener('click', () => { move(true); click = true });
$('#right').addEventListener('click', () => { move(); click = true });
// @license-end
