/**
 * Module responsible for unique toggling states
 */

(function() {
    $('body').on('click', '.btn-unique-toggle', function(e) {
        e.preventDefault();

        var $this = $(this),
            set = $this.data('set') || '',
            labelClassName = $this.data('label-class-name') || 'fa',
            activeStateClassName = $this.data('active-state-class-name') || 'fa-check',
            inactiveStateClassName = $this.data('inactive-state-class-name') || 'fa-close';
            activeStateColor = $this.data('active-state-color') || '#00a65a',
            inactiveStateColor = $this.data('inactive-state-color') || '#dd4b39';

        // $.ajax({
        //     url:  $this.data('url'),
        //     type: 'post',
        //     async: true,
        //     }).success(function (data) {

        //         if (data.status != 'ok')
        //             throw new Error("An error occured while trying to switch the status: " + data.message);

        //         $('[data-set="' + set + '"]')
        //             .find('.' + labelClassName)
        //             .removeClass(activeStateClassName)
        //             .addClass(inactiveStateClassName)
        //             .css({"color": inactiveStateColor});

        //         if(data.value) {
        //             $this.find('.' + labelClassName)
        //                 .removeClass(inactiveStateClassName)
        //                 .addClass(activeStateClassName)
        //                 .css({"color": activeStateColor});
        //         }
        // });


        $.ajax({
            url: $this.data("url"),
            type: "post",
            async: true,
            success: function(data) {
                if (data.status != "ok") throw new Error("An error occured while trying to switch the status: " + data.message);

                $('[data-set="' + set + '"]')
                    .find("." + labelClassName)
                    .removeClass(activeStateClassName)
                    .addClass(inactiveStateClassName)
                    .css({ color: inactiveStateColor });

                if (data.value) {
                    $this
                        .find("." + labelClassName)
                        .removeClass(inactiveStateClassName)
                        .addClass(activeStateClassName)
                        .css({ color: activeStateColor });
                }
            }
        });
    });
}());
