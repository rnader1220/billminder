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
        $.ajax({
            url: '/' + type + '/create?income='+income,
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
                $('#genericModal').modal('toggle');
                edit(type, id);
            });
            utility.set_dynamic_button('#control-cycle', function () {
                cycle(type, id);
            });
            utility.set_dynamic_button('#control-delete', function () {
                destroy(type, id);
            });

            $('#genericModal form :input').prop('disabled', true);
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
                show(type, id);
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
        listentry: listentry,
        listaccount: listaccount,
        listcategory: listcategory,
        add: add,
        edit: edit,
        show: show,
        destroy: destroy,
    };
})(jQuery);

var utility = (function ($, undefined) {
    var initialize = function () {
        //var dark_toggle = $("#cb-dark-theme");

        var prefersDarkScheme = window.matchMedia(
            "(prefers-color-scheme: dark)"
        );
        if (prefersDarkScheme.matches) {
            $("body").addClass("dark-theme");
            //$(dark_toggle).prop('checked', true);
        } else {
            $("body").removeClass("dark-theme");
            //$(dark_toggle).prop('checked', false);
        }

        var currentTheme = localStorage.getItem("theme");
        if (currentTheme == "dark") {
            $("body").addClass("dark-theme");
            //$(dark_toggle).prop('checked', true);
        }

        /* $(dark_toggle).on("change", function () {
            $("body").toggleClass("dark-theme");
            var theme = "light";
            if ($("body").containsClass("dark-theme")) {
                theme = "dark";
            }
            localStorage.setItem("theme", theme);
        }); */
    };


    /**
     * @param resp          Information about the object.
     * @param resp.msg   html alert message
     * @param resp.success   true/false on success.
     * @param resp.id   id of affected object.
     * @param onSuccess callback if success = true;
     */
    var show_message = function (resp, onSuccess) {
        if (resp.success) {
            show_pass_message(resp.msg);
            if (resp.username) $("#username").html(resp.username);
            if (onSuccess !== undefined) onSuccess(resp);
        } else {
            show_fail_message(resp.msg);
        }
    };
    var show_pass_message = function (msg) {
        d = document.createElement("div");
        $(d)
            .html(msg)
            .addClass("message-popup")
            .addClass("animated flipInX")
            .appendTo($("#message"))
            .click(function () {
                $(this).remove();
            })
            .delay(2500)
            .queue(function () {
                $(this).remove();
            });
    };

    var show_fail_message = function (msg) {
        d = document.createElement("div");
        $(d)
            .html(msg)
            .addClass("message-popup")
            .addClass("animated flipInX")
            .appendTo($("#message"))
            .click(function () {
                $(this).remove();
            });
    };

    var show_help = function (msg) {
        $(".overlay").addClass("active");
        d = document.createElement("div");
        $(d)
            .html(msg)
            .addClass("help-popup")
            .addClass("animated flipInX")
            .appendTo($("#message"))
            .click(function () {
                $(this).remove();
                $(".overlay").removeClass("active");
            });
    };

    var show_tab = function (selected, animate) {
        $(".active").removeClass("active");
        if (animate) {
            $("[id^='tabdiv_']").slideUp(300);
            $("#tabdiv_" + selected).slideDown(300);
        } else {
            $("[id^='tabdiv_']").hide();
            $("#tabdiv_" + selected).show();
        }
        $("#tab_" + selected).addClass("active");
    };

    var display_name = function () {
        $.ajax({
            type: "GET",
            url: "profile/username",
            data: null,
            success: function (msg) {
                $("#username").html(msg);
            },
        });
    };

    var pre_load = function () {
        $(window).off("resize");
        $("#dashboard").slideUp(300);
        $(".titleFixed").fadeOut(100, function () {
            $(".titleFixed").html("");
        });
        $("#content").fadeOut(100, function () {
            $("#content").html("");
        });
        $("#dialog").fadeOut(100, function () {
            $("#dialog").html("");
        });
        $("#details").fadeOut(100, function () {
            $("#details").html("");
        });

        $(".page-wrapper").removeClass("toggled");
        $(".overlay").removeClass("active");
        feature_chatrooms.set_config({ current_chatroom_id: null });
    };

    var show_dash = function () {
        pre_load();
        setTimeout(function () {
            $("#dashboard").slideDown(300);
        }, 300);
        feature_chatrooms.set_config({ current_chatroom_id: null });
    };

    var set_dynamic_button = function (btn_name, callback) {
        $(btn_name).show().off("click").on("click", callback);
    };

    var reset_dynamic_button = function (btn_name) {
        $(btn_name).hide().off("click");
    };

    var ajax_fail = function (msgobj) {
        var status = msgobj.status;
        if (status == 401 || status == 419) {
            document.location = "/login";
        } else {
            show_fail_message(
                "<div class='alert alert-danger message-element' style='text-align:center; width:100%'>" +
                    "<strong>Something Went Wrong!</strong><br>The requested action failed." +
                    "<br>Contact technical support.<br>" +
                    "<button class='button-error alert-danger'><span class='far fa-times'></span> Click to Close</button>" +
                    "</div>"
            );
        }
    };

    var action_fail = function (msgobj) {
        ajax_fail(msgobj);
    };

    var logout = function () {
        $.ajax({
            type: "POST",
            url: "/logout",
            data: { _token: $("meta[name='csrf-token']").attr("content") },
        })
            .done(function (msg) {
                document.location = "/login";
            })
            .fail(function (message) {
                utility.ajax_fail(message);
            });
    };

    var show_subscriber = function (subscriber_id) {
        profile_public.set_config({ subscriber_id: subscriber_id });
        profile_public.load();

        //alert('subscriber '+ subscriber_id + ' profile modal popup here');
    };

    return {
        show_subscriber: show_subscriber,
        show_message: show_message,
        initialize: initialize,
        display_name: display_name,
        show_tab: show_tab,
        pre_load: pre_load,
        show_dash: show_dash,
        ajax_fail: ajax_fail,
        action_fail: action_fail,
        set_dynamic_button: set_dynamic_button,
        reset_dynamic_button: reset_dynamic_button,
        show_help: show_help,
        logout: logout,
    };
})(jQuery);

