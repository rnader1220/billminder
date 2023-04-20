var dashboard = (function ($, undefined) {

    var list = function(type) {
        $(targetdiv[type]).html('');
        $.ajax({
            url: endpoint[type] + "/list",
            cache: false,
            data: {
                'q': $('#q').val(),
            },
            dataType: 'json'
        })
        .done(function(response) {
            response.forEach(function (el) {
                // renderer for each type?
                $(targetdiv[type]).append(render(type, el));
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
            url: endpoint[type] + '/create',
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            resp_string = form.js_form_build(resp);
            $('.modal-body').html(resp_string);

            utility.set_dynamic_button('.modal-body #control-cancel', function () {
                // empty, destroy7 modalreview(self);
            });
            utility.set_dynamic_button('.modal-body  #control-save',
                function () {
                    $('.modal-body form').submit();
                }
            );
            store(type, id);
            //show modal dialog
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
                        url: endpoint[type],
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
            }
        }).validate(type.update_rules);
    };

    var edit = function(type, id) {

        $.ajax({
            url: endpoint[type] + '/' + id + '/edit',
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            resp_string = form.js_form_build(resp);
            $('.modal-body').html(resp_string);

            utility.set_dynamic_button('.modal-body #control-cancel', function () {
                // empty, destroy7 modalreview(self);
            });
            utility.set_dynamic_button('.modal-body  #control-save',
                function () {
                    $('.modal-body form').submit();
                }
            );
            update(type, id);
            //show modal dialog
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
                        url: endpoint[type] + '/' + id,
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
            }
        }).validate(type.update_rules);
    };

    var destroy = function(type, id) {
        if (confirm()) $.ajax({
            type: "DELETE",
            url: endpoint[type] + '/' + id,
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

    var endpoint = {
        'billist': '\journal',
        'party': '\payee',
        'account': '\account',
    };


    return {
        list: list,
        add: add,
        edit: edit,
        destroy: destroy,
    };
})(jQuery);
