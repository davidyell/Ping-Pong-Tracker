$(function(){

// Defaults
$('#Player3Id').parents('div.input.select').hide();
$('#Player4Id').parents('div.input.select').hide();

// Change visible fields
   $('#MatchType').change(function(){
       if($(this).val() == 2){ // Singles
           $('#Player3Id').parents('div.input.select').hide();
           $('#Player4Id').parents('div.input.select').hide();
       }else{ // Doubles
           $('#Player3Id').parents('div.input.select').show();
           $('#Player4Id').parents('div.input.select').show();
       }
   });

});