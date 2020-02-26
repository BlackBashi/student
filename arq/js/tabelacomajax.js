$(document).ready(function(){
    $('#tabelaEditavel tbody tr td.editavel').dblclick(function(){
        if($('td > input').length > 0){
            return;
        }
        var conteudoOriginal = $(this).text();
        var novoElemento = $('<input/>', {type: "number", class: "form-control" , min: 0 , max: 10 , style: "width: 3cm", name: "nota" , value:conteudoOriginal});
        $(this).html(novoElemento.bind('blur keydown', function(e){
            var objeto = $(this);
            var keyCode = e.which;
            var conteudoNovo = $(this).val();
            if(keyCode == 13 && conteudoNovo != conteudoOriginal && conteudoNovo <= 10 && conteudoNovo >= 0){
                $.ajax({
                    type: "POST",
                    url: "http://student.local/sala",
                    data:{
                        id:$(this).parents('tr').children().first().text(),
                        nota: conteudoNovo,
                        bimestre: $('#bimestre').val(),
                        idturma: $('#idturma').val(),
                        idmateria: $('#idmateria').val(),
                        idprof: $('#idprof').val(),
                        tipo: $(this).parent().attr('title')
                    },
                    success: function(result){
                        objeto.parent().html(conteudoNovo);
                        $('#resultado').append(result);
                    }
                })
                $(this).next().focus()
            }
            else if(keyCode == 27 || e.type =='blur')
                $(this).parent().html(conteudoOriginal);
        }));
        $(this).children().select();
    })

})