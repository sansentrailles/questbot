$(function() {
    $('[data-action="delete"').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Вы уверены?')) return;

        var $this = $(this);

        $.ajax({
            url: $this.data('url'),
            type: 'post',
            async: true,
            success: function (data) {
                if (data.status != 'ok')
                    throw new Error("An error occured while trying to perform the action");

                $this.closest('[data-removable]').remove();
            }
        });
    });
});