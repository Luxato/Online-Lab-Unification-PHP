<!DOCTYPE html>           
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Kresli</title>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/plotly-latest.min.js"></script>
    <script>  
var trace1 = {
  x: [1, 2, 3, 4],
  y: [10, 15, 13, 17],
  type: 'scatter'
};

var trace2 = {
  x: [1, 2, 3, 4],
  y: [16, 5, 11, 9],
  type: 'scatter'
};

var data = [trace1, trace2];

//TESTER = document.getElementById('mydiv');
//Plotly.plot(TESTER, data);
    
    
    </script>
  </head>

  <body> 
  <div id="tester" style="width:600px;height:250px;"></div> 
  <script>
	TESTER = document.getElementById('tester');
	Plotly.plot( TESTER, [{
	x: [1, 2, 3, 4, 5],
	y: [1, 2, 4, 8, 16] }], {
	margin: { t: 0 } } );
</script>  
    hop 
    
  </body>
</html>