(function () {

    
    let modalDelete = document.getElementById('modalDelete');
    let deleteCategoria = document.getElementById('deleteCategoria');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        let element = event.relatedTarget;
        let action = element.getAttribute('data-url');
        let name = element.dataset.name;
        if(deleteCategoria) {
            deleteCategoria.innerHTML = name;
        }
        let form = document.getElementById('modalDeleteResourceForm');
        form.action = action;
    });

})();