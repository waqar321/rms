const token3 = getToken();
const headers3 = {
    "Authorization": `Bearer ${token3}`,
};

function status(url, table, id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to change the status",
        // icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ffca00",
        cancelButtonColor: "#0e1827",
        cancelButtonText: "No",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            activeInActive(id, url, table);
        }
    });
}

function activeInActive(ids, url, tbl) {
    $.ajax({
        url: url,
        method: 'POST',
        data: {id: ids, table: tbl},
        dataType: 'json',
        headers: headers3,
        success: function (data) {
            if (data && data.status == 1) {
                var status = (data.response.is_active === 1) ? 'In Activated' : 'Activated';
                Swal.fire({
                    icon: 'success',
                    text: 'Record Has Been ' + status + ' Successfully',
                    showConfirmButton: true,
                    confirmButtonColor: '#ffca00',
                })
                $('.select_none').trigger('click');
                table.draw();

            }
        },
        error: function (xhr, textStatus, errorThrown) {
            // Handle AJAX errors here
            Swal.fire(
                'Error!',
                'Form submission failed: ' + errorThrown,
                'error'
            );
        }
    });
}

function deleteData(url, table, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this record",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffca00',
        cancelButtonColor: '#0e1827',
        cancelButtonText: 'No',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteRecord(id, url, table);
        }
    });
}

function deleteRecord(ids, url, tbl) {
    $.ajax({
        url: url,
        method: 'POST',
        data: {id: ids, table: tbl},
        dataType: 'json',
        headers: headers3,
        success: function (data) {
            if (data && data.status == 1) {
                Swal.fire({
                    icon: 'success',
                    text: 'Record Has Been Deleted Successfully',
                    showConfirmButton: true,
                    confirmButtonColor: '#ffca00',
                })

                $('.select_none').trigger('click');
                table.draw();

            }
        },
        error: function (xhr, textStatus, errorThrown) {
            // Handle AJAX errors here
            Swal.fire(
                'Error!',
                'Form submission failed: ' + errorThrown,
                'error'
            );
        }
    });
}

