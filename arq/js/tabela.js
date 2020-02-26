$(document).ready(function(){
    $('#formulario p button').dblclick(function(){
        var novoElemento = $('<form/>', {role: "form", method: "POST" , action: "/sala", enctype: "multipart/form-data"});
        $('#formulario').html(novoElemento.bind( function(){
            $('#tabelaEditavel tbody tr td.editavel').dblclick(function(){
                var conteudoOriginal = $(this).text();
                var novoElemento = $('<input/>', {type: "number", class: "form-control" , style: "width: 3cm", name: "nota" , value:conteudoOriginal});
                $(this).html(novoElemento.blur( function(){
                    var conteudoNovo = $(this).val();
                    console.log(conteudoNovo);
                }));
                $(this).children().select();
            })
        }))
    })
})