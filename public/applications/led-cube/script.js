
/* global THREE */



var leds = new Array();
var scene;
var camera;
var renderer;
var canvas;
var group;
var mouseDown = false, mouseX = 0, mouseY = 0;
var targetRotationX = 0.28;
var targetRotationY = 0.36;
var targetRotationOnMouseDownX = 0;
var targetRotationOnMouseDownY = 0;
var mouseXOnMouseDown = 0;
var mouseYOnMouseDown = 0;
var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;
var zPosition = 520;
var delay = 0;
var ledTexture;
var opacity = 0.55;
var material;
var blueTexture = THREE.ImageUtils.loadTexture("img/blue.png");
var redTexture = THREE.ImageUtils.loadTexture("img/red.png");
var greenTexture = THREE.ImageUtils.loadTexture("img/green.png");
var tubeTexture = THREE.ImageUtils.loadTexture("img/silver.png");
var tubematerial = new THREE.MeshBasicMaterial({map: tubeTexture});
var editor;
var counter = 0;
var folderPath;
var SCREEN_WIDTH;
var SCREEN_HEIGHT;
var model = "3D";
var responseVideo = "false";

$(window).load(function () {


    // makeFolder(); // vytvorenie priecinka pre uzivatela pre ukladanie frameov pre video
    $.ajax({
        type: "GET",
        headers: {"Cache-Control": "no-store, must-revalidate, max-age=0",
            "Pragma": "no-cache"},
        url: "makeFile.php",
        success: function (response) {
            folderPath = response;
        }
    });

    createThreeJSObjects();
    addEditor();
    addLeds(); //pridanie lediek
    addEdges(); // pridanie hran
    addPodstavec(); // pridanie podstavca
    naplnDemoComboBox();

    $("#jsManual").on("click", function () {
        $("#manualJS").toggle("slow");
    });

    $("#matlabManual").on("click", function () {
        $("#manualMatlab").toggle("slow");
    });

    $("#restartImg").on("click", function () {
        defaultPositions();
        defaultColor();
    });


    $("#pdf_icon_m").on("click", function () {
        PdfFromHTML("m");
    });

    $("#pdf_icon_js").on("click", function () {
        PdfFromHTML("JS");
    });


    $("#loadScript").click(function () {
        $("#fileInput").click();
    });


    $.ajax({
        type: "GET",
        url: "getIfAdmin.php",
        success: function (response) {
            if (response == 0) {
                $('#videoNie').prop('checked', true);
                $('#videoAno').prop('disabled', true);
                $('#videoNie').prop('disabled', true);
                $('#stiahniVideo').prop('disabled', true);
            }
        }
    });

    $("#runButton").click(function () {
        counter = 0;
        if ($("#js").is(':checked')) {
            run(editor.getValue());
        } else {
            runMatlab();
        }
    });


    $("#loadDemoButton").click(function () {
        fileName = $('#demoSelect').val();
        readTextFile(fileName);
    });

    $("input[name='mode']").change(function () {
        naplnDemoComboBox();
        if ($("#js").is(':checked')) {
            editor.getSession().setMode("ace/mode/javascript");
            if ($("#3D").is(':checked')) {
                editor.setValue(get3dJSExample());

            } else {
                editor.setValue(get2dJSExample());
            }
        } else {
            editor.getSession().setMode("ace/mode/matlab");
            if ($("#3D").is(':checked')) {
                editor.setValue(get3dMatlabExample());
            } else {
                editor.setValue(get2dMatlabExample());

            }
        }

    });

    $("input[name='model']").change(function () {
        $("input[name='mode']").change();
        if ($("#3D").is(':checked')) {
            scene.remove(group);
            group = new THREE.Object3D(); //root element
            group.position.set(0, 60, 0);
            addLeds(); //pridanie lediek
            addEdges(); // pridanie hran
            addPodstavec(); // pridanie podstavca
            camera.position.z = zPosition;
            targetRotationX = 0.28;
            targetRotationY = 0.36;
            model = "3D";
            render();

        } else {
            scene.remove(group);
            group = new THREE.Object3D(); //root element
            group.position.set(0, 60, 0);
            addLeds2D();
            addEdges2D();
            addPodstavec2D();
            camera.position.z = 438;
            targetRotationX = 0;
            targetRotationY = 0;
            model = "2D";
            render();
        }

    });

    canvas.addEventListener('mousedown', onDocumentMouseDown, false);
    canvas.addEventListener('mousewheel', mousewheel, false); //    // Internet Explorer, Opera, Google Chrome and Safari
    canvas.addEventListener('DOMMouseScroll', mousewheel, false); //Firefox
    $("#fileInput").change(loadFileAsText);
    group.position.set(0, 60, 0);
    mouseDown = true;
    animate();

});

