
    $(document).ready(function () 
    {

    });

    function confirmDelete(id) 
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
                //
                // alert(ModuleName);
                // return false;
                
                Livewire.emit('delete'+ ModuleName, id); 
            }
        });
    }
    window.addEventListener('deleted_scene', event => 
    {
        Swal.fire({
            icon: 'success',
            title: ModuleName.replace('Manage', '') + ' Deleted Successfully!',
            text: 'The ' + event.detail.name  + ' has been deleted.',
        });                
    })
    window.addEventListener('status_updated', event => 
    {        
        Swal.fire({
            icon: 'success',
            title: ModuleName.replace('Manage', '') + ' ' +  'Updated Successfully!',
            text: 'The ' + event.detail.name  + ' has been Updated.',
        });                
    })
    window.addEventListener('created_module', event => 
    {
        var Message = window.location.search ? "Updated" : "Created";

        Swal.fire({
            icon: 'success',
            title: ModuleName.replace('Manage', '') + ' ' + Message + ' Successfully!',
            text: 'The ' + event.detail.name  + ' has been ' + Message,
        });                ``
    })
    window.addEventListener('file_deleted', event => 
    {
        if (event.detail.type == 'photo') 
        {
            Swal.fire({
                icon: 'info',
                title: 'File Deleted!!!',
                text: 'The ' + event.detail.name + "'s photo has been deleted."
            });
        }
        else if (event.detail.type == 'video')
        {
            Swal.fire({
                icon: 'info',
                title: 'File Deleted!!!',
                text: 'The ' + event.detail.name + "'s video has been deleted."
            });
        }
        else if (event.detail.type == 'document')
        {
            Swal.fire({
                icon: 'info',
                title: 'File Deleted!!!',
                text: 'The ' + event.detail.name + "'s document has been deleted."
            });
        }                     
    })
    window.addEventListener('clearedUp', event => 
    {
        Swal.fire({
            icon: 'success',
            title: 'Cache Cleared Successfully',
            text: 'The Extra Un-used files has been deleted!!!.',
        });                
    })
    window.addEventListener('notificationSent', event => 
    {
        Swal.fire({
            icon: 'success',
            title: 'Notification Sent Successfully!',
            text: 'The Notification has been generated!!!.',
        });              
    })
    // document.addEventListener('livewire:load', function () 
    // {
    //     Livewire.on('notificationSent', function () {
    //         Swal.fire({
    //             icon: 'success',
    //             title: 'Notification Sent Successfully!',
    //             text: 'The Notification has been generated!!!.',
    //         });    
    //     });
    // });
    window.addEventListener('token_created', event => 
    {
        Swal.fire({
            icon: 'success',
            title: 'Token Saved Successfully!',
            text: 'The Notification token has been updated on User.',
        });                
    });
    