/*
var dashboard = (function($, undefined) {


    var reload = function() {
        var sel = $('#mm_current_account').val();

        $('#content').fadeOut(300);
        $('#dialog').fadeOut(300);

        var endpoint = "console/dashboard";
        if(sel == 0)
            endpoint = "console/dashboard";
        $.ajax({
            url: endpoint,
            cache: false
        })
        .done(function(html) {
            $('#dashboard').html(html);
//            init();
            setTimeout(function () {
                $('#dashboard').fadeIn(300);
            }, 300);
        })
        .fail(function(message) {
            utility.ajax_fail(message);
        });

    };

   var set_module = function(selected_module) {
        $.ajax({
            type: "POST",
            url: 'console/profile/setmodule',
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "module_id": selected_module
            },
            cache: false
        })
        .done(function(html) {
            mainmenu();
        })
        .fail(function(message) {
            utility.ajax_fail(message);
        });
    };

    var init = function() {
        var sel = $('#mm_current_account').val();

        init_profile();
        init_switchers();

        init_admin();
        init_console();
        init_features();
    };

    var init_console = function() {

        $("#profile-list #profile-account").off('click').on('click', accounts.myload);

    };

    var set_account = function(selected_account) {
        $.ajax({
            type: "POST",
            url: 'console/profile/setaccount',
            data: {
                "_token": $("meta[name='csrf-token']").attr("content"),
                "account_id": selected_account
            },

            cache: false
        })
        .done(function(html) {
            mainmenu();
        })
        .fail(function(message) {
            utility.ajax_fail(message);
        });
    };

    var init_admin = function() {

        $("#admin-list #categories-item").off('click').on('click', function () {
            categories.set_config({
                arguments: '?admin=1',
            });
            categories.load();
        });

        $("#admin-list #admins-item").off('click').on('click', function () {
            users.set_config({
                parent_id: null,
                caller_name: 'administrators',
                target_div: '',
                endpoint: 'admin/users'
            });
            users.load();
        });

        $("#admin-list #subscribers-item").off('click').on('click', function () {
            users.set_config({
                parent_id: null,
                caller_name: 'subscribers',
                target_div: '',
                endpoint: 'admin/users',
            });
            users.load();
        });

        $("#admin-list #accounts-item").off('click').on('click', accounts.load);

        $("#admin-list #packages-item").off('click').on('click', packages.load);

        $("#admin-list #referrals-item").off('click').on('click', referrals.load);

        $("#admin-list #inquiries-item").off('click').on('click', inquiries.load);

        $("#cms-list #pages-item").off('click').on('click', cms_pages.load);
        $("#cms-list #media-item").off('click').on('click', cms_media.load);

        $("#cms-list #menus-list #menu-top-item").off('click').on('click', function () {
            cms_menus.set_config({
                title: 'Top Navigation Menu',
                arguments: '?location=top_menu',
            });
            cms_menus.load();
        });

        $("#cms-list #menus-list #menu-cart-item").off('click').on('click', function () {
            cms_menus.set_config({
                title: 'Cart Menu',
                arguments: '?location=cart_menu',
            });
            cms_menus.load();
        });

        $("#cms-list #menus-list #menu-promo-item").off('click').on('click', function () {
            cms_menus.set_config({
                title: 'Promo Menu',
                arguments: '?location=promo_menu',
            });
            cms_menus.load();
        });

        $("#cms-list #menus-list #menu-foot-item").off('click').on('click', function () {
            cms_menus.set_config({
                title: 'Footer Menu',
                arguments: '?location=foot_menu',
            });
            cms_menus.load();
        });

        $("#cms-list #menus-list #menu-bottom-item").off('click').on('click', function () {
            cms_menus.set_config({
                title: 'Bottom Menu',
                arguments: '?location=bottom_menu',
            });
            cms_menus.load();
        });

        $("#cms-list #menus-list #menu-social-item").off('click').on('click', function () {
            cms_menus.set_config({
                title: 'Social Menu',
                arguments: '?location=social_menu',
            });
            cms_menus.load();
        });

        $("#fadmin-list #news-item").off('click').on('click', admin_newsfeeds.load);
        $("#fadmin-list #chat-item").off('click').on('click', admin_chatrooms.load);
        $("#fadmin-list #journal-item").off('click').on('click', admin_journals.load);

    };

    var init_switchers = function() {

        // change accounts
        $('#accounts-list a').off('click').on('click', function() {
            set_account($(this).data('account'));
        });

        // change modules
        $('#modules-list a').off('click').on('click', function() {
            set_module($(this).data('module'));
        });

        $('#categories-list a').off('click').on('click', function() {
            categories.show_category($(this).data('category'));
        });

        $('#dashboard-item').off('click').on('click', load);
    };
    var init_features = function() {
        $("#feature-list #chat-item").off('click').on('click', feature_chatrooms.load);
        $("#feature-list #news-item").off('click').on('click', feature_newsfeeds.load);
        $("#feature-list #journal-item").off('click').on('click', feature_journals.load);

        $("#feature-list #msgs-item").off('click').on('click', function () {
            feature_messages.set_config({
                arguments: '',
            });
            feature_messages.load();
        });
    };


    var init_profile = function() {

        $("#profile-list #profile-item").off('click').on('click', profile.load);
        $("#profile-list #account-item").off('click').on('click', profile_account.load);
        $("#profile-list #connections-item").off('click').on('click', profile_connections.load);
        $("#profile-list #referrals-item").off('click').on('click', profile_referrals.load);

        // improve/standardize logout here
        //$("#profile-list #password-item").off('click').on('click', profile.password_load);
        //$("#profile-list #twofactor-item").off('click').on('click', profile.twofactor_load);

    };

    return {
        load: load,
        set_account: set_account,
        set_module: set_module,
        mainmenu: mainmenu
    };
})(jQuery);
*/

