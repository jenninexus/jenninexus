# Homepage UI Testing Guide - November 18, 2025

## 📋 Overview
Comprehensive testing checklist for homepage carousel arrows and social icon sizing improvements implemented on November 18, 2025.

**Test URL**: http://localhost:8002  
**Files Modified**: `public_html/index.php` (lines 32-101)

---

## ✅ Carousel Arrow Positioning Tests

### Desktop Testing (≥992px)

#### Visual Inspection
- [ ] **Arrow Position**: Arrows positioned outside carousel container
  - Left arrow at `left: -60px` from container edge
  - Right arrow at `right: -60px` from container edge
- [ ] **No Overlap**: Arrows don't overlap hero section text above
- [ ] **No Overlap**: Arrows don't overlap social icons above
- [ ] **Visibility**: Arrows clearly visible against background
- [ ] **Hover State**: Arrows highlight on hover

#### Interaction Tests
- [ ] **Click Left Arrow**: Navigates to previous slide correctly
- [ ] **Click Right Arrow**: Navigates to next slide correctly
- [ ] **Keyboard Left Arrow**: Navigates to previous slide
- [ ] **Keyboard Right Arrow**: Navigates to next slide
- [ ] **Auto-play**: Carousel auto-advances every 5 seconds
- [ ] **Pause on Hover**: Auto-play pauses when hovering carousel

#### Slide Navigation
- [ ] **Indicator Dots**: Click each dot navigates to correct slide
- [ ] **Music Slide** (dot 1): Shows music production content
- [ ] **DIY Slide** (dot 2): Shows DIY tutorials content
- [ ] **Gaming Slide** (dot 3): Shows gaming content
- [ ] **Blog Slide** (dot 4): Shows blog insights content
- [ ] **Loop Behavior**: Last slide → first slide works correctly
- [ ] **Loop Behavior**: First slide → last slide works correctly

#### Breakpoint Edge Cases
- [ ] **991px**: Arrows should have opacity 0.4 (tablet behavior)
- [ ] **992px**: Arrows should be at -60px position (desktop behavior)
- [ ] **1200px**: Arrows fully visible and positioned correctly
- [ ] **1440px**: Arrows fully visible and positioned correctly
- [ ] **1920px**: Arrows fully visible and positioned correctly
- [ ] **2560px**: Arrows fully visible and positioned correctly

---

### Mobile/Tablet Testing (<992px)

#### Visual Inspection
- [ ] **Arrow Opacity**: Arrows dimmed to `opacity: 0.4`
- [ ] **Arrow Position**: Arrows remain at default Bootstrap positions (left/right: 0)
- [ ] **Touch Priority**: Dimmed arrows indicate touch swipe is preferred method
- [ ] **No Overlap**: Arrows don't obscure slide content

#### Interaction Tests
- [ ] **Touch Swipe Left**: Navigates to next slide
- [ ] **Touch Swipe Right**: Navigates to previous slide
- [ ] **Click Arrow (if visible)**: Still works but dimmed
- [ ] **Tap Indicator Dots**: Navigates to correct slides
- [ ] **Auto-play**: Carousel auto-advances every 5 seconds

#### Device-Specific Tests
- [ ] **iPhone SE (375px)**: Arrows dimmed, swipe works
- [ ] **iPhone 13 Pro (390px)**: Arrows dimmed, swipe works
- [ ] **iPad (768px)**: Arrows dimmed, swipe works
- [ ] **iPad Pro (834px)**: Arrows dimmed, swipe works
- [ ] **Tablet (991px)**: Arrows dimmed (breakpoint edge case)

---

## ✅ Social Icon Sizing Tests

### Mobile Testing (< 768px)

#### Visual Inspection
- [ ] **Button Size**: 64px × 64px square buttons
- [ ] **Icon Size**: 2.5rem (40px) icons
- [ ] **Icon Fill**: Icons properly fill buttons with minimal whitespace
- [ ] **Gap Spacing**: 8px gap between buttons (Bootstrap `gap-2`)
- [ ] **Horizontal Layout**: Icons display in horizontal row with flexbox
- [ ] **Wrap Behavior**: Icons wrap to second row if needed (on very small screens)

