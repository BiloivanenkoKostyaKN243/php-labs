// js/space/ui.js
class SpaceUI {
constructor() {
this.fpsElement = document.getElementById('ui-fps');
this.posElement = document.getElementById('ui-pos');
this.speedElement = document.getElementById('ui-speed');
this.speedBar = document.getElementById('ui-speed-bar');
this.targetPanel = document.getElementById('ui-target-panel');
this.targetName = document.getElementById('ui-target-name');
this.targetDist = document.getElementById('ui-target-dist');
this.loadingScreen = document.getElementById('loading-screen');
this.loadingProgress = document.getElementById('loading-progress');
// Setup exit button
document.getElementById('btn-exit').addEventListener('click', () => {
window.location.href = 'index.php?route=space/intro';
});
this.frames = 0;
this.lastTime = performance.now();
this.fps = 0;
}
updateLoading(percent) {
this.loadingProgress.innerText = Math.round(percent) + '%';
if (percent >= 100) {
setTimeout(() => {
this.loadingScreen.classList.add('hidden');
}, 500);
}
}
update(playerData, nearestObject = null) {
// Calculate FPS
this.frames++;
const now = performance.now();
if (now >= this.lastTime + 1000) {
this.fps = Math.round((this.frames * 1000) / (now - this.lastTime));
this.frames = 0;
this.lastTime = now;
this.fpsElement.innerText = this.fps;
}
// Position
const pos = playerData.position;
this.posElement.innerText = `${Math.round(pos.x)}, ${Math.round(pos.y)}, ${Math.round(pos.z)}`;
// Speed
const speedVal = Math.round(playerData.speed);
this.speedElement.innerText = speedVal;
const maxSpeed = 500; // From universe API config
const speedPercent = Math.min(100, (speedVal / maxSpeed) * 100);
this.speedBar.style.width = speedPercent + '%';
// Nearest Object
if (nearestObject && nearestObject.distance < 2000) {
this.targetPanel.classList.remove('hidden');
this.targetName.innerText = nearestObject.name.toUpperCase();
this.targetDist.innerText = Math.round(nearestObject.distance);
} else {
this.targetPanel.classList.add('hidden');
}
}
}