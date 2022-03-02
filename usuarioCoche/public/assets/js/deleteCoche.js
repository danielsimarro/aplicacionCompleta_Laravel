(function () {

    
    let modalDelete = document.getElementById('modalDelete');
    let deleteCoche = document.getElementById('deleteCoche');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        let element = event.relatedTarget;
        let action = element.getAttribute('data-url');
        let name = element.dataset.name;
        if(deleteCoche) {
            deleteCoche.innerHTML = name;
        }
        let form = document.getElementById('modalDeleteResourceForm');
        form.action = action;
    });

})();