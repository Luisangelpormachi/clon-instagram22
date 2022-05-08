var url = window.location.origin;

$(document).ready(function(){
    
    like();
    dislike();

    $('#buscador').submit(function(e){
        
        $(this).attr('action', `${$(this).attr('action')}/${$('#search').val()}`);

    });

});


function like(){

    $(document).on('click', '.btn-like', function(){

        $(this).addClass('btn-dislike').removeClass('btn-like');
        $(this).attr('src', url+'/img/icons/heart-red.png');

        //obtener del dom el elemento contador de likes
        var count_likes = $(this).parent().parent().find('.count-likes');

        $.ajax({

            url: `${url}/like/${$(this).attr('data-id')}`,
            type: 'GET',
            success: function(data){
                
                // console.log(data.message);
                
                actualizarContadorLike('like', count_likes);
            }
        });
    })
}


function dislike(){

    $(document).on('click', '.btn-dislike', function(){

        $(this).addClass('btn-like').removeClass('btn-dislike');
        $(this).attr('src', url+'/img/icons/heart-grey.png');
        
        //obtener del dom el elemento contador de likes
        var count_likes = $(this).parent().parent().find('.count-likes');

        $.ajax({

            url: `${url}/dislike/${$(this).attr('data-id')}`,
            type: 'GET',
            success: function(data){
                
                // console.log(data.message);
                actualizarContadorLike('dislike', count_likes);
            }
        });
    })
}


function actualizarContadorLike(valor_like, count_likes){

    var contador_likes;

    contador_likes = count_likes.html().replace('(', '');
    contador_likes = contador_likes.replace(')', '');
    contador_likes = contador_likes.trim();
    contador_likes = parseInt(contador_likes);

    var total = 0;

    switch(valor_like){

        case 'like':
            total = contador_likes + 1;
            count_likes[0].innerHTML = `(${total})`;
        break;

        case 'dislike':
            total = contador_likes - 1;
            count_likes[0].innerHTML = `(${total})`;
        break;

        default:
            count_likes[0].innerHTML = `(${total})`;
    }
}