#### Individual Icon Tests
- [ ] **YouTube Icon** (`bi-youtube`): Centered, proper size
- [ ] **Twitch Icon** (`bi-twitch`): Centered, proper size
- [ ] **LinkedIn Icon** (`bi-linkedin`): Centered, proper size
- [ ] **GitHub Icon** (`bi-github`): Centered, proper size
- [ ] **Email Icon** (`bi-envelope-fill`): Centered, proper size
- [ ] **Discord Icon** (`bi-discord`): Centered, proper size

#### Interaction Tests
- [ ] **YouTube Link**: Opens https://youtube.com/@jenninexus in new tab
- [ ] **Twitch Link**: Opens https://twitch.tv/jenninexus in new tab
- [ ] **LinkedIn Link**: Opens https://www.linkedin.com/in/jennifer-scheerer/ in new tab
- [ ] **GitHub Link**: Opens https://github.com/jenninexus in new tab
- [ ] **Email Link**: Opens mail client to jenninexus@gmail.com
- [ ] **Discord Link**: Opens https://discord.gg/KYPh7Cp in new tab

#### Hover/Touch States
- [ ] **Touch Highlight**: Bootstrap outline effect on touch
- [ ] **Button Borders**: Outline borders visible on all buttons
- [ ] **Active State**: Button feedback on tap

#### Device-Specific Tests
- [ ] **iPhone SE (375px)**: 64px buttons, 2.5rem icons, proper spacing
- [ ] **iPhone 13 Pro (390px)**: 64px buttons, 2.5rem icons
- [ ] **Galaxy S21 (360px)**: 64px buttons, 2.5rem icons
- [ ] **Pixel 5 (393px)**: 64px buttons, 2.5rem icons

---

### Tablet Testing (768px - 991px)

#### Visual Inspection
- [ ] **Button Size**: 72px × 72px square buttons
- [ ] **Icon Size**: 2.75rem (44px) icons
- [ ] **Icon Fill**: Icons fill buttons better than mobile, less than desktop
- [ ] **Gap Spacing**: 8px gap between buttons
- [ ] **Single Row**: All 6 icons in single horizontal row
- [ ] **No Wrap**: Icons don't wrap to second row

#### Individual Icon Tests
- [ ] **All 6 Icons**: Properly sized at 2.75rem
- [ ] **All 6 Icons**: Vertically centered in 72px buttons
- [ ] **All 6 Icons**: Horizontally centered in 72px buttons

#### Interaction Tests
- [ ] **All 6 Links**: Work correctly (same as mobile tests)
- [ ] **Hover State**: Bootstrap outline effect on hover
- [ ] **Touch State**: Touch feedback works (if touch screen)

#### Device-Specific Tests
- [ ] **iPad (768px)**: 72px buttons, 2.75rem icons (breakpoint edge)
- [ ] **iPad (820px)**: 72px buttons, 2.75rem icons
- [ ] **iPad Pro (834px)**: 72px buttons, 2.75rem icons
- [ ] **Tablet Landscape (991px)**: 72px buttons, 2.75rem icons (breakpoint edge)

---

### Desktop Testing (≥992px)

#### Visual Inspection
- [ ] **Button Size**: 88px × 88px square buttons
- [ ] **Icon Size**: 3.5rem (56px) icons
- [ ] **Icon Fill**: Icons optimally fill buttons with minimal whitespace
- [ ] **Gap Spacing**: 8px gap between buttons
- [ ] **Single Row**: All 6 icons in single horizontal row
- [ ] **Centered**: Icon row centered in hero section

