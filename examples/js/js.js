window.onload = function(){
	var width = window.innerWidth - 5;
	var height = window.innerHeight - 5;
	var canvas = document.querySelector('canvas');

	canvas.setAttribute('width', width);
	canvas.setAttribute('height', height);

	var ball = {
		positionY: 0,
		positionX: 0,
		positionZ: 0,
		rotationY: 0,
		rotationX: 0,
		rotationZ: 0,
	}

	var gui = new dat.GUI();
	gui.add(ball, 'positionY').min(-5).max(5).step(1);
	gui.add(ball, 'positionX').min(-5).max(5).step(1);
	gui.add(ball, 'positionZ').min(-5).max(5).step(1);
	gui.add(ball, 'rotationY').min(-0.02).max(0.02).step(0.01);
	gui.add(ball, 'rotationX').min(-0.02).max(0.02).step(0.01);
	gui.add(ball, 'rotationZ').min(-0.02).max(0.02).step(0.01);

	var renderer = new THREE.WebGLRenderer({canvas: canvas});
	renderer.setClearColor(0x000000);

	var scene = new THREE.Scene();

	var camera = new THREE.PerspectiveCamera(90, width / height, 0.1, 5000);
	camera.position.set(0, 0, 1000);

	// var light = new THREE.AmbientLight(0xffffff);
	// scene.add(light);
	var light = new THREE.PointLight( 0xff0000, 1, 100 );
	light.position.set( 1000, 1000, 1000 );
	scene.add(light);

	// var geometryPlane = new THREE.PlaneGeometry(500,500,12,12);
	var geometryPlane = new THREE.SphereGeometry(100,40,40);
	var materialPlane = new THREE.MeshBasicMaterial({color: 0x00ff00, vertexColors: THREE.FaceColors});
	var geometry = new THREE.SphereGeometry(200,40,40);
	var material = new THREE.MeshBasicMaterial({
		// color: 0x00ff00, 
		vertexColors: THREE.FaceColors,
		// wireframe: true,
	});
	for (var i = 0; i < geometry.faces.length; i++) {
		geometry.faces[i].color.setRGB(Math.random(), Math.random(), Math.random());
		geometryPlane.faces[i].color.setRGB(Math.random(), Math.random(), Math.random());
	}

	var mesh = new THREE.Mesh(geometry, material);
	var meshPlane = new THREE.Mesh(geometryPlane, materialPlane);

	scene.add(mesh);
	scene.add(meshPlane);

	mesh.addEventListener('click', function(){
		console.log('olo');
	})

	meshPlane.position.x = -200;
	meshPlane.position.y = -200;

	var mouseX = 0, mouseY = 0;

	function onDocumentMouseMove( event ) {
		mouseX = ( event.clientX - width/2 );
		mouseY = ( event.clientY - height/2 );
	}

	var angle = 0;
	function loop(){

		meshPlane.position.y = 400*Math.sin(angle);
		meshPlane.position.x = 300*Math.cos(angle);
		meshPlane.position.z = 200*Math.cos(angle);
		angle+= Math.PI/180*1;
		
		mesh.rotation.y += ball.rotationY;
		mesh.rotation.x += ball.rotationX;
		mesh.rotation.z += ball.rotationZ;

		mesh.position.y += ball.positionY;
		mesh.position.x += ball.positionX;
		mesh.position.z += ball.positionZ;

		camera.position.x += ( mouseX - camera.position.x ) * 0.05;
		camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
		// camera.position.x += 5;
		// camera.position.z += 5;
		camera.lookAt( scene.position );

		renderer.render(scene, camera);
		document.addEventListener( 'mousemove', onDocumentMouseMove, false );
		requestAnimationFrame(function(){loop();})
	}

	loop();
	// animation();
}