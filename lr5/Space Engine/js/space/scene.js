// js/space/scene.js
class SpaceScene {
constructor(containerId) {
this.container = document.getElementById(containerId);
// Scene setup
this.scene = new THREE.Scene();
this.scene.background = new THREE.Color(0x020205);
this.scene.fog = new THREE.FogExp2(0x020205, 0.0001);
// Camera setup
this.camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 100000);
// Renderer setup
this.renderer = new THREE.WebGLRenderer({ antialias: true, logarithmicDepthBuffer: true });
this.renderer.setSize(window.innerWidth, window.innerHeight);
this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
this.container.appendChild(this.renderer.domElement);
this.setupPostProcessing();
// Lights (Only ambient here. The actual star acts as PointLight in objects.js)
this.ambientLight = new THREE.AmbientLight(0x0a0a1a, 0.5);
this.scene.add(this.ambientLight);
// Handle resize
window.addEventListener('resize', () => this.onResize(), false);
}
setupPostProcessing() {
// Selective Bloom configuration
// We use a Layers approach:
// Layer 0 = Normal objects (planets)
// Layer 1 = Bloom objects (stars, sun)
this.BLOOM_SCENE = 1;
this.bloomLayer = new THREE.Layers();
this.bloomLayer.set(this.BLOOM_SCENE);
const renderScene = new THREE.RenderPass(this.scene, this.camera);
const bloomPass = new THREE.UnrealBloomPass(
new THREE.Vector2(window.innerWidth, window.innerHeight),
2.0, // strength
0.5, // radius
0.1  // threshold
);
this.bloomComposer = new THREE.EffectComposer(this.renderer);
this.bloomComposer.renderToScreen = false;
this.bloomComposer.addPass(renderScene);
this.bloomComposer.addPass(bloomPass);
const finalPass = new THREE.ShaderPass(
new THREE.ShaderMaterial({
uniforms: {
baseTexture: { value: null },
bloomTexture: { value: this.bloomComposer.renderTarget2.texture }
},
vertexShader: `
varying vec2 vUv;
void main() {
vUv = uv;
gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
}
`,
fragmentShader: `
uniform sampler2D baseTexture;
uniform sampler2D bloomTexture;
varying vec2 vUv;
void main() {
gl_FragColor = (texture2D(baseTexture, vUv) + vec4(1.0) * texture2D(bloomTexture, vUv));
}
`,
defines: {}
}), "baseTexture"
);
finalPass.needsSwap = true;
this.finalComposer = new THREE.EffectComposer(this.renderer);
this.finalComposer.addPass(renderScene);
this.finalComposer.addPass(finalPass);
// Materials cache for selective bloom
this.materials = {};
this.darkMaterial = new THREE.MeshBasicMaterial({ color: "black" });
}
render() {
// 1. Render Bloom Scene
this.scene.traverse((obj) => {
if (obj.isMesh && this.bloomLayer.test(obj.layers) === false) {
this.materials[obj.uuid] = obj.material;
obj.material = this.darkMaterial;
}
});
// Hide points (background stars) from normal view if they don't have layer 1?
// Actually, background stars should just bloom normally if they are in layer 1.
this.bloomComposer.render();
// 2. Restore materials and render Final Scene
this.scene.traverse((obj) => {
if (this.materials[obj.uuid]) {
obj.material = this.materials[obj.uuid];
delete this.materials[obj.uuid];
}
});
this.finalComposer.render();
}
onResize() {
this.camera.aspect = window.innerWidth / window.innerHeight;
this.camera.updateProjectionMatrix();
this.renderer.setSize(window.innerWidth, window.innerHeight);
this.bloomComposer.setSize(window.innerWidth, window.innerHeight);
this.finalComposer.setSize(window.innerWidth, window.innerHeight);
}
}