/**
 * Module responsible for toggling states
 */

(function() {
    $('body').on('click', '.btn-toggle', function(e) {
        e.preventDefault();

        var $this = $(this),
            labelClassName = $this.data('label-class-name') || 'fa',
            activeStateClassName = $this.data('active-state-class-name') || 'fa-check',
            inactiveStateClassName = $this.data('inactive-state-class-name') || 'fa-close';
            activeStateColor = $this.data('active-state-color') || '#00a65a',
            inactiveStateColor = $this.data('inactive-state-color') || '#dd4b39';

        $.ajax({
            url: $this.data('url'),
            type: 'post',
            async: true,
            success: function (data) {
                if (data.status != 'ok')
                    throw new Error("An error occured while trying to switch the status");

                var newClassName = data.value ? activeStateClassName : inactiveStateClassName,
                    newColor = data.value ? activeStateColor : inactiveStateColor;

                $this.find('.' + labelClassName)
                    .removeClass(activeStateClassName)
                    .removeClass(inactiveStateClassName)
                    .addClass(newClassName)
                    .css({
                        "color": newColor
                    });
            }
        });
    });
}());
