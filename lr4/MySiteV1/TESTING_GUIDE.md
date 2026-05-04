# Space Simulator - Installation & Testing Guide

## Quick Start

### 1. Prerequisites
- PHP 7.4+ (already running your MVC app)
- Modern web browser with WebGL support
- Working MySiteV1 PHP MVC application

### 2. Files Already in Place
```
✅ css/space.css                    - Space UI styles (NEW)
✅ js/space.js                      - SpaceSimulator class (ENHANCED)
✅ views/space/main.php             - Space view (UPDATED)
✅ views/layout/header.php          - Conditional CSS loading (UPDATED)
✅ views/layout/footer.php          - Conditional footer (UPDATED)
✅ views/index/main.php             - Homepage with card (UPDATED)
✅ controllers/SpaceController.php   - Routes (EXISTING)
✅ generate_system.php              - System generator (EXISTING)
```

## Testing Steps

### Test 1: Homepage Access
```
1. Open: http://localhost/php-labs/lr4/MySiteV1/index.php
2. Should see 6 cards including new "🚀 Space Simulator"
3. Click "Запустити" button on the simulator card
```

### Test 2: Direct Route Access
```
1. Open: http://localhost/php-labs/lr4/MySiteV1/index.php?route=space
2. Should see full-screen black space scene with:
   - Stars in background
   - Yellow/golden central star
   - Colored planets orbiting
   - Crosshair in center
   - Control panel (top-left)
   - Back button (top-right)
```

### Test 3: Navigation Menu
```
1. On any page, look at header navigation
2. Click "Space Engine" link
3. Should navigate to space simulator
```

### Test 4: Interactive Features
```
🖱 Rotation:
  - Click and drag left mouse button on canvas
  - Scene should rotate smoothly

🔍 Zoom:
  - Scroll mouse wheel up/down
  - Camera should zoom in/out (15-300 range)

👆 Planet Selection:
  - Click directly on any visible planet
  - Planet should highlight/animate toward camera
  - HUD should appear (bottom-right) with info

📊 HUD Display:
  - Should show: Name, Type, Radius, Temp, Mass, Orbit Radius
  - Text should be green terminal style
  
⌨️  Escape Key:
  - Press ESC after selecting planet
  - HUD should hide
  - Auto-rotate should resume

🏠 Return Button:
  - Click "← RETURN TO SITE" button (top-right)
  - Should go back to homepage
```

### Test 5: Browser Console
```
1. Press F12 to open Developer Tools
2. Go to Console tab
3. Should see NO red errors
4. May see info messages about system loading
```

### Test 6: Different Systems
```
1. Access: http://localhost/php-labs/lr4/MySiteV1/index.php?route=space&seed=999
2. Should see DIFFERENT star/planets than seed=123
3. Try several different seed numbers
4. Each should generate unique systems
```

### Test 7: Mobile Responsiveness
```
1. Press F12 and click Device Toolbar (or Ctrl+Shift+M)
2. Switch to mobile viewport (iPhone, Android, etc.)
3. Should work correctly on mobile:
   - HUD should reposition/resize
   - Controls should remain visible
   - Canvas should fill viewport
   - Touches should control rotation
```

## Troubleshooting

### Issue: Black screen, no stars/planets visible
**Solution:**
1. Wait 2-3 seconds for assets to load
2. Open console (F12) - check for errors
3. Check that `generate_system.php` is accessible
4. Try different seed: `?route=space&seed=456`
5. Clear browser cache and refresh

### Issue: Canvas not filling screen
**Solution:**
1. Check that CSS files loaded (F12 → Network tab)
2. Verify `space.css` is in `/css/` folder
3. Check browser zoom is 100%
4. Try different browser

### Issue: Controls not working
**Solution:**
1. Click on canvas to focus it
2. Verify `OrbitControls.js` loaded (F12 → Network)
3. Try mouse wheel zoom first
4. Check JavaScript console for errors

### Issue: HUD doesn't appear after clicking planet
**Solution:**
1. Click directly on colored spheres (planets)
2. Not on the background or stars
3. Wait 1 second for animation to complete
4. Check console for errors

### Issue: Performance is slow/laggy
**Solution:**
1. Close other browser tabs
2. Disable browser extensions
3. Try Chrome/Firefox instead
4. Lower screen resolution
5. Check GPU acceleration enabled (F12 → Settings)

## What to Check