#### Individual Icon Tests
- [ ] **YouTube Icon**: 3.5rem, centered in 88px button
- [ ] **Twitch Icon**: 3.5rem, centered in 88px button
- [ ] **LinkedIn Icon**: 3.5rem, centered in 88px button
- [ ] **GitHub Icon**: 3.5rem, centered in 88px button
- [ ] **Email Icon**: 3.5rem, centered in 88px button
- [ ] **Discord Icon**: 3.5rem, centered in 88px button

#### Interaction Tests
- [ ] **All 6 Links**: Work correctly (same as mobile tests)
- [ ] **Hover State**: Bootstrap outline effect on hover
- [ ] **Cursor**: Pointer cursor on hover

#### Breakpoint Edge Cases
- [ ] **991px**: Should use tablet styles (72px/2.75rem)
- [ ] **992px**: Should use desktop styles (88px/3.5rem) - CRITICAL BREAKPOINT
- [ ] **1200px**: Desktop styles (88px/3.5rem)
- [ ] **1440px**: Desktop styles (88px/3.5rem)
- [ ] **1920px**: Desktop styles (88px/3.5rem)
- [ ] **2560px**: Desktop styles (88px/3.5rem), centered

---

## ✅ Responsive Layout Tests

### Overall Layout Integrity

#### Hero Section
- [ ] **Title**: "JenniNEXUS" displays correctly (custom styling)
- [ ] **Lead Text**: Multi-faceted creative platform text readable
- [ ] **CTA Buttons**: "Explore Content" and "YouTube Channels" visible
- [ ] **Social Icons**: 6 icons display below CTAs
- [ ] **No Overflow**: No horizontal scrollbar at any breakpoint

#### Carousel Section
- [ ] **Heading**: "Featured Content" centered and readable
- [ ] **Container**: Max-width 1140px, centered
- [ ] **Slides**: All 4 slides render correctly
- [ ] **Gradient Backgrounds**: Music (purple), DIY (pink), Gaming (cyan), Blog (orange)
- [ ] **Slide Content**: Text and icon display properly on each slide

### Cross-Browser Testing
- [ ] **Chrome**: All features work correctly
- [ ] **Firefox**: All features work correctly
- [ ] **Safari**: All features work correctly (if available)
- [ ] **Edge**: All features work correctly

### Accessibility Testing
- [ ] **Keyboard Navigation**: Tab through social icons and carousel
- [ ] **Screen Reader**: Buttons have proper `title` attributes
- [ ] **Aria Labels**: Carousel indicators have `aria-label`
- [ ] **Focus Indicators**: Visible focus outlines on interactive elements
- [ ] **Color Contrast**: Icons visible against button backgrounds

---

## 🐛 Known Issues & Edge Cases

### Expected Behaviors
1. **Mobile Icon Wrapping**: On very small screens (<350px), icons may wrap to 2 rows - THIS IS ACCEPTABLE
2. **Carousel Auto-play**: Pauses on hover, resumes after mouse leaves
3. **Touch Swipe**: Primary navigation method on mobile/tablet (<992px)
4. **Arrow Visibility**: Arrows dimmed on mobile to encourage touch swipe

### Potential Issues to Watch
1. **Ultra-wide Monitors**: Verify carousel arrows don't get lost at -60px on very wide screens
2. **Zoom Levels**: Test at 150% and 200% browser zoom
3. **Landscape Mobile**: Test mobile landscape orientation (e.g., 667×375)
4. **Tablet Portrait**: Verify breakpoint transition at 768px works smoothly

---

## 📊 Implementation Details

### Changes Made (November 18, 2025)

#### Social Icons
**Before**:
- Mobile: 64px buttons with 2.25rem icons (inline styles)
- Desktop: 80px buttons with 3.5rem icons (inline styles)
- Inconsistent sizing across breakpoints

**After**:
- Mobile (<768px): 64px buttons with 2.5rem icons (CSS)
- Tablet (768-991px): 72px buttons with 2.75rem icons (CSS)
- Desktop (≥992px): 88px buttons with 3.5rem icons (CSS)
- All inline styles removed, responsive CSS only

