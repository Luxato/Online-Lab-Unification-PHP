/**
 * Pouzite kody, obrazky, tutorialy
 * http://www.elated.com/articles/drag-and-drop-with-jquery-your-essential-guide/
 * http://www.w3schools.com/dom/dom_loadxmldoc.asp
 * http://api.jqueryui.com/draggable/
 * https://jqueryui.com/droppable/
 * http://www.sitepoint.com/creating-simple-line-bar-charts-using-d3-js/
 */
var zadanie;
var napoveda;
var riesenie;
var solutionCheck;
var solutionPile;
var unsolved;
var x;
var puzzleIndex;
var score;
var scoreArr;
var helpUsed;
var solutionUsed;

function loadXMLDoc(filename){
    if (window.XMLHttpRequest){
        var xhttp=new XMLHttpRequest();
    }
    else{
        xhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.open("GET",filename,false);
    xhttp.send();
    
    return xhttp.responseXML;
}

function createDragAndDrop(){
    $('.draggable').draggable({ revert: true, start: handleDragEvent });
    $('.droppable').droppable({
        drop: handleDropEvent,
        accept: '.draggable',
        hoverClass: 'hovered'
    });
}

function readData(){
    var i;
    var xmlDoc = loadXMLDoc("xmls/anagramy.xml");

    x = xmlDoc.getElementsByTagName("uloha");
    
    for( i = 0; i < x.length; i++){
        zadanie[i] = x[i].children[0].innerHTML.toUpperCase();
        napoveda[i] = x[i].children[1].innerHTML.toUpperCase();
        riesenie[i] = x[i].children[2].innerHTML.toUpperCase();
    }
}

function handleDragEvent(){
    $(this).draggable( 'option', 'revert', true );
}

function handleDropEvent( event, ui ) {
	
    var draggable = ui.draggable;
    draggable.draggable( 'disable' );
    draggable.position( { of: $(this), my: 'left top', at: 'left top' } );
    draggable.draggable( 'option', 'revert', false );
    $(this).droppable( 'disable' );
    solutionPile[$(this).index(".droppable")] = draggable[0].innerHTML;
    isDropped = true;
    
    var isSame = solutionCheck.every(function(element, index) {
        return element === solutionPile[index]; 
    });
    
    if(isSame){
		
        if(solutionUsed === false){
            changeScore(30);
        }
        else{
            solutionUsed = false;
        }
        helpUsed = false;
        unsolved = $.grep(unsolved, function(value) {return value != unsolved[puzzleIndex];});
        if(unsolved.length !== 0 && puzzleIndex < unsolved.length){
            reset();
        }
        else if(unsolved.length !== 0){
            puzzleIndex--;
			
            reset();
        }
        else{
            $("#end").show();
            $("#endNote").text("Gratulujem, Vyhrali ste! Vaše skóre: " + score + "/" + (zadanie.length * 30));
        }
	
    }
	
}

function createPuzzle(){
    var i;
    var temp;

    
    for( i = 0; i < zadanie[(unsolved[puzzleIndex])].length; i++){
        if(zadanie[(unsolved[puzzleIndex])][i] !== " ")
            $("#draggablePile").append("<div class=\"draggable\">" + zadanie[(unsolved[puzzleIndex])][i] + "</div>");
        else
            $("#draggablePile").append("<div class=\"space\"></div>");
    }
    
    temp = riesenie[(unsolved[puzzleIndex])].replace(" ", "");
    solutionCheck = temp.split("");
    
    for( i = 0; i < riesenie[(unsolved[puzzleIndex])].length; i++){
        if(riesenie[(unsolved[puzzleIndex])][i] !== " ")
            $("#droppablePile").append("<div class=\"droppable\"></div>");
        else
            $("#droppablePile").append("<div class=\"space\"></div>");
    }
	
	 //console.log(getCookie("unsolved"));
}

function init(){
    zadanie = new Array();
    napoveda = new Array();
    riesenie = new Array();
    solutionCheck = new Array();
    solutionPile = new Array();
    unsolved = new Array();
    scoreArr = new Array;
    helpUsed = false;
    solutionUsed = false;
    puzzleIndex = 0;

		if(getCookie("getResult"))
	   {
		   
		    scoreArr.push(getCookie("getResult"));
			
			console.log("SCORE:" + getCookie("getResult"));
			  $("#score").text("Score: " + getCookie("getResult"));
	   }
	 	score = 0;
    
	
    
    readData();
    
    for(var i = 0; i < zadanie.length; i++)
        unsolved[i] = i;
       if(getCookie("unsolved") > 0)
	   {
		   console.log(getCookie("unsolved"));
		   unsolved[puzzleIndex] = getCookie("unsolved");
	   }
	   
    createPuzzle();

    createDragAndDrop();
    
    hideSolution();
    hideHelp();
    
    $(".forwardButton").css("visibility", "visible");
    
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function reset(){
		
    $("#droppablePile").empty();
    $("#draggablePile").empty();
    solutionPile = [];
    
    createPuzzle();
    
    createDragAndDrop();
    hideSolution();
    hideHelp();
    
    if(puzzleIndex > 0){
        $(".backButton").css("visibility", "visible");
    }
    
    if(puzzleIndex === (unsolved.length - 1)){
        $(".forwardButton").css("visibility", "hidden");
        $(".backButton").css("visibility", "visible");
    }
    
    if(puzzleIndex === (0)){
        $(".backButton").css("visibility", "hidden");
        $(".forwardButton").css("visibility", "visible");
    }
    
    if(unsolved.length === 1){
        $(".backButton").css("visibility", "hidden");
        $(".forwardButton").css("visibility", "hidden");
    }
    setCookie("unsolved",unsolved[puzzleIndex],30);
	setCookie("getResult", score, 30);
}
$(document).on("click","#help",
    function(){
        if(helpUsed === false){
            changeScore(-2);
            $("#help").text(napoveda[(unsolved[puzzleIndex])]);
            helpUsed = true;
        }
    }
);

function hideHelp(){
    $("#help").text("Zobraz nápovedu");
}

$(document).on("click","#forward",
function(){
    solutionUsed = false;
    helpUsed = false;
    puzzleIndex++;
	setCookie("puzzleIndex", puzzleIndex,30);
	console.log("SET");
    reset();
});

$(document).on("click","#back",
function(){
    solutionUsed = false;
    helpUsed = false;
    puzzleIndex--;
	setCookie("puzzleIndex", puzzleIndex,30);
	console.log("SET");
    reset();
});


$(document).on("click","#aboutClose",
function(){
    $("#aboutPanel").hide();
});

$(document).on("click","#graphClose",
function(){
    $("#graphPanel").hide();
});

$(document).on("click","#buttonSolution",
    function(){
        $("#solution").show();
        $("#solution").text(riesenie[(unsolved[puzzleIndex])]);
        if(solutionUsed === false)
            solutionUsed = true;
    }
);

$(document).on("click","#buttonReset",
    function(){
        changeScore(-5);
        reset();
    }
);
$(document).on("click","#newGame",
    function(){
        $("#droppablePile").empty();
        $("#draggablePile").empty();
        init();
        $("#end").hide();
    }
);

function hideSolution(){
    $("#solution").hide();
}

function changeScore(value){
    score += value;
    scoreArr.push(score);
    $("#score").text("Score: " + score);
	
}