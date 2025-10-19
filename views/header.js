
  const menuToggle = document.createElement('div');
  menuToggle.classList.add('menu-toggle');
  menuToggle.innerHTML = '<span></span><span></span><span></span>';
  document.querySelector('header').appendChild(menuToggle);

  const navMenu = document.querySelector('header nav');

  menuToggle.addEventListener('click', () => {
    menuToggle.classList.toggle('active');
    navMenu.classList.toggle('show');
  });

