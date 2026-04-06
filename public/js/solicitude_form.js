const entidadeSelect = document.getElementById('id_entidade');
const nomeEntidadeInput = document.getElementById('nome_entidade');

if (entidadeSelect && nomeEntidadeInput) {
    entidadeSelect.addEventListener('change', (event) => {
        const option = event.target.options[event.target.selectedIndex];
        const nomeEntidade = option?.dataset?.nome || '';
        nomeEntidadeInput.value = nomeEntidade;
    });
}

const successContainer = document.querySelector('[data-solicitude-success]');
const successCode = successContainer?.dataset?.solicitudeSuccess;

if (successCode === '200') {
    const alertText = 'Solicitude creada correctamente';

    if (globalThis.Swal) {
        globalThis.Swal.fire({
            target: document.body,
            icon: 'success',
            title: alertText,
            confirmButtonText: 'Entendido',
        });
    } else {
        globalThis.alert(alertText);
    }

    if (successContainer) {
        successContainer.style.display = 'none';
    }
}
