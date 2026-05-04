# 🚀 Space Simulator Integration Guide

## Overview

A fully integrated, interactive 3D Space Simulator (inspired by SpaceEngine) has been added to the existing PHP MVC application. The simulator provides an immersive experience to explore star systems with full 3D controls and interactive planet selection.

## Files Modified & Created

### Created Files:
- **`css/space.css`** - Complete styling for the space simulator UI and HUD
- **`js/space.js`** - Enhanced with SpaceSimulator class (backward compatible with SpaceEngine)

### Modified Files:
- **`views/index/main.php`** - Added "🚀 Space Simulator" card to homepage
- **`views/layout/header.php`** - Added space.css link and conditional layout for space view
- **`views/layout/footer.php`** - Conditional footer rendering (hidden in space view)
- **`views/space/main.php`** - Updated to use new SpaceSimulator with proper Three.js imports

### Existing Files Used:
- **`generate_system.php`** - PHP endpoint generating random star systems
- **`controllers/SpaceController.php`** - Routes to space view
- **`classes/Router.php`** - Handles routing (already compatible)

## Features

### 1. **Interactive 3D Scene**
- Real-time rendering using Three.js
- 1000+ star background (procedurally generated)
- Central glowing star
- 2-5 orbiting planets with realistic orbital mechanics

### 2. **Camera & Controls**
- **Orbit Controls**: Left-click drag to rotate around the scene
- **Zoom**: Mouse wheel to zoom in/out (15-300 units range)
- **Pan**: Right-click drag to pan the camera
- **Auto-rotate**: Automatic scene rotation when idle
- **Smooth animations**: Lerp-based camera movement to selected planets

### 3. **Interactive Features**
- **Click planets**: Left-click any planet to select it
- **Camera focus**: Smooth camera animation toward selected planet
- **HUD display**: Object information (name, type, radius, temperature, mass, orbit data)
- **Escape key**: Deselect and return to auto-rotate mode

### 4. **HUD (Heads-Up Display)**
Shows when a planet is selected:
- Planet/Star name with symbol (⊙)
- Object type (STAR/PLANET)
- Radius in km
- Surface temperature in Kelvin
- Mass (for planets)
- Orbital radius in AU

### 5. **UI Elements**
- **Crosshair**: Center screen indicator
- **Control System**: Top-left help panel showing controls
- **Back Button**: Top-right button to return to main site
- **Color scheme**: Green monospace terminal aesthetic (SpaceEngine inspired)

### 6. **Performance Optimizations**
- Low polygon count (IcosahedronGeometry with 16-32 segments)
- Efficient particle-based starfield (1000 points)
- Glow effects using transparent mesh layers
- Shadow mapping disabled for low-end devices
- Responsive pixel ratio capping (max 2x)

### 7. **Random System Generation**
Each system is unique:
- Seed-based generation for reproducibility
- Random star color, size, and position
- 2-5 planets with varying orbits and colors
- Can generate new systems by accessing `?route=space&seed=XXX`

## How to Use

### Access the Simulator
1. Go to the homepage (index/main)
2. Look for the "🚀 Space Simulator" card
3. Click "Запустити" (Launch)
4. Or directly visit: `index.php?route=space`

### Navigation
- **Rotate**: Click and drag with left mouse button
- **Zoom**: Use mouse wheel
- **Select Planet**: Left-click on any planet
- **View Info**: After selection, HUD appears with details
- **Deselect**: Press ESC or click empty space
- **Return**: Click "← RETURN TO SITE" button (top-right)

### Generate New Systems
- Each system is seeded: `index.php?route=space&seed=12345`
- Try different seed numbers for different star systems

## Technical Details

### SpaceSimulator Class (js/space.js)

**Main Methods:**
```javascript
- init()                      // Initialize simulator
- setupScene()               // Create Three.js scene
- setupCamera()              // Configure camera
- setupRenderer()            // Setup WebGL renderer
- setupLights()              // Add lighting
- loadSystemData()           // Fetch/generate system data
- createStarfield()          // Create background stars
- createStar()               // Create central star with glow
- createPlanets()            // Generate planets
- setupControls()            // Setup OrbitControls
- setupUI()                  // Create HUD, crosshair, buttons
- setupEventListeners()      // Bind mouse/keyboard events
- selectPlanet(planet)       // Select and focus on planet
- updateHUD(data)            // Update displayed info
- updatePlanetOrbits()       // Animate orbital motion
- updateCameraAnimation()    // Lerp camera to target
- animate()                  // Main render loop
```

