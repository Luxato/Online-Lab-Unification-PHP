if (!Detector.webgl) Detector.addGetWebGLMessage();

var container, stats;

var camera, scene, renderer, objects;
var particleLight;
var wheel
var segwayPosition = { x: 0, y: 1, z: 0 } //x dopredu/dozadu, y hore/dole, z do¾ava/doprava
init();
var v = new Array();
var duration;
google.charts.load('current', { packages: ['corechart'] });

var dvihaj = false;
var vypocitane = false;
var poloz;

$("#segwayInputs").submit(function(event){
    event.preventDefault();
    dvihaj = true;
    vypocitane = false;
    duration = $("#timeInput").val();
    pocitaj();
    
});

//document.getElementById("myBtn").addEventListener("click", reset);

function reset(){
	poloz = true;
	$("#resetButton").hide();
	$("#submitButton").show();

}

function showReset(){
	$("#resetButton").show();
}

var graf= true;
//grafOnOff();
function grafOnOff(){
    if(graf == true){
        graf = false;
        $("#grafBan").text("Zobraziť Graf");
        $("#graf").hide();
    }
    else{
        graf = true;
        $("#grafBan").text("Skryť Graf");
        $("#graf").show();
    }
}

function degreeToRad(angle){
	return angle * Math.PI / 180;
}
function radToDegree(radians){
	return radians * 180/Math.PI;
}

/*Riadenie vzhľadu PID časti formuláru*/
function hidePid(){
	$("#pidPart").hide();
}
function showPid(){
	$("#pidPart").show();
}

if($("#pidYes").is(":checked"))
	showPid();
else
	hidePid();
/*KONIEC*/

function checkTimeInput(time){
	if(isNaN(time)){
		$("#timeInput").css("borderColor", "red");
		$("#timeInput").val("V poli musí byť zadané len číslo!");
		return false;
	}
	else if(time < 0 || time > 50){
		$("#timeInput").css("borderColor", "red");
		$("#timeInput").val("Uhol musí byť z intervalu <0,50>");
		return false;
	}
	else{
		$("#timeInput").css("color", "green");
		return true;
	}
}

function checkDegreeInput(deg){
	if(isNaN(deg)){
		$("#degreeInput").css("borderColor", "red");
		$("#degreeInput").val("V poli musí byť zadané len číslo!");
		return false;
	}
	else if(deg > 70 || deg < 0){
		$("#degreeInput").css("borderColor", "red");
		$("#degreeInput").val("Uhol musí byť z intervalu <0,70>");
		return false;}
	else{
		$("#degreeInput").css("borderColor", "green");
		return true;
	}
}
function checkSpeedInput(speed){
	if(isNaN(speed)){
		$("#speedInput").css("borderColor", "red");
		$("#speedInput").val("V poli musí byť zadané len číslo!");
		return false;
	}
	else if(speed > 10 || speed < -10){
		$("#speedInput").css("borderColor", "red");
		$("#speedInput").val("Rýchlosť musí byť z intervalu <-10,10>");
		return false;}
	else{
		$("#speedInput").css("borderColor", "green");
		return true;
	}
}
function checkPInput(value){
	if($("#pidYes").is(":checked")){
		if(isNaN(value)){
			$("#pInput").css("borderColor", "red");
			$("#pInput").val("V poli musí byť zadané len číslo!");
			return false;
		}
		if(value < 0 || value > 100){
			$("#pInput").css("borderColor", "red");
			$("#pInput").val("Hodnota musí byť z intervalu <0,100>");
			return false;
		}
		else{
			$("#pInput").css("borderColor", "green");
			return true;
		}
	}
	else return true;

}
function checkIInput(value){
	if($("#pidYes").is(":checked")){
		if(isNaN(value)){
			$("#iInput").css("borderColor", "red");
			$("#iInput").val("V poli musí byť zadané len číslo!");
			return false;
		}
		if(value < 0 || value > 50){
			$("#iInput").css("borderColor", "red");
			$("#iInput").val("Hodnota musí byť z intervalu <0,50>");
			return false;
		}
		else{
			$("#iInput").css("borderColor", "green");
			return true;
		}
	}
	else return true;
}
function checkDInput(value){
	if($("#pidYes").is(":checked")){
		if(isNaN(value)){
			$("#dInput").css("borderColor", "red");
			$("#dInput").val("V poli musí byť zadané len číslo!");
			return false;
		}
		if(value < 0 || value > 10){
			$("#dInput").css("borderColor", "red");
			$("#dInput").val("Hodnota musí byť z intervalu <0,50>");
			return false;
		}
		else{
			$("#dInput").css("borderColor", "green");
			return true;
		}
	}
	else return true;
}