function naplnDemoComboBox() {

    demoFolder = "";
    folders = new Array();
    if ($("#js").is(':checked')) {
        if ($("#3D").is(':checked')) {
            demoFolder = "demos/JS/3D";
        } else {
            demoFolder = "demos/JS/2D";
        }
    } else {
        if ($("#3D").is(':checked')) {
            demoFolder = "demos/Matlab/3D";
        } else {
            demoFolder = "demos/Matlab/2D";
        }
    }

    $.ajax({
        type: "POST",
        url: "getFiles.php",
        data: {path: demoFolder},
        success: function (response) {
            $('#demoSelect').html(" ");
            response = response.slice(0, -1);
            folders = response.split("*");
            for (i = 0; i < folders.length; i++) {
                name = folders[i].split("/")[3];

                $('#demoSelect')
                        .append($("<option></option>")
                                .attr("value", folders[i])
                                .text(name));
            }

        }
    });

}


$(window).resize(function () {
    SCREEN_WIDTH = $("#kocka").width();
    SCREEN_HEIGHT = $("#kocka").height();

    camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
    camera.updateProjectionMatrix();
    renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);

    animate();
});


//pre fierfox
$(window).on('unload', function () {
    $.ajax({
        type: "POST",
        url: "deleteFolder.php",
        data: {path: folderPath},
        success: function (response) {
        }
    });
});

////pre chrome
$(window).on('beforeunload', function () {
    $.ajax({
        type: "POST",
        url: "deleteFolder.php",
        data: {path: folderPath},
        success: function (response) {
        }
    });
});

function createThreeJSObjects() {
    SCREEN_WIDTH = window.innerWidth / 2;
    SCREEN_HEIGHT = window.innerHeight / 2;
    scene = new THREE.Scene();
    ///nastavenie kamery
    camera = new THREE.PerspectiveCamera(60, (SCREEN_WIDTH) / (SCREEN_HEIGHT), 0.1, 20000); //VIEW_ANGLE, ASPECT, maxNEAR, max FAR
    camera.position.z = zPosition;
    camera.position.y = 20;
    scene.add(camera);
    //okno na vykreslenie///////
    renderer = new THREE.WebGLRenderer({alpha: true, antialias: true, logarithmicDepthBuffer: true});
    renderer.setClearColor(0x011839, 1); /// farba cierna
    renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
    canvas = renderer.domElement;
    canvas.id = "myCanvas";
    canvas.getContext("experimental-webgl", {preserveDrawingBuffer: true});

    document.getElementById("kocka").appendChild(canvas);
    group = new THREE.Object3D(); //root element
}


function addEditor() {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/javascript");
    editor.getSession().setUseWorker(false); // vypnutie syntax checkera
}


//////////////////////////////////////2D Stvorec////////////////////////////////////////
function addLeds2D() {
    material = new THREE.MeshBasicMaterial({map: ledTexture, transparent: true, opacity: opacity});
    material.depthWrite = false;
    material.needUpdate = true;
    var spheregeometry = new THREE.SphereGeometry(3, 32, 32, 0, 6.3, 0, 1.745); // poloemern,high,width,phi start, phi length, ...mimo cyklus aby nezatazovalo pamet
    var cylindergeometry = new THREE.CylinderGeometry(3, 3, 7, 64, 1, true); // top radius, bottom radius, height, radius segment
    var cylindergeometry2 = new THREE.CylinderGeometry(4, 4, 1, 64, false);
    var sphere = new THREE.Mesh(spheregeometry, material);
    for (x = 0; x < 8; x++)
    {
        leds[x] = new Array();
        for (y = 0; y < 8; y++)
        {
            var ledGroup = new THREE.Object3D();
            var sphere = new THREE.Mesh(spheregeometry, material.clone());
            sphere.position.set(0, 4, 0);
            ledGroup.add(sphere);
            var cylinder = new THREE.Mesh(cylindergeometry, material.clone());
            cylinder = cylinder.clone();
            cylinder.position.set(0, 0, 0);
            ledGroup.add(cylinder);
            var cylinder2 = new THREE.Mesh(cylindergeometry2, material.clone());
            cylinder2 = cylinder2.clone();
            cylinder2.position.set(0, -3, 0);
            ledGroup.add(cylinder2);
            ledGroup.position.set(-100 + x * 30, -100 + y * 30, 160);
            ledGroup.isOn = false;
            leds[x][y] = ledGroup;
            group.add(ledGroup);
        }
    }
    scene.add(group); // pridanie root elementu
}

function addEdges2D() {
    for (x = 0; x < 8; x++)
    {
        addEdge(leds[0][x].position, leds[7][x].position);
        addEdge(leds[x][0].position, leds[x][7].position);
    }
}

function addPodstavec2D() {
    var box = new THREE.Object3D();
    var boxGeometry = new THREE.BoxGeometry(400, 150, 150);
    var boxMaterial = new THREE.MeshBasicMaterial({color: 0x00});
    var cube = new THREE.Mesh(boxGeometry, boxMaterial);
    box.add(cube);
    box.position.set(5, -180, 150);
    group.add(box);

}



