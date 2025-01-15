// @license magnet:?xt=urn:btih:b8999bbaf509c08d127678643c515b9ab0836bae&dn=ISC.txt ISC
const el = document.getElementById('close');
const iframe = document.getElementsByName('guide')[0];

el.style.display = 'none';
el.addEventListener('click', () => el.style.display = 'none');

for (let link of document.getElementsByName('open'))
  link.addEventListener('click', () => el.style.display = 'initial');

iframe.addEventListener('load', () => {
  const iframeContent = iframe.contentWindow.document;
  iframe.style.height = iframeContent.documentElement.scrollHeight + 'px';
});
// @license-end