function checkInputs(inputs){
	var vstupy = {};
	inputs.map(function(x){vstupy[x.name] = x.value;}); 
	if(!checkTimeInput(vstupy.time))
		return false;
	if(!checkDegreeInput(vstupy.degree))
		return false;
	if(!checkSpeedInput(vstupy.speed))
		return false;
	if(!checkPInput(vstupy.p))
		return false;
	if(!checkIInput(vstupy.i))
		return false;
	if(!checkDInput(vstupy.d))
		return false;
	

	return true;
}
$("#loadingGif").hide();
$("#loadingGif").css("margin","0 0 0 0");
$("#loadingGif").css("position","absolute");
function pocitaj(){
	v = new Array();

	if(checkInputs($( "#segwayInputs" ).serializeArray())){
		$("#submitButton").hide();
		$("#loadingGif").show();
		$("#angleInput").val(degreeToRad(parseFloat($("#degreeInput").val()))); //updatne skrytý input kam vloží uhol prepocitany do radianov

		v[0] = {"time": 0, "phi": parseFloat($("#angleInput").val()), "x": 0};
		console.log(v);
        if(graf == true){
        	$("#graf").show();
		  google.charts.setOnLoadCallback(drawGoogleGraph); 

        }
		console.log($( "#segwayInputs" ).serialize());
	    $.post("http://147.175.105.140:8033/~stranovsky/public/applications/hok/model.php",$( "#segwayInputs" ).serialize(), function (data) {
	    	$("#loadingGif").hide();
	    	//console.log(data);
	        if(data==false){
	        	alert("Zadané dáta nie sú valídne. Zabezpečenie servera ich odmietlo prijať!");
	        	reset();
	        }
	        else{
		        vysledok = jQuery.parseJSON(data);
		        vysleok = vysledok.result;
		        xka = vysledok.result[0];
		        phicka = vysledok.result[1];
		        var i = 0;

		        for (k in xka) {
		            /*console.log(k);*/
		            var o = { "time": phicka[k].x, "phi": phicka[k].y , "x": xka[k].y};
		            v[i] = o;
		            i++;
		        }
		        console.log(v.length);
		        vypocitane = true;
	        }
	    })
	    .done(function () {
	        
	        //premazGraf();
	    });
    }
}


function drawGoogleGraph() {
    var i = 0;
    var options = {
        width: $("#graf").innerWidth(),
        height: $("#graf").innerHeight(),
        vAxis: { minValue: -70, maxValue: 70, baselineColor: "black", textStyle: {color: "black"} },
        hAxis: { minValue: 0, maxValue: duration, baselineColor: "black", title:"Čas v sekundách", titleTextStyle: {color: "black"}, textStyle: {color: "black"}},
        backgroundColor: "transparent",
        legend: {position:"bottom", textStyle:{color: "black"}}
    };

    var chart = new google.visualization.LineChart(
        document.getElementById('graf'));
    data = new google.visualization.DataTable();
    data.addColumn('number', 'time');
    data.addColumn('number', 'Uhol náklonu v stupňoch');
    data.addColumn('number', 'Poloha vozidla');
    function drawChart() {
        chart.draw(data, options);
    }

    pridajHodnotuDoGrafu = function () {
        data.addRow([v[0].time, radToDegree(v[0].phi), v[0].x] );
        drawChart();
    }
    drawChart();
}



