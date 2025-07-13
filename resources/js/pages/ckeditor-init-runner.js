document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.initCKEditor === 'function') {
        window.initCKEditor('#immediate_corrective_action', data => {
            window.Livewire.dispatch('updateImmediateCorrectiveAction', {
                value: data
            });
        });

        window.initCKEditor('#description', data => {
            window.Livewire.dispatch('updateDescription', {
                value: data
            });
        });
    }
});
