/**
 * dat.globe Javascript WebGL Globe Toolkit
 * https://github.com/dataarts/webgl-globe
 *
 * Copyright 2011 Data Arts Team, Google Creative Lab
 *
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 */

import * as THREE from 'https://unpkg.com/three@0.95.0/build/three.module.js';

const GLOBE_RADIUS = 150;
const CURVE_MIN_ALTITUDE = 20;
const CURVE_MAX_ALTITUDE = 200;
const DEGREE_TO_RADIAN = Math.PI / 180;

function clamp(num, min, max) {
    return num <= min ? min : (num >= max ? max : num);
}

function coordinateToPosition(lat, lng, radius) {
    const phi = (90 - lat) * DEGREE_TO_RADIAN;
    // const theta = (lng + 180) * DEGREE_TO_RADIAN;
    const theta = lng * DEGREE_TO_RADIAN;

    return new THREE.Vector3(
        - radius * Math.sin(phi) * Math.cos(theta),
        radius * Math.cos(phi),
        radius * Math.sin(phi) * Math.sin(theta)
    );
}

function isFunction(functionToCheck) {
    return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
}

let mousedown = false;
let parsedMosueSave;

function getSplineFromCoords(coords) {
    const startLat = coords[0];
    const startLng = coords[1];
    const endLat = coords[2];
    const endLng = coords[3];
  
    // start and end points
    const start = coordinateToPosition(startLat, startLng, GLOBE_RADIUS);
    const end = coordinateToPosition(endLat, endLng, GLOBE_RADIUS);
    
    // altitude
    const altitude = clamp(start.distanceTo(end) * .75, CURVE_MIN_ALTITUDE, CURVE_MAX_ALTITUDE);
    
    // 2 control points
    const interpolate = d3.geoInterpolate([startLng, startLat], [endLng, endLat]);
    const midCoord1 = interpolate(0.25);
    const midCoord2 = interpolate(0.75);
    const mid1 = coordinateToPosition(midCoord1[1], midCoord1[0], GLOBE_RADIUS + altitude);
    const mid2 = coordinateToPosition(midCoord2[1], midCoord2[0], GLOBE_RADIUS + altitude);
  
    return {
      start,
      end,
      spline: new THREE.CubicBezierCurve3(start, mid1, mid2, end)
    };
  }

const effects = [];
let rotate = true;

const mouseObjects = [];
const hoverCallbacks = [];
const clickCallbacks = [];
const leaveCallbacks = [];

