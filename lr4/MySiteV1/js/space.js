/**
 * Space Explorer - Mini Game
 * Premium Interactive 3D Space Engine
 */

class SpaceSimulator {
    constructor(containerSelector) {
        this.container = document.querySelector(containerSelector);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.composer = null; // For post-processing effects

        // Game Objects
        this.stars = [];
        this.planets = [];
        this.starfield = null;
        this.raycaster = new THREE.Raycaster();
        this.mouse = new THREE.Vector2();

        // Game State
        this.gameState = {
            systemsExplored: 0,
            habitablePlanetsFound: 0,
            isScanning: false,
            scanProgress: 0,
            isWarping: false
        };

        // UI Elements
        this.hud = null;
        this.crosshair = null;
        this.scanBar = null;
        
        this.selectedObject = null;
        this.cameraTargetPosition = null;
        this.cameraAnimating = false;

        this.animationTime = 0;
        this.clock = new THREE.Clock();
    }

    async init() {
        this.setupScene();
        this.setupCamera();
        this.setupRenderer();
        this.setupPostProcessing();
        this.setupLights();
        
        this.setupUI();
        this.setupEventListeners();

        // Show loading
        this.container.querySelector('.space-loading').classList.remove('hidden');
        
        await this.loadSystemData();
        this.createStarfield();
        this.createStars();
        this.createPlanets();
        this.setupControls();
        
        this.container.querySelector('.space-loading').classList.add('hidden');
        this.animate();
    }

    setupScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x02040a);
        this.scene.fog = new THREE.FogExp2(0x02040a, 0.0001);
    }

    setupCamera() {
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        this.camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 5000);
        this.camera.position.set(0, 150, 400);
        this.camera.lookAt(0, 0, 0);
    }

    setupRenderer() {
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;

        this.renderer = new THREE.WebGLRenderer({ antialias: true, powerPreference: "high-performance" });
        this.renderer.setSize(width, height);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.toneMapping = THREE.ReinhardToneMapping;
        this.renderer.toneMappingExposure = 1.2;
        
        this.container.appendChild(this.renderer.domElement);
    }

    setupPostProcessing() {
        if (typeof THREE.EffectComposer === 'undefined') return;

        const renderScene = new THREE.RenderPass(this.scene, this.camera);
        // Resolution, strength, radius, threshold
        const bloomPass = new THREE.UnrealBloomPass(
            new THREE.Vector2(window.innerWidth, window.innerHeight),
            1.5, 0.4, 0.85
        );
        bloomPass.threshold = 0.2;
        bloomPass.strength = 1.2; 
        bloomPass.radius = 0.5;

        this.composer = new THREE.EffectComposer(this.renderer);
        this.composer.addPass(renderScene);
        this.composer.addPass(bloomPass);
    }

    setupLights() {
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.1);
        this.scene.add(ambientLight);
    }

    async loadSystemData() {
        try {
            const seed = Math.floor(Math.random() * 100000);
            const response = await fetch(`generate_system.php?seed=${seed}`);
            const data = await response.json();
            this.universeData = data;
            this.gameState.systemsExplored++;
            this.updateStatsTracker();
        } catch (error) {
            console.error('Failed to load universe schema');
        }
    }

    createStarfield() {
        if(this.starfield) this.scene.remove(this.starfield);

        const starsGeometry = new THREE.BufferGeometry();
        const starCount = 3000;
        const positions = new Float32Array(starCount * 3);
        const colors = new Float32Array(starCount * 3);

        for (let i = 0; i < starCount * 3; i += 3) {
            // spherical distribution
            const r = 1000 + Math.random() * 3000;
            const theta = 2 * Math.PI * Math.random();
            const phi = Math.acos(2 * Math.random() - 1);
            
            positions[i] = r * Math.sin(phi) * Math.cos(theta);
            positions[i + 1] = r * Math.sin(phi) * Math.sin(theta);
            positions[i + 2] = r * Math.cos(phi);

            // subtle coloring
            const mixColor = new THREE.Color();
            mixColor.setHSL(Math.random(), 0.8, 0.8);
            colors[i] = mixColor.r;
            colors[i + 1] = mixColor.g;
            colors[i + 2] = mixColor.b;
        }

        starsGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        starsGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

        const starsMaterial = new THREE.PointsMaterial({
            size: 2.0,
            vertexColors: true,
            transparent: true,
            opacity: 0.8,
            sizeAttenuation: true
        });

        this.starfield = new THREE.Points(starsGeometry, starsMaterial);
        this.scene.add(this.starfield);
    }

    createStars() {
        // Clear old
        this.stars.forEach(s => this.scene.remove(s));
        this.stars = [];

        this.universeData.systems.forEach(system => {
            const data = system.star;
            // A more detailed geometry for stars
            const geometry = new THREE.IcosahedronGeometry(data.size, 12);
            const material = new THREE.MeshBasicMaterial({ color: data.color });
            const star = new THREE.Mesh(geometry, material);
            star.position.fromArray(data.position);
            star.userData = data;
            this.scene.add(star);

            const starLight = new THREE.PointLight(data.color, 2.5, 2000);
            starLight.position.copy(star.position);
            this.scene.add(starLight);

            // Inner core glow
            const glowMat = new THREE.MeshBasicMaterial({
                color: data.color, transparent: true, opacity: 0.3, side: THREE.BackSide, blending: THREE.AdditiveBlending
            });
            const glowMesh = new THREE.Mesh(new THREE.IcosahedronGeometry(data.size * 1.4, 12), glowMat);
            glowMesh.position.copy(star.position);
            this.scene.add(glowMesh);
            
            this.stars.push(star);
        });
    }

    createPlanets() {
        // Clear old
        this.planets.forEach(p => this.scene.remove(p.mesh));
        this.planets = [];

        this.universeData.systems.forEach(system => {
            system.planets.forEach((data, index) => {
                const geometry = new THREE.IcosahedronGeometry(Math.max(data.size, 1), 16);
                
                // Procedural-like material
                const material = new THREE.MeshPhongMaterial({
                    color: data.color,
                    emissive: new THREE.Color(data.color).multiplyScalar(0.1),
                    shininess: data.habitability > 50 ? 50 : 5,
                    flatShading: true
                });

                const planet = new THREE.Mesh(geometry, material);
                planet.position.fromArray(data.position);
                planet.userData = { ...data, isScanned: false };

                this.scene.add(planet);

                // Atmosphere
                if(data.atmosphere !== 'None') {
                    const atmoMat = new THREE.MeshPhongMaterial({
                        color: data.color, transparent: true, opacity: 0.2, side: THREE.BackSide, blending: THREE.AdditiveBlending, depthWrite: false
                    });
                    const atmoMesh = new THREE.Mesh(new THREE.IcosahedronGeometry(Math.max(data.size, 1) * 1.2, 16), atmoMat);
                    planet.add(atmoMesh);
                }

                this.planets.push({
                    mesh: planet,
                    data: data,
                    angle: Math.random() * Math.PI * 2
                });
            });
        });
    }

    setupControls() {
        this.controls = new THREE.FlyControls(this.camera, this.renderer.domElement);
        this.controls.movementSpeed = 80;
        this.controls.domElement = this.renderer.domElement;
        this.controls.rollSpeed = Math.PI / 12;
        this.controls.autoForward = false;
        this.controls.dragToLook = true;
    }

    setupUI() {
        // HUD
        this.hud = document.createElement('div');
        this.hud.className = 'glass-panel space-hud';
        this.hud.innerHTML = `
            <div class="hud-title"><span class="planet-icon">⊕</span> <span id="hud-name">Scanning...</span></div>
            <div id="hud-content"></div>
            <div class="scan-container hidden" id="scan-bar-container">
                <div class="scan-label">Analyzing Target...</div>
                <div class="scan-bar-bg"><div class="scan-bar-fill" id="scan-bar"></div></div>
            </div>
        `;
        this.container.appendChild(this.hud);

        // Stats Tracker
        const tracker = document.createElement('div');
        tracker.className = 'glass-panel game-stats-tracker';
        tracker.innerHTML = `
            <div class="tracker-item"><span>Systems Explored:</span><span id="stat-systems" style="color:#00d2ff; font-weight:bold;">0</span></div>
            <div class="tracker-item"><span>Habitable Worlds:</span><span id="stat-habitable" style="color:#69f0ae; font-weight:bold;">0</span></div>
        `;
        this.container.appendChild(tracker);

        // Loading
        const loader = document.createElement('div');
        loader.className = 'space-loading hidden';
        loader.innerHTML = `<div class="loading-spinner"></div><div>INITIATING HYPERJUMP</div>`;
        this.container.appendChild(loader);

        // Crosshair
        this.crosshair = document.createElement('div');
        this.crosshair.className = 'space-crosshair';
        this.container.appendChild(this.crosshair);

        // Warp Btn
        const warpContainer = document.createElement('div');
        warpContainer.className = 'jump-btn-container';
        warpContainer.innerHTML = `<button class="btn-hyperjump"><span class="icon">⚡</span> Hyperjump</button>`;
        this.container.appendChild(warpContainer);
        warpContainer.querySelector('.btn-hyperjump').onclick = () => this.initiateWarp();

        // Warp overlay
        const warpOverlay = document.createElement('div');
        warpOverlay.className = 'warp-overlay';
        warpOverlay.id = 'warp-overlay';
        this.container.appendChild(warpOverlay);

        // Controls info
        const controls = document.createElement('div');
        controls.className = 'glass-panel space-controls';
        controls.innerHTML = `
            <div class="space-controls-title">SYSTEM PROTOCOLS</div>
            <div class="controls-grid">
                <div class="control-item"><span class="key">W</span><span class="key">A</span><span class="key">S</span><span class="key">D</span> Move</div>
                <div class="control-item"><span class="key">R</span><span class="key">F</span> Up/Down</div>
                <div class="control-item"><span class="key">Mouse</span> Look (Drag)</div>
                <div class="control-item"><span class="key">Click</span> Target/Scan</div>
                <div class="control-item"><span class="key">ESC</span> Cancel Target</div>
            </div>
        `;
        this.container.appendChild(controls);

        // Back link
        const backBtn = document.createElement('button');
        backBtn.className = 'space-back-btn';
        backBtn.innerHTML = '← Disconnect';
        backBtn.onclick = () => window.location.href = 'index.php?route=index/main';
        this.container.appendChild(backBtn);
    }

    updateStatsTracker() {
        document.getElementById('stat-systems').innerText = this.gameState.systemsExplored;
        document.getElementById('stat-habitable').innerText = this.gameState.habitablePlanetsFound;
    }

    setupEventListeners() {
        this.container.addEventListener('click', (e) => {
            // Ignore if clicking UI
            if(e.target.closest('.space-hud') || e.target.closest('.space-controls') || e.target.closest('.jump-btn-container')) return;
            this.onCanvasClick(e);
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.deselectObject();
        });
        window.addEventListener('resize', () => this.onWindowResize());
    }

    onCanvasClick(event) {
        if(this.gameState.isWarping) return;
        
        const rect = this.renderer.domElement.getBoundingClientRect();
        this.mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        this.mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        this.raycaster.setFromCamera(this.mouse, this.camera);
        const allObjects = [...this.stars, ...this.planets.map(p => p.mesh)];
        const intersects = this.raycaster.intersectObjects(allObjects);

        if (intersects.length > 0) {
            const selected = intersects[0].object;
            this.selectObject(selected);
        }
    }

    selectObject(object) {
        if(this.gameState.isScanning) return; // Busy
        
        this.selectedObject = object;
        this.crosshair.classList.add('active');

        // Approach camera
        const distance = object.userData.size * 5 + 30;
        const direction = new THREE.Vector3(1, 0.5, 1).normalize();
        this.cameraTargetPosition = object.position.clone().add(direction.multiplyScalar(distance));
        this.cameraAnimating = true;

        this.hud.classList.add('active');
        
        if (object.userData.type === 'planet' && !object.userData.isScanned) {
            this.startScan(object);
        } else {
            this.displayObjectInfo(object.userData);
        }
    }

    startScan(object) {
        this.gameState.isScanning = true;
        document.getElementById('hud-name').innerText = "Scanning " + object.userData.name + "...";
        document.getElementById('hud-content').innerHTML = "";
        
        const scanContainer = document.getElementById('scan-bar-container');
        const scanBar = document.getElementById('scan-bar');
        scanContainer.classList.remove('hidden');
        
        let progress = 0;
        const scanTime = object.userData.scanDifficulty * 500; // ms
        const interval = 50;
        const step = (interval / scanTime) * 100;

        const scanInterval = setInterval(() => {
            progress += step;
            scanBar.style.width = Math.min(progress, 100) + "%";
            
            if(progress >= 100) {
                clearInterval(scanInterval);
                this.gameState.isScanning = false;
                scanContainer.classList.add('hidden');
                object.userData.isScanned = true;
                
                if(object.userData.habitability > 80) {
                    this.gameState.habitablePlanetsFound++;
                    this.updateStatsTracker();
                }
                
                if(this.selectedObject === object) { // If still selected
                    this.displayObjectInfo(object.userData);
                }
            }
        }, interval);
    }

    displayObjectInfo(data) {
        document.getElementById('hud-name').innerText = data.name;
        
        let content = `
            <div class="hud-item">
                <span class="hud-label">CLASSIFICATION</span>
                <span class="hud-value">${data.type.toUpperCase()}</span>
            </div>
        `;

        if (data.type === 'planet') {
            const habStatus = data.habitability > 80 ? 'good' : (data.habitability < 20 ? 'rare' : '');
            
            content += `
                <div class="hud-item">
                    <span class="hud-label">Radius</span>
                    <span class="hud-value">${(data.size * 3000).toFixed(0)} km</span>
                </div>
                <div class="hud-item">
                    <span class="hud-label">Habitability</span>
                    <span class="hud-value ${habStatus}">${data.habitability}%</span>
                </div>
                <div class="hud-item">
                    <span class="hud-label">Atmosphere</span>
                    <span class="hud-value">${data.atmosphere}</span>
                </div>
                <div class="hud-item" style="flex-direction:column; align-items:flex-start; margin-top:15px; border-top:1px solid rgba(255,255,255,0.1); padding-top:10px;">
                    <span class="hud-label" style="color:#b388ff">Detected Resources</span>
                    <span class="hud-value" style="font-size:0.85rem; margin-top:5px;">${data.resources}</span>
                </div>
            `;
        } else {
            content += `
                <div class="hud-item">
                    <span class="hud-label">Core Temp</span>
                    <span class="hud-value" style="color:#ff9e80">${data.temperature}K</span>
                </div>
                <div class="hud-item">
                    <span class="hud-label">Energy Output</span>
                    <span class="hud-value">${(data.size * 1.5).toFixed(1)} PHz</span>
                </div>
            `;
        }

        document.getElementById('hud-content').innerHTML = content;
    }

    deselectObject() {
        if(this.gameState.isScanning) return;
        this.selectedObject = null;
        this.cameraAnimating = false;
        this.hud.classList.remove('active');
        this.crosshair.classList.remove('active');
    }

    async initiateWarp() {
        if(this.gameState.isWarping) return;
        this.gameState.isWarping = true;
        this.deselectObject();

        const overlay = document.getElementById('warp-overlay');
        const loader = this.container.querySelector('.space-loading');
        
        // Flash Screen
        overlay.classList.add('active');
        loader.classList.remove('hidden');

        // Fetch new data
        await this.loadSystemData();

        setTimeout(() => {
            // Rebuild world
            this.createStarfield();
            this.createStars();
            this.createPlanets();
            
            // Random camera position
            this.camera.position.set(Math.random()*200, 150, Math.random()*200);
            
            // Remove flash
            overlay.classList.remove('active');
            loader.classList.add('hidden');
            this.gameState.isWarping = false;
        }, 1500);
    }

    updatePlanetOrbits(deltaTime) {
        this.planets.forEach(planet => {
            planet.angle += planet.data.orbitSpeed * 0.05;

            const starPos = planet.data.starPosition;
            const x = starPos[0] + Math.cos(planet.angle) * planet.data.orbitRadius;
            const z = starPos[2] + Math.sin(planet.angle) * planet.data.orbitRadius;
            
            // Allow slight vertical orbit tilt based on initial data
            planet.mesh.position.set(x, planet.data.position[1], z);

            planet.mesh.rotation.y += 0.01;
        });
    }

    updateCameraAnimation() {
        if (!this.cameraAnimating || !this.cameraTargetPosition) return;

        const currentPos = this.camera.position;
        const distance = currentPos.distanceTo(this.cameraTargetPosition);
        
        if (distance > 1.0) {
            currentPos.lerp(this.cameraTargetPosition, 0.05);
        } else {
            this.cameraAnimating = false;
        }

        if (this.selectedObject) {
            // Smoothly look at target
            const targetRot = new THREE.Quaternion();
            const m = new THREE.Matrix4();
            m.lookAt(this.camera.position, this.selectedObject.position, this.camera.up);
            targetRot.setFromRotationMatrix(m);
            this.camera.quaternion.slerp(targetRot, 0.1);
        }
    }

    onWindowResize() {
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;

        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
        if(this.composer) this.composer.setSize(width, height);
    }

    animate() {
        requestAnimationFrame(() => this.animate());

        const delta = this.clock.getDelta();
        
        if(!this.gameState.isWarping) {
            this.updatePlanetOrbits(delta);
            this.updateCameraAnimation();
            
            // Only update controls if not forcefully animating camera to a target
            if(!this.cameraAnimating) {
                this.controls.update(delta);
            }
        }

        if (this.composer) {
            this.composer.render();
        } else {
            this.renderer.render(this.scene, this.camera);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('#space-canvas');
    if (container) {
        const simulator = new SpaceSimulator('#space-canvas');
        simulator.init();
    }
});


