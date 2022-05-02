var url = window.location.origin;

$(document).ready(function(){
    
    console.log('js cargado');

    like();
    dislike();

});


function like(){

    $(document).on('click', '.btn-like', function(){
        console.log('like');
        $(this).addClass('btn-dislike').removeClass('btn-like');
        $(this).attr('src', url+'/img/icons/heart-red.png');

        $.ajax({

            url: `${url}/like/${$(this).attr('data-id')}`,
            type: 'GET',
            success: function(data){
                
                console.log(data.message);

            }

        });

    })

}


function dislike(){

    $(document).on('click', '.btn-dislike', function(){

        console.log('dislike');
        $(this).addClass('btn-like').removeClass('btn-dislike');
        $(this).attr('src', url+'/img/icons/heart-grey.png');
        
        $.ajax({

            url: `${url}/dislike/${$(this).attr('data-id')}`,
            type: 'GET',
            success: function(data){
                
                console.log(data.message);

            }

        });

    })

}

