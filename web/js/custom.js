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
    }
};

/**
 * Init components
 */
$(document).ready(function () {
    $.motherboardForm.init();
});