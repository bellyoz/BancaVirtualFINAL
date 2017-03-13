function run(){

	slide();
	$("#login").addClass("display-loginn");
	document.getElementById("login-button").onclick  = desplegar;
	
}
function slide(){
	
 $(function(){
 	$(".slides").slidesjs({
 		  play: {
      
        
      effect: "slide",
       
      interval: 3000,
       
      auto: true,
      
      swap: true,
      
      pauseOnHover: false,
       
      restartDelay: 2500
        
    }
 	});
 });
}
function desplegar(){

		$("#login").toggleClass("display-loginn");
   		$("#login").toggleClass("display-login");

}