////////////////////3D kocka////////////////////////////
function addLeds() {
    ledTexture = THREE.ImageUtils.loadTexture("img/led.png");
    ledTexture.minFilter = THREE.NearestFilter;
    material = new THREE.MeshBasicMaterial({map: ledTexture, transparent: true, opacity: opacity});
    material.depthWrite = false;
    material.needUpdate = true;
    var spheregeometry = new THREE.SphereGeometry(3, 32, 32, 0, 6.3, 0, 1.745); // poloemern,high,width,phi start, phi length, ...mimo cyklus aby nezatazovalo pamet
    var cylindergeometry = new THREE.CylinderGeometry(3, 3, 7, 64, 1, true); // top radius, bottom radius, height, radius segment
    var cylindergeometry2 = new THREE.CylinderGeometry(4, 4, 1, 64, false);
    var sphere = new THREE.Mesh(spheregeometry, material);
    for (x = 0; x < 8; x++)
    {
        leds[x] = new Array();
        for (y = 0; y < 8; y++)
        {
            leds[x][y] = new Array();
            for (z = 0; z < 8; z++)
            {
                var ledGroup = new THREE.Object3D();
                var sphere = new THREE.Mesh(spheregeometry, material.clone());
                sphere.position.set(0, 4, 0);
                ledGroup.add(sphere);
                var cylinder = new THREE.Mesh(cylindergeometry, material.clone());
                cylinder = cylinder.clone();
                cylinder.position.set(0, 0, 0);
                ledGroup.add(cylinder);
                var cylinder2 = new THREE.Mesh(cylindergeometry2, material.clone());
                cylinder2 = cylinder2.clone();
                cylinder2.position.set(0, -3, 0);
                ledGroup.add(cylinder2);
                ledGroup.position.set(-100 + x * 30, -100 + y * 30, 120 - z * 30);
                ledGroup.isOn = false;
                leds[x][y][z] = ledGroup;
                group.add(ledGroup);
            }
        }
    }
    scene.add(group); // pridanie root elementu
    render();
}

////pridanie hran//////////
function addEdges() {
    for (x = 0; x < 8; x++)
    {
        for (y = 0; y < 8; y++)
        {
            addEdge(leds[0][x][y].position, leds[7][x][y].position);
            // addEdge(leds[x][0][y].position, leds[x][7][y].position);
            addEdge(leds[x][y][0].position, leds[x][y][7].position);
            addEdge(leds[x][0][0].position, leds[x][7][0].position);
            addEdge(leds[x][0][7].position, leds[x][7][7].position);
            addEdge(leds[0][0][x].position, leds[0][7][x].position);
            addEdge(leds[7][0][x].position, leds[7][7][x].position);
        }
    }
    render();
}

function addEdge(pos1, pos2) {
    tubeTexture.minFilter = THREE.NearestFilter;
    path = new THREE.CatmullRomCurve3([
        new THREE.Vector3(pos1.x, pos1.y - 3, pos1.z), // odpocitane 3 aby islo zo spodu led
        new THREE.Vector3(pos2.x, pos2.y - 3, pos2.z)
    ]);
    tubegeometry = new THREE.TubeGeometry(path, 1, 0.4, 20);
    grid = new THREE.Mesh(tubegeometry, tubematerial);
    group.add(grid);
}

