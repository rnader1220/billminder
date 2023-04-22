
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