### API Integration

**Endpoint**: `generate_system.php?seed=123`

**Response Format**:
```json
{
  "star": {
    "type": "star",
    "name": "Sol",
    "position": [0, 0, 0],
    "size": 7,
    "color": "#ffff00",
    "temperature": 5778
  },
  "planets": [
    {
      "type": "planet",
      "name": "Mercury",
      "position": [20, 0, 0],
      "size": 0.4,
      "color": "#8c7853",
      "orbitRadius": 20,
      "orbitSpeed": 0.04
    }
  ],
  "seed": 123
}
```

### CSS Classes

**Main Container:**
- `.space-container` - Full viewport canvas container
- `main--space` - Special main element styling

**UI Elements:**
- `.space-hud` - Information display panel
- `.space-crosshair` - Center crosshair
- `.space-controls` - Control help panel
- `.space-back-btn` - Return button

**Responsive:**
- Hidden header/footer in space view
- Mobile-optimized HUD (smaller text, repositioned)
- Touch-friendly controls on mobile devices

## Backward Compatibility

The existing `SpaceEngine` class is preserved in `js/space.js` for backward compatibility with any legacy space pages that might use the canvas-based approach.

The `SpaceSimulator` class runs on containers with ID `#space-canvas` and class `space-container` (DIV elements), while the legacy `SpaceEngine` class runs on `<canvas>` elements.

## Browser Requirements

- **Modern WebGL support** (Three.js r128)
- **ES6 JavaScript** support
- **Recommended**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+

## Performance Considerations

- **Low-end devices**: ~30-60 FPS
- **Mid-range devices**: 60 FPS
- **High-end devices**: 60+ FPS (capped by display)

**Optimization tips for low-end devices:**
1. Reduce starfield count (change `starCount` from 1000)
2. Lower planet geometry segments (16 instead of 32)
3. Disable shadows (already optimized)
4. Reduce animation speed

## Integration Summary

| Component | Status | Notes |
|-----------|--------|-------|
| Three.js Library | ✅ CDN | Using r128 from CDN |
| OrbitControls | ✅ CDN | Loaded from jsDelivr |
| Space CSS | ✅ New | `css/space.css` |
| Space JS | ✅ Enhanced | `js/space.js` with backward compat |
| PHP Controller | ✅ Existing | `SpaceController::action_main()` |
| System Generator | ✅ Existing | `generate_system.php` |
| Home Card | ✅ New | Added to `views/index/main.php` |
| Layout System | ✅ Updated | Conditional rendering in header/footer |
| Navigation | ✅ Updated | Space route in header nav items |

## Known Limitations

1. **Mock data**: Planet temperatures and masses are procedurally generated
2. **Orbit paths**: Not drawn visually (only implied by orbital motion)
3. **No planet textures**: Uses solid colors for performance
4. **No sound**: Silent experience (can be added)
5. **No atmosphere effects**: Clean rendering for performance

## Future Enhancements

- [ ] Add orbit path visualization
- [ ] Planet texture mapping
- [ ] Sound effects and ambient music
- [ ] Multiplayer via WebSockets
- [ ] Save favorite systems
- [ ] Galaxy view (zoom out)
- [ ] Search for named systems
- [ ] Time acceleration/deceleration
- [ ] More realistic physics simulation

## Troubleshooting

### Canvas not displaying
- Check browser console (F12) for errors
- Ensure Three.js CDN links are accessible
- Verify GPU support with `WebGL` test

### Slow performance
- Close other browser tabs
- Lower browser zoom to 100%
- Use Chrome/Firefox for best performance
- Disable browser extensions

### Click selection not working
- Ensure mouse is over canvas area
- Try clicking directly on planet mesh
- Check that objects are in view

### HUD not updating
- Select a planet (click on it)
- Check browser console for errors
- Verify `generate_system.php` is accessible

## Support

For issues or questions:
1. Check browser console (F12 → Console tab)
2. Verify all files are in correct locations
3. Clear browser cache and reload
4. Try a different seed/system

---

**Created**: 2026
**Last Updated**: 2026-04-05
**Version**: 1.0 (Initial Release)

