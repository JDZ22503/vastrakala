const fs = require('fs');
let file = 'c:/laragon/www/ayush_web/resources/views/admin/mockups/index.blade.php';
let code = fs.readFileSync(file, 'utf8');

// 1. Add CSS for handles
const cssHandles = `
        .resize-handle-r { position: absolute; right: -4px; top: 50%; transform: translateY(-50%); width: 8px; height: 16px; background: #fff; border: 1px solid #8b3dff; border-radius: 4px; z-index: 10; cursor: ew-resize; display: none; }
        .resize-handle-b { position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%); width: 16px; height: 8px; background: #fff; border: 1px solid #8b3dff; border-radius: 4px; z-index: 10; cursor: ns-resize; display: none; }
        .drag-el.selected .resize-handle-r, .drag-el.selected .resize-handle-b { display: block; }`;
if (!code.includes('.resize-handle-r')) {
    code = code.replace(/(\.resize-handle\s*\{\s*position:\s*absolute;[\s\S]*?\})/, match => match + cssHandles);
}

// 2. Inject handles into makeDrag
if (!code.includes('className = \'resize-handle-r\'')) {
    code = code.replace(/el\.appendChild\(rh\);/, 
`el.appendChild(rh);
            const rhr = document.createElement('div'); rhr.className = 'resize-handle-r';
            const rhb = document.createElement('div'); rhb.className = 'resize-handle-b';
            el.appendChild(rhr); el.appendChild(rhb);
            rhr.addEventListener('mousedown', (e) => resizeSideStart(e, el, 'w'));
            rhb.addEventListener('mousedown', (e) => resizeSideStart(e, el, 'h'));`);
}

// 3. Inject resizeSideStart logic
const sideResizeLogic = `
        function resizeSideStart(e, el, mode) {
            e.preventDefault(); e.stopPropagation();
            const sx=e.clientX, sy=e.clientY, ow=el.offsetWidth, oh=el.offsetHeight;
            function mv(ev) {
                if(mode==='w') {
                    el.style.width=Math.max(20,ow+(ev.clientX-sx)/scale)+'px';
                } else if(mode==='h') {
                    el.style.height=Math.max(20,oh+(ev.clientY-sy)/scale)+'px';
                }
            }
            function up() { document.removeEventListener('mousemove',mv); document.removeEventListener('mouseup',up); }
            document.addEventListener('mousemove',mv); document.addEventListener('mouseup',up);
        }
`;
if (!code.includes('function resizeSideStart')) {
    code = code.replace(/function resizeStart\(/, sideResizeLogic + '        function resizeStart(');
}

// 4. Update addCustomElement for UI scaling using cqw
const newAddLogic = `} else {
                clone.style.width = '100%';
                clone.style.height = '100%';
                clone.style.pointerEvents = 'none';
                const el = makeDrag(cx-100, cy-50, 200, 100, 'decor');
                el.style.containerType = 'inline-size';
                
                const els = [clone, ...clone.querySelectorAll('*')];
                els.forEach(c => {
                    if (c.style && c.style.fontSize) {
                        const px = parseFloat(c.style.fontSize);
                        if(px > 0) c.style.fontSize = (px / 200 * 100) + 'cqw'; // relative to initial 200px width
                    }
                    if (c.style && c.style.padding) {
                        const parts = c.style.padding.split(' ').map(p => {
                            if(p.includes('px')) return (parseFloat(p) / 200 * 100) + 'cqw';
                            return p;
                        });
                        c.style.padding = parts.join(' ');
                    }
                    if (c.style && c.style.borderRadius) {
                        if(c.style.borderRadius.includes('px')) c.style.borderRadius = (parseFloat(c.style.borderRadius) / 200 * 100) + 'cqw';
                    }
                    if (c.style && c.style.borderWidth) {
                        if(c.style.borderWidth.includes('px')) c.style.borderWidth = (parseFloat(c.style.borderWidth) / 200 * 100) + 'cqw';
                    }
                });
                
                el.appendChild(clone);
            }`;

if (code.includes('const el = makeDrag(cx-100, cy-50, 200, null, \'decor\');')) {
    code = code.replace(/\} else \{\s*clone\.style\.width = '100%';\s*clone\.style\.height = '100%';\s*clone\.style\.pointerEvents = 'none';\s*const el = makeDrag\(cx-100, cy-50, 200, null, 'decor'\);\s*el\.appendChild\(clone\);\s*\}/, newAddLogic);
}

fs.writeFileSync(file, code);
console.log('Update successful!');
