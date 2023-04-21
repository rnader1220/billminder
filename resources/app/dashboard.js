var dashboard = (function ($, undefined) {

    var initialize = function() {
        list('entry');
    };


    var list = function(dtype) {
        if(dtype == 'entry') $('#entry-div').slideUp(300, function() {$('#entry-div').html('');});
        $('#account-div').slideUp(300, function() {$('#account-div').html('');});
        $('#party-div').slideUp(300, function() {$('#party-div').html('');});
        $('#category-div').slideUp(300, function() {$('#category-div').html('');});
        setTimeout(function () {
            $.ajax({
                url: '/' + dtype,
                cache: false,
                data: {
                    'q': $('#q').val(),
                },
                dataType: 'json'
            })
            .done(function(response) {
                $('#' + dtype + '-div').html('');
                response.forEach(function (el) {
                    $('#' + dtype + '-div').append(library.drawElement(dtype, el));
                });
                $('#' + dtype + '-div').slideDown(300);
            })
            .fail(function(message) {
                utility.ajax_fail(message);
            });
        }, 600);

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


    var show = function(type, id) {

        $.ajax({
            url: '/' + type + '/' + id,
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
            utility.set_dynamic_button('#control-edit', function () {
                edit(type, id);
            });
            utility.set_dynamic_button('#control-cycle', function () {
                cycle(type, id);
            });
            utility.set_dynamic_button('#control-delete', function () {
                destroy(type, id);
            });


            $('#genericModal').modal('toggle');
        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });
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

            utility.set_dynamic_button('#control-cancel', function () {
                $('#genericModal').modal('toggle');
                utility.reset_dynamic_button('#control-cancel');
                utility.reset_dynamic_button('#control-save');
                $('.modal-footer').html('');
                $('.modal-title').html('');
                $('.modal-header').html('');
            });
            utility.set_dynamic_button('#control-save',
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


    var cycle = function(type, id) {
        var data = [{
            name: "_token",
            value: $("meta[name='csrf-token']").attr("content")
        }]; // convert form to array

        if (confirm()) $.ajax({
            type: "patch",
            url: '/' + type + '/' + id + '/cycle',
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


    var destroy = function(type, id) {
        var data = [{
            name: "_token",
            value: $("meta[name='csrf-token']").attr("content")
        }]; // convert form to array

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
        initialize: initialize,
        list: list,
        add: add,
        edit: edit,
        show: show,
        destroy: destroy,
    };
})(jQuery);
