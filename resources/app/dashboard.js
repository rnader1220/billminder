var dashboard = (function ($, undefined) {


    var initialize = function() {
        listentry();
    };

    var listentry = function() {

        if($('#account-div').data('open') == true) {
            $('#account-div').slideUp(300, function() {
                $('#account-div').html('');
                $('#account-div').data('open', false);
            });
        }

        if($('#category-div').data('open') == true) {
            $('#category-div').slideUp(300, function() {
                $('#category-div').html('');
                $('#category-div').data('open', false);
            });
        }
        list('entry');
    };

    var listaccount = function() {
        if($('#account-div').data('open') == true) {
            $('#account-div').slideUp(300, function() {
                $('#account-div').html('').data('open', false);
            });
        } else {
            if($('#category-div').data('open') == true) {
                $('#category-div').slideUp(300, function() {
                    $('#category-div').html('').data('open', false);
                });
            }
            list('account');
        }
    };

    var listcategory = function() {
        if($('#category-div').data('open') == true) {
            $('#category-div').slideUp(300, function() {
                $('#category-div').html('').data('open', false);
            });
        } else {
            if($('#account-div').data('open') == true) {
                $('#account-div').slideUp(300, function() {
                    $('#account-div').html('').data('open', false);
                });
            }
            list('category');
        }
    };

    var list = function(dtype) {
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
            $('#' + dtype + '-div').data('open', true);
            $('#' + dtype + '-div').slideDown(300);
        })
        .fail(function(message) {
            utility.ajax_fail(message);
        });
    };

    var add = function(type, income) {
        url = '/' + type + '/create';
        if(typeof(income) != 'undefined')
            url += '?income='+income;
        $.ajax({
            url: url,
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            showModalForm(type, null, resp,
                function() {},
                function() {store(type);}
                );
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
                            $('#genericModal').modal('hide'); //'toggle'
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
            showModalForm(type, id, resp,
                function() {},
                function() {}
                );
        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });
    };

    var showModalForm = function(type, id, resp, cb_cancel, cb_submit) {
        $('.modal-body').html(modal_form.js_form_build(resp));
        $('.modal-header').html('<h5 class="modal-title">'+resp.title+'</h5>');
        $('.modal-header').append(modal_form.js_panel_control(resp.controls.head));
        $('.modal-footer').html('');
        if(typeof(resp.actions) == 'object') {
            $('.modal-footer').append(modal_form.js_panel_action(resp.actions));
        }
        $('.modal-footer').append(modal_form.js_panel_control(resp.controls.foot));
        $('#genericModal').modal('show'); //'toggle'

        utility.set_dynamic_button('#control-cancel', function () {
            $('#genericModal').modal('hide'); //'toggle'
            utility.reset_dynamic_button('#control-cancel');
            utility.reset_dynamic_button('#control-save');
            $('.modal-footer').html('');
            $('.modal-title').html('');
            $('.modal-header').html('');
            if(typeof(cb_cancel) == 'function') cb_cancel();
        });

        utility.set_dynamic_button('.btn-action', function() {
            actionGet(this, type, id);
        });

        utility.set_dynamic_button('#control-save', function () {
            $('.modal-body form').submit();
        });

        utility.set_dynamic_button('#control-edit', function () {
            //$('#genericModal').modal('toggle');
            edit(type, id);
        });

        utility.set_dynamic_button('#control-delete', function () {
            destroy(type, id);
        });

        if(typeof(cb_submit) == 'function') cb_submit();
    };

    var actionGet = function(self, type, id) {
        action = $(self).data('action');
        $.ajax({
            url: '/' + type + '/' + id + '/action?action=' + action ,
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            //$('#genericModal').modal('toggle');
            switch(resp.action) {
                case 'show':  showModalForm(type, null, resp,
                    function() {},
                    function() {}
                ); break;
                case 'create':
                    showModalForm(type, null, resp,
                        function() {},
                        function() {actionPost(action, type, id);}
                    );
                    break;
                case 'edit':  showModalForm(type, null, resp,
                    function() {},
                    function() {actionPatch(action, type, id);}
                ); break;
                default: utility.show_message(resp, function () {
                    list(type);
                }); break;
            }

        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });
    };

    var actionPost = function(action, type, id) {
        $('.modal-body form').on('submit', function (e) {

            e.preventDefault();
            var data = $('form').serializeArray(); // convert form to array
                    data.push({
                        name: "_token",
                        value: $("meta[name='csrf-token']").attr("content")
                    });

            $.ajax({
                url: '/' + type + '/' + id + '/action?action=' + action ,
                cache: false,
                type: "POST",
                data: $.param(data),
                dataType: 'json'
            })
            .done(function (resp) {
                $('#genericModal').modal('hide'); //'toggle
                utility.show_message(resp, function () {
                    list(type);
                });

            })
            .fail(function (message) {
                utility.ajax_fail(message);
            });
        });
    };

    var actionPatch = function(action, type, id) {
        $('.modal-body form').on('submit', function (e) {
            e.preventDefault();
            var data = $('form').serializeArray(); // convert form to array
            data.push({
                name: "_token",
                value: $("meta[name='csrf-token']").attr("content")
            });
            $.ajax({
                url: '/' + type + '/' + id + '/action?action=' + action,
                cache: false,
                type: "PATCH",
                data: $.param(data),
                dataType: 'json'
            })
            .done(function (resp) {
                //$('#genericModal').modal('toggle');
                switch(resp.action) {
                    case 'show':  show(type, id); break;
                    case 'create':
                        showModalForm(type, null, resp,
                            function() {},
                            function() {actionPost(type);}
                        );
                        break;
                    case 'edit':  edit(type, id); break;
                    default: utility.show_message(resp, function () {
                        list(type);
                        $('#genericModal').modal('hide');
                    }); break;
                }

            })
            .fail(function (message) {
                utility.ajax_fail(message);
            });
        });
    };

    var edit = function(type, id) {
        $.ajax({
            url: '/' + type + '/' + id + '/edit',
            cache: false,
            dataType: 'json'
        })
        .done(function (resp) {
            showModalForm(type, id, resp,
                function() {show(type, id);},
                function() {update(type, id);}
            );
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
                            if(type == 'category') {
                                list('entry');
                            }
                            $('#genericModal').modal('hide'); //'toggle'
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
                $('#genericModal').modal('hide'); //'toggle'
            });
        })
        .fail(function (message) {
            utility.ajax_fail(message);
        });
    };

    return {
        initialize: initialize,
        listentry: listentry,
        listaccount: listaccount,
        listcategory: listcategory,
        add: add,
        edit: edit,
        show: show,
        destroy: destroy,
    };
})(jQuery);
