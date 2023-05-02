var library = (function ($, undefined) {

    var drawEntry = function(el) {
        html = "<div class='row'><div class='col-12 mb-2'><div class='app-draw-row entry-"+ el.status+"' onclick=\"dashboard.show('entry', "+el.id+");\">";
        html += "<div class='row'>";
        html += "<div class='col-3 col-md-1 text-start'>" + entryIcon(el.status);
        html += (el.autopay == 1?"<i class='fa fa-solid fa-robot' title='Autopay'></i>":"");
        html += "</div>";
        html += "<div class='col-3 col-md-2 text-end'>";
        html += (el.estimated_date == 1?"<i class='fa fa-solid fa-circle-question' title='Estimated'></i>&nbsp;":"");
        html += (typeof(el.next_due_date) == 'string'?dateFormat(el.next_due_date):"<i class='fa fa-solid fa-circle-exclamation' title='Date Not Set'></i>");
        html += "</div>";
        html += "<div class='col-6 col-md-2 text-end'>" +
            (el.estimated_amount == 1?"<i class='fa fa-solid fa-circle-question' title='Estimated'></i>&nbsp;":"") +
            (el.amount == '0.00'?"<i class='fa fa-solid fa-circle-exclamation' title='Amount Not Set'></i>":el.amount) + "</div>";
        html += "<div class='col-12 col-md-4 text-start'>"+ el.name + "</div>";
        html += "<div class='d-none d-md-inline col-md-3 text-start'>"+ (typeof(el.category) != 'string'?'Unassigned':el.category) + "</div>";
        html += '</div></div></div>';
        return html;
    };

    var entryIcon = function(status) {
        switch (status) {
            case 'income': return '<i class="fa-solid fa-badge-dollar fa-fw" title="Income"></i>';
            case 'late': return '<i class="fa-solid fa-triangle-exclamation fa-fw" title="Late"></i>';
            case 'due': return '<i class="fa-solid fa-alarm-clock fa-fw" title="Due"></i>';
            case 'expense': return '<i class="fa-solid fa-file-invoice-dollar fa-fw" title="Expense"></i>';
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
