<h1>Interaktívny 3D WebGL model Segway vozidla</h1>
<script type="text/javascript" src="js/jQuery.js"></script>
<script type="text/javascript" src="js/googleGraphs.js"></script>
<style>
#segwayInputs{
  padding-bottom: 10px;
}
#segwayInputs > div{
  width: 45%;
}
#segwayInputs > div> div{
  width: 100%;
  padding-right: 10px;
}
#segwayInputs input[type="text"], #segwayInputs input[type="number"]{
  width: 100%;
}
#segwayInputs  div{
  display: inline-block;
}
#segwayInputs > button{
  float: none;
  margin-top: 20px;
}
#resetButton, #grafBan, #segwayInputs > button{
	width: 155px;
}
#resetButton{
	display: none;
}
.pidAll{
  float:right;
}
#graf{
	display: none;
}
#loadingGif{
	display: none;
	position: absolute;
	bottom: 0%;
	right: 0%;
}
#webGLWindow{
	position: relative;
	width: 100%; 
	height: 500px
}


</style>
<div id="webGLWindow">
	<div id="webGL" style="position: absolute; width: 100%; height: 100%"></div>
	<img id="loadingGif" src="loading.gif" alt="loading gif">
</div>

<div id="graf" style="height: 250px;"></div>
<form id="segwayInputs" >
	<div>
		<label for="timeInput">Trvanie animácie:</label>
		<input name="time" value="5" id="timeInput" type="text" placeholder="Zadaj čas v sekundách" onchange="checkTimeInput(this.value)"><br>

		<label for="degreeInput">Počiatočný uhol v stupňoch:</label>
		<input name="degree" value="30" id="degreeInput" type="text" placeholder="Zadaj uhol v stupňoch" onchange="checkDegreeInput(this.value)"><br>

		<label for="speedInput">Počiatočná rýchlosť vozidla v m/s:</label>
		<input name="speed" value="5" id="speedInput" type="text" placeholder="Zadaj rýchlosť" onchange="checkSpeedInput(this.value)"><br>

	    <input name="angle" id="angleInput" hidden>
	</div>
	<div class="pidAll">
		<label for="pid">Použiť PID regulátor?</label>

		<input id="pidYes" name="pid" type="radio" value="SegwayPID.mo" checked onclick="showPid()">
		<label for="pidYes">áno</label>

		<input id="pidNo" name="pid" type="radio" value="SegwayOnly.mo" onclick="hidePid()">
		<label for="pidNo">nie</label>
	    <div id="pidPart">
	        <label for="pInput">P: </label>
	        <input name="p" type="text" value="18" id="pInput" onchange="checkPInput(this.value)"><br>
	        <label for="iInput">I: </label>
	        <input name="i" type="text" value="20" id="iInput" onchange="checkIInput(this.value)"><br>
	        <label for="dInput">D: </label>
	        <input name="d" type="text" value="0.1" id="dInput" onchange="checkDInput(this.value)"><br>
    	</div>
    </div>
	<button type="submit" id="submitButton">Odoslať</button>
</form>
<button type="button" id="resetButton" onclick="reset()" >Reset</button>
<button type="button" id="grafBan" onclick="grafOnOff()" >Skryť Graf</button>

<script src="js/three/three.min.js"></script>
<script src="js/three/Animation.js"></script>
<script src="js/three/AnimationHandler.js"></script>
<script src="js/three/KeyFrameAnimation.js"></script>

<script src="js/three/ColladaLoader.js"></script>
<script src="js/three/OrbitControls.js"></script>
<script src="js/three/Detector.js"></script>
<script src="js/three/stats.min.js"></script>
<script src="js/code.js"></script>