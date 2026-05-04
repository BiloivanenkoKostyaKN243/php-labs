const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

const controls = new THREE.OrbitControls(camera, renderer.domElement);
camera.position.set(0, 50, 100);
controls.update();

const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(0, 0, 0);
scene.add(light);

const ambientLight = new THREE.AmbientLight(0x404040, 0.2);
scene.add(ambientLight);

let starMesh;
let planetMeshes = [];
let planetsData = [];

const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();
const infoDiv = document.getElementById('info');

function onMouseClick(event) {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(planetMeshes);
    if (intersects.length > 0) {
        const planet = planetsData[planetMeshes.indexOf(intersects[0].object)];
        infoDiv.innerHTML = `Planet: ${planet.name}<br>Distance: ${planet.distance}<br>Size: ${planet.size}`;
        infoDiv.style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
    }
}

window.addEventListener('click', onMouseClick);

function loadSystem(seed) {
    fetch(`api/system.php?seed=${seed}`)
        .then(response => response.json())
        .then(data => {
            // Очистка предыдущих объектов
            if (starMesh) scene.remove(starMesh);
            planetMeshes.forEach(mesh => scene.remove(mesh));
            planetMeshes = [];
            planetsData = data.planets;

            // Создание звезды
            const starGeometry = new THREE.SphereGeometry(data.star.size, 32, 32);
            const starMaterial = new THREE.MeshBasicMaterial({ color: data.star.color, emissive: data.star.color, emissiveIntensity: 0.5 });
            starMesh = new THREE.Mesh(starGeometry, starMaterial);
            scene.add(starMesh);

            // Создание планет
            data.planets.forEach(planet => {
                const planetGeometry = new THREE.SphereGeometry(planet.size, 16, 16);
                const planetMaterial = new THREE.MeshLambertMaterial({ color: planet.color });
                const planetMesh = new THREE.Mesh(planetGeometry, planetMaterial);
                planetMesh.position.x = planet.distance;
                scene.add(planetMesh);
                planetMeshes.push(planetMesh);
            });
        });
}

const seedInput = document.getElementById('seed-input');
seedInput.addEventListener('change', () => {
    loadSystem(seedInput.value);
});

loadSystem(123);

function animate() {
    requestAnimationFrame(animate);

    // Анимация планет
    planetMeshes.forEach((mesh, index) => {
        const planet = planetsData[index];
        mesh.position.x = Math.cos(Date.now() * planet.orbitSpeed) * planet.distance;
        mesh.position.z = Math.sin(Date.now() * planet.orbitSpeed) * planet.distance;
    });

    controls.update();
    renderer.render(scene, camera);
}

animate();

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});
