var dashboard = (function ($, undefined) {

    var list = function(type) {
        $('#' + type + '_div').html('');
        $.ajax({
            url: '/' + type + "/index",
            cache: false,
            data: {
                'q': $('#q').val(),
            },
            dataType: 'json'
        })
        .done(function(response) {
            response.forEach(function (el) {
                // renderer for each type?
                //$('#' + type + '_div').append(render(type, el));
                // list-init for each type ??
            });
        })
        .fail(function(message) {
            utility.ajax_fail(message);
        });
        // show or make each one show separately ??
    };

    var add = function(type) {
        $.ajax({
            url: '/' + type + '/create',
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            $('.modal-body').html(modal_form.js_form_build(resp));
            $('.modal-header').html('<h5 class="modal-title">'+resp.title+'</h5>');
            $('.modal-header').append(modal_form.js_panel_control(resp.controls.head));

            $('.modal-footer').html(modal_form.js_panel_control(resp.controls.foot));



            utility.set_dynamic_button('#control-cancel', function () {
                $('#genericModal').modal('toggle');
                utility.reset_dynamic_button('#control-cancel');
                utility.reset_dynamic_button('#control-save');
                $('.modal-footer').html('');
                $('.modal-title').html('');
                $('.modal-header').html('');
            });
            utility.set_dynamic_button('#control-save', function () {
                    $('.modal-body form').submit();
                }
            );
            store(type);
            $('#genericModal').modal('toggle');

        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });

    };

    var store = function(type) {
        $('.modal-body form').on('submit', function (e) {
            e.preventDefault();
            if (true) {
                var data = $(this).serializeArray(); // convert form to array
                data.push({
                    name: "_token",
                    value: $("meta[name='csrf-token']").attr("content")
                });

                if ($(this).valid()) $.ajax({
                        type: "POST",
                        url: '/' + type,
                        data: $.param(data),
                        dataType: 'json'
                    })
                    .done(function (resp) {
                        utility.show_message(resp, function () {
                            list(type);
                            $('#genericModal').modal('toggle');
                        });
                    })
                    .fail(function (message) {
                        utility.ajax_fail(message);
                    });
            }
        }).validate(type.update_rules);
    };

    var edit = function(type, id) {

        $.ajax({
            url: '/' + type + '/' + id + '/edit',
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            $('.modal-body').html(modal_form.js_form_build(resp));
            $('.modal-header').html('<h5 class="modal-title">'+resp.title+'</h5>');
            $('.modal-header').append(modal_form.js_panel_control(resp.controls.head));
            $('.modal-footer').html(modal_form.js_panel_control(resp.controls.foot));

            utility.set_dynamic_button('.modal-body #control-cancel', function () {
                $('#genericModal').modal('toggle');
                utility.reset_dynamic_button('#control-cancel');
                utility.reset_dynamic_button('#control-save');
                $('.modal-footer').html('');
                $('.modal-title').html('');
                $('.modal-header').html('');
            });
            utility.set_dynamic_button('.modal-body  #control-save',
                function () {
                    $('.modal-body form').submit();
                }
            );
            update(type, id);
            $('#genericModal').modal('toggle');
        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });
    };

    var update = function(type, id) {
        $('.modal-body form').on('submit', function (e) {
            e.preventDefault();
            if (true) {
                var data = $(this).serializeArray(); // convert form to array
                data.push({
                    name: "_token",
                    value: $("meta[name='csrf-token']").attr("content")
                });

                if ($(this).valid()) $.ajax({
                        type: "PATCH",
                        url: '/' + type + '/' + id,
                        data: $.param(data),
                        dataType: 'json'
                    })
                    .done(function (resp) {
                        utility.show_message(resp, function () {
                            list(type);
                            $('#genericModal').modal('toggle');
                        });
                    })
                    .fail(function (message) {
                        utility.ajax_fail(message);
                    });
            }
        }).validate(type.update_rules);
    };

    var destroy = function(type, id) {
        if (confirm()) $.ajax({
            type: "DELETE",
            url: '/' + type + '/' + id,
            data: $.param(data),
            dataType: 'json'
        })
        .done(function (resp) {
            utility.show_message(resp, function () {
                list(type);
            });
        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });
    };

    return {
        list: list,
        add: add,
        edit: edit,
        destroy: destroy,
    };
})(jQuery);
