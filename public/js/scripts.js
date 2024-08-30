/* public/js/scripts.js */
$(document).ready(function(){
    $('#socio_cpf').mask('000.000.000-00');
    
    $('#submit-button').on('click', function(event) {
        const cpf = $('#socio_cpf').val();
        if (!isValidCPF(cpf)) {
            event.preventDefault();
            $('#cpf-error').text('CPF inválido.');
        } else {
            $('#cpf-error').text('');
        }
    });
});

function isValidCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false;
    }
    let add = 0;
    for (let i = 0; i < 9; i++) {
        add += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let rev = 11 - (add % 11);
    if (rev === 10 || rev === 11) {
        rev = 0;
    }
    if (rev !== parseInt(cpf.charAt(9))) {
        return false;
    }
    add = 0;
    for (let i = 0; i < 10; i++) {
        add += parseInt(cpf.charAt(i)) * (11 - i);
    }
    rev = 11 - (add % 11);
    if (rev === 10 || rev === 11) {
        rev = 0;
    }
    if (rev !== parseInt(cpf.charAt(10))) {
        return false;
    }
    return true;
}
