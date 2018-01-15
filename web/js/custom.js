$.motherboardForm = {
    form: null,

    init: function () {
        var _this = this;

        _this.form = $('.motherboard-form');
        _this.initEvents();
    },

    initEvents: function () {
        var _this = this;

        _this.form.on('change', '#chipset', function (e) {
            _this.requestSockets($(this).val());
        });

        _this.form.on('click', '.repeatable-block .duplicate', function (e) {
            e.preventDefault();
            _this.cloneRepeatable($(this));
        });

        _this.form.on('click', '.repeatable-block .remove', function (e) {
            e.preventDefault();
            _this.removeRepeatable($(this));
        });
    },

    requestSockets: function (chipsetId) {
        var _this = this;

        $.ajax({
            url: ajaxGetSocketsByChipsetUrl + '/' + chipsetId,
            success: function (response) {
                _this.updateSockets(response.data);
            },
            error: function () {
                console.log('Can\'t get sockets for chipset with id ' + chipsetId);
            }
        });
    },

    updateSockets: function (data) {
        var _this = this;

        var options = '';

        for (var id in data) {
            options += "<option value='" + id + "'>" + data[id] + "</option>";
        }

        _this.form.find('#socket').html(options);
    },

    cloneRepeatable: function (button) {
        var repeatable = button.closest('.repeatable-block');
        repeatable.after(repeatable.clone());
    },

    removeRepeatable: function (button) {
        var block = button.closest('.form-group');
        
        if (block.find('.repeatable-block').length > 1) {
            var repeatable = button.closest('.repeatable-block');
            repeatable.remove();
        }

    }
};

/**
 * Init components
 */
$(document).ready(function () {
    $.motherboardForm.init();
});