### File Integrity
```bash
# Check files exist:
ls -l MySiteV1/css/space.css
ls -l MySiteV1/js/space.js
ls -l MySiteV1/views/space/main.php

# Check file sizes (should have actual content):
wc -l MySiteV1/css/space.css      # Should be ~200+ lines
wc -l MySiteV1/js/space.js        # Should be ~600+ lines
```

### Network Requests (F12 → Network tab)
Should see:
- ✅ index.php (200 OK)
- ✅ style.css (200 OK)
- ✅ space.css (200 OK)
- ✅ three.js from CDN (200 OK)
- ✅ OrbitControls.js from CDN (200 OK)
- ✅ space.js (200 OK)
- ✅ generate_system.php (200 OK, with JSON response)

### Console Messages (F12 → Console)
Should NOT see:
- ❌ Uncaught TypeError
- ❌ Uncaught ReferenceError
- ❌ 404 Not Found errors
- ❌ CORS errors

May see:
- ℹ️ "Loading system with seed: 123"
- ℹ️ Some browser info messages

## Performance Baseline

Expected performance:
- **Load time**: 2-5 seconds (depends on connection)
- **Frame rate**: 30-60 FPS
- **Memory**: 50-150 MB (GPU)
- **CPU**: <10% idle, 20-40% during interaction

## Browser Support

| Browser | Version | Support |
|---------|---------|---------|
| Chrome  | 90+     | ✅ Full |
| Firefox | 88+     | ✅ Full |
| Safari  | 14+     | ✅ Full |
| Edge    | 90+     | ✅ Full |
| Mobile  | Modern  | ✅ Responsive |

## Success Indicators

✅ Space simulator is working correctly if:

1. [x] You can navigate to the space simulator
2. [x] Black canvas fills the entire screen
3. [x] Stars are visible in the background
4. [x] A central yellow/golden star is visible
5. [x] Colored planets are visible orbiting
6. [x] Mouse controls rotate the view
7. [x] Mouse wheel zooms in/out
8. [x] You can click planets and they animate
9. [x] HUD appears with planet information
10. [x] ESC key deselects and hides HUD
11. [x] Back button returns to homepage
12. [x] Different seeds generate different systems
13. [x] No red errors in console
14. [x] Works on mobile viewport
15. [x] Navigation menu includes space link

## Advanced Testing

### Performance Testing
```javascript
// Run in console to measure performance:
performance.mark('render-start');
// perform action...
performance.mark('render-end');
performance.measure('render', 'render-start', 'render-end');
console.log(performance.getEntriesByName('render')[0]);
```

### Memory Usage
```javascript
// Check memory in supported browsers:
console.log(performance.memory);
```

### WebGL Info
```javascript
// Get WebGL details:
const canvas = document.querySelector('#space-canvas canvas');
const gl = canvas.getContext('webgl');
console.log(gl.getParameter(gl.RENDERER));
console.log(gl.getParameter(gl.VERSION));
```

## Integration Verification Checklist

- [ ] All files created/modified
- [ ] Homepage shows space simulator card
- [ ] Can navigate to space view
- [ ] Canvas renders correctly
- [ ] 3D objects visible (star, planets)
- [ ] Controls work (rotate, zoom)
- [ ] Planet selection works
- [ ] HUD displays correct info
- [ ] Back button works
- [ ] Mobile responsive
- [ ] No console errors
- [ ] No CSS conflicts
- [ ] No JavaScript conflicts
- [ ] Different seeds work
- [ ] Performance acceptable

## Production Deployment

Before going live:

1. **Minify assets**
   ```bash
   # Consider minifying space.js and space.css
   ```

2. **Test on target browsers**
   - Test on customer browsers
   - Test on target devices

3. **Monitor performance**
   - Add analytics tracking
   - Monitor error reporting

4. **Set up CDN caching**
   - CDN links for Three.js should be cached
   - Space.js should be cached locally

5. **Backup**
   - Keep backup of original files
   - Version control integration

## Support Resources

- **Three.js Docs**: https://threejs.org/docs/
- **OrbitControls**: https://threejs.org/docs/#examples/en/controls/OrbitControls
- **Browser WebGL Support**: https://get.webgl.org/
- **Performance Tips**: https://threejs.org/docs/#manual/en/introduction/WebGL-compatibility

---

**Testing Complete? Great! The Space Simulator is ready to use! 🚀**

For more details, see: SPACE_SIMULATOR_README.md
For integration overview, see: INTEGRATION_SUMMARY.md

