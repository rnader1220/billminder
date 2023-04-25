var library = (function ($, undefined) {

    var drawEntry = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row entry-"+ el.status+"' onclick=\"dashboard.show('entry', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-2 col-md-1' style='text-align:left'>";
        html += ""+entryIcon(el.status);
        html += "</div>";
        html += "<div class='col-4 col-md-2' style='text-align:right'>";
        html += dateFormat(el.next_due_date);
        html += "</div>";

        html += "<div class='col-6 col-md-2' style='text-align:right'>";
        html += el.amount;
        html += "</div>";

        html += "<div class='col-6 col-md-4' style='text-align:left'>";
        html += el.name;
        html += "</div>";
        html += "<div class='col-6 col-md-3' style='text-align:left'>";
        html += el.category;
        html += "</div>";

        html += '</div></div></div>';
        return html;
    };

    var entryIcon = function(status) {
        switch (status) {
            case 'income': return '<i class="fa-solid fa-money-bill-wave fa-fw"></i>';
            case 'late': return '<i class="fa-solid fa-triangle-exclamation fa-fw"></i>';
            case 'due': return '<i class="fa-solid fa-alarm-clock fa-fw"></i>';
            case 'expense': return '<i class="fa-solid fa-file-invoice-dollar fa-fw"></i>';
        }
    };

    var drawSecondary = function(type, el) {
        html = "<div class='row'><div class='col-12 offset-md-2 col-md-8'>" +
        "<div class='app-draw-row category ml-2 mr-4 px-2' onclick=\"dashboard.show('"+type+"', "+el.id+");\">";
        html += el.label;
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
            default:
                return drawSecondary(type, el);
        }
        return '';
    };

    return {
        drawElement: drawElement,
        drawButton: drawButton,
    };
})(jQuery);
