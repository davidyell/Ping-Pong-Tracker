$(function(){

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

});