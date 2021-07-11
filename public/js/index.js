$('.cards').on('change', 'input[type=checkbox]', function(){
    var checked = (this.checked ? "1" : "0");
    $.ajax({
        url: '/task/changeStatus/'+$(this).data("id"),
        type: 'POST',
        data: {'status': checked},
    });
});