var library = (function ($, undefined) {

    var drawEntry = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row entry-"+ el.status+"' onclick=\"dashboard.show('entry', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-xs-2 col-md-1 centered'>";
        html += ""+entryIcon(el.status);
        html += "</div>";
        html += "<div class='col-xs-4 col-md-2' style='text-align:right'>";
        html += dateFormat(el.next_due_date);
        html += "</div>";

        html += "<div class='col-xs-4 col-md-2' style='text-align:right'>";
        html += el.amount;
        html += "</div>";

        html += "<div class='col-xs-6 col-md-4' style='text-align:left'>";
        html += el.name;
        html += "</div>";
        html += "<div class='col-xs-6 col-md-3' style='text-align:left'>";
        html += el.category;
        html += "</div>";

        html += '</div></div></div>';
        return html;
    };

    var entryIcon = function(status) {
        switch (status) {
            case 'income': return '<i class="fa-solid fa-money-bill-wave"></i>';
            case 'late': return '<i class="fa-solid fa-triangle-exclamation"></i>';
            case 'due': return '<i class="fa-solid fa-alarm-clock"></i>';
            case 'expense': return '<i class="fa-solid fa-file-invoice-dollar"></i>';
        }
    };

    var drawAccount = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row account' onclick=\"dashboard.show('account', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12 centered'>";
        html += el.name;
        html += "</div>";
        html += '</div>';
        html += '</div></div></div>';
        return html;
    };

    var drawCategory = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row category' onclick=\"dashboard.show('category', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-md-12 centered'>";
        html += el.label;
        html += "</div>";
        html += '</div>';
        html += '</div></div></div>';
        return html;
    };

    var dateFormat = function(value) {
        var dateval = new Date(value);
        return dateval.toDateString().substring(4,10);
    };

    var drawButton = function(attr) {
        htmlString = "<button title='" + attr.title + "' type='button' ";
        htmlString += "class='btn btn-primary btn-utility' id='" + attr.btn_id + "'>";
        if (attr.hasOwnProperty('icon')) {
            htmlString += "<span class='" + attr.icon + "'></span>";
        }
        if (attr.hasOwnProperty('label')) {
            htmlString += "<span>&nbsp;" + attr.label + "</span>";
        }
        htmlString += '</button>';
    };

    var drawElement = function(type, el) {
        switch(type) {
            case('entry'):
                return drawEntry(el);
            case('account'):
                return drawAccount(el);
            case('party'):
                return drawParty(el);
            case('category'):
                return drawCategory(el);
        }
        return '';
    };


    return {
        drawElement: drawElement,
        drawButton: drawButton,
    };
})(jQuery);


