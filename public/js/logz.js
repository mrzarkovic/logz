/**
 * Created by Milos Zarkovic (mzarkovicm@gmail.com) on 21-Jan-16.
 */
function LogZ(idName) {

    this.table = $("#" + idName);
    this.playersHolder = $("[data-role='table-head']");
    this.logsHolder = $("[data-role='table-body']");
    this.resultsHolder = $("[data-role='table-foot']");
    this.totalLogs = 0;
    this.currentLog = 0;

    /**
     * Add a new player
     */
    this.addEntry = function () {
        // Add log column
        this.totalLogs++;
        this.currentLog = this.totalLogs;
        console.log("total logs: " +this.totalLogs);

        var entryRow = this.getTemplateClone("entry-row");
        var logControls = this.getTemplateClone("controls-col", true);
        var entryNoCol = this.getTemplateClone("entry-no-col");
        var dateCol = this.getTemplateClone("date-col");
        var logCol = this.getTemplateClone("log-col");
        var logInput = this.getTemplateClone("input");

        entryNoCol.html(this.currentLog);
        entryNoCol.appendTo(entryRow);

        dateCol.html(this.getFormattedDate());
        dateCol.appendTo(entryRow);

        logInput.appendTo(logCol);
        logCol.appendTo(entryRow);

        logControls.appendTo(entryRow);

        entryRow.addClass("active");
        entryRow.attr("data-status", "editing");
        entryRow.attr("data-id", this.currentLog);
        entryRow.appendTo(this.logsHolder);
    };

    /**
     * Save the game row
     */
    this.saveRow = function (e) {
        var logText = "";
        var logId = this.table.attr("data-id");
        var parentRow = $(e).parents("tr");

        var childSelector = "[data-role='log-col']";
        var defaultVal = "/";

        // Check for editing
        if (parentRow.attr("data-status") == "editing") {
            parentRow.attr("data-status", "inactive");
            parentRow.toggleClass("active");
        }

        // Disable input field
        var children = parentRow.children(childSelector);
        var _this = this;
        $.each(children, function (i, child) {
            var disabeledInput = _this.getTemplateClone("disabled-input");
            var input = $(child).children();
            if (input.attr("data-role") != "disabled-input") {
                logText = input.val();
                if (logText == "") logText = defaultVal;
                $(input).remove();
                $(disabeledInput).html(logText);
                $(disabeledInput).appendTo($(child));
            }
        });

        // Ajax save to database
        var request = $.ajax({
            url: "/log/ajax/add-entry/" + logId,
            method: "POST",
            data: { logText : logText },
            dataType: "html"
        });

        request.done(function( msg ) {
            console.log(msg);
            //$( "#log" ).html( msg );
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    };

    /**
     * Edit a game row
     */
    this.editRow = function (e) {
        var parentRow = $(e).parents("tr");
        var childSelector = "[data-role='log-col']";

        parentRow.toggleClass("active");
        parentRow.attr("data-status", "editing");

        // Enable input fields
        var children = parentRow.find(childSelector);
        var _this = this;
        $.each(children, function (i, child) {
            var inputField = _this.getTemplateClone("input");
            var val = $(child).children("[data-role='disabled-input']").html();
            $(child).html($(inputField).val(val));
        });
    };

    /**
     * Get the element clone
     * @param {string} role - Role of the element
     * @param {boolean} keephtml - Copy events
     * @param {boolean} deep - Preform a deep copy
     * @returns {DOM element} - Clone element
     */
    this.getTemplateClone = function (role, keephtml, deep) {
        nohtml = typeof nohtml !== 'undefined' ? keephtml : false;
        deep = typeof deep !== 'undefined' ? deep : false;

        if (keephtml)
            return $("[data-role='" + role + "-template']").clone(deep).attr("data-role", role).removeClass("template");
        else
            return $("[data-role='" + role + "-template']").clone(deep).html("").attr("data-role", role).removeClass("template");
    };

    /**
     * Get datetime in format d.m.Y. H:i:s
     * @returns {string}
     */
    this.getFormattedDate = function() {
        var date = new Date();
        var day = "0" + date.getDate();
        day = day.substr(day.length - 2);
        var month = "0" + (date.getMonth() + 1);
        month = month.substr(month.length - 2);
        var hours = "0" + date.getHours();
        hours = hours.substr(hours.length - 2);
        var minutes = "0" + date.getMinutes();
        minutes = minutes.substr(minutes.length - 2);
        var seconds = "0" + date.getSeconds();
        seconds = seconds.substr(seconds.length - 2);

        var str = day + "." + month + "." + date.getFullYear() + "." + " " + hours + ":" + minutes + ":" + seconds;

        return str;
    }
}