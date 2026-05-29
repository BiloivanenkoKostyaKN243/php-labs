// js/space/main.js
document.addEventListener('DOMContentLoaded', async () => {
const ui = new SpaceUI();
ui.updateLoading(10);
// 1. Fetch Universe API Configuration
const uniRes = await fetch('index.php?route=space/api_universe');
const universeConfig = await uniRes.json();
ui.updateLoading(30);
// 2. Fetch Player Start Data
const playerRes = await fetch('index.php?route=space/api_player');
const playerConfig = await playerRes.json();
ui.updateLoading(50);
// 3. Initialize Engine Components
const spaceScene = new SpaceScene('space-canvas');
// Set player position
spaceScene.camera.position.set(...playerConfig.startPosition);
const controls = new SpaceControls(spaceScene.camera, spaceScene.renderer.domElement);
controls.maxSpeed = universeConfig.maxSpeed;
const spaceObjects = new SpaceObjects(spaceScene, universeConfig);
ui.updateLoading(70);
// 4. Fetch Objects Data (Stars and Planets) and Generate
const objRes = await fetch('index.php?route=space/api_objects');
const systemData = await objRes.json();
await spaceObjects.init(systemData);
ui.updateLoading(100);
// 5. Main Game Loop
const clock = new THREE.Clock();
function animate() {
requestAnimationFrame(animate);
const delta = clock.getDelta();
// Update Physics & Camera
controls.update(delta);
// Update Planets (Orbits, Rotation, Atmosphere shaders)
spaceObjects.update(delta);
// Update UI (Speed, XYZ, Distance to nearest)
const playerData = controls.getPlayerData();
const nearestObj = spaceObjects.getNearestObject(playerData.position);
ui.update(playerData, nearestObj);
// Render Scene with Selective Bloom Post-Processing
spaceScene.render();
}
animate();
});