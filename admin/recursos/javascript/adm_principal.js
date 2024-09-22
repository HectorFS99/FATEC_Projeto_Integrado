function transformarTabela(id_tabela) {
    if ($.fn.dataTable.isDataTable(id_tabela)) {
        $(id_tabela).DataTable().destroy();
    }
 
    let table = new DataTable(id_tabela, {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            search: "",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Exibir _MENU_ itens por página",
            info: "Exibindo _END_ de _TOTAL_ registro(s)",
            infoEmpty: "",
            "paginate": {
                "next":       "<i class=\"fa-solid fa-angle-right\"></i>",
                "previous":   "<i class=\"fa-solid fa-angle-left\"></i>"
            },
        }
    });
}