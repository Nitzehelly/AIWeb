const container = document.getElementById('container');
const signUpBtn = document.getElementById('sign-up-btn');
const signInBtn = document.getElementById('sign-in-btn');
const signInOverlayBtn = document.getElementById('sign-in-btn-overlay');
const signUpOverlayBtn = document.getElementById('sign-up-btn-overlay');

if (signUpBtn) signUpBtn.addEventListener('click', () => container.classList.add('sign-up-mode'));
if (signInBtn) signInBtn.addEventListener('click', () => container.classList.remove('sign-up-mode'));
if (signUpOverlayBtn) signUpOverlayBtn.addEventListener('click', () => container.classList.add('sign-up-mode'));
if (signInOverlayBtn) signInOverlayBtn.addEventListener('click', () => container.classList.remove('sign-up-mode'));