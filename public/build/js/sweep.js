$(document).ready(function() {
    
    $('#broomButton').on('click', function() 
    {
        $(this).css('display', 'none');
        // $(this).remove(); 
        $('#loadingBarGif').css('display', 'block');

    
        const token5 = getToken();  
        const headers5 = {
            "Authorization": `Bearer ${token5}`,
        };

        $.ajax({
            url: sweepUrl,
            method: 'GET',
            data: {
                ajax: true
            },
            dataType: 'json', // Set the expected data type to JSON
            headers: headers5,
            beforeSend: function () {
                // $('.error-container').html('');
                $('#packet_body').html('');
                $('#packet_body').html(`<div class="text-center"><img src="${giff_url}" alt="Loading..."></div>`);
            },
            success: function (data) 
            {
                if (data && data.status == 1) 
                {
                    $('#broomButton').css('display', 'block');
                    $('#loadingBarGif').css('display', 'none');

                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        text: 'The Extra Un-used files has been deleted!!!.',
                    });  
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                Swal.fire(
                    'Error!',
                    'Sweeping Up is Failed: ' + errorThrown,
                    'error'
                );
            }
        });   
    });
});

