// js/space/objects.js
class SpaceObjects {
constructor(sceneManager, universeConfig) {
this.sceneManager = sceneManager;
this.scene = sceneManager.scene;
this.config = universeConfig;
this.planets = [];
this.clock = new THREE.Clock();
this.simplex = new SimplexNoise();
}
async init(systemData) {
this.createStarfield();
this.createCentralStar(systemData.star);
this.createPlanets(systemData.planets, systemData.star.position);
}
createStarfield() {
const starCount = this.config.starCount || 10000;
const geometry = new THREE.BufferGeometry();
const positions = new Float32Array(starCount * 3);
const colors = new Float32Array(starCount * 3);
const colorList = [
new THREE.Color(0xffffff), // White
new THREE.Color(0xffccaa), // Warm
new THREE.Color(0xaaccff), // Blueish
new THREE.Color(0xffaa88)  // Red/Orange
];
for (let i = 0; i < starCount; i++) {
// Irregular distribution to simulate Milky Way band and random scatters
let r, theta, phi;
if (Math.random() > 0.3) {
// Disk-like (Milky Way)
r = 2000 + Math.random() * 8000;
theta = Math.random() * Math.PI * 2;
phi = (Math.PI / 2) + (Math.random() - 0.5) * 0.4; // near equator
} else {
// Spherical halo
r = 1000 + Math.random() * 9000;
theta = Math.random() * Math.PI * 2;
phi = Math.acos(2 * Math.random() - 1);
}
positions[i * 3] = r * Math.sin(phi) * Math.cos(theta);
positions[i * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
positions[i * 3 + 2] = r * Math.cos(phi);
const color = colorList[Math.floor(Math.random() * colorList.length)];
// Vary intensity
const intensity = 0.5 + Math.random() * 0.5;
colors[i * 3] = color.r * intensity;
colors[i * 3 + 1] = color.g * intensity;
colors[i * 3 + 2] = color.b * intensity;
}
geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
const material = new THREE.PointsMaterial({
size: 2,
vertexColors: true,
transparent: true,
opacity: 0.8,
sizeAttenuation: false // Keep stars small regardless of distance
});
const starfield = new THREE.Points(geometry, material);
// Make background stars bloom
starfield.layers.enable(this.sceneManager.BLOOM_SCENE);
this.scene.add(starfield);
}
createCentralStar(starData) {
// Glowing Core
const geo = new THREE.SphereGeometry(starData.size, 64, 64);
const mat = new THREE.MeshBasicMaterial({ color: starData.color });
const starMesh = new THREE.Mesh(geo, mat);
starMesh.position.set(...starData.position);
starMesh.layers.enable(this.sceneManager.BLOOM_SCENE); // Selective Bloom!
this.scene.add(starMesh);
// Light Source
const pointLight = new THREE.PointLight(starData.color, starData.intensity, 100000);
pointLight.position.set(...starData.position);
this.scene.add(pointLight);
}
createPlanets(planetsData, starPosition) {
planetsData.forEach(pData => {
const group = new THREE.Group();
// Generate procedural texture on a canvas
const tex = this.generateProceduralTexture(pData);
// Base Planet
const geo = new THREE.SphereGeometry(pData.size, 64, 64);
const mat = new THREE.MeshStandardMaterial({
map: tex,
roughness: pData.hasWater ? 0.3 : 0.8,
metalness: 0.1
});
const planetMesh = new THREE.Mesh(geo, mat);
group.add(planetMesh);
// Atmosphere Rim Lighting Shader
if (pData.hasAtmosphere) {
const atmoGeo = new THREE.SphereGeometry(pData.size * 1.05, 64, 64);
const atmoMat = new THREE.ShaderMaterial({
uniforms: {
color: { value: new THREE.Color(0x4ddbff) }, // Atmosphere color
viewVector: { value: this.sceneManager.camera.position }
},
vertexShader: `
uniform vec3 viewVector;
varying float intensity;
void main() {
vec3 vNormal = normalize( normalMatrix * normal );
vec3 vNormel = normalize( normalMatrix * viewVector );
intensity = pow( 0.6 - dot(vNormal, vNormel), 2.0 );
gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
}
`,
fragmentShader: `
uniform vec3 color;
varying float intensity;
void main() {
vec3 glow = color * intensity;
gl_FragColor = vec4( glow, intensity * 0.5 ); // Alpha based on intensity
}
`,
side: THREE.FrontSide,
blending: THREE.AdditiveBlending,
transparent: true,
depthWrite: false
});
const atmoMesh = new THREE.Mesh(atmoGeo, atmoMat);
// Assign custom property to update viewVector every frame
atmoMesh.isAtmosphere = true;
group.add(atmoMesh);
}
// Set initial position
group.position.set(starPosition[0] + pData.orbitRadius, 0, starPosition[2]);
this.scene.add(group);
this.planets.push({
group: group,
data: pData,
angle: Math.random() * Math.PI * 2,
starPos: starPosition
});
});
}
generateProceduralTexture(pData) {
const canvas = document.createElement('canvas');
canvas.width = 512;
canvas.height = 256;
const ctx = canvas.getContext('2d');
const imgData = ctx.createImageData(canvas.width, canvas.height);
const baseRgb = new THREE.Color(pData.baseColor);
const waterRgb = new THREE.Color(0x0a3b66); // Dark blue water
for (let x = 0; x < canvas.width; x++) {
for (let y = 0; y < canvas.height; y++) {
// Map to spherical coordinates for seamless horizontal wrap (basic)
const nx = x / canvas.width - 0.5;
const ny = y / canvas.height - 0.5;
let val = this.simplex.noise3D(nx * pData.noiseScale, ny * pData.noiseScale, 0);
// add detail
val += 0.5 * this.simplex.noise3D(nx * pData.noiseScale * 2, ny * pData.noiseScale * 2, 0);
const i = (x + y * canvas.width) * 4;
if (pData.hasWater && val < 0) {
// Water
imgData.data[i] = waterRgb.r * 255;
imgData.data[i+1] = waterRgb.g * 255;
imgData.data[i+2] = waterRgb.b * 255;
} else {
// Land
const landMod = val > 0 ? val : 0;
imgData.data[i] = baseRgb.r * 255 * (1 - landMod * 0.3);
imgData.data[i+1] = baseRgb.g * 255 * (1 - landMod * 0.3);
imgData.data[i+2] = baseRgb.b * 255 * (1 - landMod * 0.3);
}
imgData.data[i+3] = 255; // Alpha
}
}
ctx.putImageData(imgData, 0, 0);
const texture = new THREE.CanvasTexture(canvas);
texture.anisotropy = this.sceneManager.renderer.capabilities.getMaxAnisotropy();
return texture;
}
update(delta) {
const cameraPos = this.sceneManager.camera.position;
this.planets.forEach(p => {
// Orbital motion
p.angle += p.data.orbitSpeed * delta;
p.group.position.x = p.starPos[0] + Math.cos(p.angle) * p.data.orbitRadius;
p.group.position.z = p.starPos[2] + Math.sin(p.angle) * p.data.orbitRadius;
// Rotation
p.group.rotation.y += 0.05 * delta;
// Update atmosphere view vector
p.group.children.forEach(child => {
if (child.isAtmosphere) {
// Direction from center of planet to camera
const viewVector = new THREE.Vector3().subVectors(cameraPos, p.group.position);
child.material.uniforms.viewVector.value = viewVector;
}
});
});
}
getNearestObject(playerPosition) {
let nearest = null;
let minDist = Infinity;
this.planets.forEach(p => {
const dist = playerPosition.distanceTo(p.group.position);
// subtract radius so distance is to surface
const distToSurface = Math.max(0, dist - p.data.size);
if (distToSurface < minDist) {
minDist = distToSurface;
nearest = { name: p.data.name, distance: distToSurface };
}
});
// Also check central star
// Central star is at 0,0,0
const starDist = playerPosition.length() - 50; // 50 is star size
if (starDist < minDist) {
minDist = starDist;
nearest = { name: "Solaris Alpha", distance: starDist };
}
return nearest;
}
}