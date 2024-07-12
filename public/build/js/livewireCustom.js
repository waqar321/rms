
    $(document).ready(function() 
    {
        $('#addStudentPanel').css('display', 'none'); 

        $('.add_student').css('display', 'block');
        $('.add_student').addClass('btn btn-primary float-end custom-margin-bottom');
        $('.add_student').text('Add Student');
        
        $('.close_form').css('display', 'none');
        $('.close_form').addClass('btn btn-primary float-end custom-margin-bottom');
        $('.close_form').css('background-color', 'red'); 
        $('.close_form').text('Close Form');

        function uncollapsePanel(collapse) 
        {
            if(collapse == 0)
            {
                $('#addStudentPanel').css('display', 'block');
                $('.add_student').css('display', 'none');
                $('.close_form').css('display', 'block');
            }
            else
            {
                $('#addStudentPanel').css('display', 'none');
                $('.close_form').css('display', 'none');
                $('.add_student').css('display', 'block');
            }
        }

        function confirmDelete(studentId) 
        {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    // console.log('working ' + studentId);
                    Livewire.emit('deleteStudent', studentId); 
                }
            });
        }                
    });

