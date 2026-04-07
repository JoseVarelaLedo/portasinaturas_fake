document.addEventListener('submit', (event) => {
    const approveForm = event.target.closest('.form_aprobar_solicitude');

    if (approveForm) {
        if (approveForm.dataset.swalConfirmed === '1') {
            delete approveForm.dataset.swalConfirmed;
            return;
        }

        event.preventDefault();

        if (globalThis.Swal) {
            const dialog = approveForm.closest('dialog');

            globalThis.Swal.fire({
                target: dialog ?? document.body,
                icon: 'question',
                title: 'Aprobar solicitude',
                text: 'Seguro que queres aprobar esta solicitude?',
                showCancelButton: true,
                confirmButtonText: 'Si, aprobar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                approveForm.dataset.swalConfirmed = '1';
                approveForm.requestSubmit();
            });

            return;
        }

        if (globalThis.confirm('Seguro que queres aprobar esta solicitude?')) {
            approveForm.dataset.swalConfirmed = '1';
            approveForm.requestSubmit();
        }

        return;
    }

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

document.addEventListener('DOMContentLoaded', () => {
    const errorContainer = document.querySelector('[data-estado-solicitude-error]');
    const errorMessage = errorContainer?.dataset?.estadoSolicitudeError;

    if (!errorMessage) {
        return;
    }

    if (globalThis.Swal) {
        globalThis.Swal.fire({
            icon: 'warning',
            title: 'Non se puido aprobar',
            text: errorMessage,
            confirmButtonText: 'Entendido',
        });

        return;
    }

    globalThis.alert(errorMessage);
});
