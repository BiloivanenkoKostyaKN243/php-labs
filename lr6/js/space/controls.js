// js/space/controls.js
class SpaceControls {
constructor(camera, domElement) {
this.camera = camera;
this.domElement = domElement;
this.velocity = new THREE.Vector3();
this.acceleration = 150.0; // Units per second
this.maxSpeed = 500.0;
this.friction = 2.0; // Simulated space drag for gameplay
this.moveState = { forward: 0, back: 0, left: 0, right: 0, up: 0, down: 0 };
// Mouse look state
this.isDragging = false;
this.previousMousePosition = { x: 0, y: 0 };
this.setupEventListeners();
}
setupEventListeners() {
window.addEventListener('keydown', (e) => this.onKeyDown(e), false);
window.addEventListener('keyup', (e) => this.onKeyUp(e), false);
this.domElement.addEventListener('mousedown', (e) => {
this.isDragging = true;
this.previousMousePosition = { x: e.offsetX, y: e.offsetY };
}, false);
this.domElement.addEventListener('mouseup', () => { this.isDragging = false; }, false);
this.domElement.addEventListener('mouseleave', () => { this.isDragging = false; }, false);
this.domElement.addEventListener('mousemove', (e) => {
if (!this.isDragging) return;
const deltaMove = {
x: e.offsetX - this.previousMousePosition.x,
y: e.offsetY - this.previousMousePosition.y
};
const rotationSpeed = 0.002;
// Yaw (Y axis)
this.camera.rotateOnWorldAxis(new THREE.Vector3(0, 1, 0), -deltaMove.x * rotationSpeed);
// Pitch (X axis local)
this.camera.rotateX(-deltaMove.y * rotationSpeed);
this.previousMousePosition = { x: e.offsetX, y: e.offsetY };
}, false);
}
onKeyDown(event) {
switch (event.code) {
case 'KeyW': this.moveState.forward = 1; break;
case 'KeyS': this.moveState.back = 1; break;
case 'KeyA': this.moveState.left = 1; break;
case 'KeyD': this.moveState.right = 1; break;
case 'KeyR': this.moveState.up = 1; break;
case 'KeyF': this.moveState.down = 1; break;
}
}
onKeyUp(event) {
switch (event.code) {
case 'KeyW': this.moveState.forward = 0; break;
case 'KeyS': this.moveState.back = 0; break;
case 'KeyA': this.moveState.left = 0; break;
case 'KeyD': this.moveState.right = 0; break;
case 'KeyR': this.moveState.up = 0; break;
case 'KeyF': this.moveState.down = 0; break;
}
}
update(delta) {
// Build movement vector based on camera direction
const moveVector = new THREE.Vector3(
this.moveState.right - this.moveState.left,
this.moveState.up - this.moveState.down,
this.moveState.back - this.moveState.forward
);
moveVector.normalize();
// Apply acceleration to velocity in camera local space
if (moveVector.lengthSq() > 0) {
// Transform movement vector to world space
moveVector.applyQuaternion(this.camera.quaternion);
this.velocity.x += moveVector.x * this.acceleration * delta;
this.velocity.y += moveVector.y * this.acceleration * delta;
this.velocity.z += moveVector.z * this.acceleration * delta;
}
// Apply friction
this.velocity.x -= this.velocity.x * this.friction * delta;
this.velocity.y -= this.velocity.y * this.friction * delta;
this.velocity.z -= this.velocity.z * this.friction * delta;
// Clamp speed
if (this.velocity.length() > this.maxSpeed) {
this.velocity.setLength(this.maxSpeed);
}
// Move camera
this.camera.position.addScaledVector(this.velocity, delta);
}
getPlayerData() {
return {
position: this.camera.position,
speed: this.velocity.length()
};
}
}