export var DAT = DAT || {};

 DAT.Globe = function(container, opts) {
   opts = opts || {};
   
   var colorFn = opts.colorFn || function(x) {
     var c = new THREE.Color();
     c.setHSL( 0.8, 0.6, 1.0 + x / 2);
    //  c.setHSL( ( 0.6 - ( x * 0.6 ) ), 1.0, 0.62 );
    //  c.setHSL( ( 0.6 - ( x * 0.5 ) ), 1.0, 0.5 );
     return c;
   };
   var imgDir = opts.imgDir || '/img/globe/';

 
   var Shaders = {
     'earth' : {
       uniforms: {
         'texture': { type: 't', value: null }
       },
       vertexShader: [
         'varying vec3 vNormal;',
         'varying vec2 vUv;',
         'void main() {',
           'gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );',
           'vNormal = normalize( normalMatrix * normal );',
           'vUv = uv;',
         '}'
       ].join('\n'),
       fragmentShader: [
         'uniform sampler2D texture;',
         'varying vec3 vNormal;',
         'varying vec2 vUv;',
         'void main() {',
        //    'vec3 diffuse = texture2D( texture, vUv ).xyz;',
           'vec3 diffuse = vec3( 0.1, 0.1, 0.3 );',
           'float intensity = 1.0 - dot( vNormal, vec3( 0.2, -0.3, 0.9 ) ) * 0.84;',
           'vec3 atmosphere = vec3( 0.8, 0.8, 1.0 ) * pow( intensity, 10.0 );',
           'float darkness = max(0.0, dot(vec3(0.5, -0.3, 0.6), vNormal) - 0.4) * 0.3;',
           'float darkness2 = max(0.0, dot(vec3(1.0, -0.2, 0.5), vNormal) - 0.8) * 0.2;',
           'gl_FragColor = vec4( diffuse + atmosphere - darkness - darkness2, 1.0 );',
          //  'gl_FragColor = vec4( darkness2, darkness2, darkness2, 1.0 );',
         '}'
       ].join('\n')
     },
     'atmosphere' : {
       uniforms: {},
       vertexShader: [
         'varying vec3 vNormal;',
         'void main() {',
           'vNormal = normalize( normalMatrix * normal );',
           'gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );',
         '}'
       ].join('\n'),
       fragmentShader: [
         'varying vec3 vNormal;',
         'void main() {',
           'float intensity = pow( 0.8 - dot( vNormal, vec3( 0, 0, 0.9 ) ), 12.0 );',
           'gl_FragColor = vec4( 0.3, 0.4, 1.0, 1.0 ) * intensity;',
         '}'
       ].join('\n')
     }
   };


    const easingFunctions = {
        // no easing, no acceleration
        linear: t => t,
        // accelerating from zero velocity
        easeInQuad: t => t*t,
        // decelerating to zero velocity
        easeOutQuad: t => t*(2-t),
        // acceleration until halfway, then deceleration
        easeInOutQuad: t => t<.5 ? 2*t*t : -1+(4-2*t)*t,
        // accelerating from zero velocity 
        easeInCubic: t => t*t*t,
        // decelerating to zero velocity 
        easeOutCubic: t => (--t)*t*t+1,
        // acceleration until halfway, then deceleration 
        easeInOutCubic: t => t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1,
        // accelerating from zero velocity 
        easeInQuart: t => t*t*t*t,
        // decelerating to zero velocity 
        easeOutQuart: t => 1-(--t)*t*t*t,
        // acceleration until halfway, then deceleration
        easeInOutQuart: t => t<.5 ? 8*t*t*t*t : 1-8*(--t)*t*t*t,
        // accelerating from zero velocity
        easeInQuint: t => t*t*t*t*t,
        // decelerating to zero velocity
        easeOutQuint: t => 1+(--t)*t*t*t*t,
        // acceleration until halfway, then deceleration 
        easeInOutQuint: t => t<.5 ? 16*t*t*t*t*t : 1+16*(--t)*t*t*t*t
    }
 
 let raycaster = new THREE.Raycaster();
 let intersects = [];
 let oceanCtx;

   var camera, scene, renderer, w, h;
   var mesh, atmosphere, point;
 
   var overRenderer;
 
   var curZoomSpeed = 0;
   var zoomSpeed = 50;
 
   var mouse = { x: 0, y: 0 }, mouseOnDown = { x: 0, y: 0 };
   var rotation = { x: 8, y: 0 },
       target = { x: Math.PI*3/2, y: Math.PI / 6.0 },
       targetOnDown = { x: 0, y: 0 };
 
   var distance = 100000, distanceTarget = 100000;
   var padding = 40;
   var PI_HALF = Math.PI / 2;
   let oceansLoaded = false;
   let oceanCallback = () => false;
 
   function init() {
 
     container.style.color = '#fff';
     container.style.font = '13px/20px Arial, sans-serif';
 
     var shader, uniforms, material;
     w = container.offsetWidth || window.innerWidth;
     h = container.offsetHeight || window.innerHeight;
 
     camera = new THREE.PerspectiveCamera(30, w / h, 1, 10000);
     camera.position.z = distance;
 
     scene = new THREE.Scene();
 
     var geometry = new THREE.SphereGeometry(GLOBE_RADIUS, 80, 60);
 
     shader = Shaders['earth'];
     uniforms = THREE.UniformsUtils.clone(shader.uniforms);
 
    //  uniforms['texture'].value = THREE.ImageUtils.loadTexture(imgDir+'world.jpg');
 
     material = new THREE.ShaderMaterial({
           uniforms: uniforms,
           vertexShader: shader.vertexShader,
           fragmentShader: shader.fragmentShader
         });
 
     mesh = new THREE.Mesh(geometry, material);
     mesh.rotation.y = Math.PI;
     scene.add(mesh);

     mouseObjects.push(mesh);
 
     shader = Shaders['atmosphere'];
     uniforms = THREE.UniformsUtils.clone(shader.uniforms);
 
     material = new THREE.ShaderMaterial({
 
           uniforms: uniforms,
           vertexShader: shader.vertexShader,
           fragmentShader: shader.fragmentShader,
           side: THREE.BackSide,
           blending: THREE.AdditiveBlending,
           transparent: true
 
         });
 
     mesh = new THREE.Mesh(geometry, material);
     mesh.scale.set( 1.1, 1.1, 1.1 );
     scene.add(mesh);
 
     geometry = new THREE.BoxGeometry(0.75, 0.75, 1);
     geometry.applyMatrix(new THREE.Matrix4().makeTranslation(0,0,-0.5));
 
     point = new THREE.Mesh(geometry);
 
     renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
     renderer.setSize(w, h);
 
     renderer.domElement.style.position = 'absolute';
 
     container.appendChild(renderer.domElement);
 
     container.addEventListener('mousedown', onMouseDown, false);
     container.addEventListener('touchstart', onMouseDown, false);

     container.addEventListener('mousemove', checkMouse, false);
     container.addEventListener('touchmove', checkMouse, false);
 
    //  container.addEventListener('mousewheel', onMouseWheel, false);
 
     document.addEventListener('keydown', onDocumentKeyDown, false);
 
     window.addEventListener('resize', onWindowResize, false);
 
     container.addEventListener('mouseover', function() {
       overRenderer = true;
     }, false);
 
     container.addEventListener('mouseout', function() {
       overRenderer = false;
     }, false);

     
      const canvas = document.createElement('canvas');
      canvas.width = 318;
      canvas.height = 159;
      canvas.style.display="none";
      document.body.appendChild(canvas);

      oceanCtx = canvas.getContext('2d');
      const img1 = new Image();
      img1.src = '/img/globe/ocean.jpg';

      img1.onload = function () {
          oceanCtx.drawImage(img1, 0, 0);
          oceansLoaded = true;
          // console.log(img1.width);
          oceanCallback();
      };
   }

    function fadeCallback(progress, effect){
        effect.object.material.opacity = 1 - progress;
    }

    function scaleDownCallback(progress, effect){
        effect.object.scale.set(progress, progress, progress);
    }

    function scaleUpCallback(progress, effect){
        effect.object.scale.set(1 + progress, 1 + progress, 1 + progress);
    }

    function rotateCallback(progress, effect){
        effect.object.rotation.y = progress * Math.PI * 2;
    }

    function translateUpCallback(progress, effect){
        const newPos = effect.startPosition.clone();
        newPos.setLength(effect.startPosition.length() + progress * effect.strength);
        effect.object.position.set(newPos.x, newPos.y, newPos.z);
    }

    function translateDownCallback(progress, effect){
        const newPos = effect.startPosition.clone();
        newPos.setLength(effect.startPosition.length() - progress * effect.strength);
        effect.object.position.set(newPos.x, newPos.y, newPos.z);
    }


    function highlightAt(lat, lng, settings) {
        if(!settings) {
            settings = {};
        }
        if(!settings.effects) {
            settings.effects = [];
        }
        /**
         * basic
         */
        const type = settings.type || "cone";
        const resolution = settings.resolution || 30;
        const size = settings.size || 4;
        const width = settings.width || 1;
        const depth = settings.depth || 1;
        const height = settings.height || 1;
        const color = settings.color || 0xff0000;
        const material = settings.material || new THREE.MeshBasicMaterial( {color} );
        
        let xRotOffset = 0;

        let geometry;
        switch(type) {
            case "circle": geometry = new THREE.CircleGeometry( size, resolution ); break;
            case "ring": geometry = new THREE.RingGeometry( size * 0.75, size, resolution ); break;
            case "cube": geometry = new THREE.BoxGeometry( size * width, size * depth, size * height ); break;
            case "icosphere": geometry = new THREE.IcosahedronGeometry( size, 0); break;
            case "cone": geometry = new THREE.ConeGeometry( size / 2, size, resolution ); xRotOffset = Math.PI / 2; break;
            default: throw new Error("highlight type not sopported error");
        }
        
        
        material.transparent = true;
        const highlight = new THREE.Mesh( geometry, material );
        // pos
        const pos = coordinateToPosition(lat, lng, GLOBE_RADIUS + height);
        highlight.position.set(pos.x, pos.y, pos.z);

        // rot
        highlight.rotateY(lng * DEGREE_TO_RADIAN - Math.PI / 2);
        highlight.rotateX(-lat * DEGREE_TO_RADIAN + xRotOffset);

        scene.add( highlight );
        mouseObjects.push(highlight);


        /**
         * effects
         */
        for (const effect of settings.effects) {
            effect.type = effect.type || "fade";
            effect.iterationCount = effect.iterationCount || -1;// -1 => infinite
            effect.duration = effect.duration || 1000;//ms
            effect.delay = effect.delay || 0;
            effect.pause = effect.pause || 0;
            effect.strength = effect.strength || 10;
            effect.onComplete = effect.onComplete || (() => true);
            effect.easing = effect.easing || "linear";
            effect.direction = effect.direction || "normal";//reverse / alternate
            effect.start = Date.now() - skipped;
            effect.object = highlight;
            effect.startPosition = pos;

            if(easingFunctions.hasOwnProperty(effect.easing)) {
                effect.easingFunction = easingFunctions[effect.easing];
            } else {
                effect.easingFunction = easingFunctions["linear"];
            }

            switch(effect.type) {
                case "fade": effect.callback = fadeCallback; break;
                case "scaleDown": effect.callback = scaleDownCallback; break;
                case "scaleUp": effect.callback = scaleUpCallback; break;
                case "translateUp": effect.callback = translateUpCallback; break;
                case "translateDown": effect.callback = translateDownCallback; break;
                case "rotate": effect.callback = rotateCallback; break;
                case "custom": effect.callback = settings.effect.callback || (() => true); break;
                default: throw new Error("effect type '" + effectType + "' is not supported");
            }

            effects.push(effect);
        }
    }

    let runAnimations = true;
    let animPause = 0;
    let skipped = 0;
    function pauseAnimations() {
      if(!runAnimations) return;

      animPause = Date.now();
      runAnimations = false;
    }

    function startAnimations() {
      if(runAnimations) return;

      runAnimations = true;
      skipped += (Date.now() - animPause);
    }

    function tickEffects() {
        if(!runAnimations) return;
        const millis = Date.now() - skipped;
        const removals = [];
        for (const effect of effects) {
            const lifetime = millis - (effect.start + effect.delay);
            const iterations = Math.floor(lifetime / (effect.duration + effect.pause));

            if(lifetime < 0) continue;
            const alive = effect.iterationCount === -1 || iterations < effect.iterationCount;
            if(!alive) {
                removals.push(effect);
                continue;
            }
            let progress = lifetime % (effect.duration + effect.pause) / effect.duration - (effect.pause / effect.duration / 2);
            if(effect.direction === "reverse") {
                progress = 1 - progress;
            }
            if(effect.direction === "alternate" && lifetime / (effect.duration + effect.pause) % 2 >= 1) {
                progress = 1 - progress;
            }
            progress = Math.min(1, Math.max(0, progress));
            progress = effect.easingFunction(progress);
            effect.callback(progress, effect);
        }
        for (const removal of removals) {
            if(removal.onComplete && isFunction(removal.onComplete)) {
                removal.onComplete();
            } else if(removal.onComplete) {
                removal.onComplete.callback();
            }
            effects.splice(effects.indexOf(removal), 1);
            // console.log("removed effect of type " + removal.type);
        }
    }

    function trajectoryFromTo(startLat, startLng, endLat, endLng, settings) {
        if(!settings) {
            settings = {};
        }

        const resolution = settings.resolution || 26;
        const color = settings.color || 0xff0000
        const material = settings.material || new THREE.LineDashedMaterial( {linewidth: 3, color, opacity: 0.5, dashSize: 0, gapSize: 100000, scale: 1} );
        const visible = settings.visible || true;
        
        const onclick = settings.onclick || false;
        const onhover = settings.onhover || false;
        const onleave = settings.onleave || false;

        let curve = getSplineFromCoords([ startLat, startLng, endLat, endLng ]);
        let curve2 = getSplineFromCoords([ endLat, endLng, startLat, startLng ]);

        const points = curve.spline.getPoints( resolution );
        const points2 = curve2.spline.getPoints( resolution );
        let geometry = new THREE.BufferGeometry().setFromPoints( points );
        let geometry2 = new THREE.BufferGeometry().setFromPoints( points2 );

        const splineObject = new THREE.Line( geometry, material );
        const splineObject2 = new THREE.Line( geometry2, material );
        splineObject.computeLineDistances();
        splineObject2.computeLineDistances();
        const ld = splineObject.geometry.getAttribute("lineDistance");
        const lineLength = ld.getX(ld.count - 1);
        splineObject.visible = visible;
        splineObject2.visible = false;  

        return {
            animate: (direction = "in", fillMode = "forewards", duration = 1000, delay = 0, easing = "easeInQuad") => {
              // console.log(direction)
                direction = direction === "in";
                fillMode = fillMode === "forewards";

                scene.add( splineObject );
                scene.add( splineObject2 );
                /**
                 * mouse stuff
                 */
                if(onhover || onclick || onleave) {
                  mouseObjects.push(splineObject);
                }
                if(onhover) {
                  hoverCallbacks[splineObject.id] = onhover;
                }
                if(onhover) {
                  clickCallbacks[splineObject.id] = onclick;
                }
                if(onleave) {
                  leaveCallbacks[splineObject.id] = onleave;
                }

                const effect = {
                    duration,
                    delay,
                    pause: 0,
                    type: "lineSpecial",
                    direction: direction ? "normal" : "reverse",
                    iterationCount: 1,
                    easingFunction: easingFunctions[easing],
                    start: Date.now() - skipped,
                    object: splineObject,
                    callback: (progress, effect) => {
                        splineObject.material.dashSize = progress * lineLength;
                        if(fillMode) {
                            splineObject2.visible = false;
                            splineObject.visible = true;
                        } else {
                            splineObject2.visible = true;
                            splineObject.visible = false;
                        }
                    }
                }

                const onCompleteObj = {
                    onComplete: (func) => {
                        onCompleteObj.callback = () => {
                            if(!direction) {
                                removeEntity(splineObject);
                                removeEntity(splineObject2);
                            }
                            func();
                        }
                    },
                    callback: () => {
                        if(!direction) {
                            removeEntity(splineObject);
                            removeEntity(splineObject2);
                        }
                    },
                }
                effect.onComplete = onCompleteObj;
                effects.push(effect);
                return onCompleteObj;
            },
        };
    }
 
   function addData(data, opts) {
     var lat, lng, size, color, i, step, colorFnWrapper;
 
     opts.animated = opts.animated || false;
     this.is_animated = opts.animated;
     opts.format = opts.format || 'magnitude'; // other option is 'legend'
     if (opts.format === 'magnitude') {
       step = 3;
       colorFnWrapper = function(data, i) { return colorFn(data[i+2]); }
     } else if (opts.format === 'legend') {
       step = 4;
       colorFnWrapper = function(data, i) { return colorFn(data[i+3]); }
     } else {
       throw('error: format not supported: '+opts.format);
     }
 
     if (opts.animated) {
       if (this._baseGeometry === undefined) {
         this._baseGeometry = new THREE.Geometry();
         for (i = 0; i < data.length; i += step) {
           lat = data[i];
           lng = data[i + 1];
 //        size = data[i + 2];
           color = colorFnWrapper(data,i);
           size = 0;
           addPoint(lat, lng, size, color, this._baseGeometry);
         }
       }
       if(this._morphTargetId === undefined) {
         this._morphTargetId = 0;
       } else {
         this._morphTargetId += 1;
       }
       opts.name = opts.name || 'morphTarget'+this._morphTargetId;
     }
     var subgeo = new THREE.Geometry();
     for (i = 0; i < data.length; i += step) {
       lat = data[i];
       lng = data[i + 1];
       color = colorFnWrapper(data,i);
       size = data[i + 2];
       size = easingFunctions.easeOutQuint(size);
       size *= 5;

       addPoint(lat, lng, size, color, subgeo);
     }
     if (opts.animated) {
       this._baseGeometry.morphTargets.push({'name': opts.name, vertices: subgeo.vertices});
     } else {
       this._baseGeometry = subgeo;
     }
 
   };
 
   function createPoints() {
     if (this._baseGeometry !== undefined) {
       if (this.is_animated === false) {
         this.points = new THREE.Mesh(this._baseGeometry, new THREE.MeshBasicMaterial({
               color: 0xffffff,
               vertexColors: THREE.FaceColors,
               morphTargets: false
             }));
       } else {
         if (this._baseGeometry.morphTargets.length < 8) {
           console.log('t l',this._baseGeometry.morphTargets.length);
           var padding = 8-this._baseGeometry.morphTargets.length;
           console.log('padding', padding);
           for(var i=0; i<=padding; i++) {
             console.log('padding',i);
             this._baseGeometry.morphTargets.push({'name': 'morphPadding'+i, vertices: this._baseGeometry.vertices});
           }
         }
         this.points = new THREE.Mesh(this._baseGeometry, new THREE.MeshBasicMaterial({
               color: 0xffffff,
               vertexColors: THREE.FaceColors,
               morphTargets: true
             }));
       }
       scene.add(this.points);
     }
   }
 
   function addPoint(lat, lng, size, color, subgeo) {
 
     var phi = (90 - lat) * Math.PI / 180;
     var theta = (180 - lng) * Math.PI / 180;
 
     point.position.x = GLOBE_RADIUS * Math.sin(phi) * Math.cos(theta);
     point.position.y = GLOBE_RADIUS * Math.cos(phi);
     point.position.z = GLOBE_RADIUS * Math.sin(phi) * Math.sin(theta);
 
     point.lookAt(mesh.position);
 
     point.scale.z = Math.max( size, 0.1 ); // avoid non-invertible matrix
     point.updateMatrix();
 
     for (var i = 0; i < point.geometry.faces.length; i++) {
 
       point.geometry.faces[i].color = color;
 
     }
     if(point.matrixAutoUpdate){
       point.updateMatrix();
     }
     subgeo.merge(point.geometry, point.matrix);
   }

   function parseTouchEvent(event) {
    if(event.touches?.length > 0) {
        event.clientX = event.touches[0].clientX;
        event.clientY = event.touches[0].clientY;

        const rect = event.target.getBoundingClientRect();
        event.offsetX = event.clientX - rect.left;
        event.offsetY = event.clientX - rect.top;
        // console.log(event);
    }
    return event;
   }
 
   function onMouseDown(event) {
      mousedown = true;
      rotate = false;
      // event.preventDefault();
 
     event = parseTouchEvent(event);
     
     container.addEventListener('mousemove', onMouseMove, false);
     container.addEventListener('mouseup', onMouseUp, false);
     container.addEventListener('mouseout', onMouseOut, false);

     container.addEventListener('touchmove', onMouseMove, false);
     container.addEventListener('touchend', onMouseUp, false);
     container.addEventListener('touchleave', onMouseOut, false);
     
     if(!event.clientX) {
       return;
      }
      
      mouseOnDown.x = - event.clientX;
      mouseOnDown.y = event.clientY;
      
      targetOnDown.x = target.x;
      targetOnDown.y = target.y;
      
      container.style.cursor = 'move';
      onMouseMove(event)
   }
 
   function isTouchEvent(e) {
     return e.touches !== undefined;
   }

   function onMouseMove(event) {

    event = parseTouchEvent(event);

     mouse.x = - event.clientX;
     mouse.y = event.clientY;
 
     var zoomDamp = distance/1000;
 
     target.x = targetOnDown.x + (mouse.x - mouseOnDown.x) * 0.005 * zoomDamp;
     if(!isTouchEvent(event)) {
       target.y = targetOnDown.y + (mouse.y - mouseOnDown.y) * 0.005 * zoomDamp;
     }
 
     target.y = target.y > PI_HALF ? PI_HALF : target.y;
     target.y = target.y < - PI_HALF ? - PI_HALF : target.y;
   }
 
   function onMouseUp(event) {
    mousedown = false;
    rotate = true;
    checkMouse(event, true);
    container.removeEventListener('mousemove', onMouseMove, false);
     container.removeEventListener('mouseup', onMouseUp, false);
     container.removeEventListener('mouseout', onMouseOut, false);

     container.removeEventListener('touchmove', onMouseMove, false);
     container.removeEventListener('touchend', onMouseUp, false);
     container.removeEventListener('touchleave', onMouseOut, false);
     container.style.cursor = 'auto';
   }
 
   function onMouseOut(event) {
    mousedown = false;
    rotate = true;
    container.removeEventListener('mousemove', onMouseMove, false);
     container.removeEventListener('mouseup', onMouseUp, false);
     container.removeEventListener('mouseout', onMouseOut, false);

     container.removeEventListener('touchmove', onMouseMove, false);
     container.removeEventListener('touvhend', onMouseUp, false);
     container.removeEventListener('touchleave', onMouseOut, false);
   }
 
   function onMouseWheel(event) {
     event.preventDefault();
     if (overRenderer) {
       zoom(event.wheelDeltaY * 0.3);
     }
     return false;
   }
 
   function onDocumentKeyDown(event) {
     switch (event.keyCode) {
       case 38:
         zoom(100);
         event.preventDefault();
         break;
       case 40:
         zoom(-100);
         event.preventDefault();
         break;
     }
   }

   function onWindowResize( event ) {
    // console.log($(container).innerHeight());
    camera.aspect = container.offsetWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize( container.offsetWidth, container.clientHeight );
   }
 
   function zoom(delta) {
     distanceTarget -= delta;
     distanceTarget = distanceTarget > 1000 ? 1000 : distanceTarget;
     distanceTarget = distanceTarget < 350 ? 350 : distanceTarget;
   }
 
   function animate() {
     requestAnimationFrame(animate);
     tickEffects();
     render();
   }
 
   function render() {
     zoom(curZoomSpeed);
     if(!isMobile()) {
       checkMouse();
     }
     rotation.x += (target.x - rotation.x) * 0.1;
     rotation.y += (target.y - rotation.y) * 0.1;
     distance += (distanceTarget - distance) * 0.3;
    if(rotate) {
        target.x -= 0.001;
    } else {
      target.x = rotation.x;
    }

     camera.position.x = distance * Math.sin(rotation.x) * Math.cos(rotation.y);
     camera.position.y = distance * Math.sin(rotation.y);
     camera.position.z = distance * Math.cos(rotation.x) * Math.cos(rotation.y);

     camera.lookAt(mesh.position);
 
     renderer.render(scene, camera);
   }
 
   init();
   this.animate = animate;
 
 
   this.__defineGetter__('time', function() {
     return this._time || 0;
   });
 
   this.__defineSetter__('time', function(t) {
     var validMorphs = [];
     var morphDict = this.points.morphTargetDictionary;
     for(var k in morphDict) {
       if(k.indexOf('morphPadding') < 0) {
         validMorphs.push(morphDict[k]);
       }
     }
     validMorphs.sort();
     var l = validMorphs.length-1;
     var scaledt = t*l+1;
     var index = Math.floor(scaledt);
     for (i=0;i<validMorphs.length;i++) {
       this.points.morphTargetInfluences[validMorphs[i]] = 0;
     }
     var lastIndex = index - 1;
     var leftover = scaledt - index;
     if (lastIndex >= 0) {
       this.points.morphTargetInfluences[lastIndex] = 1 - leftover;
     }
     this.points.morphTargetInfluences[index] = leftover;
     this._time = t;
    });

    function removeEntity(object) {
        // console.log(object.name);
        scene.remove(object);
        object.geometry.dispose();
        object.material.dispose();
        if(mouseObjects.includes(object)) {
          mouseObjects.splice(mouseObjects.indexOf(object), 1);
          hoverCallbacks[object.id] = undefined;
          clickCallbacks[object.id] = undefined;
          leaveCallbacks[object.id] = undefined;
        }
    }

    function initPopulationDots() {
        this.addData( continents[1], {format: 'magnitude', name: "continents"} );
        this.createPoints();
    }

    function initSurfaceDots() {
        if(!oceansLoaded) {
          oceanCallback = () => {
            this.initSurfaceDots();
          };
          return;
        }
        const data = [];
        const rows = 170;
        const dotDensity = 0.4;
        for (let lat = -90; lat < 90; lat += 180 / rows) {
            const radius = Math.cos(Math.abs(lat) * DEGREE_TO_RADIAN) * GLOBE_RADIUS;
            const circumference = radius * Math.PI * 2;
            const dotsForLat = circumference * dotDensity;
            for (let x = 0; x < dotsForLat; x++) {
                const long = -180 + x * 360 / dotsForLat;
                if (!visibilityForCoordinate(long, lat)) continue;
                data.push(lat);
                data.push(long);
                data.push(0);
            }
        }
        this.addData( data, {format: 'magnitude', name: "surface"} );
        this.createPoints();
    }

    function visibilityForCoordinate(long, lat) {
      const width = 318;
      const height = 159;
      const x = (((long / 180 + 1) / 2) % 1) * width;
      const y = (((-lat / 90 + 1) / 2) % 1) * height;
      return oceanCtx.getImageData(x, y, 1, 1).data[0] < 90;
    }

    function kmToDregree(km) {
        return Math.atan(kmToUnit(km) / GLOBE_RADIUS) * 180 / Math.PI;
    }

    const earthCircumference = 40075;

    function kmToUnit(km) {
        return km * ((GLOBE_RADIUS * 2 * Math.PI) / earthCircumference);
    }
    
    let lastHovered;
    function checkMouse(e, click = false) {
      if(e) {
        e = parseTouchEvent(e);
        parsedMosueSave = e;
      } else if(parsedMosueSave && overRenderer){
        e = parsedMosueSave;
      } else {
        return;
      }
        const mouseVec = new THREE.Vector2(
          (e.offsetX / container.offsetWidth) * 2 - 1,
          -(e.offsetY/ container.offsetHeight) * 2 + 1);
        raycaster.setFromCamera(mouseVec, camera);
    	  intersects = raycaster.intersectObjects(mouseObjects);
          // console.log(mouseVec);
        let hovered;
        if(intersects.length > 0) {
          const hit = intersects[0];
          hovered = hit.object.id;
          if(hit.object.type === "Line") {
            if(hoverCallbacks[hit.object.id]) {
              hoverCallbacks[hit.object.id](hit.object, e, mousedown);
            }
            if(click && clickCallbacks[hit.object.id]) {
              clickCallbacks[hit.object.id](hit.object, e, mousedown);
            }
          }
        }
        if(hovered !== lastHovered) {
          if(leaveCallbacks[lastHovered]) {
            leaveCallbacks[lastHovered](scene.getObjectById(lastHovered, true), e, mousedown);
          }
        }
        lastHovered = hovered;
    }

    function stopRotation() {
      rotate = false;
    }

    function startRotation() {
      rotate = true;
    }

   this.addData = addData;
   this.createPoints = createPoints;
   this.renderer = renderer;
   this.scene = scene;
   this.tickEffects = tickEffects;
   this.trajectoryFromTo = trajectoryFromTo;
   this.initPopulationDots = initPopulationDots;
   this.highlightAt = highlightAt;
   this.kmToDregree = kmToDregree;
   this.initSurfaceDots = initSurfaceDots;
   this.stopRotation = stopRotation;
   this.startRotation = startRotation;
   this.pauseAnimations = pauseAnimations;
   this.startAnimations = startAnimations;
 
   return this;

 };