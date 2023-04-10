jQuery(document).ready(function($){
    let userinput = document.getElementById('searchuser');
    userinput.addEventListener('keyup', function(e){
        let thisval = e.target.value;
        let html = '<div class="p-4"><div class="row">';
        $.ajax({
            url: global.root_url + "functions/ajax.php",
            method: "POST",
            data: {
                coinmate_search: thisval
            },
            dataType: "json",
            cache: false,
            success: function(data){
                // console.log('this is success: ', data)
                data.users.map(function(v, k){
                    console.log('vis: ', v);
                    let name = v.name ? v.name : v.username;
                    let bio = v.bio.length > 85 ? v.bio.slice(0, 85) + '...' : v.bio;
                    html += '<div class="col-sm-4 col-md-4 col-xs-6"><div class="card mw-100 mb-4 shadow-sm rounded bg-body" style="width: 18rem;">'
                    +'<img class="img-flude" style="height:250px; object-fit:cover;" src="'+ global.root_url +'dynamic/pfp/'+v.pfp+'" class="card-img-top" alt="...">'
                    +'<div class="card-body">'
                    +'<h5 class="card-title">'+ name + '</h5>'
                    +'<p class="card-text color-light link-secondary" style="min-height: 70px;">'+bio+'</p>'
                    +'<a href="'+global.root_url+'coinmate.php?action=user_details&id='+v.id+'" class="btn btn-primary">Go Details</a>'
                    +'</div>'
                  +'</div></div>'
                })
                +'</div></div>';

                jQuery(document.body).find('#commitmentWrap').html(html);
            }, 
            error: function(error){
                console.log('this is error: ', error)
            }
          });
    });
    

    // Enable bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    $('.select2').select2( {
        theme: 'bootstrap-5'
    });
});