#### Carousel Arrows
**Before**:
- Desktop: Positioned at -50px with opacity 1
- Mobile: Opacity 0.3 (very faint)

**After**:
- Desktop (≥992px): Positioned at -60px (more spacing)
- Mobile/Tablet (<992px): Opacity 0.4 (slightly more visible)

### CSS Media Queries
```css
/* Mobile Default */
.social-links a { width: 64px; height: 64px; }
.social-links a i { font-size: 2.5rem; }

/* Tablet */
@media (min-width: 768px) and (max-width: 991px) {
  .social-links a { width: 72px; height: 72px; }
  .social-links a i { font-size: 2.75rem; }
}

/* Desktop */
@media (min-width: 992px) {
  .social-links a { width: 88px !important; height: 88px !important; }
  .social-links a i { font-size: 3.5rem !important; }
  
  #featuredCarousel .carousel-control-prev { left: -60px; }
  #featuredCarousel .carousel-control-next { right: -60px; }
}

/* Mobile Carousel Arrows */
@media (max-width: 991px) {
  #featuredCarousel .carousel-control-prev,
  #featuredCarousel .carousel-control-next {
    opacity: 0.4;
  }
}
```

---

## 📚 Testing Resources

### Browser DevTools
```javascript
// Check computed styles for social icon at 992px breakpoint
const icon = document.querySelector('.social-links a:first-child');
const iconElement = icon.querySelector('i');
console.log('Button size:', window.getComputedStyle(icon).width);
console.log('Icon size:', window.getComputedStyle(iconElement).fontSize);

// Check carousel arrow position at 992px breakpoint
const prevArrow = document.querySelector('#featuredCarousel .carousel-control-prev');
console.log('Arrow left position:', window.getComputedStyle(prevArrow).left);
```

### Responsive Testing Tools
- **Chrome DevTools**: Device toolbar (Cmd/Ctrl + Shift + M)
- **Firefox**: Responsive Design Mode (Cmd/Ctrl + Shift + M)
- **Safari**: Enter Responsive Design Mode (Develop menu)

### Device Presets to Test
1. iPhone SE (375×667) - Smallest common mobile
2. iPhone 13 Pro (390×844) - Modern mobile
3. iPad (768×1024) - Common tablet portrait
4. iPad Pro (834×1194) - Larger tablet
5. Desktop (1440×900) - Common laptop
6. Desktop (1920×1080) - Full HD monitor

---

## ✅ Sign-Off Checklist

### Development Environment
- [ ] **Dev Server Running**: http://localhost:8002 accessible
- [ ] **No PHP Errors**: Check terminal output for errors
- [ ] **No Console Errors**: Browser console shows no JS errors
- [ ] **Cache Cleared**: Hard refresh (Ctrl+Shift+R) performed

### Core Functionality
- [ ] **Carousel Navigation**: All methods work (arrows, dots, keyboard, auto-play)
- [ ] **Social Links**: All 6 links open correctly
- [ ] **Responsive Sizing**: Icons and arrows size correctly at 375px, 768px, 992px, 1440px

### Visual Quality
- [ ] **No Overlap**: Carousel arrows don't overlap hero content
- [ ] **Icon Fill**: Social icons properly fill buttons (not too much whitespace)
- [ ] **Consistent Spacing**: 8px gap between all social icons
- [ ] **Centered Layout**: Hero section centered at all breakpoints

### Deployment Readiness
- [ ] **All Tests Passed**: Majority of checklist items completed
- [ ] **Critical Issues Resolved**: No blocking issues found
- [ ] **Documentation Updated**: 11-18.md reflects completed work
- [ ] **Ready for Production**: Code ready to deploy (once testing complete)

---

**Test Guide Created**: November 18, 2025  
**Last Updated**: November 18, 2025  
**Related Files**: `storage/11-18.md`, `storage/11-12.md`, `public_html/index.php`
