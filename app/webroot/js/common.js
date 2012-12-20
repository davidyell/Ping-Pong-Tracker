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

});