function addPodstavec() {
    var box = new THREE.Object3D();

    ledTexture = THREE.ImageUtils.loadTexture("img/silver.png");
    ledTexture.minFilter = THREE.NearestFilter;
    blueTexture2 = THREE.ImageUtils.loadTexture("img/blue2.png");
    blueTexture.minFilter = THREE.NearestFilter;
    var boxGeometry = new THREE.BoxGeometry(400, 150, 400);
    var boxMaterial = new THREE.MeshBasicMaterial({color: 0x00});
    var cube = new THREE.Mesh(boxGeometry, boxMaterial);
    box.add(cube);
////////sruby
    var geometry = new THREE.CylinderGeometry(3.5, 5, 2, 64);
    var material = new THREE.MeshBasicMaterial({map: ledTexture});
    var cylinder = new THREE.Mesh(geometry, material);
///predna strana///////////
    for (x = 0; x < 4; x++) {
        cylinder.rotation.x = -80;
        cylinder.position.set(-190 + 127 * x, 65, 200);
        box.add(cylinder.clone());
        cylinder.position.set(-190 + 127 * x, -65, 200);
        box.add(cylinder.clone());
    }
    cylinder.position.set(-190, 0, 200);
    box.add(cylinder.clone());
    cylinder.position.set(190, 0, 200);
    box.add(cylinder.clone());
////////////////////////////////
///zadna strana///////////
    cylinder.rotation.x = 80;
    for (x = 0; x < 4; x++) {
        cylinder.position.set(-190 + 127 * x, 65, -200);
        box.add(cylinder.clone());
        cylinder.position.set(-190 + 127 * x, -65, -200);
        box.add(cylinder.clone());
    }
    cylinder.position.set(-190, 0, -200);
    box.add(cylinder.clone());
    cylinder.position.set(190, 0, -200);
    box.add(cylinder.clone());
////////////////////////////////
///horna strana///////////
    cylinder.rotation.x = 0;
    for (x = 0; x < 4; x++) {
        cylinder.position.set(-190 + 127 * x, 75, -190);
        box.add(cylinder.clone());
        cylinder.position.set(-190 + 127 * x, 75, 190);
        box.add(cylinder.clone());
    }
    cylinder.position.set(-190, 75, 0);
    box.add(cylinder.clone());
    cylinder.position.set(190, 75, 0);
    box.add(cylinder.clone());
////////////////////////////////
///dolna strana///////////
    cylinder.rotation.x = 160;
    for (x = 0; x < 4; x++) {
        cylinder.position.set(-190 + 127 * x, -75, -190);
        box.add(cylinder.clone());
        cylinder.position.set(-190 + 127 * x, -75, 190);
        box.add(cylinder.clone());
    }
    cylinder.position.set(-190, -75, 0);
    box.add(cylinder.clone());
    cylinder.position.set(190, -75, 0);
    box.add(cylinder.clone());
////////////////////////////////
///lava strana///////////
    cylinder.rotation.z = -80;
    for (x = 0; x < 4; x++) {
        cylinder.position.set(-200, 65, -190 + 127 * x);
        box.add(cylinder.clone());
        cylinder.position.set(-200, -65, -190 + 127 * x);
        box.add(cylinder.clone());
    }
    cylinder.position.set(-200, 0, -190);
    box.add(cylinder.clone());
    cylinder.position.set(-200, 0, 190);
    box.add(cylinder.clone());
////////////////////////////////
///prava strana///////////
    cylinder.rotation.z = 80;
    for (x = 0; x < 4; x++) {
        cylinder.position.set(200, 65, -190 + 127 * x);
        box.add(cylinder.clone());
        cylinder.position.set(200, -65, -190 + 127 * x);
        box.add(cylinder.clone());
    }

    cylinder.position.set(200, 0, -190);
    box.add(cylinder.clone());
    cylinder.position.set(200, 0, 190);
    box.add(cylinder.clone());
////////////////////////////////
////////Text//////////
    var data = {
        text: "LED",
        size: 40,
        height: 2,
        curveSegments: 100,
        font: "helvetiker",
        weight: "regular",
        bevelEnabled: false,
        bevelThickness: 0.1,
        bevelSize: 0.1
    };
    var loader = new THREE.FontLoader();
    loader.load('fonts/helvetiker_regular.typeface.js', function (font) {
        var geometry = new THREE.TextGeometry(data.text, {
            font: font,
            //  weight: "bold",
            size: data.size,
            height: data.height,
            curveSegments: data.curveSegments,
            bevelEnabled: data.bevelEnabled,
            bevelThickness: data.bevelThickness,
            bevelSize: data.bevelSize
        });
        var material = new THREE.MeshBasicMaterial({map: blueTexture2});
        var textGeo = new THREE.Mesh(geometry, material);
        textGeo.position.set(-140, -10, 200);
        box.add(textGeo);
    });
    loader.load('fonts/helvetiker_regular.typeface.js', function (font) {
        var geometry = new THREE.TextGeometry("cube", {
            font: font,
            //  weight: "bold",
            size: 30,
            height: data.height,
            curveSegments: data.curveSegments,
            bevelEnabled: data.bevelEnabled,
            bevelThickness: data.bevelThickness,
            bevelSize: data.bevelSize
        });
        var material = new THREE.MeshBasicMaterial({map: blueTexture2});
        var textGeo = new THREE.Mesh(geometry, material);
        textGeo.position.set(45, -10, 200);
        box.add(textGeo);
        var cubeTexture = THREE.ImageUtils.loadTexture("img/cubeimg.PNG");
        cubeTexture.minFilter = THREE.NearestFilter;
        var material = new THREE.MeshBasicMaterial({map: cubeTexture});
        var geometry = new THREE.PlaneGeometry(50, 50, 1, 1);
        var plane = new THREE.Mesh(geometry, material);
        plane.position.set(0, -170, 220);
        group.add(plane);
        box.position.set(5, -180, 15);
        group.add(box);
    });
    render();
}

///////////////////////////////////////////////////////////////////////////////////////////////////

function animate() {

    id = requestAnimationFrame(animate);
    if (!mouseDown) {
        cancelAnimationFrame(id);
    }
    render();
}

function render() {
//horizontal
    group.rotation.y += (targetRotationX - group.rotation.y) * 0.1;
    //vertical 
    finalRotationY = (targetRotationY - group.rotation.x);
    group.rotation.x += finalRotationY * 0.1;
    renderer.render(scene, camera);
}



/////////////////////rozsvietenie///////////////
function on() {
    var object;
    if (arguments.length === 1) {
        object = arguments[0];
    } else
    {
        var inputArr = new Array();
        inputindex = 0;
        for (inputindex = 0; inputindex < arguments.length; inputindex++) {
            inputArr[inputindex] = arguments[inputindex];
        }
        object = createObject(inputArr.slice(0));
    }
    if (object.start !== null) {
        delay += object.start * 1000;
    }
    setTimeout(function () {
        finallOn(object);
    }, delay);


}

