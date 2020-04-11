var congrat = document.getElementsByName('submit_btn');

congrat.on('click', function(){
    Swal.fire({
        type: 'success',
        title: 'Your registration is done successfully..!',
        text: 'Ok'
    })
})