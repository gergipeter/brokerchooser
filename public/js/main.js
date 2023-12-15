$(document).ready(function() {
    // Attach a click event listener to the button
    $('.trackMouse').on('click', function(e) {
        e.preventDefault();
        
        var data = {
            action: 'click',
            variant_name: $(this).find('.variant_name').text(),
            test_name: $(this).find('.test_name').text(),
            _token: $('meta[name="csrf-token"]').attr('content'),
        };
        
        $.ajax({
            url: '/track-mouse',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response.message);
                var alertElement = $('<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
                $("#jumbotron_header").append(alertElement);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});