function finallOn(input) {

    var x = makeArray(input.x); //makeArray(input[0]);
    var y = makeArray(input.y); //makeArray(input[1]);
    if ($("#3D").is(':checked')) {
        var z = makeArray(input.z); //makeArray(input[2]);
    }

    if (input.color !== null) {
        currentMaterial = setColor(input.color);
    } else {
        currentMaterial = setColor("b");
    }

    currentMaterial.minFilter = THREE.NearestFilter;
    try {
        if ($("#3D").is(':checked')) {
            for (c1 = 0; c1 < x.length; c1++) {
                for (c2 = 0; c2 < y.length; c2++) {
                    for (c3 = 0; c3 < z.length; c3++) {
                        for (xy = 0; xy < 3; xy++) {
                            leds[x[c1] - 1][y[c2] - 1][z[c3] - 1].children[xy].material.map = currentMaterial;
                            leds[x[c1] - 1][y[c2] - 1][z[c3] - 1].children[xy].material.opacity = 1;
                            leds[x[c1] - 1][y[c2] - 1][z[c3] - 1].isOn = true;
                        }
                    }
                }
            }
        } else {
            for (c1 = 0; c1 < x.length; c1++) {
                for (c2 = 0; c2 < y.length; c2++) {
                    for (xy = 0; xy < 3; xy++) {
                        leds[x[c1] - 1][y[c2] - 1].children[xy].material.map = currentMaterial;
                        leds[x[c1] - 1][y[c2] - 1].children[xy].material.opacity = 1;
                        leds[x[c1] - 1][y[c2] - 1].isOn = true;
                    }
                }
            }

        }
        if (input.stop !== null || input.stop === 0) {
            setTimeout(function () {
                finallOff(input);
            }, input.stop * 1000);
        }
    } catch (err) {
        alert("chyba pri rozsviecovani - Skontroluj si pozície");
    }
    render();
}
//////////////////////////////////////////////////////////////
//////////////////////////zhasnutie///////////////////
function off() {

    var object;
    if (arguments.length === 1) {
        object = arguments[0];
    } else
    {
        var inputArr = new Array();
        inputindex = 0;
        for (inputindex = 0; inputindex < arguments.length; inputindex++) {
            inputArr[inputindex] = arguments[inputindex];
        }
        if ($("#3D").is(':checked')) {
            x = inputArr[0];
            y = inputArr[1];
            z = inputArr[2];

            ((inputArr.length === 4) ? start = inputArr[3] : start = null);
            object = {x: x, y: y, z: z, start: start};
        } else {
            x = inputArr[0];
            y = inputArr[1];

            ((inputArr.length === 3) ? start = inputArr[2] : start = null);
            object = {x: x, y: y, start: start};
        }
    }

    if (object.start !== null) {
        delay += object.start * 1000;
    }
    setTimeout(function () {
        finallOff(object);
    }, delay);

}

function finallOff(input) {
    x = makeArray(input.x);
    y = makeArray(input.y);
    if ($("#3D").is(':checked')) {
        z = makeArray(input.z);
    }
    try {
        if ($("#3D").is(':checked')) {
            for (c1 = 0; c1 < x.length; c1++) {
                for (c2 = 0; c2 < y.length; c2++) {
                    for (c3 = 0; c3 < z.length; c3++) {
                        for (xy = 0; xy < 3; xy++) {
                            leds[x[c1] - 1][y[c2] - 1][z[c3] - 1].children[xy].material.map = ledTexture;
                            leds[x[c1] - 1][y[c2] - 1][z[c3] - 1].children[xy].material.opacity = opacity;
                            leds[x[c1] - 1][y[c2] - 1][z[c3] - 1].isOn = false;
                        }
                    }
                }
            }
        } else {

            for (c1 = 0; c1 < x.length; c1++) {
                for (c2 = 0; c2 < y.length; c2++) {
                    for (xy = 0; xy < 3; xy++) {
                        leds[x[c1] - 1][y[c2] - 1].children[xy].material.map = ledTexture;
                        leds[x[c1] - 1][y[c2] - 1].children[xy].material.opacity = opacity;
                        leds[x[c1] - 1][y[c2] - 1].isOn = false;
                    }
                }
            }

        }
    } catch (e) {
        alert("chyba pri zhasínaní - Skontroluj si pozície");
    }
    render();
}

