const entidadeSelect = document.getElementById('id_entidade');
const nomeEntidadeInput = document.getElementById('nome_entidade');

if (entidadeSelect && nomeEntidadeInput) {
    entidadeSelect.addEventListener('change', (event) => {
        const option = event.target.options[event.target.selectedIndex];
        const nomeEntidade = option?.dataset?.nome || '';
        nomeEntidadeInput.value = nomeEntidade;
    });
}
