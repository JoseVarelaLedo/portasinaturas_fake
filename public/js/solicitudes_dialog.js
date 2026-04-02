document.addEventListener('click', (event) => {
    // abrir diálogo
    const openBtn = event.target.closest('[data-dialog-id]');
    if (openBtn) {
        const dialog = document.getElementById(openBtn.dataset.dialogId);
        dialog?.showModal();
        return;
    }

    // pechar diálogo
    const closeBtn = event.target.closest('[data-close-dialog]');
    if (closeBtn) {
        closeBtn.closest('dialog')?.close();
        return;
    }

    // click fóra do diálogo
    const dialog = event.target.closest('dialog');
    if (dialog && dialog.open) {
        const rect = dialog.getBoundingClientRect();
        const outside =
            event.clientX < rect.left ||
            event.clientX > rect.right ||
            event.clientY < rect.top ||
            event.clientY > rect.bottom;

        if (outside) dialog.close();
    }
});