////////////////////////////////////////////////////////////
function createObject(input)
{
    stopTime = null;
    start = null;
    color = null;

    if ($("#3D").is(':checked')) {
        if (input.length === 4) {
            if (typeof (input[3]) == "string") {
                color = input[3];
            } else {
                stopTime = input[3];
            }
        } else if (input.length == 5) {
            if ((typeof (input[3]) == "string") && (input[3] == "r" || input[3] == "b" || input[3] == "g")) {
                color = input[3];
                stopTime = input[4];
            } else if (typeof (input[3]) == "string") {
                start = input[4];
            } else if (typeof (input[3]) == "number") {
                stopTime = input[3];
                start = input[4];
            }
        } else if (input.length === 6) {
            color = input[3];
            start = input[5];
            if (typeof (input[4]) == "number") {
                stopTime = input[4];
            }
        }
        return {x: input[0], y: input[1], z: input[2], color: color, start: start, stop: stopTime};
    } else {
        if (input.length === 3) {
            if (typeof (input[2]) == "string") {
                color = input[2];
            } else {
                stopTime = input[2];
            }
        } else if (input.length === 4) {
            if ((typeof (input[2]) == "string") && (input[2] == "r" || input[2] == "b" || input[2] == "g")) {
                color = input[2];
                stopTime = input[3];
            } else if (typeof (input[2]) == "string") {
                start = input[3];
            } else if (typeof (input[2]) == "number") {
                stopTime = input[2];
                start = input[3];
            }
        } else if (input.length === 5) {
            color = input[2];
            start = input[4];
            if (typeof (input[3]) == "number") {
                stopTime = input[3];
            }
        }
        return {x: input[0], y: input[1], color: color, start: start, stop: stopTime};
    }
}

function makeArray(input) {
    var arr = new Array();
    if ((typeof input) == "number") {
        if (input == 0) {
            for (position = 1; position <= 8; position++) {
                arr.push(position);
            }
        } else {
            arr.push(input);
        }
    } else if ((typeof input) == "object") {
        return input;
    } else if ((typeof input) == "string") {
        interval = input.split("-");
        for (start = parseInt(interval[0]); start <= parseInt(interval[1]); start++) {
            arr.push(start);
        }
    }
    return arr;
}

function setColor(clr) {
    if (clr == "r") {
        return redTexture;
    } else if (clr == "b") {
        return blueTexture;
    } else {
        return greenTexture;
    }
}



function run(text)
{
    $("#errVideo").text("");
    deleteFrames(1);

    if (controll()) {
        delay = 0;
        text = repairTextJS(text);
        if ($("#videoAno").is(':checked')) {
            text += "\n\ setTimeout(function () {clearInterval(myInterval); makeVideo();}, delay+300); ";
        }
        ;
        try {
            eval(text);
            if ($("#videoAno").is(':checked')) {
                var myInterval = setInterval(function () {
                    render();
                    createScreen();
                }, 310);
            }
        } catch (err) {
            alert("nerozpoznany prikaz v scripte>>>" + err.message);
        }
    } else {
        alert("nepovoleny script");
    }
}

function repairTextJS(text) {
    for (ind = 0; ind < text.length; ind++) {
        if (text.charAt(ind) == ":") {
            index = ind;
            if (!isNaN(text.charAt(index - 1)))
            {
                text = text.replaceAt(index, "-");
                text = text.splice(index - 1, "'");
                text = text.splice(index + 3, "'");
                ind = ind + 2;
            }
        }
    }
    return text;
}


function runMatlab() {
    text = editor.getValue();

    $.ajax({
        type: "GET",
        url: "octavePhp.php",
        data: {scriptText: text, model: model, file: folderPath},
        success: function (response) {
            //alert(response);
            response = repairMatlabResponse(response);
            run(response);
        }
    });
}


function repairMatlabResponse(response) {
    while (response.indexOf("-1") != -1 || response.indexOf("ans =") != -1) {
        response = response.replace("-1", "''");
        response = response.replace("ans =", "");
    }
    if ($("#3D").is(':checked')) {
        countOfComma = 2;
    } else {
        countOfComma = 1;
    }
    for (ind = 0; ind < response.length; ind++) {
        if (response.charAt(ind) == "(") {
            index = ind;
            response = response.splice(index + 1, "[");
            ind++;
            nmOfComma = 0;
            while (nmOfComma != countOfComma + 1)
            {
                if (response.charAt(ind) == ",") {
                    if (nmOfComma < countOfComma) {
                        response = response.splice(ind, "]");
                        ind++;
                        response = response.splice(ind + 1, "[");
                        ind++;

                    } else if (nmOfComma == countOfComma) {
                        response = response.splice(ind, "]");
                        ind++;
                    }
                    nmOfComma++;
                }
                if (response.charAt(ind) == ")") {
                    response = response.splice(ind, "]");
                    ind++;
                    nmOfComma++;
                }
                ind++;
            }
        }
    }
    for (ind = 0; ind < response.length; ind++) {
        if (response.charAt(ind) == "[") {
            while (response.charAt(ind) != "]") {
                if (response.charAt(ind) == " ") {
                    response = response.replaceAt(ind, ",");
                    ind++;
                }
                ind++;
            }
        }
    }
    return response;
}

function createScreen() {
    if ($("#videoAno").is(':checked')) {
        myCanvas = $("#myCanvas")[0];
        picture = myCanvas.toDataURL();
        console.log(picture);
        $.ajax({
            type: "POST",
            url: "saveScreen.php",
            data: 'data=' + encodeURIComponent(picture) + '&i=' + counter++ +
                    '&path=' + folderPath,
            success: function (response) {
                if (response == "stop") {
                    $("#errVideo").text("bol odoslanych max pocet obrazkov - video nebude kompletne");
                }

            }
        });
    }


}

