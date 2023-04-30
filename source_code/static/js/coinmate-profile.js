jQuery(document).ready(function($){
    $(document.body).find('#loader').hide();
    let userinput = document.getElementById('searchForm');
    userinput.addEventListener('submit', function(e){
        e.preventDefault();
        let age = document.getElementById('ageRange').value, 
        sex = document.getElementById('ssex').value, 
        zipcode = document.getElementById('szipcode').value, 
        city = document.getElementById('scity').value, 
        country = document.getElementById('scountry').value;

        let data = {
            age: age, 
            sex: sex, 
            zipcode: zipcode, 
            city: city, 
            country: country, 
            coinmate_search: true, 
            user_id: window.global.user_id
        }
        
        console.table('data before: ', data);
        let html = '<div class="p-4"><div class="row">';
        $.ajax({
            url: global.root_url + "functions/ajax.php",
            method: "POST",
            data: data,
            dataType: "json",
            cache: false,
            success: function(data){
                console.log('response: ', data)
                if(data.users){
                    data.users.map(function(v, k){
                        let name = v.name ? v.name : v.username;
                        let bio = v.bio.length > 85 ? v.bio.slice(0, 85) + '...' : v.bio;
                        html += '<div class="col-sm-4 col-md-4 col-xs-6"><div class="card mw-100 mb-4 shadow-sm rounded bg-body" style="width: 18rem;">'
                        +'<img class="img-flude" style="height:250px; object-fit:cover;" src="'+ global.root_url +'dynamic/pfp/'+v.pfp+'" class="card-img-top" alt="...">'
                        +'<div class="card-body">'
                        +'<h5 class="card-title">'+ name + '</h5>'
                        +'<p class="card-text color-light link-secondary" style="min-height: 70px;">'+bio+'</p>'
                        +'<a href="'+global.root_url+'coinmate.php?action=user_details&id='+v.user_id+'" class="btn btn-primary">Go Details</a>'
                        +'</div>'
                        +'</div></div>'
                    })
                }else{
                    html += '<div class="alert alert-dark" role="alert">No data are found for display</div>'
                }
                +'</div></div>';

                jQuery(document.body).find('#commitmentWrap').html(html);
            }, 
            error: function(error){
                console.log(error.responseText)
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