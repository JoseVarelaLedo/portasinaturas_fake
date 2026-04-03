const updateBotonRemesa = () => {
    const checks = Array.from(document.querySelectorAll('.check-emenda'));
    const boton = document.getElementById('boton-xerar-remesa');

    if (!boton || checks.length === 0) {
        return;
    }

    const haySeleccion = checks.some((check) => check.checked);

    boton.hidden = !haySeleccion;
    boton.disabled = !haySeleccion;
};

document.addEventListener('change', (event) => {
    if (!event.target.closest('.check-emenda')) {
        return;
    }

    updateBotonRemesa();
});

document.addEventListener('DOMContentLoaded', () => {
    updateBotonRemesa();
});