function saveVideo() {

    try {
        if (responseVideo.indexOf("true") == -1) {
            throw "exception";
        }
        var save = document.createElement('a');
        save.href = "frames/" + folderPath + "/output.mp4";
        save.download = 'output.mp4' || url;
        var event = document.createEvent("MouseEvents");
        event.initMouseEvent(
                "click", true, false, window, 0, 0, 0, 0, 0
                , false, false, false, false, 0, null
                );
        save.dispatchEvent(event);
    } catch (FileNotFoundException) {
        alert("video neexistuje alebo je poskodene");
    }
}


function makeVideo() {
    if ($("#videoAno").is(':checked')) {
        $.ajax({
            type: "POST",
            url: "makeVideo.php",
            data: {path: folderPath},
            success: function (response) {
                responseVideo = response;
                deleteFrames(0);
            }
        });
    }
}

function deleteFrames(deleteVideo) {
    $.ajax({
        type: "POST",
        url: "deleteFrames.php",
        data: 'path=' + folderPath + '&deleteVideo=' + deleteVideo,
        success: function (response) {

        }
    });

}


function controll() {
    s = editor.getValue();
    if (s.indexOf("leds") != -1 || s.indexOf("xz") != -1 || s.indexOf("zx") != -1 || s.indexOf("timeOut") != -1) {
        return false;
    }
    return true;
}

function defaultPositions() {
    camera.position.z = 520;
    zPosition = 520;
    camera.updateProjectionMatrix();
    if ($("#3D").is(':checked')) {
        group.rotation.x = 0.27818812760985956;
        group.rotation.y = 0.359801403079834;
        targetRotationX = 0.28;
        targetRotationY = 0.36;
    } else {
        group.rotation.x = 0;
        group.rotation.y = 0;
        targetRotationX = 0;
        targetRotationY = 0;
    }
    render();
}

function defaultColor() {
    if ($("#3D").is(':checked')) {
        for (x = 0; x < 8; x++)
        {
            for (y = 0; y < 8; y++)
            {
                for (z = 0; z < 8; z++)
                {
                    for (i = 0; i < 3; i++)
                    {
                        leds[x][y][z].children[i].material.map = ledTexture;
                        leds[x][y][z].children[i].material.opacity = opacity;
                    }
                }
            }
        }
    } else {
        for (x = 0; x < 8; x++)
        {
            for (y = 0; y < 8; y++)
            {
                for (i = 0; i < 3; i++)
                {
                    leds[x][y].children[i].material.map = ledTexture;
                    leds[x][y].children[i].material.opacity = opacity;
                }
            }
        }
    }
    render();
}

function stop() {
    throw "error";
}


function download()
{
    var textFileAsBlob = new Blob([editor.getValue()], {type: 'text/plain'});
    var downloadLink = document.createElement("a");

    if ($("#js").is(':checked')) {
        downloadLink.download = "script.js";
    } else {
        downloadLink.download = "script.m";

    }
    if (window.webkitURL != null)
    {
        // Chrome allows the link to be clicked
        // without actually adding it to the DOM.
        downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
    }
    else
    {
        // Firefox requires the link to be added to the DOM
        // before it can be clicked.
        downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
        downloadLink.onclick = destroyClickedElement;
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
    }
    downloadLink.click();
}


function PdfFromHTML(input) {

    if (input == "JS") {
        var doc = new jsPDF('l', 'mm', [$('#manualJS').width() * 0.2645833, $('#manualJS').height() * 0.2645833]);
        $('#manualJS').css("color", "black");
        $('#manualJS').css("background", "white");
        doc.addHTML($('#manualJS')[0], {
        }, function () {
            doc.save('JS_MANUAL.pdf');
        });
        $('#manualJS').css("color", "white");
        $('#manualJS').css("background", "rgba(0, 0, 0, 0.8)");
    } else {
        var doc = new jsPDF('l', 'mm', [$('#manualMatlab').width() * 0.2645833, $('#manualMatlab').height() * 0.2645833]);
        $('#manualMatlab').css("color", "black");
        $('#manualMatlab').css("background", "white");
        doc.addHTML($('#manualMatlab')[0], {
        }, function () {
            doc.save('MATLAB_MANUAL.pdf');
        });
        $('#manualMatlab').css("color", "white");
        $('#manualMatlab').css("background", "rgba(0, 0, 0, 0.8)");

    }
}

function destroyClickedElement(event)
{
    document.body.removeChild(event.target);
}

