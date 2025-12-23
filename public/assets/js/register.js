const $btnSubmit = document.getElementById('btn-submit');
const $contrasenia = document.getElementById('password');
const $contraseniaRepetida = document.getElementById('password-repeat');

const verificarContrasenia = (contrasenia, contraseniaRepetida, btnSubmit) => {
  const inpContrasenia = contrasenia.value.trim();
  const inpContraseniaRepetida = contraseniaRepetida.value.trim();

  inpContrasenia === inpContraseniaRepetida ?
    btnSubmit.removeAttribute('disabled') :
    btnSubmit.setAttribute('disabled', 'true')
}

$contrasenia.addEventListener('input', () => {
  verificarContrasenia($contrasenia, $contraseniaRepetida, $btnSubmit);
});

$contraseniaRepetida.addEventListener('input', () => {
  verificarContrasenia($contrasenia, $contraseniaRepetida, $btnSubmit);
});
