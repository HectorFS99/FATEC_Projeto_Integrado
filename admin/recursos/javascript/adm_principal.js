function transformarTabela(id_tabela) {
    if ($.fn.dataTable.isDataTable(id_tabela)) {
        $(id_tabela).DataTable().destroy();
    }
 
    let table = new DataTable(id_tabela, {
        language: {
            search: ""
            , searchPlaceholder: "Buscar..."
            , lengthMenu: "Exibir _MENU_ itens por página"
            , info: "Exibindo _END_ de _TOTAL_ registro(s)"
            , infoEmpty: ""
            , "paginate": {
                 "first": "Primeiro"
                 , "last": "Último"
                 , "next": "<i class=\"fa-solid fa-angle-right\"></i>"
                 , "previous": "<i class=\"fa-solid fa-angle-left\"></i>"
            }
            , zeroRecords: "Nenhum registro encontrado."
            , emptyTable: "Não existem dados a serem exibidos."
            , thousands: "."
            , decimal: ","
            , infoFiltered: ""
        }
    });
}

/***** SweetAlert2. *****/
// Popups
const popupSwal = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-lg btn-light custom-button-popup',
        cancelButton: 'btn btn-lg btn-danger custom-button-popup',
        popup: 'custom-popup'
    },
    buttonsStyling: false
});
 
// Toasts
const toastSwal = Swal.mixin({
    toast: true,
    position: 'top-end',
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast',
    },
    showConfirmButton: false,
    timer: 7000,
    timerProgressBar: true,
});
