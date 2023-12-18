
        $('#list').on('click', function(e){
            console.log(e);
            $.get('/listlecteurs',function(data) {
              console.log(data);
              $('#listlecteur').empty();
              $.each(data, function(index, lecteurObj){
                $('#listlecteur').append('<input type="button" class="onelecteur" id="onelecteur" value="'+lecteurObj.first_name+'">');
              })
              });
            });

            $('.onelecteur').on('click',function(e){
               console.log(e);
               $.get('/listlecteurs',function(data) {
              console.log(data);
              });
               var lecteur_id = e.target.first_name;
               console.log(lecteur_id);
            });
