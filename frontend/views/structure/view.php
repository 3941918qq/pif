<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use frontend\components\FooterWidget;
use frontend\components\BackNavWidget;

$this->title="";

?>
		<style>
			body {
				font-family: Monospace;
				background-color: #000;
				color: #fff;
				margin: 0 0 0 0;
				padding: 0 0 0 0;
				border: none;
				cursor: default;
			}
			#info {
				color: #fff;
				position: absolute;
				top: 10px;
				width: 100%;
				text-align: center;
				z-index: 100;
				display:block;
			}
			#info a {
				color: #f00;
				font-weight: bold;
				text-decoration: underline;
				cursor: pointer
			}
			#glFullscreen {
				width: 100%;
				height: 100vh;
				/* min-width: 640px; */
				min-height: 360px;
				position: relative;
				overflow: hidden;
				z-index: 0;
			}
			#example {
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				background-color: #000000;
			}
			#feedback {
				color: darkorange;
			}
			#dat {
				user-select: none;
				position: absolute;
				left: 0;
				top: 0;
				z-Index: 200;
			}
		</style>
<div id="glFullscreen">
    <canvas id="example"></canvas>
</div>
<div id="dat">

</div>
<div id="info">
    <!-- <a href="http://threejs.org" target="_blank" rel="noopener">three.js</a> - OBJLoader2 direct loader test -->
    <div id="feedback"></div>
</div>

<div class="container" style="background-color:#eee;">
    
</div>
<script src="/js/three/three.min.js"></script>
<script src="/js/three/TrackballControls.js"></script>
<script src="/js/three/MTLLoader.js"></script>
<script src="/js/three/dat.gui.min.js"></script>
<script src="/js/three/LoaderSupport.js"></script>
<script src="/js/three/OBJLoader2.js"></script>

<script>

var OBJLoader2Example = function ( elementToBindTo ) {
    this.renderer = null;
    this.canvas = elementToBindTo;
    this.aspectRatio = 1;
    this.recalcAspectRatio();

    this.scene = null;
    this.cameraDefaults = {
        posCamera: new THREE.Vector3( 0.0, 175.0, 800.0 ),
        posCameraTarget: new THREE.Vector3( 0, 0, 0 ),
        near: 0.1,
        far: 10000,
        fov: 45
    };
    this.camera = null;
    this.cameraTarget = this.cameraDefaults.posCameraTarget;

    this.controls = null;
};

OBJLoader2Example.prototype = {

    constructor: OBJLoader2Example,

    initGL: function () {
        this.renderer = new THREE.WebGLRenderer( {
            canvas: this.canvas,
            antialias: true,
            autoClear: true
        } );
        this.renderer.setClearColor( 0xFFFFFF );

        this.scene = new THREE.Scene();

        this.camera = new THREE.PerspectiveCamera( this.cameraDefaults.fov, this.aspectRatio, this.cameraDefaults.near, this.cameraDefaults.far );
        this.resetCamera();
        this.controls = new THREE.TrackballControls( this.camera, this.renderer.domElement );

        var ambientLight = new THREE.AmbientLight( 0x404040 );
        var directionalLight1 = new THREE.DirectionalLight( 0xC0C090 );
        var directionalLight2 = new THREE.DirectionalLight( 0xC0C090 );

        directionalLight1.position.set( -100, -50, 100 );
        directionalLight2.position.set( 100, 50, -100 );

        this.scene.add( directionalLight1 );
        this.scene.add( directionalLight2 );
        this.scene.add( ambientLight );

        // var helper = new THREE.GridHelper( 1200, 60, 0xFF4444, 0x404040 );
        // this.scene.add( helper );
    },

    initContent: function () {
        var modelName = 'female02';
        this._reportProgress( { detail: { text: 'Loading: ' + modelName } } );

        var scope = this;
        var objLoader = new THREE.OBJLoader2();
        var callbackOnLoad = function ( event ) {
            scope.scene.add( event.detail.loaderRootNode );
            console.log( 'Loading complete: ' + event.detail.modelName );
            scope._reportProgress( { detail: { text: '' } } );
        };

        var onLoadMtl = function ( materials ) {
            objLoader.setModelName( modelName );
            objLoader.setMaterials( materials );
            objLoader.setLogging( true, true );
            objLoader.load( '/models/sdg/sdg.obj', callbackOnLoad, null, null, null, false );
        };
        objLoader.loadMtl( '/models/sdg/sdg.mtl', null, onLoadMtl );
    },

    _reportProgress: function( event ) {
        var output = THREE.LoaderSupport.Validator.verifyInput( event.detail.text, '' );
        console.log( 'Progress: ' + output );
        document.getElementById( 'feedback' ).innerHTML = output;
    },

    resizeDisplayGL: function () {
        this.controls.handleResize();

        this.recalcAspectRatio();
        this.renderer.setSize( this.canvas.offsetWidth, this.canvas.offsetHeight, false );

        this.updateCamera();
    },

    recalcAspectRatio: function () {
        this.aspectRatio = ( this.canvas.offsetHeight === 0 ) ? 1 : this.canvas.offsetWidth / this.canvas.offsetHeight;
    },

    resetCamera: function () {
        this.camera.position.copy( this.cameraDefaults.posCamera );
        this.cameraTarget.copy( this.cameraDefaults.posCameraTarget );

        this.updateCamera();
    },

    updateCamera: function () {
        this.camera.aspect = this.aspectRatio;
        this.camera.lookAt( this.cameraTarget );
        this.camera.updateProjectionMatrix();
    },

    render: function () {
        if ( ! this.renderer.autoClear ) this.renderer.clear();
        this.controls.update();
        this.renderer.render( this.scene, this.camera );
    }

};

var app = new OBJLoader2Example( document.getElementById( 'example' ) );

var resizeWindow = function () {
    app.resizeDisplayGL();
};

var render = function () {
    requestAnimationFrame( render );
    app.render();
};

window.addEventListener( 'resize', resizeWindow, false );

console.log( 'Starting initialisation phase...' );
app.initGL();
app.resizeDisplayGL();
app.initContent();

render();


</script>
<?= FooterWidget::widget()?>
