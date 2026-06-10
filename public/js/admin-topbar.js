if (!window.adminTopbarReady) {
  window.adminTopbarReady = true;

  document.querySelectorAll('[data-menu-toggle]').forEach((button) => {
    button.addEventListener('click', (event) => {
      event.stopPropagation();
      const target = document.getElementById(button.dataset.menuToggle);

      document.querySelectorAll('.dropdown-panel').forEach((panel) => {
        if (panel !== target) {
          panel.classList.remove('show');
        }
      });

      if (target) {
        target.classList.toggle('show');
      }
    });
  });

  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-panel').forEach((panel) => panel.classList.remove('show'));
  });
}
