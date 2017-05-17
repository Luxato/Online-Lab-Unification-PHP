<script>
    var path = "<?= $path ?>";
</script>
  <script src="<?= $path ?>kniznice/three.js"></script>
  <script src="<?= $path ?>kniznice/TrackballControls.js"></script>
  <script src="<?= $path ?>kniznice/OrbitControls.js"></script>
  <script src="<?= $path ?>kniznice/OBJLoader.js"></script>
  <script src="<?= $path ?>kniznice/Detector.js"></script>
  <script src="<?= $path ?>kniznice/MTLLoader.js"></script>
  <script src="<?= $path ?>kniznice/OBJMTLLoader.js"></script>
  <script src="<?= $path ?>kniznice/ImageUtils.js"></script>
  <script src="<?= $path ?>kniznice/jquery.min.js"></script>
  <script src="<?= $path ?>kniznice/jquery.flot.js"></script>
   <script src="<?= $path ?>kniznice/FresnelShader.js"></script>

	<style>
	#container{
		height:500px !important;
		visibility:visible;
		z-index:-2;
	}

	#myForm{
		position:absolute;
		top:30px;
		left:1000px;
	}

	#vys{
		z-index:1;
		display:block;
		}

	#vys p{
		margin:auto;
		padding:2px;
		}

	#volba{
		position:relative;
		left:170px;
		}

	#riadeny{
		position:absolute;
		}

	label.field{
		text-align: left;
		width: 200px;
		float: left;
	}

	button{
		margin:5px;
	}

	#testovacie_pole{
		z-index:1;
		position:fixed;
		top:400px;
		left:100px;
		color:white;
		}

	#pid{
		display:none;
		}

	#nonpid{
		display:none;
		}

	.check_selector:not(:checked) ~ #nonpid{
		display:block;
		}

	.check_selector:checked ~ #pid{
		display:block;
		}

	#placeholder{
		width:400px;
		height:200px;
		position:absolute;
		/*bottom:20px;
		left:50px;*/
        right: 0;
		z-index:3
	}
	canvas {
        margin: 0 auto;
        display: block;
        background: rgba(0,0,0,0.05);
        padding: 6px;
        border-radius: 55px;
    }

	</style>
  <script>


    // This is where our model viewer code goes.
	//var container;
	var camera,CubeCamera, scene, renderer;
	var mouseX = 0, mouseY = 0;
	var dimx=window.innerWidth /2;
	var dimy=window.innerHeight / 2;

	var windowHalfX = window.innerWidth / 2;
	var windowHalfY = window.innerHeight / 2;
	var korekcia_vysky=-0.8;
	var valec_3;
	var tiene=false;
	var valec_1=null;
	var valec_2=null;
	var valec_3=null;
	init();
	animate();
	stavprostredia=false;


	/*** Initialize ***/
	function init() {
	  // This <div> will host the canvas for our scene.
	  //var inputfil=document.getElementById("vyska");
	  renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });

	  renderer.shadowMapEnabled = true;
	  renderer.sortObjects = false;
	  renderer.autoClear = false;


	 // renderer.shadowMapEnabled = false;
	 // renderer.shadowMapAutoUpdate = true;
	  //renderer.clearTarget( light.shadowMap );
	  renderer.shadowMapType = THREE.PCFSoftShadowMap;
	  //renderer.shadowMapCullFrontFaces = false;

	  // This is the scene we will add all objects to.
	  scene = new THREE.Scene();
	  //scene2 = new THREE.Scene();
	  //scene3 = new THREE.Scene();
	  //scene.height=300;

	  rura=false;
	  valec_s=false;
	  var container = document.createElement( 'div' );
	 // container=document.getElementById("container");
	  container.id="container";
	  document.body.appendChild( container );
	  // You can adjust the cameras distance and set the FOV to something
	  // different than 45°. The last two values set the clippling plane.
	  camera = new THREE.PerspectiveCamera( 80, dimx / dimy, 0.1, 2000 );
	  CubeCamera = new THREE.CubeCamera( 0.01, 500, 512 );
	  scene.add(CubeCamera);

	  CubeCamera.renderTarget.mapping = new THREE.CubeRefractionMapping();
	  CubeCamera.name="kamera";


	  var sklo = new THREE.MeshPhongMaterial( {
						 color: 0xaaaaaa,
						 transparent:true,
						 opacity:0.1,
						 reflectivity:0.5
						 });

	  var stena = new THREE.MeshLambertMaterial( {
						 color: 0xaaaaaa,
						 });

	  var texture = THREE.ImageUtils.loadTexture(path + "voda.jpg");//, {}, function() {renderer.render(scene);});


	  var urls = [
		  path +'skybox/posx.jpg',
		  path +'skybox/negx.jpg',
		  path +'skybox/posy.jpg',
		  path +'skybox/negy.jpg',
		  path +'skybox/posz.jpg',
		  path +'skybox/negz.jpg'
		],

		// wrap it up into the object that we need
	  cubemap = THREE.ImageUtils.loadTextureCube(urls);

		// set the format, likely RGB unless you've gone crazy
	  cubemap.format = THREE.RGBFormat;

	  var shader = THREE.ShaderLib['cube']; // init cube shader from built-in lib
		shader.uniforms['tCube'].value = cubemap; // apply textures to shader

		// create shader material
		var skyBoxMaterial = new THREE.ShaderMaterial( {
		  fragmentShader: shader.fragmentShader,
		  vertexShader: shader.vertexShader,
		  uniforms: shader.uniforms,
		  depthWrite: false,
		  side: THREE.BackSide
		});

		// create skybox mesh
		skybox = new THREE.Mesh(
		  new THREE.CubeGeometry(1000, 1000, 1000),
		  skyBoxMaterial
		);
		skybox.name="obloha";
		//scene.add(skybox);

	  var valecMaterial = new THREE.MeshPhongMaterial( {map: THREE.ImageUtils.loadTexture(path+'voda.jpg') } );
	  var sky = new THREE.MeshLambertMaterial( {
						color:0xffffff,
						envMap:cubemap
						} );

	  var material_gray = new THREE.MeshLambertMaterial( {
						 color: 0x050505,
						 reflectivity:0.97
						 });


	  popisMaterial = new THREE.MeshLambertMaterial({
						color: 0x707070,
						transparent: true
						});

	  camera.position.x = 10;


	  // These variables set the camera behaviour and sensitivity.

	  controls = new THREE.OrbitControls (camera ,renderer.domElement);
	  //controls.addEventListener( 'change', render );
	  //controls = new THREE.TrackballControls( camera );
	  controls.rotateSpeed = 5.0;
	  controls.zoomSpeed = 5;
	  controls.panSpeed = 2;
	  controls.noZoom = false;
	  controls.noPan = false;
	  controls.staticMoving = true;
	  controls.dynamicDampingFactor = 0.3;



	  // You can set the color of the ambient light to any value.
	  // I have chose a completely white light because I want to paint
	  // all the shading into my texture. You propably want something darker.


		spotlight=new THREE.SpotLight( 0xf2f7ff,7);

			spotlight.position.set( -6, 8, 20 );
			spotlight.target.position.set(20,0,9);
			spotlight.castShadow = false;
			spotlight.distance=100;
			//spotlight.shadowCameraNear = 1;
			//spotlight.shadowCameraFar = 70;
			//spotlight.shadowDarkness = 0.4;
			//spotlight.shadowCameraVisible = true;
			spotlight.angle=Math.PI/2;
			scene.add( spotlight );

		/*var spotlight2=new THREE.SpotLight( 0xffffff,2);

			spotlight2.position.set( -60, 80, -40 );
			spotlight2.target.position.set(20,0,9);
			spotlight2.distance=1000;
			spotlight2.angle=Math.PI/2;
			scene.add( spotlight2 );*/


	  hemLight = new THREE.HemisphereLight(0xffffef, 0x909080, 1);
			scene.add(hemLight);


	  directionalLight = new THREE.DirectionalLight( 0xffffee,4);
			directionalLight.position.set( -20, 20, -24 );
			//directionalLight.target.position.set( 2, 0, 11 );
			//directionalLight.angle=Math.PI;
			//directionalLight.onlyShadow=true;
			//directionalLight.exponent=0.1;
			directionalLight.shadowCameraLeft=-40;

			directionalLight.shadowCameraRight=50;

			directionalLight.shadowCameraTop=50;

			directionalLight.shadowCameraBottom=-30;

			directionalLight.shadowBias = 0.01;
			directionalLight.castShadow = true;
			directionalLight.shadowDarkness = 0.6;
			//directionalLight.shadowCameraVisible = true;
			directionalLight.shadowCameraNear = 1;
			directionalLight.shadowCameraFar = 100;
			directionalLight.shadowMapWidth = 512; // default is 512
			directionalLight.shadowMapWidth = 512; // default is 512
			directionalLight.shadowMapHeight = 512; // default is 512
			scene.add( directionalLight );


		directionalLight2 = new THREE.DirectionalLight( 0xffffee,1);
			directionalLight2.position.set( 20, -40, 24 );

			//directionalLight2.castShadow = true;
			//directionalLight2.shadowDarkness = 0.9;
			scene.add( directionalLight2 );
	//  /*** Texture Loading ***/


	var fShader = THREE.FresnelShader;

	var fresnelUniforms =
	{
		"texture": { type: "t", value: THREE.ImageUtils.loadTexture( path + "voda.jpg" ) },
		"mRefractionRatio": { type: "f", value: 1.3 },
		"mFresnelBias": 	{ type: "f", value: 0.5 },
		"mFresnelPower": 	{ type: "f", value: 2 },
		"mFresnelScale": 	{ type: "f", value: 1.0 },
		"tCube": 			{ type: "t", value: CubeCamera.renderTarget } //  textureCube }
	};

	// create custom material for the shader
	customMaterial = new THREE.ShaderMaterial(
	{
		//bumpMap: THREE.ImageUtils.loadTexture('7718-bump11smart.png'),
	    uniforms: 		fresnelUniforms,
		vertexShader:   fShader.vertexShader,
		fragmentShader: fShader.fragmentShader
	}   );

	//customMaterial.map    = THREE.ImageUtils.loadTexture('voda.jpg');
	customMaterial.bumpMap = THREE.ImageUtils.loadTexture(path + '7718-bump11smart.png');








	  /*** OBJ Loading ***/
	  loader = new THREE.OBJMTLLoader();

	  loader2 = new THREE.OBJLoader();


	  sustava1();


	  // We set the renderer to the size of the window and
	  // append a canvas to our HTML page.

	  renderer.setSize( dimx, dimy );
	  //renderer.setSize( 700, 400 );
	  renderer.setClearColor( 0xa0a0a0, 1);
	  container.appendChild( renderer.domElement );




	}

	/*** The Loop ***/
	function animate() {
	  // This function calls itself on every frame. You can for example change
	  // the objects rotation on every call to create a turntable animation.
	  requestAnimationFrame( animate );

	  // On every frame we need to calculate the new camera position
	  // and have it look exactly at the center of our scene.
	  controls.update();
	  render();
	  }

	function render()
	{
	  renderer.clear();
	  if(valec_1 != null)valec_1.visible=false;
	  if(valec_2 != null)valec_2.visible=false;
	  if(valec_3 != null)valec_3.visible=false;
	  //if(valec_1 != null){
	  CubeCamera.position.x=valec_2.position.x+0.4;
	  CubeCamera.position.z=valec_2.position.z;
	  CubeCamera.position.y=valec_2.position.y;
	 // }


	  if(typeof nadrzka2 !== 'undefined') nadrzka2.visible=false;
	  CubeCamera.updateCubeMap( renderer, scene );

	  if(valec_1 != null)valec_1.visible=true;
	  if(valec_2 != null)valec_2.visible=true;
	  if(valec_3 != null)valec_3.visible=true;
	  if(typeof nadrzka2 !== 'undefined') nadrzka2.visible=true;

	  renderer.render( scene, camera );
	}




	function sustava1()
	{
		/**SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  **/

		  while(typeof scene.getObjectByName("sustava") !="undefined")
		  {
			//obj=scene.children[scene.children.length-i];
			obj=scene.getObjectByName("sustava");
			scene.remove(obj);
			//obj.dispose();
			//obj.geometry.dispose();
			//i++;
		  }


		  loader.load( path+'objekty2/zaklad.obj',path+'objekty2/zaklad.mtl', function ( event ) {
			var object = event;
			object.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
				var textura=THREE.ImageUtils.loadTexture(path+'textury/brushed_aluminium_texture512_2.jpg');
				textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
				textura.repeat.set(5,5);
				child.material.map = textura;
				//child.material.bumpMap = textura;
				child.material.bumpScale= 0.001;
				child.castShadow = true;
				child.receiveShadow = false;
			  }
			} );
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			object.position.y += korekcia_vysky;
			scene.add( object );
		  });



		   loader.load( path+'objekty2/nadrz.obj',path+'objekty2/nadrz.mtl', function ( event ) {
			var object = event;
			//object.traverse( function ( child ) {
			 // if ( child instanceof THREE.Mesh ) {
		//		child.material = sklo;
		//	  }
		//	} );
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.castShadow = true;
			object.position.y += korekcia_vysky;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });

		//  loader.load( path+'objekty2/nadrz_inv.obj',path+'objekty2/nadrz_inv.mtl', function ( event ) {
		//	var object = event;
		//	object.traverse( function ( child ) {
		//	  if ( child instanceof THREE.Mesh ) {
		//		child.material = sklo;
		//	  }
		//	} );
		//	object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.castShadow = true;
		//	object.position.y += korekcia_vysky;
		//    object.castShadow = true;
		   // object.receiveShadow = true;
			//scene.add( object );
		  //});

		  loader.load( path+'objekty2/noha.obj',path+'objekty2/noha.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z -= 2.09376;
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });

		  loader.load( path+'objekty2/noha.obj',path+'objekty2/noha.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			object.position.z += 2.85;
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });

		  loader.load( path+'objekty2/valec.obj',path+'objekty2/valec.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/odmerka.jpg');
					var textura2=THREE.ImageUtils.loadTexture(path+'textury/odmerka_alpha2.jpg');
					child.material=popisMaterial;
					child.material.map = textura;
					child.material.alphaMap = textura2;
			  }
			} );
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			object.position.z += 2.1954;
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });




		  loader.load( path+'objekty2/valec.obj',path+'objekty2/valec.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/odmerka.jpg');
					var textura2=THREE.ImageUtils.loadTexture(path+'textury/odmerka_alpha2.jpg');
					child.material=popisMaterial;
					child.material.map = textura;
					child.material.alphaMap = textura2;
			  }
			} );

			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.1954;
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });







		  loader.load( path+'objekty2/valec.obj',path+'objekty2/valec.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/odmerka.jpg');
					var textura2=THREE.ImageUtils.loadTexture(path+'textury/odmerka_alpha2.jpg');
					child.material=popisMaterial;
					child.material.map = textura;
					child.material.alphaMap = textura2;
			  }
			} );
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			object.position.z -= 2.09376;
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });




		   loader.load( path+'objekty2/hadicky.obj',path+'objekty2/hadicky.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });


		  //PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC  PLC

		   loader.load( path+'objekty2/plc_low.obj',path+'objekty2/plc_low.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.x=-0.08754;
			object.position.y=0.31454;
			object.position.z=-1.80383;
			object.position.y += korekcia_vysky;

			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });




		  loader.load( path+'objekty2/plc_low.obj',path+'objekty2/plc_low.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.x=-0.08239;
			object.position.y=0.31454;
			object.position.z=0.28754;
			object.position.y += korekcia_vysky;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });




		   loader.load( path+'objekty2/plc_inv.obj',path+'objekty2/plc_inv.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.y += korekcia_vysky;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });





		  loader.load( path+'objekty2/plc_low.obj',path+'objekty2/plc_low.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.x=0.19058;
			object.position.y=0.15790;
			object.position.z=1.17330;
			object.rotation.y=Math.PI/2;
			object.position.y += korekcia_vysky;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });



		   loader.load( path+'objekty2/plc_low.obj',path+'objekty2/plc_low.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.x=0.19058;
			object.position.y=0.15790;
			object.position.z=-0.97240;
			object.rotation.y=Math.PI/2;
			object.position.y += korekcia_vysky;

			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });



		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		   loader.load( path+'objekty2/pumpa_low.obj',path+'objekty2/pumpa_low.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.y += korekcia_vysky;
			//object.castShadow = true;
			//object.receiveShadow = false;
			scene.add( object );
		  });



		  loader.load( path+'objekty2/uchytka.obj',path+'objekty2/uchytka.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.y += korekcia_vysky;
			object.position.y+=0.64;
			object.position.z+=2.775;
			object.rotation.x +=Math.PI;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });



		  loader.load( path+'objekty2/uchytka.obj',path+'objekty2/uchytka.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.y += korekcia_vysky;

			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });



		  loader.load( path+'objekty2/uchytka.obj',path+'objekty2/uchytka.mtl', function ( event ) {
			var object = event;
			object.name="sustava";
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.y += korekcia_vysky;
			object.position.z -=2.08623;
			object.castShadow = true;
			object.receiveShadow = true;
			scene.add( object );
		  });


		 /* loader2.load( path+'objekty2/obloha.obj', function ( event ) {
			var object = event;
			object.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
				child.material = sky;
			  }
			} );
			object.scale = new THREE.Vector3( 25, 25, 25 );
			//object.position.set(0.22609+0.18, -0.75982, 0.55816);
			//object.position.z += 2.09376;
			object.position.y += korekcia_vysky+50;
			//object.castShadow = true;
			//object.receiveShadow = false;
			scene.add( object );
		  });*/






		  //VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA
		  loader2.load( path+'objekty2/voda.obj', function ( event ) {
			valec_1 = event;
			valec_1.name="sustava";
			valec_1.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
				child.material = customMaterial;
			  }
			} );

			valec_1.scale.y=0.5;
			//valec_1.scale.y=document.getElementById("h1").value/30;
			valec_1.position.z += 2.1954;
			valec_1.position.y += korekcia_vysky+0.05;
			//scene2.add( valec_1 );
			scene.add( valec_1 );
		  });



		  loader2.load( path+'objekty2/voda.obj', function ( event ) {
			valec_2 = event;
			valec_2.name="sustava";
			valec_2.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
				child.material = customMaterial;
			  }
			} );

			valec_2.scale.y=0.5;
			//valec_2.scale.y=document.getElementById("h2").value/30;
			//object.position.y -= 1.01;
			valec_2.position.y += korekcia_vysky+0.05;
			//valec_2.position.x += 2;
			//scene2.add( valec_2 );
			scene.add( valec_2 );
		  });


		  loader2.load( path+'objekty2/voda.obj', function ( event ) {
			valec_3 = event;
			valec_3.name="sustava";
			valec_3.traverse( function ( child ) {
			  if ( child instanceof THREE.Mesh ) {
				//child.material.map = texture;
				child.material = customMaterial;
				//CubeCamera.position=child.position;
			  }
			} );

			valec_3.scale.y=0.5;
			//valec_3.scale.y=document.getElementById("h3").value/30;
			valec_3.position.z -= 2.09376;
			valec_3.position.y += korekcia_vysky+0.05;
			valec_3.castShadow = true;
			valec_3.receiveShadow = true;
			//scene2.add( valec_3 );
			scene.add( valec_3 );
		  });

	}






	function sustava2()
	{
		/**SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  SUSTAVA  **/


		while(typeof scene.getObjectByName("sustava") !="undefined")
		{
			//obj=scene.children[scene.children.length-i];
			obj=scene.getObjectByName("sustava");
			scene.remove(obj);
			//obj.dispose();
			//obj.geometry.dispose();
			//i++;
		}


		loader.load( 'objekty/plc s.obj','objekty/plc s.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.22609+0.18, -0.75982, 0.55816);
		object.position.y += korekcia_vysky;
		object.castShadow = true;
	    object.receiveShadow = false;
		scene.add( object );
		});


	  /*loader.load( 'objekty/plc s.obj','objekty/plc s.mtl', function ( event ) {
		var object = event;
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.22609, -0.75982, 1.47709);
		scene.add( object );
	  });*/


	  loader.load( 'objekty/plc s.obj','objekty/plc s.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.22609+0.18, -0.75982, -0.34272);
		object.position.y += korekcia_vysky;
		object.castShadow = true;
	    object.receiveShadow = false;
		scene.add( object );
	  });

	  loader.load( 'objekty/plc s.obj','objekty/plc s.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.31285, 0.32782, 0.29894);
		object.rotation.y=-45*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/plc s.obj','objekty/plc s.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.36610, 0.32782, 1.22701);
		object.rotation.y=-45*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/plc s.obj','objekty/plc s.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.31285, 0.32782, -0.54546);
		object.rotation.y=-45*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/stena.obj','objekty/stena.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;

		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.y += korekcia_vysky;
		//object.position.y -= 2.5;
		scene.add( object );
	  });




	  //rurky strieborne//////////////////////////////////////////////////////////////////////////////

	 /*loader.load( 'objekty/rurky strieborne.obj','objekty/rurky strieborne.mtl', function ( event ) {
		var object = event;
		object.traverse( function ( child ) {
		  /*if ( child instanceof THREE.Mesh ) {
			child.material.map = texture;
		  }*/
		/*} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.y -= 2.5;
		scene.add( object );
	  });*/


	  // uchytky////////////////////////////////////////////////////////////////////////////////////////////////

	  //stredna dolna
	  loader.load( 'objekty/uchytka_low.obj','objekty/uchytka_low.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.y -= 2.5;
		object.position.y += korekcia_vysky;
		object.castShadow = true;
		scene.add( object );
	  });


	  //lava dolna
	  loader.load( 'objekty/uchytka sd.obj','objekty/uchytka sd.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			//child.material.map = texture;
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.z -= 1.01;
		object.position.y += korekcia_vysky;
		object.castShadow = true;
		scene.add( object );
	  });


	  //prava dolna
	  loader.load( 'objekty/uchytka sd.obj','objekty/uchytka sd.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.z += 1.01;
		object.position.y += korekcia_vysky;
		object.castShadow = true;
		scene.add( object );
	  });



	  //stredna horna
	  loader.load( 'objekty/uchytka sd.obj','objekty/uchytka sd.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			//child.material.map = texture;
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.y -= 2.5;
		object.position.y += 2;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  //lava horna
	  loader.load( 'objekty/uchytka sd.obj','objekty/uchytka sd.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.z -= 1.01;
		object.position.y += 2;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  //prava horna
	  loader.load( 'objekty/uchytka sd.obj','objekty/uchytka sd.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.z += 1.01;
		object.position.y += 2;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });








	  loader.load( 'objekty/zlatarura l.obj','objekty/zlatarura l.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.30800+0.18, -1.22272, 0.54);
		//object.position.y -= 2.5;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlatarura l.obj','objekty/zlatarura l.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.30800+0.18, -1.22272, -0.33662);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlatarura l.obj','objekty/zlatarura l.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.35398, -0.12329, 1.22187);
		object.rotation.y=-140*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlatarura l.obj','objekty/zlatarura l.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.3271, -0.116, 0.26880);
		object.rotation.y=-150*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlatarura l.obj','objekty/zlatarura l.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.29978, -0.14329, -0.54002);
		object.rotation.y=-129*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlatarura s.obj','objekty/zlatarura s.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.x += 0.18;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlaty_ohyb.obj','objekty/zlaty_ohyb.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.55463, -0.18532, 0.98421);
		object.rotation.y=130*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlaty_ohyb.obj','objekty/zlaty_ohyb.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.47752, -0.18532, 0.00186);
		object.rotation.y=119*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/zlaty_ohyb.obj','objekty/zlaty_ohyb.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(-0.53916, -0.203, -0.73545);
		object.rotation.y=141*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/valec velky.obj','objekty/valec velky.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.y -= 2.5;
		object.position.y += korekcia_vysky;
		object.castShadow = true;
		object.receiveShadow = true;
		scene.add( object );
	  });




	  ////////////////////////////koncovky/////////////////////////






	  loader.load( 'objekty/koniec_str_m.obj','objekty/koniec_str_m.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.48364, -0.91977, 0.98440);
		//object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });




	  loader.load( 'objekty/koniec_str_m.obj','objekty/koniec_str_m.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.47747, -0.91977, -0.77267);
		//object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });



	  loader.load( 'objekty/koniec_str_v.obj','objekty/koniec_str_v.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.47709, -0.94192, 0.10168);
		object.rotation.set(180*Math.PI/180, 0*Math.PI/180, 0*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	   loader.load( 'objekty/koniec_str_v.obj','objekty/koniec_str_v.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.49427, -0.15438, 0.93438);
		//object.rotation.set(180*Math.PI/180, 0*Math.PI/180, 0*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/koniec_str_v.obj','objekty/koniec_str_v.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.53763, -0.15438, -0.01645);
		//object.rotation.set(180*Math.PI/180, 0*Math.PI/180, 0*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  loader.load( 'objekty/koniec_str_v.obj','objekty/koniec_str_v.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.53028, -0.15438, -1.03264);
		//object.rotation.set(180*Math.PI/180, 0*Math.PI/180, 0*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });






	  //pri: valec lavy stredny pravy
	  loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.31193, -0.29351, 1.23977);
		object.rotation.set(0*Math.PI/180, 40*Math.PI/180, -90*Math.PI/180);
		//object.rotation.x=90*Math.PI/180;
		//object.rotation.y=90*Math.PI/180;
		//object.rotation.z=90*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	   loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.27723, -0.29351, 0.24182);
		object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		//object.position.y -= 2.5;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	   loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.27723, -0.29351, -0.75716);
		object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });

	  //////////////////////////////////


	    loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.05106, -0.178, 1.44722);
		//object.rotation.set(90*Math.PI/180, 180*Math.PI/180, 19*Math.PI/180);
		object.rotation.x=75*Math.PI/180;
		object.rotation.y=-15*Math.PI/180;
		object.rotation.z=47*Math.PI/180;
		//object.rotation.x=1*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	    loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.12606, -0.17, -0.40384);
		//object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.rotation.x=83*Math.PI/180;
		object.rotation.y=-7*Math.PI/180;
		object.rotation.z=39*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	    loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.033, -0.132, 0.572);
		//object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.rotation.x=83*Math.PI/180;
		object.rotation.y=-7*Math.PI/180;
		object.rotation.z=61*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	    loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.30655+0.18, -1.05, 0.98370);
		//object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.rotation.x=180*Math.PI/180;
		object.rotation.y=90*Math.PI/180;
		object.rotation.z=0*Math.PI/180;
		object.position.y += korekcia_vysky;

		scene.add( object );
	  });


	    loader.load( 'objekty/rurka_nova.obj','objekty/rurka_nova.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = rura;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.set(0.30038+0.18, -1.21749, -0.60173);
		//object.rotation.set(0*Math.PI/180, 56*Math.PI/180, -90*Math.PI/180);
		object.rotation.x=0*Math.PI/180;
		object.rotation.y=90*Math.PI/180;
		object.rotation.z=-90*Math.PI/180;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });



	  loader.load( 'objekty/cierny_valec.obj','objekty/cierny_valec.mtl', function ( event ) {
		var object = event;
		object.name="sustava";

		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.y -= 2.5;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });



	  loader.load( 'objekty/cierny_valec.obj','objekty/cierny_valec.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.x -= 0.3;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });










	 loader.load( 'objekty/hadicky.obj','objekty/hadicky.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = true;
			child.receiveShadow = true;
		  }
		} );
		//object.material.depthWrite=false;
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });


	  	  //valce

	  //stredny
	  loader.load( 'objekty/valec stredny.obj','objekty/valec stredny.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = valec_s;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.y -= 2.5;
		object.position.y += korekcia_vysky;
		object.castShadow = true;
		scene.add( object );
	  });

	  //pravy
	  loader.load( 'objekty/valec stredny.obj','objekty/valec stredny.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = valec_s;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.z -= 1.01;
		object.position.y += korekcia_vysky;
		scene.add( object );
	  });

	  //lavy
	  loader.load( 'objekty/valec stredny.obj','objekty/valec stredny.mtl', function ( event ) {
		var object = event;
		object.name="sustava";
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.castShadow = valec_s;
			child.receiveShadow = true;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		object.position.z += 1.01;
		object.position.y += korekcia_vysky;
		object.castShadow = true;
		scene.add( object );
	  });


	 /* loader2.load( path+'objekty2/obloha.obj', function ( event ) {
		var object = event;
		object.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.material = sky;
		  }
		} );
		object.scale = new THREE.Vector3( 25, 25, 25 );
		//object.position.set(0.22609+0.18, -0.75982, 0.55816);
		//object.position.z += 2.09376;
		object.position.y += korekcia_vysky+50;
		//object.castShadow = true;
	    //object.receiveShadow = false;
		scene.add( object );
	  });*/






	  //VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA  VODA
	  loader2.load( 'objekty/valec.obj', function ( event ) {
		valec_1 = event;
		valec_1.name="sustava";
		valec_1.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.material = customMaterial;
		  }
		} );

		valec_1.scale.y=0.7;
		valec_1.position.z += 1.01;
		valec_1.position.y += korekcia_vysky;
		//scene2.add( valec_1 );
		scene.add( valec_1 );
	  });



	  loader2.load( 'objekty/valec.obj', function ( event ) {
		valec_2 = event;
		valec_2.name="sustava";
		valec_2.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			child.material = customMaterial;
		  }
		} );

		valec_2.scale.y=0.5;
		//object.position.y -= 1.01;
		valec_2.position.y += korekcia_vysky;
		//valec_2.position.x += 2;
		//scene2.add( valec_2 );
		scene.add( valec_2 );
	  });


	  loader2.load( 'objekty/valec.obj', function ( event ) {
		valec_3 = event;
		valec_3.name="sustava";
		valec_3.traverse( function ( child ) {
		  if ( child instanceof THREE.Mesh ) {
			//child.material.map = texture;
			child.material = customMaterial;
			//CubeCamera.position=child.position;
		  }
		} );

		valec_3.scale.y=0.2;
		valec_3.position.z -= 1.01;
		valec_3.position.y += korekcia_vysky;
		valec_3.castShadow = true;
		valec_3.receiveShadow = true;
		//scene2.add( valec_3 );
		scene.add( valec_3 );
	  });



	}








	function bezprostredia()
	{
		stavprostredia=false;

		spotlight.intensity=7;
		directionalLight.intensity=0;
		directionalLight2.intensity=0;

		//var i=1;
		while(typeof scene.getObjectByName("zmaz") !="undefined")
		{
			//obj=scene.children[scene.children.length-i];
			obj=scene.getObjectByName("zmaz");
			scene.remove(obj);
			//obj.dispose();
			//obj.geometry.dispose();
			//i++;
		}
		scene.remove(scene.getObjectByName("kamera"));
		scene.remove(scene.getObjectByName("obloha"));
		//CubeCamera.updateCubeMap( renderer, scene );
		//renderer.render( scene, camera );
	}
	function prostredie1()
	  {
		  bezprostredia();
		  if(stavprostredia==false)
		  {
			  stavprostredia=true;

			  spotlight.intensity=7;
			  directionalLight.intensity=0;
			  directionalLight.castShadow=false;
			  directionalLight2.intensity=0;

			  scene.add(skybox);
			  loader.load( path+'objekty2/stol.obj',path+'objekty2/stol.mtl', function ( event ) {
				var object = event;
				object.traverse( function ( child ) {
				  if ( child instanceof THREE.Mesh ) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/wood-texture1024.jpg');
					textura.wrapS=textura.wrapT=THREE.MirroredRepeatWrapping;
					textura.repeat.set(2,-2);
					//textura.offset.set( 1, 0);
					child.material.map = textura;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.02;
					child.castShadow = true;
					child.receiveShadow = true;
				  }
				} );
				object.name="zmaz";
				object.scale = new THREE.Vector3( 25, 25, 25 );
				//object.position.set(0.22609+0.18, -0.75982, 0.55816);
				object.position.y += korekcia_vysky;
				scene.add( object );
			  });


			  loader.load( path+'objekty2/komnata.obj',path+'objekty2/komnata.mtl', function ( event ) {
				var object = event;
				var s=0;
				object.traverse( function ( child ) {
				//child.material=stena;

				  if ( child instanceof THREE.Mesh && s==4) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/wood_roof1024.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(6,6);

					child.material.map = textura;
					child.material.wrapAround=true;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.1;
					child.castShadow = true;
					child.receiveShadow = true;
				  }

				  if ( child instanceof THREE.Mesh && s==3) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/castle_wall1024.jpg');
					var textura2=THREE.ImageUtils.loadTexture(path+'textury/castle_wall1024bump.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(1,1);
					textura2.wrapS=textura2.wrapT=THREE.RepeatWrapping;
					textura2.repeat.set(1,1);
					child.material.map = textura;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.05;
					//child.material.wrapAround=true;
					child.castShadow = true;
					child.receiveShadow = true;
				  }

				 /* if ( child instanceof THREE.Mesh && s==5) {
					var textura=THREE.ImageUtils.loadTexture('textury/white_paint_stucco.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(10,10);
					child.material.map = textura;
					//child.material.transparent=true;
					//child.material.opacity=0.99;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.02;
					child.material.wrapAround=true;
					child.castShadow = true;
					child.receiveShadow = true;
				  }*/
				  s=s+1;

				} );
				s=0;
				object.name="zmaz";
				object.scale = new THREE.Vector3( 25, 25, 25 );
				//object.position.set(0.22609+0.18, -0.75982, 0.55816);
				//object.castShadow = true;
				object.position.y += korekcia_vysky;
				scene.add( object );
			  });



			  loader.load( path+'objekty2/strecha.obj',path+'objekty2/strecha.mtl', function ( event ) {
				var object = event;
				var s=0;
				object.traverse( function ( child ) {
				//child.material=stena;

				  if ( child instanceof THREE.Mesh && s==3) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/wood_roof1024.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(6,6);

					child.material.map = textura;
					child.material.wrapAround=true;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.05;
					child.castShadow = true;
					child.receiveShadow = true;
				  }

				  if ( child instanceof THREE.Mesh && s>3) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/roof texture 1.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(4,4);
					child.material.map = textura;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.4;
					//child.material.wrapAround=true;
					child.castShadow = true;
					child.receiveShadow = true;
				  }

				  s=s+1;

				} );
				s=0;
				object.name="zmaz";
				object.scale = new THREE.Vector3( 25, 25, 25 );
				//object.position.set(0.22609+0.18, -0.75982, 0.55816);
				//object.castShadow = true;
				object.position.y += korekcia_vysky;
				scene.add( object );
			  });

		}

	}


	function prostredie2()
	{
		bezprostredia();
		if(stavprostredia==false)
		{
			stavprostredia=true;

			spotlight.intensity=0;
			directionalLight.intensity=4;
			directionalLight.castShadow=true;
			directionalLight2.intensity=1;
			scene.add(skybox);

			loader.load( path+'objekty2/stol.obj',path+'objekty2/stol.mtl', function ( event ) {
				var object = event;
				object.traverse( function ( child ) {
				  if ( child instanceof THREE.Mesh ) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/wood-texture1024.jpg');
					textura.wrapS=textura.wrapT=THREE.MirroredRepeatWrapping;
					textura.repeat.set(2,-2);
					//textura.offset.set( 1, 0);
					child.material.map = textura;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.02;
					child.castShadow = true;
					child.receiveShadow = true;
				  }
				} );
				object.name="zmaz";
				object.scale = new THREE.Vector3( 25, 25, 25 );
				//object.position.set(0.22609+0.18, -0.75982, 0.55816);
				object.position.y += korekcia_vysky;
				scene.add( object );
			});


			  loader.load( path+'objekty2/miestnost3.obj',path+'objekty2/miestnost3.mtl', function ( event ) {
				var object = event;
				var s=0;
				object.traverse( function ( child ) {
				  if ( child instanceof THREE.Mesh && s==4) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/wood-flooring1024.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(3,3);
					child.material.map = textura;
					child.material.wrapAround=true;
					//child.material.bumpMap = textura;
					//child.material.bumpScale= 0.05;
					child.receiveShadow = true;
				  }

				  if ( child instanceof THREE.Mesh && s==3) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/white_paint_stucco.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(10,10);
					child.material.map = textura;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.02;
					child.material.wrapAround=true;
					child.castShadow = true;
					child.receiveShadow = true;
				  }

				  if ( child instanceof THREE.Mesh && s==5) {
					var textura=THREE.ImageUtils.loadTexture(path+'textury/white_paint_stucco.jpg');
					textura.wrapS=textura.wrapT=THREE.RepeatWrapping;
					textura.repeat.set(10,10);
					child.material.map = textura;
					//child.material.transparent=true;
					//child.material.opacity=0.99;
					child.material.bumpMap = textura;
					child.material.bumpScale= 0.02;
					child.material.wrapAround=true;
					child.castShadow = true;
					child.receiveShadow = true;
				  }
				  s=s+1;

				} );
				s=0;
				object.name="zmaz";
				object.scale = new THREE.Vector3( 25, 25, 25 );
				//object.position.set(0.22609+0.18, -0.75982, 0.55816);
				//object.castShadow = true;
				object.position.y += korekcia_vysky;
				scene.add( object );
			  });

		}
	}



	function vypocet(){
	if(typeof control2!=='undefined')clearInterval(control2);
	valec_1.scale.y=document.getElementById("h1").value/30;
	valec_2.scale.y=document.getElementById("h2").value/30;
	valec_3.scale.y=document.getElementById("h3").value/30;
	}




	function ajax2()
	{
		if (document.getElementById("ref").value>28 || document.getElementById("ref").value<0){alert("Požadovaná hladina je mimo rozsah 0-28"); return;}
		if (document.getElementById("h1").value>28 || document.getElementById("h1").value<0){alert("Zadaná hladina valca 1 je mimo rozsah 0-28"); return;}
		if (document.getElementById("h2").value>28 || document.getElementById("h2").value<0){alert("Zadaná hladina valca 2 je mimo rozsah 0-28"); return;}
		if (document.getElementById("h3").value>28 || document.getElementById("h3").value<0){alert("Zadaná hladina valca 3 je mimo rozsah 0-28"); return;}
		if (document.getElementById("ro").value<0){alert("Hustota nemôže byť záporná"); return;}
		if (document.getElementById("st").value<0){alert("Simulačný čas musí byť kladný"); return;}
		if (document.getElementById("nv").value<0){alert("Počet hodnôt musí byť kladný"); return;}
		if (document.getElementById("q1").value<0){alert("Prítok nemôže byť záporný"); return;}
		if (document.getElementById("q2").value<0){alert("Prítok nemôže byť záporný"); return;}
		if (document.getElementById("q3").value<0){alert("Prítok nemôže byť záporný"); return;}
		if (document.getElementById("P").value<0){alert("Hodnoty regulátora nemôžu byť záporné"); return;}
		if (document.getElementById("Ti").value<0){alert("Hodnoty regulátora nemôžu byť záporné"); return;}
		if (document.getElementById("Td").value<0){alert("Hodnoty regulátora nemôžu byť záporné"); return;}


		valec_1.scale.y=document.getElementById("h1").value/30;
		valec_2.scale.y=document.getElementById("h2").value/30;
		valec_3.scale.y=document.getElementById("h3").value/30;

		var xmlhttp2;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp2=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp2.onreadystatechange=function()
		{
			if (xmlhttp2.readyState==1) document.getElementById("testovacie_pole").innerHTML+="Loading";
			if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
			{
				var string2=xmlhttp2.responseText;
				document.getElementById("testovacie_pole").innerHTML="";

				var udaje2=JSON.parse(string2);
				console.log(udaje2);

				animation(udaje2,valec_1,valec_2,valec_3);
			}
		}
		data=form();
		console.log("odosielam");
		console.log(data);
		xmlhttp2.open("POST",path+"vypocet_dr.php",true);
		xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//document.getElementById("testovacie_pole").innerHTML=data;
		xmlhttp2.send(data);

		//else alert("Zadana hladina je mimo rozsah");
	}

	function form()
	{
		var temp='';
		temp+='ro='+dajHodnotu('ro');
		/*temp+='&R1='+dajHodnotu('R1');
		temp+='&R2='+dajHodnotu('R2');
		temp+='&R3='+dajHodnotu('R3');
		temp+='&F1='+dajHodnotu('F1');
		temp+='&F2='+dajHodnotu('F2');
		temp+='&F3='+dajHodnotu('F3');*/

		temp+='&R1=8000';
		temp+='&R2=8000';
		temp+='&R3=8000';
		temp+='&F1=0.00785';
		temp+='&F2=0.00785';
		temp+='&F3=0.00785';

		temp+='&h1='+dajHodnotu('h1');
		temp+='&h2='+dajHodnotu('h2');
		temp+='&h3='+dajHodnotu('h3');
		temp+='&st='+dajHodnotu('st');
		temp+='&nv='+dajHodnotu('nv');
		if(document.getElementById("checkbox").checked)
		{
			temp+='&checked=true';
			temp+='&ref='+dajHodnotu('ref');
			temp+='&P='+dajHodnotu('P');
			temp+='&Ti='+dajHodnotu('Ti');
			temp+='&Td='+dajHodnotu('Td');
			if(document.getElementById("val1").checked) temp+='&riad=1';
			else if(document.getElementById("val2").checked) temp+='&riad=2';
			else if(document.getElementById("val3").checked) temp+='&riad=3';
		}
		else
		{
			temp+='&q1='+dajHodnotu('q1');
			temp+='&q2='+dajHodnotu('q2');
			temp+='&q3='+dajHodnotu('q3');
		}
		return temp;
	}

	function dajHodnotu(str)
	{
		return document.getElementById(str).value;
	}
	function animation(pole,objekt1,objekt2,objekt3)
	{
		graf=[];
		graf2=[];
		graf3=[];
	    var options = {
			xaxis:
			{
				min:0, max: document.getElementById("st").value,  tickSize: document.getElementById("st").value*20/document.getElementById("nv").value
			},

			yaxis:
			{
				min:0, max: 30,  tickSize: 5
			},

			legend:
			{
				backgroundColor:"#000000",
				backgroundOpacity:0
			}
		};
	    //plot = $("#placeholder").plot(graf, options).data("plot");
		plot=$.plot($("#placeholder"), [{label:"h1",data:graf},{label:"h2",data:graf2},{label:"h3",data:graf3}] ,options);
		//plot.setupGrid();
		control2=setInterval(function(){animTimer(pole,objekt1,objekt2,objekt3)},40);
		j=0;
	}


	function animTimer(pole,objekt1,objekt2,objekt3)
	{
		if (j<pole[1].length){
			objekt1.scale.y=(pole[1][j]/30);
			objekt2.scale.y=(pole[2][j]/30);
			objekt3.scale.y=(pole[3][j]/30);

			graf.push([pole[0][j],pole[1][j]]);
			graf2.push([pole[0][j],pole[2][j]]);
			graf3.push([pole[0][j],pole[3][j]]);
			plot.setData([graf,graf2,graf3]);
			//plot.setupGrid();
			plot.draw();
			//plot.show();
		}
		else clearInterval(control2);
		j++;
	}

  </script>
	<div id="vys">
	                <div class="col-md-4" style="margin: 0 auto; margin-bottom: 25px;">
                            <!--<p><label class="field">Parameter:</label><input class="textbox form-control" id="p" name="p" value="1" step="0.01"></p>-->
                        <div class="form-group">
                            <p><label class="field">Hustota:</label><input class="form-control" id="ro" name="ro" value="1" type="number" min="0" max="30" step="0.1"></p>
                        </div>
                            <!--<p><label class="field">Hydraulický odpor 1:</label><input class="textbox form-control" id="R1" name="R1" value="8000" type="number" ></p>
                            <p><label class="field">Hydraulický odpor 2:</label><input class="textbox form-control" id="R2" name="R2" value="8000" type="number" ></p>
                            <p><label class="field">Hydraulický odpor 3:</label><input class="textbox form-control" id="R3" name="R3" value="8000" type="number" ></p>
                            <p><label class="field">Prierez valca 1:</label><input class="textbox form-control" id="F1" name="F1" value="0.00785" type="number" ></p>
                            <p><label class="field">Prierez valca 2:</label><input class="textbox form-control" id="F2" name="F2" value="0.00785" type="number" ></p>
                            <p><label class="field">Prierez valca 3:</label><input class="textbox form-control" id="F3" name="F3" value="0.00785" type="number" ></p>-->
                        <div class="form-group">
                        <p><label class="field">Počiatočná hladina valca 1:</label><input class="textbox form-control" id="h1" name="h1" value="15" type="number" size="10" onchange="vypocet()" min="0" max="30" step="0.1"></p>
                            <p><label class="field">Počiatočná hladina valca 2:</label><input class="textbox form-control" id="h2" name="h2" value="15" type="number" onchange="vypocet()" min="0" max="30" step="0.1"></p>
                            <p><label class="field">Počiatočná hladina valca 3:</label><input class="textbox form-control" id="h3" name="h3" value="15" type="number" onchange="vypocet()" min="0" max="30" step="0.1"></p>
                            <p><label class="field">Simulačný čas:</label><input class="textbox form-control" id="st" name="st" value="20" type="number" ></p>
                            <p><label class="field">Počet hodnôt:</label><input class="textbox form-control" id="nv" name="nv" value="200" type="number" ></p>
                            <label class="field">With/Without Controller:</label><input type="checkbox" class="check_selector "id="checkbox" name="ifController">
                        </div>
                            <div id="nonpid"><p><label class="field">Prítok 1:</label><input class="textbox form-control" id="q1" name="q1" value="0" type="number" ></p>
                            <p><label class="field">Prítok 2:</label><input class="textbox form-control" id="q2" name="q2" value="0" type="number" ></p>
                            <p><label class="field">Prítok 3:</label><input class="textbox form-control" id="q3" name="q3" value="0" type="number" ></p></div>

                            <div id="pid"><p><label class="field">P:</label><input class="textbox form-control" id="P" name="P" value="35" type="number" min="0" max="500" step="0.01"></p>
                            <p><label class="field">Ti:</label><input class="textbox form-control" id="Ti" name="Ti" value="1.5" type="number" min="0" max="500" step="0.01"></p>
                            <p><label class="field">Td:</label><input class="textbox form-control" id="Td" name="Td" value="1" type="number" min="0" max="500" step="0.01"></p>
                            <div id="riadeny"><p>Riadený valec:</p></div>
                            <div id="volba"><input type="radio" name="vyber" id="val1" checked="checked">ľavý<br>
                            <input type="radio" name="vyber" id="val2">stredný<br>
                            <input type="radio" name="vyber" id="val3">pravý</div>
                            <p><label class="field">Požadovaná hladina:</label><input class="textbox form-control" id="ref" name="ref" value="5" type="number" min="0" max="28" step="0.1"></p></div>

                            <p><button class="btn btn-success btn-md pull-right" type="button" onclick=ajax2() >Simulácia</button></p>


                        <!--    <div class="Con">
                            <p><label class="field">P:</label><input class="textbox form-control" id="P" name="P" value="35" type="number" min="0" max="500" step="0.01"></p>
                            <p><label class="field">Ti:</label><input class="textbox form-control" id="Ti" name="Ti" value="1.5" type="number" min="0" max="500" step="0.01"></p>
                            <p><label class="field">Td:</label><input class="textbox form-control" id="Td" name="Td" value="1" type="number" min="0" max="500" step="0.01"></p>
                            <p><label class="field">Set point:</label><input class="textbox form-control" id="ref" name="ref" value="8" type="number" min="0" max="50" step="0.01"></p>
                            </div> -->
                    </div>
	</div>

	<div id="nastavenie">
	<button class="btn btn-md btn-info" type="button" onclick=prostredie1() >Hrad</button>
	<button class="btn btn-md btn-info" type="button" onclick=prostredie2() >Miestnosť</button>
	<button class="btn btn-md btn-info" type="button" onclick=bezprostredia() >Bez prostredia</button>
	<button class="btn btn-md btn-info" type="button" onclick=sustava1() >Sústava1</button>
	<button class="btn btn-md btn-info" type="button" onclick=sustava2() >Sústava2</button>
	</div>

	<div id="placeholder"> </div>




	<div id="testovacie_pole">

	</div>