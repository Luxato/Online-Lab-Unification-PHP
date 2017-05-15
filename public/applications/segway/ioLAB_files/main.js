$( document ).ready(function() {  
  $("#content").css("min-height",($("#container aside").height()-40)+"px");
  
  $("#prihlasovanie h2").click(function() {
    $('#prihlasovanie #prihlasovanie_in').slideToggle('slow', function(){
        $("#content").css("min-height",($("#container aside").height()-40)+"px");
    }); 
  }); 
});