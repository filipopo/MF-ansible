// @license magnet:?xt=urn:btih:b8999bbaf509c08d127678643c515b9ab0836bae&dn=ISC.txt ISC
const el = document.getElementById('close');

el.style.display = 'none';
el.firstChild.addEventListener('click', () => el.style.display = 'none');

for (let link of document.querySelectorAll('li > a'))
  link.addEventListener('click', () => el.style.display = 'initial');
// @license-end
