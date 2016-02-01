/**
 * Created by Milos Zarkovic (mzarkovicm@gmail.com) on 21-Jan-16.
 */
function Table(idName) {

    this.table = $("#" + idName);
    this.playersHolder = $("[data-role='table-head']");
    this.gamesHolder = $("[data-role='table-body']");
    this.resultsHolder = $("[data-role='table-foot']");
    this.totalPlayers = 1;
    this.currentGame = 1;

    /**
     * Initialize the table
     */
    this.initialize = function () {
        // Add 1st player input
        var playersRow = this.getTemplateClone("players-row").attr("data-status", "editing").addClass("active");
        var playerCol = this.getTemplateClone("player-col");
        var playerInput = this.getTemplateClone("input-text");
        var playerControls = this.getTemplateClone("controls-col", true);
        playerCol.attr("data-id", 1);
        playerInput.appendTo(playerCol);
        playerCol.appendTo(playersRow);
        playerControls.appendTo(playersRow);
        playersRow.appendTo(this.playersHolder);

        // Add 1st game
        var gamesRow = this.getTemplateClone("game-row").attr("data-status", "active").addClass("active").attr("data-id", 1);
        var gameCol = this.getTemplateClone("game-col");
        var gameInput = this.getTemplateClone("input-number");
        var gameControls = this.getTemplateClone("controls-col", true);
        gameCol.attr("data-id", 1);
        gameInput.appendTo(gameCol);
        gameCol.appendTo(gamesRow);
        gameControls.appendTo(gamesRow);
        gamesRow.appendTo(this.gamesHolder);

        // Add results row
        var resultsRow = this.getTemplateClone("results");
        var resultCol = this.getTemplateClone("result-col");
        var resultInput = this.getTemplateClone("disabled-input");
        resultCol.attr("data-id", 1);
        resultInput.appendTo(resultCol);
        resultCol.appendTo(resultsRow);
        resultsRow.appendTo(this.resultsHolder);
    };

    /**
     * Add a new player
     */
    this.addPlayer = function () {
        // Add player column
        this.totalPlayers++;
        console.log("total players: " +this.totalPlayers);
        var playerRow = $("[data-role='players-row']").attr("data-status", "editing").addClass("active");
        var playersControl = playerRow.children("[data-role='controls-col']");
        var lastPlayer = $("[data-role='player-col']").last();
        var playerCol = this.getTemplateClone("player-col");
        var playerInput = this.getTemplateClone("input-text");
        var playerID = Number(lastPlayer.attr("data-id")) + 1;
        playerCol.attr("data-id", playerID);
        playerInput.appendTo(playerCol);
        playerCol.insertBefore(playersControl);

        // Add game column
        var gameRow = $("[data-role='game-row']").last();
        var gameControls = gameRow.children("[data-role='controls-col']");
        var gameCol = this.getTemplateClone("game-col", false, true);
        var gameInput = this.getTemplateClone("input-number");
        gameCol.attr("data-id", playerID);
        gameInput.appendTo(gameCol);
        gameCol.insertBefore(gameControls);

        // Add result column
        var resultsRow = $("[data-role='results']");
        var disabledInput = this.getTemplateClone("disabled-input");
        var resultCol = this.getTemplateClone("result-col").attr("data-id", playerID);
        disabledInput.appendTo(resultCol);
        resultCol.appendTo(resultsRow);
    };

    /**
     * Save the game row
     */
    this.saveRow = function (e) {
        var parentRow = $(e).parents("tr");

        // Check if players row
        if (parentRow.attr("data-role") == "players-row") {
            var childSelector = "[data-role='player-col']";
            var defaultVal = "N.N.";
        } else {
            var childSelector = "[data-role='game-col']";
            var defaultVal = 0;
        }

        // Check for editing
        if (parentRow.attr("data-status") == "editing") {
            parentRow.attr("data-status", "inactive");
            parentRow.toggleClass("active");
        } else if (parentRow.attr("data-role") == "game-row") {
            this.addRow();
        }

        // Disable input fields
        var children = parentRow.children(childSelector);
        var _this = this;
        $.each(children, function (i, child) {
            var disabeledInput = _this.getTemplateClone("disabled-input");
            var input = $(child).children();
            if (input.attr("data-role") != "disabled-input") {
                var val = input.val();
                if (val == "") val = defaultVal;
                $(input).remove();
                $(disabeledInput).html(val);
                $(disabeledInput).appendTo($(child));
            }
        });
    };

    /**
     * Add a new game row
     */
    this.addRow = function () {
        this.currentGame++;
        console.log("current game: "+this.currentGame);
        var activeRow = $("[data-role='game-row'][data-status='active']").last();
        var oldID = Number(activeRow.attr("data-id"));
        var newID = oldID + 1;
        var resultsRow = $("[data-role='results']");
        var newRow = activeRow.clone(true).appendTo(this.gamesHolder);
        var newInputs = newRow.find("[data-role='input-number']");
        $.each(newInputs, function (i, child) {
            $(child).val("");
        });
        newRow.attr("data-id", newID);
        activeRow.attr("data-status", "inactive");
        activeRow.toggleClass("active");
    };

    /**
     * Edit a game row
     */
    this.editRow = function (e) {
        var parentRow = $(e).parents("tr");

        // Check if players row
        if (parentRow.attr("data-role") == "players-row") {
            var childSelector = "[data-role='player-col']";
            var inputType = "input-text";
        } else {
            var childSelector = "[data-role='game-col']";
            var inputType = "input-number";
        }
        parentRow.toggleClass("active");
        parentRow.attr("data-status", "editing");

        // Enable input fields
        var children = parentRow.find(childSelector);
        var _this = this;
        $.each(children, function (i, child) {
            var inputField = _this.getTemplateClone(inputType);
            var val = $(child).children("[data-role='disabled-input']").html();
            $(child).html($(inputField).val(val));
        });
    };

    /**
     * Watch for the changes in the fields
     */
    this.watchForChanges = function () {
        var _this = this;
        var fields = $("[data-role^='game-col']");
        $.each(fields, function (i, field) {
            $(field).change(function (e) {
                _this.calculateCol($(this).attr("data-id"));
            });
        });
    };

    /**
     * Calculate total score in one column
     * @param {int} id - ID of the column
     */
    this.calculateCol = function (id) {
        var cols = $("[data-role='game-col'][data-id='" + id + "']");
        var total = 0;

        $.each(cols, function (i, col) {
            var colParentStatus = $(col).parent().attr("data-status");
            if (colParentStatus == "inactive") {
                var num = Number($(col).children("[data-role='disabled-input']").html());
            } else {
                var num = Number($(col).children("[data-role='input-number']").val());
            }
            total = total + num;
        });

        // Write results
        var resultsRow = $("[data-role='results']");
        var resultCol = resultsRow.children("[data-role='result-col'][data-id='" + id + "']");
        var resultInput = resultCol.children("[data-role='disabled-input']");
        $(resultInput).html(total);
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
}