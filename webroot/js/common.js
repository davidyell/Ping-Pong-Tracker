$(function(){

// Ajax globals
    $(document).ajaxStart(function() {
        $('#loading').show();
    });
    $(document).ajaxStop(function() {
        $('#loading').hide();
    });

// Defaults
    $('#MatchesPlayer3PlayerId').parents('div.input.select').hide();
    $('#MatchesPlayer4PlayerId').parents('div.input.select').hide();

// Change visible fields
   $('#MatchMatchTypeId').change(function(){
       if($(this).val() == 1){ // Singles
           $('#MatchesPlayer3PlayerId').parents('div.input.select').hide();
           $('#MatchesPlayer4PlayerId').parents('div.input.select').hide();
       }else{ // Doubles
           $('#MatchesPlayer3PlayerId').parents('div.input.select').show();
           $('#MatchesPlayer4PlayerId').parents('div.input.select').show();
       }
   });

// Submitted but with errors, so change the selection
    if($('#MatchMatchTypeId').val() == 2){
        $('#MatchesPlayer3PlayerId').parents('div.input.select').show();
        $('#MatchesPlayer4PlayerId').parents('div.input.select').show();
    }

// If the match type changes from doubles to singles, we need to clear the doubles players to allow validation
    $('#MatchMatchTypeId').change(function(e){
        if($(this).val() == 1){
            $('#MatchesPlayer3PlayerId option:selected').removeAttr('selected');
            $($('#MatchesPlayer3PlayerId option')[$('#MatchesPlayer3PlayerId option').length-1]).attr('selected','selected');

            $('#MatchesPlayer4PlayerId option:selected').removeAttr('selected');
            $($('#MatchesPlayer4PlayerId option')[$('#MatchesPlayer4PlayerId option').length-1]).attr('selected','selected');
        }
    });

    $('#department-ranks').stupidtable();
    $('#rankings').stupidtable();
    
// Deal with Tournament draws and matches
    $('#TournamentAddForm .buttons button').click(function(e) {
        e.preventDefault();
        
        if ($(this).hasClass('add')) {
            $('#TournamentPlayers option:selected').each(function(i, e) {
                $('#TournamentSelectedPlayers').append(e);
            });
        } else {
            $('#TournamentSelectedPlayers option:selected').each(function(i, e) {
                $('#TournamentPlayers').append(e);
            });
        }
    });
    
    $('#dodraw').click(function(e) {
        e.preventDefault();
        
        var error = false;
        
        // Bit of rudimentary validation
        if ($('#TournamentSelectedPlayers option').length == 0) {
            $('div.selected_players').addClass('error');
            if ($('div.selected_players div.error-message').length == 0) {
                $('div.selected_players').append('<div class="error-message">Please select some players</div>');
            }
            error = true;
        } else {
            if ($('div.selected_players').hasClass('error')) {
                $('div.selected_players').removeClass('error');
                $('div.selected_players div.error-message').remove();
            }
        }
        
        if ($('#TournamentName').val() == '') {
            $('#TournamentName').parents('div.input').addClass('error');
            if ($('#TournamentName').parents('div.input').find('div.error-message').length == 0) {
                $('#TournamentName').parents('div.input').append('<div class="error-message">Please enter a name</div>');
            }
            error = true;
        } else {
            if ($('#TournamentName').parents('div.input').hasClass('error')) {
                $('#TournamentName').parents('div.input').removeClass('error');
                $('#TournamentName').parents('div.input').find('div.error-message').remove();
            }
        }
        
        if (error === false) {
            $.ajax({
                type: 'post',
                url: '/tournaments/draw.json',
                data: $('#TournamentAddForm').serialize(),
                success: function(data, textStatus) {
                    if (textStatus == 'success') {
                        $('#draw').html('<img src="../files/tournament.png" alt="Tournament draw">');
                        $('#draw').append('<input type="hidden" name="data[Tournament][rounds]" id="TournamentRounds" value=\'' + JSON.stringify(data) + '\'>');
//                        console.log(data);
                        $('#save_tournament').show();
                    }
                }
            });
        }
    });
    
    $('.tournament .match form').submit(function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var form = $(this);
        var match = form.parents('div.match');
        
        // Clear out old validation
        if ($(form).find('div.error-message')) {
            $(form).find('div.error-message').remove();
        }
        
        $.ajax({
            type: 'post',
            url: url,
            data: $(this).serialize(),
            success: function(data, textStatus) {
                if (data.outcome == 'Failed') {
                    
                    // Output some feedback to the user
                    if (Object.keys(data.validation.MatchesPlayer).length > 0) {
                        if (data.validation.MatchesPlayer[1].score != 'undefined') {
                            $(form).find('div.scores').append('<div class="error-message">' + data.validation.MatchesPlayer[1].score + '</div>');
                        }
                        if (data.validation.MatchesPlayer[2].score != 'undefined') {
                            $(form).find('div.scores').append('<div class="error-message">' + data.validation.MatchesPlayer[2].score + '</div>');
                        }                        
                    }
                    
                    $(match).effect('shake');
                } else if (data.outcome == 'Success') {
                    $(match).fadeOut();
                    var draw = $('#tournament-draw').attr('src');
                    var d = new Date();
                    $('#tournament-draw').attr('src', draw + '?' + d.getTime());
                    
                    if (data.updateDraw) {
                        window.location.reload();
                    }
                }
            }
        });
    });

});