function init() {
    container = document.getElementById("webGL");
    jQueryContainer = jQuery("#webGL");

    scene = new THREE.Scene();
    scene.position.y = -30;


    var SCREEN_WIDTH = jQueryContainer.innerWidth(), SCREEN_HEIGHT = jQueryContainer.innerHeight();
    var VIEW_ANGLE = 60, ASPECT = SCREEN_WIDTH / SCREEN_HEIGHT, NEAR = 0.1, FAR = 20000;
    camera = new THREE.PerspectiveCamera(VIEW_ANGLE, ASPECT, NEAR, FAR);
    camera.position.set(20, 20, 40);
    var pozerajNa = scene.position;
    pozerajNa.y = -10;
    camera.lookAt(pozerajNa);


    renderer = new THREE.WebGLRenderer({ antialias: true, alhpa: false });
    renderer.shadowMapEnabled = true;
    renderer.sortObjects = false;
    renderer.autoClear = false;
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(jQueryContainer.innerWidth(), jQueryContainer.innerHeight());
    renderer.shadowMapType = THREE.PCFSoftShadowMap;


    container.appendChild(renderer.domElement);

    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.rotateSpeed = 1.0;
    controls.zoomSpeed = 5;
    controls.panSpeed = 2;
    controls.enableZoom = true;
    controls.enablePan = true;
    controls.enableDamping = true;
    controls.dampingFactor = 0.3;

    var skyBoxGeometry = new THREE.CubeGeometry(10000, 10000, 10000);
    var skyBoxMaterial = new THREE.MeshBasicMaterial({ color: 0x9999ff, side: THREE.BackSide });
    var skyBox = new THREE.Mesh(skyBoxGeometry, skyBoxMaterial);
    scene.add(skyBox);
    var manager = new THREE.LoadingManager();
   /* manager.onProgress = function (item, loaded, total) {
        console.log(item, loaded, total);
    };*/

    var loader = new THREE.ColladaLoader(manager);
    loader.options.convertUpAxis = true;

    loader.load(baseUrl+'/applications/hok/objects/segway.dae', function (collada) {
        model = collada.scene;
        model.getObjectByName("Segway").rotation.z = degreeToRad(70);
        model.position.setY(1); //oprava polohy aby nebol segway zemou
        scene.add(model);
        render();
        animate();
    }, function (progress) {
        // show some progress
    });


    // Grid

    var size = 400, step = 15;

    var geometry = new THREE.Geometry();
    var material = new THREE.LineBasicMaterial({ color: 0x303030 });

    for (var i = -size; i <= size; i += step) {

        geometry.vertices.push(new THREE.Vector3(-size, -0.04, i));
        geometry.vertices.push(new THREE.Vector3(size, -0.04, i));

        geometry.vertices.push(new THREE.Vector3(i, -0.04, -size));
        geometry.vertices.push(new THREE.Vector3(i, -0.04, size));

    }

    var line = new THREE.LineSegments(geometry, material);
    scene.add(line);

    // Lights
    LightBulb1 = new THREE.Mesh(new THREE.SphereGeometry(0.0001, 0.0001, 0.0001), new THREE.MeshBasicMaterial({ color: 0xffffff })); //neviditelna gulička

    var energy = new THREE.PointLight(0xffffff, 0.5);	//bude svietit
    LightBulb1.add(energy);							//ked ju pripojíme

    LightBulb1.position.setY(50);
    LightBulb2 = LightBulb1.clone();
    LightBulb1.position.setX(20);
    LightBulb1.position.setZ(20);
    LightBulb2.position.setX(-30);
    LightBulb2.position.setZ(-40);
    LightBulb3 = LightBulb1.clone();
    LightBulb3.position.setY(-50);

    scene.add(LightBulb1);
    scene.add(LightBulb2);
    scene.add(LightBulb3);

    stats = new Stats();
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.top = '0px';
    container.appendChild(stats.domElement);

    //

    window.addEventListener('resize', onWindowResize, false);

}

function onWindowResize() {
    camera.aspect = jQueryContainer.innerWidth() / jQueryContainer.innerHeight();
    camera.updateProjectionMatrix();
    renderer.setSize(jQueryContainer.innerWidth(), jQueryContainer.innerHeight());
    renderer.sortObjects = false;
}

//
var fps = 20;//502 / duration;
var now;
var then = Date.now();
var delta;



function animate() {

    requestAnimationFrame(animate);

    now = Date.now();
    delta = now - then;


    if (delta > 1000 / fps) {
        then = now - (delta % (1000 / fps));
        if(dvihaj == true)
        	zdvihniSegway();
        else if(poloz == true){
        	model.getObjectByName("Segway").rotation.z = degreeToRad(70);
        	model.position.x = 0;
        	poloz = false;
        }
        else
        	move();
    }
    onWindowResize();
    render();
    controls.update();
    stats.update();
}

var clock = new THREE.Clock();
var vpred = false;
function move() {
    if(model.getObjectByName("Kotva").rotation.y > degreeToRad(90) ){
		model.getObjectByName("Kotva").rotation.y-=0.048;
	}
	if(v[0] != undefined && v[0].time > duration){
		v = new Array();
		showReset();
		return;
    }
    else if(v[0] != undefined && (v[0].phi > degreeToRad(70) || v[0].phi < degreeToRad(-70))){
        if(model.getObjectByName("Segway").rotation.z >= 0 )
            model.getObjectByName("Segway").rotation.z = degreeToRad(70);
        else
            model.getObjectByName("Segway").rotation.z = degreeToRad(-70);
        model.position.x = v[0].x;
        model.getObjectByName("Koleso1").rotation.y =  v[0].x / 8 * Math.PI *-1;
        model.getObjectByName("Koleso2").rotation.y =  v[0].x / 8 * Math.PI *-1;
        if(graf == true)
            pridajHodnotuDoGrafu();
        v = new Array();
        showReset();
        return;
    }
    else if (v[0] != undefined) {
        console.log(v[0]);
        model.getObjectByName("Segway").rotation.z = v[0].phi;
        model.position.x = v[0].x;
        model.getObjectByName("Koleso1").rotation.y =  v[0].x / 8 * Math.PI *-1;
        model.getObjectByName("Koleso2").rotation.y =  v[0].x / 8 * Math.PI *-1;
        if(graf == true)
            pridajHodnotuDoGrafu();
        if(v.length == 1)
        	showReset();
        v.shift();    
        return;
    }

}

function zdvihniSegway(angle){
    if(model.getObjectByName("Segway").rotation.z > parseFloat($("#angleInput").val())){
    	model.getObjectByName("Segway").rotation.z-=0.008; 
    	model.getObjectByName("Kotva").rotation.y+=0.012;
	}	
	else if(vypocitane == true)
		dvihaj = false;
}

function render() {

    var timer = Date.now() * 10.50005;

    THREE.AnimationHandler.update(clock.getDelta());

    renderer.render(scene, camera);

}