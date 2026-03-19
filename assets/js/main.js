const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.nav');

if (menuToggle && nav) {
  menuToggle.addEventListener('click', () => {
    nav.classList.toggle('open');
    menuToggle.setAttribute(
      'aria-expanded',
      nav.classList.contains('open').toString()
    );
  });
}

const forms = document.querySelectorAll('form[data-validate]');
forms.forEach((form) => {
  form.addEventListener('submit', (event) => {
    const requiredFields = form.querySelectorAll('[data-required]');
    let isValid = true;
    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        isValid = false;
        field.style.borderColor = '#b74b4b';
      } else {
        field.style.borderColor = '#e2d6cc';
      }
    });

    if (!isValid) {
      event.preventDefault();
      alert('Please fill out all required fields before submitting.');
    }
  });
});
