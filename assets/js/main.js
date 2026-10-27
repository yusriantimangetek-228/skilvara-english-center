// FAQ accordion + filter kategori
document.querySelectorAll('.faq-q').forEach(b => b.addEventListener('click', () => b.parentElement.classList.toggle('open')));
const tabs = document.querySelectorAll('.tab');
function showCat(id) { document.querySelectorAll('.faq').forEach(f => f.style.display = f.dataset.cat === id ? '' : 'none'); }
tabs.forEach(t => t.addEventListener('click', () => { tabs.forEach(x => x.classList.remove('on')); t.classList.add('on'); showCat(t.dataset.cat); }));
if (tabs.length) showCat(tabs[0].dataset.cat);
