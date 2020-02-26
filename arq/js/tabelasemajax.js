$(document).ready(function(){
    $('#tabelaEditavel tbody tr td.editavel').dblclick(function(){
        var conteudoOriginal = $(this).text();
        var novoElemento = $('<input/>', {type: "number", class: "form-control" , style: "width: 3cm", name: "nota" , value:conteudoOriginal});
        $(this).html(novoElemento.bind( function(){
            var conteudoNovo = $(this).val();
        }));
        $(this).children().select();
    })
})