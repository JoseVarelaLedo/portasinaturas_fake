const openDialogById = (dialogId) => {
    const dialog = document.getElementById(dialogId);

    if (dialog && !dialog.open) {
        dialog.showModal();
    }
};

const activateTab = (tabButton) => {
    const tabsRoot = tabButton.closest('[data-tabs]');

    if (!tabsRoot) {
        return;
    }

    const targetId = tabButton.dataset.tabTarget;

    tabsRoot.querySelectorAll('[data-tab-target]').forEach((button) => {
        const isActive = button === tabButton;
        button.classList.toggle('is-active', isActive);
        button.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });

    tabsRoot.querySelectorAll('[role="tabpanel"]').forEach((panel) => {
        panel.hidden = panel.id !== targetId;
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(globalThis.location.search);
    const openDialogId = params.get('open_dialog');

    if (!openDialogId) {
        return;
    }

    openDialogById(openDialogId);

    params.delete('open_dialog');
    const nextQuery = params.toString();
    const querySegment = nextQuery ? '?' + nextQuery : '';
    const nextUrl = globalThis.location.pathname + querySegment + globalThis.location.hash;
    globalThis.history.replaceState(null, '', nextUrl);
});

document.addEventListener('click', (event) => {
    const switchBtn = event.target.closest('[data-switch-dialog]');
    if (switchBtn) {
        const currentDialog = switchBtn.closest('dialog');
        currentDialog?.close();
        openDialogById(switchBtn.dataset.switchDialog);
        return;
    }

    const openBtn = event.target.closest('[data-dialog-id]');
    if (openBtn) {
        openDialogById(openBtn.dataset.dialogId);
        return;
    }

    const tabBtn = event.target.closest('[data-tab-target]');
    if (tabBtn) {
        activateTab(tabBtn);
        return;
    }

    const closeBtn = event.target.closest('[data-close-dialog]');
    if (closeBtn) {
        closeBtn.closest('dialog')?.close();
        return;
    }

    const dialog = event.target.closest('dialog');
    if (dialog?.open) {
        const rect = dialog.getBoundingClientRect();
        const outside =
            event.clientX < rect.left ||
            event.clientX > rect.right ||
            event.clientY < rect.top ||
            event.clientY > rect.bottom;

        if (outside) dialog.close();
    }
});