// this version of form.js is optimized for modal, not for card.
// find and remove all mentions of card

var modal_form = (function ($, undefined) {

    var library = {
        input_checkbox: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label><br>";
            }
            htmlString += "<label class='cb3switch' ><input type='checkbox' name='" + attr.datapoint + "' id='is_" + attr.datapoint + "' ";
            if (attr.hasOwnProperty('cbvalue')) {
                htmlString += " value='" + attr.cbvalue + "' ";
            } else {
                htmlString += " value='1' ";
            }
            if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                htmlString += " disabled='disabled' ";
            }

            if (attr.hasOwnProperty('checked') || attr.value == 1 || attr.value) {
                htmlString += " checked ";
            } else if (attr.hasOwnProperty('value') && (attr.value == 1 || attr.value == attr.cbvalue)) {
                htmlString += " checked ";
            }
            htmlString += "><span class='cb3slider' for='is_" + attr.datapoint + "'></span></label>";
            htmlString += "</div></div>";
            return htmlString;
        },

        input_date: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label>";
            }
            htmlString += "<div class='input-group'><input class='form-control' type='date' " +
                "id='" + attr.datapoint + "' name='" + attr.datapoint + "' ";
            if (attr.hasOwnProperty('placeholder')) {
                htmlString += " placeholder='" + attr.placeholder + "'";
            }
            if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                htmlString += " disabled='disabled' ";
            }
            if (attr.hasOwnProperty('value')) {
                htmlString += " value='" + attr.value + "' ";
            }
            htmlString += " ></div></div></div>";
            return htmlString;
        },

        input_hidden: function (attr) {
            htmlString = "<input type='hidden' " +
                "id='" + attr.datapoint + "' name='" + attr.datapoint + "' ";
            if (attr.hasOwnProperty('value')) {
                htmlString += " value='" + attr.value + "' ";
            }
            htmlString += " >";
            return htmlString;
        },

        input_radio: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label>";
            }
            if (attr.hasOwnProperty('vertical')) {
                htmlString += "<div class='btn-group-vertical btn-group-toggle' ";
            } else {
                htmlString += "<div class='btn-group-toggle' ";

            }
            htmlString += "style='width:100%; text-align:center' data-toggle='buttons'>";

            attr.list.forEach(function (element) {
                htmlString += "<label class='btn btn-radio' for='" + attr.datapoint + "-" + element.value + "' >" +
                    "<input type='radio' id='" + attr.datapoint + "-" + element.value + "' ";
                if (attr.hasOwnProperty('value') && attr.value == element.value) {
                    htmlString += " checked ";
                }
                if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                    htmlString += " disabled='disabled' ";
                }
                htmlString += "name='" + attr.datapoint + "' value='" + element.value + "'> " +
                    element.label + "</label>";
            });
            htmlString += "</div></div></div>";
            return htmlString;
        },

        input_text: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label>";
            }

            htmlString += "<div class='input-group'><input class='form-control' type='text' " +
                "id='" + attr.datapoint + "' name='" + attr.datapoint + "' ";

            if (attr.hasOwnProperty('placeholder')) {
                htmlString += " placeholder='" + attr.placeholder + "'";
            }

            if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                htmlString += " disabled='disabled' ";
            }

            if (attr.hasOwnProperty('value')) {
                htmlString += " value='" + attr.value + "' ";
            }

            if (attr.hasOwnProperty('numeric')) {
                htmlString += " style='text-align:right' ";
            }

            htmlString += " ></div></div></div>";
            return htmlString;
        },

        input_password: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label>";
            }
            htmlString += "<div class='input-group'><input class='form-control' type='password' " +
                "id='" + attr.datapoint + "' name='" + attr.datapoint + "' ";
            if (attr.hasOwnProperty('placeholder')) {
                htmlString += " placeholder='" + attr.placeholder + "'";
            }
            if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                htmlString += " disabled='disabled' ";
            }
            if (attr.hasOwnProperty('value')) {
                htmlString += " value='" + attr.value + "' ";
            }
            if (attr.hasOwnProperty('numeric')) {
                htmlString += " style='text-align:right' ";
            }
            htmlString += " ></div></div></div>";
            return htmlString;
        },

        download: function (attr) {
            return "<div class='" + attr.grid_class + "'><a href='" + attr.value + "' target='_new' " +
            "style='max-width: inherit; border: solid 1px silver; padding: 12px; margin-top: 20px;'> VIEW FILE</a></div>";
        },


        image: function (attr) {
            return "<div class='" + attr.grid_class + "'><img src='" + attr.value + "' " +
            "style='max-width: inherit; border: solid 1px silver; padding: 12px; margin-top: 20px;' / ></div>";
        },

        audio: function (attr) {
            return "<audio class='" + attr.grid_class + "' controls><source src='" + attr.value + "' " +
            "style='max-width: inherit; border: solid 1px silver; padding: 12px; margin-top: 20px;' / ></audio>";
        },

        video: function (attr) {
            return "<video class='" + attr.grid_class + "' controls><source src='" + attr.value + "' " +
            "style='max-width: inherit; border: solid 1px silver; padding: 12px; margin-top: 20px;' / ></video>";
        },


        select: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label>";
            }

            htmlString += "<select data-live-search='true' class='form-control selectpicker'  id='sel_" + attr.datapoint + "' ";

            if (attr.hasOwnProperty('multiple') && attr.multiple == true) {
                htmlString += "  name='" + attr.datapoint + "[]' multiple='multiple' ";
            } else {
                htmlString += "  name='" + attr.datapoint + "'";
            }

            if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                htmlString += " disabled='disabled' ";
            }
            htmlString += ">";

            if(attr.hasOwnProperty('allow_null')) {
                htmlString += "<option ";
                if (!attr.hasOwnProperty('value') || attr.value == '-99') {
                    htmlString += "selected ";
                }
                htmlString += "value = '-99'>";
                if (attr.hasOwnProperty('placeholder') ) {
                    htmlString += "- " + attr.placeholder + " -";
                } else {
                    htmlString += "- not selected -";
                }
                htmlString += "</option>\n";

            }

            attr.list.forEach(function (element) {
                htmlString += "<option ";
                if (attr.hasOwnProperty('value') && attr.value == element.value) {
                    htmlString += " selected ";
                }
                if (element.hasOwnProperty('disabled') && element.disabled == true) {
                    htmlString += " disabled='disabled' ";
                }
                htmlString += "value='" + element.value + "'>" + element.label + "</option>\n";
            });

            htmlString += "</select>";
            htmlString += "</div></div>";
            return htmlString;
        },

        textarea: function (attr) {
            htmlString = "<div class='" + attr.grid_class + "'  id='" + attr.datapoint + "_div'>" +
                "<div class='form-group'>";
            if (attr.hasOwnProperty('label')) {
                htmlString += "<label for='" + attr.datapoint + "' class='control-label'>" + attr.label + "</label>";
            }
            htmlString += "<textarea class='form-control' ";

            if (attr.hasOwnProperty('disabled') && attr.disabled == true) {
                htmlString += " disabled='disabled' ";
            }
            if (attr.hasOwnProperty('rows')) {
                htmlString += " rows='" + attr.rows + "' ";
            }
            if (attr.hasOwnProperty('placeholder')) {
                htmlString += " placeholder='" + attr.placeholder + "' ";
            }
            htmlString += " id='" + attr.datapoint + "' name='" + attr.datapoint + "' >";
            if (attr.hasOwnProperty('value')) {
                htmlString += attr.value;
            }
            htmlString += "</textarea>";
            htmlString += "</div></div>";
            return htmlString;
        },

        spacer: function (attr) {
            return "<div class='" + attr.grid_class + "'>&nbsp;</div>";
        },

        static_text: function (attr) {
            return "<div class='" + attr.grid_class + "'><p>" + attr.text + "</p></div>";
        },

        divider: function (attr) {
            return "<div class='" + attr.grid_class + "'><hr></div>";
        },

        button_control: function (attr) {
            htmlString = "<button title='" + attr.title + "' style='display: none' type='button' " +
                "class='btn " + attr.class + " btn-control' id='" + attr.id + "'>";
            if (attr.hasOwnProperty('icon')) {
                htmlString += "<span class='" + attr.icon + "'></span>";
            }
            if (attr.hasOwnProperty('caption')) {
                htmlString += "<span>&nbsp;" + attr.caption + "</span>";
            }
            htmlString += "</button>";
            return htmlString;
        },



        button_utility: function (attr) {
            htmlString = "<button title='" + attr.title + "' type='button' ";

            if (attr.hasOwnProperty('disabled')) {
                htmlString += 'disabled';
            }
            htmlString += "class='btn " + attr.button_class + " btn-utility' id='" + attr.id + "'>";

            if (attr.hasOwnProperty('icon')) {
                htmlString += "<span class='" + attr.icon + "'></span>";
            }
            if (attr.hasOwnProperty('label')) {
                htmlString += "<span>&nbsp;" + attr.label + "</span>";
            }
            htmlString += '</button>';
            if (attr.hasOwnProperty('grid_class')) {
                htmlString = "<div class='" + attr.grid_class + "'>" + htmlString + "</div>";
            }
            return htmlString;
        }

    };

    var panel_control = function (list) {
        htmlString = '';
        htmlString += "<div class='modal-control-panel'>";
        htmlString += button_control(list);
        htmlString += "</div>";
        return htmlString;
    };

    var button_control = function (list) {
        htmlString = '';
        htmlString += "<div class='btn-group'>";
        list.forEach(function (element) {
            htmlString += library.button_control(element);
        });
        htmlString += "</div>";
        return htmlString;
    };

    var panel_utility = function (list) {
        htmlString = '';
        htmlString += "<div class='modal-utility-panel'>";
        htmlString += button_utility(list);
        htmlString += "</div class='modal-utility-panel'>";
        return htmlString;
    };

    var button_utility = function (list) {
        htmlString = '';
        list.forEach(function (element) {
            htmlString += library.button_utility(element);
        });
        return htmlString;
    };

    var table_build = function (content) {


        /* card body -- table here */
        htmlString += "<div class='index-table col-lg-12'>";
        htmlString += "<table id='" + content.table_name + "' class='hover display-table' style='width:100%'>";
        htmlString += "<tbody></tbody><tfoot></tfoot></table></div>";

        return htmlString;
    };

    var form_element = function(element) {
        return library[element.type](element.parameters);
    };

    var form_build = function (content) {
        htmlString = "<form id='" + content.form_name + "_form' class='form' data-mode='" + content.mode + "' ";
        if (content.hasOwnProperty('upload_form')) {
            htmlString += "enctype='multipart/form-data'> ";
        } else {
            htmlString += "accept-charset='UTF-8'> ";
        }
        if (content.hasOwnProperty('csrf')) { // may not do this at all. but rely on client-side csrf meta value for protection.
            htmlString += "<input type='hidden' name='_token' value='" + attr.csrf + "'>";
        }
        htmlString += "<div class='edit-body container'>";
        content.form.forEach(function (row) {
            htmlString += "<div class='row'>";
            row.forEach(function (element, content) {
                // untested: watch for action working properly
                if(content.mode == 'create') {
                    if(typeof(element.parameters.create != 'undefined') && element.parameters.create === false ) {
                        element.parameters.disabled = true;
                    }
                } else if(content.mode == 'edit') {
                    if(typeof(element.parameters.edit != 'undefined') && element.parameters.edit === false ) {
                        element.parameters.disabled = true;
                    }
                }
                htmlString += form_element(element);
            });
            htmlString += "</div>";
        });
        htmlString += "</div>";
        htmlString += "</form>";

        return htmlString;
    };

    return {
        js_form_element: form_element,
        js_panel_control: panel_control,
        js_button_control: button_control,
        js_table_build: table_build,
        js_form_build: form_build,
    };
})(jQuery);