function loadFileAsText()
{
    var fileToLoad = document.getElementById("fileInput").files[0];
    var fileReader = new FileReader();
    nameOfFile = fileToLoad.name.split(".");
    if (nameOfFile[1] == 'm') {
        $('#matlab').prop('checked', true);
    } else if (nameOfFile[1] == "js") {
        $('#js').prop('checked', true);
    }
    fileReader.onload = function (fileLoadedEvent)
    {
        var textFromFileLoaded = fileLoadedEvent.target.result;
        editor.setValue(textFromFileLoaded);
    };
    fileReader.readAsText(fileToLoad, "UTF-8");
}


function readTextFile(nameOfFile) {
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", nameOfFile, false);
    rawFile.onreadystatechange = function ()
    {
        if (rawFile.readyState === 4)
        {
            if (rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                editor.setValue(allText);
            }
        }
    };
    rawFile.send(null);
}

///////////////////////events/////////////////////////////
function onDocumentMouseDown(event) {
    mouseDown = true;
    event.preventDefault();
    canvas.addEventListener('mousemove', onDocumentMouseMove, false);
    canvas.addEventListener('mouseup', onDocumentMouseUp, false);
    mouseXOnMouseDown = event.clientX - windowHalfX;
    targetRotationOnMouseDownX = targetRotationX;
    mouseYOnMouseDown = event.clientY - windowHalfY;
    targetRotationOnMouseDownY = targetRotationY;
    animate(); //koli prerusovaniu cyklu

}

function onDocumentMouseMove(event) {

    mouseX = event.clientX - windowHalfX;
    mouseY = event.clientY - windowHalfY;
    targetRotationY = targetRotationOnMouseDownY + (mouseY - mouseYOnMouseDown) * 0.02;
    targetRotationX = targetRotationOnMouseDownX + (mouseX - mouseXOnMouseDown) * 0.02;
    //render();
}


function onDocumentMouseUp(event) {
    mouseDown = false;
    canvas.removeEventListener('mousemove', onDocumentMouseMove, false);
    canvas.removeEventListener('mouseup', onDocumentMouseUp, false);
}

function mousewheel(event) {

    if ('wheelDelta' in event) {
        zPosition -= event.wheelDelta / 4; //event.wheelData 120 ak hore -120 ak dole
        camera.position.z = zPosition;
    }
    else {  // Firefox
        zPosition -= event.detail; //detail vracia 3
        camera.position.z = zPosition;
    }
    render(); //
}

/////na pridanie substringu
String.prototype.splice = function (idx, s) {
    return (this.slice(0, idx) + s + this.slice(idx, this.length));
};
String.prototype.replaceAt = function (index, character) {
    return this.substr(0, index) + character + this.substr(index + character.length);
}


function get3dJSExample() {
    return "on({x: 3:5, z:1, y:[3,4,5], start: 2, color:'r', stop: 2 }); \n\
on(1,1,1);\n\
on(5,5,5,'r');\n\
on(1:5,1:5,1,'',2); // rozsvieti sa po 2 sekundach po predchadzajucej\n\
on([2,4,8],8,1,3);// po 3 sekundach sa dane ledky zhasnu\n\
on(8,8,8,'r',2,3);// rozsvieti sa na cerveno 3sek po predchadzajucej a o 2sek sa zhasne\n\
off({x: 1, y:1, z:1 }); //zhasnutie\n\
off(5,5,5); //zhasnutie\n\
off(1:5,1:5,1,2); // dane ledky sa zhasnu 2 sek po predchadzajucej funkcii ";
}

function get2dJSExample() {
    return "on({x: 3:5, z:1, start: 2, color:'r', stop: 2 }); \n\
on(1,1);\n\
on(5,5,'r');\n\
on(1:5,1:5,'',2); // rozsvieti sa po 2 sekundach po predchadzajucej\n\
on([2,4,8],8,3);// po 3 sekundach sa dane ledky zhasnu\n\
on(8,8,'r',2,3);// rozsvieti sa na cerveno 3sek po predchadzajucej a o 2sek sa zhasne\n\
off({x: 1, y:1 }); //zhasnutie\n\
off(5,5); //zhasnutie\n\
off(1:5,1:5,2); // dane ledky sa zhasnu 2 sek po predchadzajucej funkcii ";
}

function get3dMatlabExample() {
    return "on(1,1,1);\n\
on(3,4,5,'r');\n\
on(4:7,4:7,1,' ',2); %rozsviesti sa po 2 sekundach\n\
on([2,4,8],8,1,3); %po 3 sekundach sa zhasne\n\
on(8,8,8,'r',2,3); %rozsvieti sa po 2 a zhasne po 3 sekundach\n\
off(5,5,5); %zhasnutie;\n\
off(1:5,[1,3,5],1,2); %vykona sa po 2 sekundach";
}

function get2dMatlabExample() {
    return "on(1,1);\n\
on(3,4,'r');\n\
on(4:7,4:7,' ',2); %rozsviesti sa po 2 sekundach\n\
on([2,4,8],8,3); %po 3 sekundach sa zhasne\n\
on(8,8,'r',2,3); %rozsvieti sa po 2 a zhasne po 3 sekundach\n\
off(5,5); %zhasnutie;\n\
off(1:5,[1,3,5],2); %vykona sa po 2 sekundach";
}