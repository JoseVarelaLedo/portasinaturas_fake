document.addEventListener('submit', (event) => {
    const form = event.target.closest('.form_xerar_emenda');

    if (!form) {
        return;
    }

    const hasAdmin = form.dataset.hasAdmin === '1';
    const hasTecnico = form.dataset.hasTecnico === '1';

    if (hasAdmin && hasTecnico) {
        return;
    }

    event.preventDefault();

    let text = 'A solicitude non ten usuario técnico asignado.';

    if (!hasAdmin && !hasTecnico) {
        text = 'A solicitude non ten usuario administrativo nin técnico asignados.';
    } else if (!hasAdmin) {
        text = 'A solicitude non ten usuario administrativo asignado.';
    }

    if (globalThis.Swal) {
        const dialog = form.closest('dialog');

        globalThis.Swal.fire({
            target: dialog ?? document.body,
            icon: 'warning',
            title: 'Non se pode xerar emenda',
            text,
            confirmButtonText: 'Entendido',
        });

        return;
    }

    globalThis.alert(text);
});
