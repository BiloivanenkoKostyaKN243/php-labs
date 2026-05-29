document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('space-canvas');
    if (!container) return;

    // 1. Ініціалізація сцени
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 50, 100);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(renderer.domElement);

    // OrbitControls дозволяє просто крутити мишкою навколо центру
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    
    // Світло
    scene.add(new THREE.AmbientLight(0x404040)); // Базове освітлення

    // 2. Отримання даних з нашого спрощеного PHP API
    const response = await fetch('generate_system.php');
    const data = await response.json();
    const system = data.systems[0]; // Беремо першу згенеровану систему

    // 3. Створення зірки
    const starGeo = new THREE.SphereGeometry(system.star.size, 32, 32);
    const starMat = new THREE.MeshBasicMaterial({ color: system.star.color });
    const starMesh = new THREE.Mesh(starGeo, starMat);
    scene.add(starMesh);

    // Додаємо джерело світла всередині зірки
    const pointLight = new THREE.PointLight(system.star.color, 2, 300);
    scene.add(pointLight);

    // 4. Створення планет
    const planets = [];
    system.planets.forEach(p => {
        const pGeo = new THREE.SphereGeometry(p.size, 32, 32);
        const pMat = new THREE.MeshStandardMaterial({ color: p.color });
        const pMesh = new THREE.Mesh(pGeo, pMat);
        scene.add(pMesh);
        
        // Зберігаємо планету і її параметри орбіти для анімації
        planets.push({
            mesh: pMesh, 
            angle: Math.random() * Math.PI * 2, 
            radius: p.orbitRadius, 
            speed: p.orbitSpeed 
        });
    });

    // 5. Анімація
    function animate() {
        requestAnimationFrame(animate);
        
        // Рух планет по колу
        planets.forEach(p => {
            p.angle += p.speed;
            p.mesh.position.x = Math.cos(p.angle) * p.radius;
            p.mesh.position.z = Math.sin(p.angle) * p.radius;
            p.mesh.rotation.y += 0.01; // Обертання планети навколо своєї осі
        });

        controls.update();
        renderer.render(scene, camera);
    }
    
    animate();

    // 6. Обробка зміни розміру вікна
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
});
