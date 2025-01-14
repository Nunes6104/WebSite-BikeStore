'use strict';
const openModal = document.querySelector('.openModal');
const showBox = document.querySelector('.showBox');
const closeBox = document.querySelector('.closeBox');
const overlay = document.querySelector('.overlay');

openModal.addEventListener('click', function(){
  showBox.classList.remove('hidden');
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
});

closeBox.addEventListener('click', function(){
  showBox.classList.add('hidden');
  overlay.classList.remove('active');
  document.body.style.overflow = '';
});
overlay.addEventListener('click', closeBox);

//------------- Search Bar -------------//
const searchInput = document.getElementById('searchInput');
const results = document.getElementById('results');
const links = results.getElementsByTagName('li');

// Função principal
searchInput.addEventListener('keyup', function () {
    const query = searchInput.value.toLowerCase().trim(); // Remove espaços extras

    // Se o input estiver vazio, esconde tudo
    if (query === "") {
        results.style.display = "none";
        return;
    }
    // Itera pelos links para encontrar correspondências
    for (let i = 0; i < links.length; i++) {
        const linkText = links[i].textContent || links[i].innerText;

        if (linkText.toLowerCase().includes(query)) {
            links[i].style.display = "block";
            results.style.display = "flex";
        } else {
            links[i].style.display = "none";
        }
    }
});


