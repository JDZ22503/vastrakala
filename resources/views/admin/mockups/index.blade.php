<x-app-layout>
 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton&family=Pacifico&family=Cinzel:wght@600;700&family=Sigmar+One&family=Dancing+Script:wght@700&family=Bebas+Neue&family=Lobster&family=Righteous&family=Russo+One&family=Permanent+Marker&family=Abril+Fatface&family=Fredoka+One&family=Bangers&family=Boogaloo&family=Satisfy&family=Poiret+One&family=Monoton&family=Raleway:wght@300;400;700;900&family=Merriweather:wght@300;700;900&family=Josefin+Sans:wght@100;300;700&family=Nunito:wght@300;700;900&family=Space+Grotesk:wght@300;700&display=swap');
        .studio-wrap { display: flex; height: calc(100vh - 65px); min-height: 700px; overflow: hidden; background: #e5e5e5; }
        
        /* CANVA STYLE SIDEBAR NAV */
        .sidebar-nav {
            width: 72px; min-width: 72px; background: #fff; border-right: 1px solid #e5e5e5;
            display: flex; flex-direction: column; align-items: center; padding: 16px 0; gap: 8px; z-index: 100;
        }
        .nav-btn {
            width: 64px; height: 60px; border-radius: 8px; border: none; background: transparent; color: #555;
            cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 500; font-family: 'Outfit', sans-serif; gap: 6px; transition: all 0.2s;
        }
        .nav-btn i { font-size: 20px; }
        .nav-btn:hover { background: #f0f2f5; color: #111; }
        .nav-btn.active { background: #e8ecf4; color: #8b3dff; }

        /* CANVA STYLE SIDEBAR PANEL */
        .sidebar-panel {
            width: 340px; min-width: 340px; background: #fff; border-right: 1px solid #e5e5e5;
            display: flex; flex-direction: column; height: 100%; position: relative; color: #333;
        }
        .panel-content {
            overflow-y: auto; height: 100%; display: none; padding-bottom: 20px;
            scrollbar-width: thin; scrollbar-color: #ccc transparent;
        }
        .panel-content.active { display: block; }

        /* TOP BAR */
        .top-bar {
            height: 60px; background: #fff; border-bottom: 1px solid #e5e5e5; display: flex;
            align-items: center; justify-content: space-between; padding: 0 20px; z-index: 90;
        }

        .studio-canvas-container {
            flex: 1; display: flex; flex-direction: column; background: #f0f2f5; position: relative;
        }

        /* TOOLBAR ELEMENTS */
        .search-bar {
            display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #d1d5db;
            border-radius: 6px; padding: 0 12px; height: 40px; margin-bottom: 16px; width: 100%; box-sizing: border-box;
        }
        .search-bar i { color: #888; font-size: 14px; }
        .search-bar input {
            border: none; background: transparent; width: 100%; height: 100%; font-size: 13px; outline: none; color: #333;
        }
        .search-bar input::placeholder { color: #9ca3af; }

        .tb-section { padding: 16px; border-bottom: 1px solid #f0f2f5; }
        .tb-section h4 {
            font-size: 13px; text-transform: none; letter-spacing: 0;
            color: #111; margin-bottom: 12px; font-weight: 600; font-family: 'Outfit', sans-serif;
        }
        .tb-btn {
            display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 14px;
            border: 1px solid #e1e3e5; border-radius: 8px; background: #fff; color: #333;
            cursor: pointer; transition: all 0.15s; font-size: 13px; margin-bottom: 8px;
            box-sizing: border-box;
        }
        .tb-btn:hover { background: #f9f9f9; border-color: #8b3dff; }
        .tb-btn i { width: 18px; text-align: center; color: #555; font-size: 16px; }

        /* Generate Button */
        .generate-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 10px 12px; border: none; border-radius: 8px;
            background: #8b3dff; color: #fff;
            cursor: pointer; font-size: 14px; font-weight: 600; transition: all 0.2s;
            box-sizing: border-box;
        }
        .generate-btn:hover { background: #7a31e8; }
        .generate-btn i { font-size: 16px; }

        .export-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 10px 16px; border: none; border-radius: 6px;
            background: #fff; border: 1px solid #d1d5db; color: #333;
            cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s;
        }
        .export-btn:hover { background: #f0f2f5; }

        .tb-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .tb-grid .tb-btn {
            justify-content: center; flex-direction: column; gap: 6px;
            padding: 12px 6px; font-size: 11px; font-weight: 600;
        }
        .tb-grid .tb-btn i { font-size: 20px; width: auto; color: #555; }

        .swatch-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 8px; }
        .swatch {
            aspect-ratio: 1; border-radius: 8px; cursor: pointer; border: 2px solid transparent;
            transition: all 0.15s; box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
        }
        .swatch:hover, .swatch.active { border-color: #8b3dff; transform: scale(1.05); }

        /* Format Pills & Sidebar UI Elements */
        .format-pills { display: flex; gap: 4px; background: #f0f2f5; border-radius: 8px; padding: 4px; }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #e1e3e5;
            background: #fff;
            color: #555;
            text-align: center;
        }
        .badge.active {
            background: #8b3dff !important;
            color: #fff !important;
            border-color: #8b3dff !important;
        }
        .format-pill {
            flex: 1;
            border: none;
            background: transparent;
        }
        .format-pill.active {
            background: #fff;
            color: #111;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .swatch {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #e1e3e5;
            transition: transform 0.1s;
        }
        .swatch:hover { transform: scale(1.1); }
        .swatch.active { border: 2px solid #8b3dff; }

        /* TEXT PROPS */
        .props-row { display: flex; gap: 8px; align-items: center; margin-bottom: 8px; }
        .props-row label { font-size: 11px; color: #555; width: 40px; flex-shrink: 0; font-weight: 500; }
        .props-input {
            flex: 1; background: #fff; border: 1px solid #d1d5db; border-radius: 6px;
            color: #333; padding: 6px 8px; font-size: 13px; outline: none;
        }
        .props-input:focus { border-color: #8b3dff; }

        /* CONTEXT TOOLBAR */
        .context-toolbar {
            position: absolute; top: 76px; left: 50%; transform: translateX(-50%);
            background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex; align-items: center; gap: 4px; padding: 6px; border: 1px solid #e1e3e5;
            z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.2s, top 0.2s;
        }
        .context-toolbar.active { opacity: 1; pointer-events: auto; }
        .ct-btn {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            height: 32px; min-width: 32px; padding: 0 10px; border-radius: 6px; border: none;
            background: transparent; color: #444; font-size: 13px; font-weight: 600; cursor: pointer;
            transition: all 0.15s; font-family: 'Outfit', sans-serif;
        }
        .ct-btn:hover { background: #f0f2f5; color: #111; }
        .ct-divider { width: 1px; height: 20px; background: #e5e5e5; margin: 0 4px; }
        .ct-color-picker {
            width: 24px; height: 24px; border-radius: 50%; border: 1px solid #ccc;
            cursor: pointer; overflow: hidden; padding: 0; background: transparent;
        }
        .ct-color-picker::-webkit-color-swatch-wrapper { padding: 0; }
        .ct-color-picker::-webkit-color-swatch { border: none; border-radius: 50%; }

        /* CANVAS AREA */
        .studio-canvas-area {
            flex: 1; display: flex; align-items: flex-start; justify-content: center;
            overflow: auto; padding: 60px 40px;
            background-image: radial-gradient(#ccc 1px, transparent 1px);
            background-size: 16px 16px;
            cursor: grab;
        }
        .studio-canvas-area:active { cursor: grabbing; }

        /* ARTBOARD */
        .artboard { position: relative; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.6); border-radius: 3px; flex-shrink: 0; margin: auto; }
        .artboard-inner { position: relative; width: 100%; height: 100%; overflow: hidden; }

        /* BG LAYERS */
        .bg-image-layer {
            position: absolute; inset: 0; z-index: 0;
            background-size: cover; background-position: center top;
        }
        .bg-overlay-layer {
            position: absolute; inset: 0; z-index: 1;
        }

        /* DRAGGABLE */
        .drag-el {
            position: absolute; cursor: move; user-select: none;
            outline: 2px solid transparent; transition: outline 0.1s; z-index: 5;
        }
        .drag-el:hover { outline: 2px solid rgba(209,163,146,0.4); }
        .drag-el.selected { outline: 2px solid #D1A392; }
        .drag-el .resize-handle {
            position: absolute; width: 14px; height: 14px; background: #D1A392;
            border: 2px solid #fff; border-radius: 3px; cursor: nwse-resize;
            right: -7px; bottom: -7px; display: none; z-index: 30;
        }
        .resize-handle-r { position: absolute; right: -4px; top: 50%; transform: translateY(-50%); width: 8px; height: 16px; background: #fff; border: 1px solid #8b3dff; border-radius: 4px; z-index: 10; cursor: ew-resize; display: none; }
        .resize-handle-b { position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%); width: 16px; height: 8px; background: #fff; border: 1px solid #8b3dff; border-radius: 4px; z-index: 10; cursor: ns-resize; display: none; }
        .drag-el.selected .resize-handle-r, .drag-el.selected .resize-handle-b { display: block; }
        .drag-el.selected .resize-handle { display: block; }
        .drag-el .delete-handle {
            position: absolute; width: 22px; height: 22px; background: #e55; color: #fff;
            border-radius: 50%; cursor: pointer; font-size: 13px; line-height: 22px;
            text-align: center; right: -8px; top: -8px; display: none; z-index: 30; font-weight: bold;
        }
        .drag-el.interact-mode { outline: 2px solid #22c55e !important; cursor: default; }
        .drag-el.interact-mode .resize-handle, .drag-el.interact-mode .resize-handle-r,
        .drag-el.interact-mode .resize-handle-b, .drag-el.interact-mode .delete-handle { display: none !important; }
        .drag-el.interact-mode > *:not(.interact-badge) { pointer-events: all !important; }
        .interact-badge { position: absolute; top: -22px; left: 50%; transform: translateX(-50%);
            background: #22c55e; color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 10px;
            white-space: nowrap; z-index: 40; pointer-events: none; font-family: 'Outfit', sans-serif; }
        .drag-el.selected .delete-handle { display: block; }

        /* Click-to-change overlay */
        .screen-overlay {
            position: absolute; inset: 0; z-index: 10; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            background: transparent; transition: background 0.2s; border-radius: inherit;
        }
        .screen-overlay:hover { background: rgba(0,0,0,0.45); }
        .screen-overlay .cam-icon {
            opacity: 0; transition: opacity 0.2s; color: #fff; font-size: 20px;
            background: rgba(209,163,146,0.9); width: 40px; height: 40px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }
        .screen-overlay:hover .cam-icon { opacity: 1; }

        /* DEVICE FRAMES */
        .device-frame { pointer-events: none; width: 100%; height: 100%; position: relative; }

        .device-imac { background: #222; border-radius: 12px; padding: 12px 12px 42px; box-shadow: inset 0 0 0 2px #333; }
        .device-imac .screen { width: 100%; height: calc(100%); border-radius: 2px; overflow: hidden; background: #000; position: relative; }
        .device-imac .screen img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .device-imac .stand-area { position: absolute; bottom: 0; left: 0; right: 0; height: 42px; display: flex; flex-direction: column; align-items: center; }
        .device-imac .chin { width: 100%; height: 26px; background: #222; border-radius: 0 0 12px 12px; display: flex; align-items: center; justify-content: center; }
        .device-imac .chin-dot { width: 7px; height: 7px; background: #444; border-radius: 50%; }
        .device-imac .stand-foot { width: 28%; height: 16px; background: linear-gradient(#2a2a2a, #333); clip-path: polygon(12% 0, 88% 0, 100% 100%, 0% 100%); }

        .device-macbook { background: #2c2c2e; border-radius: 10px 10px 0 0; padding: 8px 10px 6px; box-shadow: inset 0 0 0 1.5px #444; }
        .device-macbook .screen { width: 100%; height: calc(100% - 14px); border-radius: 2px; overflow: hidden; background: #000; position: relative; }
        .device-macbook .screen img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .device-macbook .base { position: absolute; bottom: -5px; left: -5%; width: 110%; height: 7px; background: linear-gradient(#3a3a3c, #2c2c2e); border-radius: 0 0 5px 5px; }
        .device-macbook .notch { position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); width: 16%; height: 3px; background: #555; border-radius: 0 0 3px 3px; }

        .device-ipad { background: #1c1c1e; border-radius: 14px; padding: 10px; box-shadow: inset 0 0 0 1.5px #333; }
        .device-ipad .screen { width: 100%; height: 100%; border-radius: 6px; overflow: hidden; background: #000; position: relative; }
        .device-ipad .screen img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .device-iphone {
            background: #2a2a2c;
            border-radius: 44px;
            padding: 8px;
            box-shadow: inset 0 0 0 1px #444, inset 0 0 0 3px #2a2a2c, 0 0 0 1px #1a1a1a;
            position: relative;
        }
        /* Side buttons */
        .device-iphone::before {
            content: '';
            position: absolute;
            right: -3px; top: 22%;
            width: 3px; height: 14%;
            background: #333;
            border-radius: 0 3px 3px 0;
        }
        .device-iphone::after {
            content: '';
            position: absolute;
            left: -3px; top: 18%;
            width: 3px; height: 8%;
            background: #333;
            border-radius: 3px 0 0 3px;
            box-shadow: 0 28px 0 #333, 0 52px 0 #333;
        }
        .device-iphone .screen {
            width: 100%; height: 100%;
            border-radius: 38px;
            overflow: hidden;
            background: #000;
            position: relative;
        }
        .device-iphone .screen img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .device-iphone .notch-pill {
            position: absolute; top: 10px; left: 50%; transform: translateX(-50%);
            width: 30%; height: 22px;
            background: #000; border-radius: 20px; z-index: 3;
        }

        /* TEXT */
        .text-element { color: #fff; padding: 4px 8px; min-width: 50px; word-break: break-word; white-space: pre-wrap; pointer-events: auto; }
        .text-element:focus { outline: none; }

        .empty-state { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: rgba(255,255,255,0.12); pointer-events: none; z-index: 0; }
        .empty-state i { font-size: 52px; margin-bottom: 14px; }

        /* Template Grid */
        .template-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 4px 0;
            min-height: 200px;
        }
        .tpl-card {
            background: #fff;
            border: 1px solid #e1e3e5;
            border-radius: 8px;
            padding: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .tpl-card:hover {
            border-color: #8b3dff;
            background: #f9f9f9;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }
        .tpl-preview {
            width: 100%;
            aspect-ratio: 9/12;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 4px;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
        }
        .tpl-card p {
            margin: 0;
            font-size: 11px;
            font-weight: 600;
            color: #111;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .tp-line { border-radius: 2px; flex-shrink: 0; }
        .tp-device { border-radius: 4px; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        .tp-phone { border-radius: 6px; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }

        @media (max-width: 768px) {
            .studio-wrap { flex-direction: column; height: auto; }
            .studio-toolbar { width: 100%; min-width: unset; max-height: 280px; }
            .studio-canvas-area { min-height: 500px; }
        }

        :root {
            --bg: #ffffff;
            --bg2: #f5f5f7;
            --bg3: #ececec;
            --text: #1a1a1a;
            --text2: #666;
            --text3: #999;
            --border: #e1e3e5;
            --border2: rgba(0, 0, 0, 0.2);
            --accent: #8b3dff;
            --accent-light: #f5edfc;
            --radius: 8px;
            --radius-lg: 12px;
        }

        #tab-elements {
            padding: 0;
        }

        .search-wrap {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            background: var(--bg);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .search-inner {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 7px 10px;
        }
        .search-inner svg {
            flex-shrink: 0;
            color: var(--text3);
        }
        .search-inner input {
            border: none;
            background: transparent;
            word-break: break-word;
        }

        /* Canvas Footer Bar */
        .studio-footer {
            height: 48px;
            background: #fff;
            border-top: 1px solid #e1e3e5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            z-index: 100;
            color: #555;
            font-size: 13px;
            font-weight: 500;
            user-select: none;
        }
        .footer-left, .footer-right { display: flex; align-items: center; gap: 16px; }
        .footer-center { position: absolute; left: 50%; transform: translateX(-50%); display: flex; align-items: center; gap: 12px; }
        
        .footer-btn {
            display: flex; align-items: center; gap: 6px; padding: 6px 8px; border-radius: 4px;
            cursor: pointer; transition: background 0.15s;
        }
        .footer-btn:hover { background: #f0f2f5; color: #111; }
        
        .zoom-wrap { display: flex; align-items: center; gap: 10px; }
        .zoom-slider {
            width: 120px;
            height: 4px;
            background: #e1e3e5;
            border-radius: 2px;
            -webkit-appearance: none;
            outline: none;
        }
        .zoom-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
            background: #fff;
            border: 2px solid #8b3dff;
            border-radius: 50%;
            cursor: pointer;
        }
        .page-badge {
            background: #f0f2f5; padding: 4px 10px; border-radius: 4px; border: 1px solid #e1e3e5; font-family: monospace;
        }

        .search-inner input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: var(--text);
            width: 100%;
        }
        .search-inner input::placeholder {
            color: var(--text3);
        }

        /* tabs */
            .tabs {
                display: flex;
                border-bottom: 1px solid var(--border);
                overflow-x: auto;
                scrollbar-width: none;
                background: var(--bg);
                position: sticky;
                top: 57px;
                z-index: 9;
            }
            .tabs::-webkit-scrollbar {
                display: none;
            }
            .tab {
                padding: 9px 13px;
                font-size: 12px;
                font-weight: 500;
                color: var(--text2);
                cursor: pointer;
                white-space: nowrap;
                border-bottom: 2px solid transparent;
                transition: all 0.15s;
                user-select: none;
            }
            .tab:hover {
                color: var(--text);
            }
            .tab.active {
                color: var(--accent);
                border-bottom-color: var(--accent);
            }

            /* scrollable content */
            .panel-body {
                overflow-y: auto;
                flex: 1;
                scrollbar-width: thin;
                scrollbar-color: var(--border2) transparent;
            }
            .panel-body::-webkit-scrollbar {
                width: 4px;
            }
            .panel-body::-webkit-scrollbar-thumb {
                background: var(--border2);
                border-radius: 4px;
            }

            /* section */
            .section {
                padding: 12px 12px 4px;
            }
            .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 9px;
            }
            .section-title {
                font-size: 12px;
                font-weight: 600;
                color: var(--text);
            }
            .see-all {
                font-size: 11px;
                color: var(--accent);
                cursor: pointer;
            }
            .see-all:hover {
                text-decoration: underline;
            }

            .divider {
                height: 1px;
                background: var(--border);
                margin: 2px 12px;
            }

            /* grids */
            .grid-2 {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 6px;
                margin-bottom: 8px;
            }
            .grid-3 {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 6px;
                margin-bottom: 8px;
            }
            .grid-4 {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr;
                gap: 5px;
                margin-bottom: 8px;
            }

            /* element card */
            .el {
                background: var(--bg2);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 10px 6px 8px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 5px;
                cursor: pointer;
                transition: all 0.15s;
                user-select: none;
            }
            .el:hover {
                border-color: var(--accent);
                background: var(--accent-light);
            }
            .el:active {
                transform: scale(0.96);
            }
            .el svg {
                flex-shrink: 0;
            }
            .el-label {
                font-size: 10px;
                color: var(--text2);
                text-align: center;
                line-height: 1.3;
            }

            /* row element card */
            .el-row {
                background: var(--bg2);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 8px 10px;
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                transition: all 0.15s;
                user-select: none;
            }
            .el-row:hover {
                border-color: var(--accent);
                background: var(--accent-light);
            }
            .el-row:active {
                transform: scale(0.98);
            }
            .el-row .el-label {
                text-align: left;
                font-size: 11px;
                color: var(--text);
            }

            /* preview rect */
            .preview {
                width: 100%;
                height: 54px;
                border-radius: var(--radius);
                border: 1px solid var(--border);
                cursor: pointer;
                transition: border-color 0.15s;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--bg2);
            }
            .preview:hover {
                border-color: var(--accent);
            }

            /* badges row */
            .badges {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-bottom: 8px;
            }
            .badge {
                font-size: 10px;
                padding: 3px 9px;
                border-radius: 20px;
                font-weight: 600;
                cursor: pointer;
                transition: opacity 0.15s;
            }
            .badge.active {
                background: var(--accent);
                color: #fff;
            }
            .swatch {
                width: 24px;
                height: 24px;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid var(--border);
                transition: transform 0.1s;
            }
            .swatch:hover { transform: scale(1.1); }
            .swatch.active { border: 2px solid var(--accent); }

            /* tooltip on hover */
            .el[title]:hover::after {
                content: attr(title);
                position: absolute;
                background: #1a1a1a;
                color: #fff;
                font-size: 10px;
                padding: 3px 7px;
                border-radius: 4px;
                white-space: nowrap;
                pointer-events: none;
                z-index: 100;
                margin-top: 4px;
            }
    </style>

    <div class="studio-wrap">
        <!-- CANVA SIDEBAR NAV -->
        <div class="sidebar-nav">
            <button class="nav-btn active" onclick="switchTab('design')" id="nav-design"><i class="fa-solid fa-layer-group"></i>Design</button>
            <button class="nav-btn" onclick="switchTab('elements')" id="nav-elements"><i class="fa-solid fa-shapes"></i>Elements</button>
            <button class="nav-btn" onclick="switchTab('text')" id="nav-text"><i class="fa-solid fa-font"></i>Text</button>
            <button class="nav-btn" onclick="switchTab('uploads')" id="nav-uploads"><i class="fa-solid fa-cloud-arrow-up"></i>Bg</button>
            
            <div style="flex:1;"></div>
            <button class="nav-btn" style="color:#e88;" onclick="clearAll()"><i class="fa-solid fa-trash"></i>Reset</button>
        </div>

        <div class="sidebar-panel">
            <div id="tab-design" class="panel-content active">
            {{-- MAIN ACTION --}}
            <div class="tb-section">
                <div class="search-bar"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Describe your ideal design"></div>
                <div style="display:flex; gap:8px; margin-bottom: 16px;">
                    <button class="generate-btn" style="background:#f0f2f5;color:#333;border:1px solid #e1e3e5;padding:10px 12px;font-size:13px;" onclick="document.getElementById('mainUpload').click()">
                        <i class="fa-solid fa-wand-magic-sparkles" style="color:#8b3dff;"></i> Generate
                    </button>
                    <button class="generate-btn" style="padding:10px 12px;font-size:13px;">Search</button>
                </div>
                <input type="file" id="mainUpload" class="hidden" accept="image/*" />
            </div>

            {{-- FORMATS --}}
            <div class="tb-section">
                <h4>Design size</h4>
                <div class="badges">
                    <div class="badge format-pill active" data-format="story" onclick="setFormat('story')">Story</div>
                    <div class="badge format-pill" data-format="insta" onclick="setFormat('insta')">Insta</div>
                    <div class="badge format-pill" data-format="square" onclick="setFormat('square')">Square</div>
                    <div class="badge format-pill" data-format="wide" onclick="setFormat('wide')">Wide</div>
                </div>
            </div>

            {{-- BACKGROUNDS --}}
            <div class="tb-section">
                <h4>Post background</h4>
                <div class="badges">
                    <div class="badge" style="background:var(--bg2);color:var(--text);border:1px solid var(--border);" onclick="document.getElementById('bgUpload').click()">Upload</div>
                    <input type="file" id="bgUpload" class="hidden" accept="image/*" />
                    <div class="swatch" style="background:linear-gradient(160deg, #e8d5c4, #a08068)" onclick="setBg('warm')"></div>
                    <div class="swatch" style="background:linear-gradient(160deg, #1e1e1e, #0a0a0a)" onclick="setBg('dark')"></div>
                    <div class="swatch" style="background:linear-gradient(160deg, #d1a392, #7e635a)" onclick="setBg('terracotta')"></div>
                    <div class="swatch" style="background:linear-gradient(135deg, #667eea, #764ba2)" onclick="setBg('ocean')"></div>
                    <div class="swatch" style="background:linear-gradient(180deg, #0f0c29, #302b63)" onclick="setBg('midnight')"></div>
                </div>
            </div>

            {{-- TEMPLATES --}}
            <div class="tb-section">
                <h4>Templates</h4>
                <div class="template-grid" id="templateGrid">
                    <!-- Cards injected by JS below -->
                </div>
            </div>
            </div> <!-- CLOSE DESIGN TAB -->

            <!-- ELEMENTS TAB -->
            <div id="tab-elements" class="panel-content" style="padding: 0;">
    <div class="search-wrap">
                <div class="search-inner">
                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input
                        id="searchElementsInput"
                        placeholder="Search elements..."
                        oninput="filterElements(this.value)"
                    />
                    <svg
                        id="el-clear-btn"
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        style="cursor: pointer; display: none"
                        onclick="clearElSearch()"
                    >
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>

            <div class="tabs">
                <div class="tab active" onclick="switchElTab(this, 'all')">
                    All
                </div>
                <div class="tab" onclick="switchElTab(this, 'shapes')">
                    Shapes
                </div>
                <div class="tab" onclick="switchElTab(this, 'frames')">
                    Frames
                </div>
                <div class="tab" onclick="switchElTab(this, 'icons')">Icons</div>
                <div class="tab" onclick="switchElTab(this, 'charts')">
                    Charts
                </div>
                <div class="tab" onclick="switchElTab(this, 'ui')">UI</div>
                <div class="tab" onclick="switchElTab(this, 'deco')">Deco</div>
            </div>

            <div class="panel-body" id="panel-body">
                <!-- SHAPES -->
                <div class="section" data-cat="shapes">
                    <div class="section-header">
                        <span class="section-title">Shapes</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-4">
                        <div class="el" onclick="handleElClick(event)" data-name="circle">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <circle
                                    cx="11"
                                    cy="11"
                                    r="9"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                            </svg>
                            <span class="el-label">Circle</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="square">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <rect
                                    x="2"
                                    y="2"
                                    width="18"
                                    height="18"
                                    rx="1.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                            </svg>
                            <span class="el-label">Square</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="rectangle">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <rect
                                    x="1"
                                    y="5"
                                    width="20"
                                    height="12"
                                    rx="1.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                            </svg>
                            <span class="el-label">Rect</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="triangle">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <polygon
                                    points="11,2 20,20 2,20"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                            </svg>
                            <span class="el-label">Triangle</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="star">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <polygon
                                    points="11,2 13.5,8.5 20,9 15.2,13.5 16.8,20 11,16.5 5.2,20 6.8,13.5 2,9 8.5,8.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Star</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="blob">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <path
                                    d="M11 2 Q17 2 18 8 Q22 10 20 15 Q18 20 13 20 Q10 22 8 20 Q4 19 3 14 Q0 10 4 7 Q5 2 11 2Z"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Blob</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="hexagon">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <polygon
                                    points="11,2 19,6.5 19,15.5 11,20 3,15.5 3,6.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Hexagon</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="diamond">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <polygon
                                    points="11,2 20,11 11,20 2,11"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Diamond</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="pentagon">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <polygon
                                    points="11,2 20,8.5 16.5,19 5.5,19 2,8.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Pentagon</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="rounded rectangle">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <rect
                                    x="1"
                                    y="5"
                                    width="20"
                                    height="12"
                                    rx="5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                            </svg>
                            <span class="el-label">Pill</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="cross">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <path
                                    d="M8,2 h6 v6 h6 v6 h-6 v6 h-6 v-6 h-6 v-6 h6Z"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Cross</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="arrow shape">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <path
                                    d="M2,9 h12 v-4 l7,6 -7,6 v-4 h-12Z"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Arrow</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- FRAMES -->
                <div class="section" data-cat="frames">
                    <div class="section-header">
                        <span class="section-title">Frames</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-4">
                        <div class="el" onclick="handleElClick(event)" data-name="phone frame">
                            <svg width="18" height="22" viewBox="0 0 18 28">
                                <rect
                                    x="1"
                                    y="1"
                                    width="16"
                                    height="26"
                                    rx="3"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <line
                                    x1="6"
                                    y1="25"
                                    x2="12"
                                    y2="25"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                                <rect
                                    x="7"
                                    y="3"
                                    width="4"
                                    height="1.5"
                                    rx="0.75"
                                    fill="#555"
                                />
                            </svg>
                            <span class="el-label">Phone</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="laptop frame">
                            <svg width="22" height="18" viewBox="0 0 26 20">
                                <rect
                                    x="2"
                                    y="1"
                                    width="22"
                                    height="14"
                                    rx="2"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <path
                                    d="M0,17 Q13,15 26,17"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Laptop</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="browser frame">
                            <svg width="22" height="18" viewBox="0 0 24 18">
                                <rect
                                    x="1"
                                    y="1"
                                    width="22"
                                    height="16"
                                    rx="2"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <line
                                    x1="1"
                                    y1="5.5"
                                    x2="23"
                                    y2="5.5"
                                    stroke="#555"
                                    stroke-width="1.2"
                                />
                                <circle cx="4.5" cy="3.2" r="1" fill="#555" />
                                <circle cx="7.5" cy="3.2" r="1" fill="#555" />
                                <circle cx="10.5" cy="3.2" r="1" fill="#555" />
                            </svg>
                            <span class="el-label">Browser</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="ipad tablet frame">
                            <svg width="16" height="22" viewBox="0 0 18 26">
                                <rect
                                    x="1"
                                    y="1"
                                    width="16"
                                    height="24"
                                    rx="2.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <circle cx="9" cy="23" r="1" fill="#555" />
                            </svg>
                            <span class="el-label">iPad</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="circle frame">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <circle
                                    cx="11"
                                    cy="11"
                                    r="9"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="2.5"
                                    stroke-dasharray="2 1"
                                />
                            </svg>
                            <span class="el-label">Circle</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="imac desktop frame">
                            <svg width="22" height="20" viewBox="0 0 26 22">
                                <rect
                                    x="1"
                                    y="1"
                                    width="24"
                                    height="16"
                                    rx="2"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <line
                                    x1="8"
                                    y1="19"
                                    x2="18"
                                    y2="19"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                                <line
                                    x1="13"
                                    y1="17"
                                    x2="13"
                                    y2="19"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">iMac</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="polaroid photo frame">
                            <svg width="18" height="22" viewBox="0 0 18 22">
                                <rect
                                    x="1"
                                    y="1"
                                    width="16"
                                    height="20"
                                    rx="1.5"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <rect
                                    x="3"
                                    y="3"
                                    width="12"
                                    height="10"
                                    rx="1"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1"
                                />
                            </svg>
                            <span class="el-label">Polaroid</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="tv screen frame">
                            <svg width="22" height="18" viewBox="0 0 24 20">
                                <rect
                                    x="1"
                                    y="1"
                                    width="22"
                                    height="15"
                                    rx="2"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.6"
                                />
                                <path
                                    d="M8,17 L7,20 M16,17 L17,20"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">TV</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- LINES -->
                <div class="section" data-cat="shapes">
                    <div class="section-header">
                        <span class="section-title">Lines &amp; arrows</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-4">
                        <div class="el" onclick="handleElClick(event)" data-name="straight line">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <line
                                    x1="2"
                                    y1="7"
                                    x2="22"
                                    y2="7"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                            </svg>
                            <span class="el-label">Line</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="arrow line">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <line
                                    x1="2"
                                    y1="7"
                                    x2="17"
                                    y2="7"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                                <polygon points="17,4 22,7 17,10" fill="#555" />
                            </svg>
                            <span class="el-label">Arrow</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="curved line">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <path
                                    d="M2,11 Q12,2 22,11"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                            </svg>
                            <span class="el-label">Curve</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="dashed line">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <line
                                    x1="2"
                                    y1="7"
                                    x2="22"
                                    y2="7"
                                    stroke="#555"
                                    stroke-width="1.8"
                                    stroke-dasharray="4,3"
                                />
                            </svg>
                            <span class="el-label">Dashed</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="double arrow">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <polygon points="7,4 2,7 7,10" fill="#555" />
                                <line
                                    x1="2"
                                    y1="7"
                                    x2="22"
                                    y2="7"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                                <polygon points="17,4 22,7 17,10" fill="#555" />
                            </svg>
                            <span class="el-label">Double</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="wavy line">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <path
                                    d="M2,7 Q5,3 8,7 Q11,11 14,7 Q17,3 20,7 Q22,9 22,7"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                            </svg>
                            <span class="el-label">Wavy</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="dotted line">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <line
                                    x1="2"
                                    y1="7"
                                    x2="22"
                                    y2="7"
                                    stroke="#555"
                                    stroke-width="2"
                                    stroke-dasharray="1,4"
                                    stroke-linecap="round"
                                />
                            </svg>
                            <span class="el-label">Dotted</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="elbow connector">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <path
                                    d="M2,11 L12,11 L12,3 L22,3"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                            </svg>
                            <span class="el-label">Elbow</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- ICONS -->
                <div class="section" data-cat="icons">
                    <div class="section-header">
                        <span class="section-title">Icons</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-4">
                        <div class="el" onclick="handleElClick(event)" data-name="home icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                                />
                                <polyline points="9,22 9,12 15,12 15,22" />
                            </svg>
                            <span class="el-label">Home</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="search icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            <span class="el-label">Search</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="user person icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"
                                />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <span class="el-label">User</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="heart like icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"
                                />
                            </svg>
                            <span class="el-label">Heart</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="email mail icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <span class="el-label">Email</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="map pin location icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"
                                />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span class="el-label">Pin</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="clock time icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12,6 12,12 16,14" />
                            </svg>
                            <span class="el-label">Clock</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="phone call icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.64A2 2 0 012 .82h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"
                                />
                            </svg>
                            <span class="el-label">Phone</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="share upload icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"
                                />
                                <polyline points="16,6 12,2 8,6" />
                                <line x1="12" y1="2" x2="12" y2="15" />
                            </svg>
                            <span class="el-label">Share</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="settings gear icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"
                                />
                            </svg>
                            <span class="el-label">Settings</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="notification bell icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"
                                />
                                <path d="M13.73 21a2 2 0 01-3.46 0" />
                            </svg>
                            <span class="el-label">Bell</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="lock security icon">
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="3"
                                    y="11"
                                    width="18"
                                    height="11"
                                    rx="2"
                                    ry="2"
                                />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                            <span class="el-label">Lock</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- CHARTS -->
                <div class="section" data-cat="charts">
                    <div class="section-header">
                        <span class="section-title">Charts &amp; data</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-4">
                        <div class="el" onclick="handleElClick(event)" data-name="bar chart">
                            <svg width="22" height="18" viewBox="0 0 24 18">
                                <rect
                                    x="1"
                                    y="11"
                                    width="4"
                                    height="6"
                                    fill="#bbb"
                                />
                                <rect
                                    x="7"
                                    y="7"
                                    width="4"
                                    height="10"
                                    fill="#888"
                                />
                                <rect
                                    x="13"
                                    y="4"
                                    width="4"
                                    height="13"
                                    fill="#555"
                                />
                                <rect
                                    x="19"
                                    y="9"
                                    width="4"
                                    height="8"
                                    fill="#aaa"
                                />
                            </svg>
                            <span class="el-label">Bar chart</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="line chart graph">
                            <svg width="22" height="18" viewBox="0 0 24 18">
                                <polyline
                                    points="2,15 6,10 10,12 14,5 18,8 22,4"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                                <circle cx="2" cy="15" r="1.5" fill="#555" />
                                <circle cx="6" cy="10" r="1.5" fill="#555" />
                                <circle cx="10" cy="12" r="1.5" fill="#555" />
                                <circle cx="14" cy="5" r="1.5" fill="#555" />
                                <circle cx="18" cy="8" r="1.5" fill="#555" />
                                <circle cx="22" cy="4" r="1.5" fill="#555" />
                            </svg>
                            <span class="el-label">Line chart</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="pie chart">
                            <svg width="22" height="20" viewBox="0 0 22 22">
                                <path
                                    d="M11,11 L11,2 A9,9 0 0,1 18.4,6.5Z"
                                    fill="#555"
                                />
                                <path
                                    d="M11,11 L18.4,6.5 A9,9 0 0,1 11,20Z"
                                    fill="#888"
                                />
                                <path
                                    d="M11,11 L11,20 A9,9 0 0,1 2,11Z"
                                    fill="#bbb"
                                />
                                <path
                                    d="M11,11 L2,11 A9,9 0 0,1 11,2Z"
                                    fill="#ddd"
                                />
                            </svg>
                            <span class="el-label">Pie chart</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="donut chart">
                            <svg width="22" height="20" viewBox="0 0 22 22">
                                <circle
                                    cx="11"
                                    cy="11"
                                    r="8"
                                    fill="none"
                                    stroke="#ddd"
                                    stroke-width="5"
                                />
                                <circle
                                    cx="11"
                                    cy="11"
                                    r="8"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="5"
                                    stroke-dasharray="18 32"
                                    stroke-dashoffset="-6"
                                />
                                <circle
                                    cx="11"
                                    cy="11"
                                    r="8"
                                    fill="none"
                                    stroke="#888"
                                    stroke-width="5"
                                    stroke-dasharray="12 38"
                                    stroke-dashoffset="-24"
                                />
                            </svg>
                            <span class="el-label">Donut</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="area chart">
                            <svg width="22" height="18" viewBox="0 0 24 18">
                                <path
                                    d="M2,15 L6,10 L10,12 L14,5 L18,8 L22,4 L22,16 L2,16Z"
                                    fill="#ddd"
                                />
                                <polyline
                                    points="2,15 6,10 10,12 14,5 18,8 22,4"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="1.8"
                                />
                            </svg>
                            <span class="el-label">Area</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="radar spider chart">
                            <svg width="22" height="20" viewBox="0 0 22 22">
                                <polygon
                                    points="11,2 19,7 19,15 11,20 3,15 3,7"
                                    fill="none"
                                    stroke="#ccc"
                                    stroke-width="1"
                                />
                                <polygon
                                    points="11,5 16,8.5 16,13.5 11,17 6,13.5 6,8.5"
                                    fill="none"
                                    stroke="#ccc"
                                    stroke-width="1"
                                />
                                <polygon
                                    points="11,6 15,9 15,13 11,16 7,13 7,9"
                                    fill="#ddd"
                                    stroke="#555"
                                    stroke-width="1.4"
                                />
                            </svg>
                            <span class="el-label">Radar</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="gauge meter chart">
                            <svg width="22" height="14" viewBox="0 0 24 14">
                                <path
                                    d="M2,13 A10,10 0 0,1 22,13"
                                    fill="none"
                                    stroke="#ddd"
                                    stroke-width="3"
                                />
                                <path
                                    d="M2,13 A10,10 0 0,1 16,4"
                                    fill="none"
                                    stroke="#555"
                                    stroke-width="3"
                                />
                                <line
                                    x1="12"
                                    y1="13"
                                    x2="16"
                                    y2="5"
                                    stroke="#e55"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Gauge</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="scatter plot chart">
                            <svg width="22" height="18" viewBox="0 0 24 18">
                                <circle cx="5" cy="13" r="2" fill="#555" />
                                <circle cx="9" cy="8" r="2" fill="#555" />
                                <circle cx="13" cy="12" r="2" fill="#555" />
                                <circle cx="17" cy="5" r="2" fill="#555" />
                                <circle cx="20" cy="9" r="2" fill="#555" />
                                <circle cx="7" cy="4" r="2" fill="#888" />
                            </svg>
                            <span class="el-label">Scatter</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- UI ELEMENTS -->
                <div class="section" data-cat="ui">
                    <div class="section-header">
                        <span class="section-title">UI elements</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-2">
                        <!-- SEARCH BAR -->
                        <div class="el-row" onclick="handleElClick(event)" data-name="search bar nav ui">
                             <div style="flex:1; height:18px; border:1.5px solid #ccc; border-radius:12px; display:flex; align-items:center; padding:0 6px; gap:4px; transform: scale(0.85); background: #fdfdfd;">
                                <i class="fa-solid fa-magnifying-glass" style="font-size:7px; color:#888;"></i>
                                <div style="width:1px; height:8px; background:#eee;"></div>
                                <div style="height:3px; width:45%; background:#f0f0f0; border-radius:1px;"></div>
                            </div>
                            <span class="el-label">Search Bar</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="progress bar">
                            <div
                                style="
                                    flex: 1;
                                    height: 7px;
                                    background: #e5e5e5;
                                    border-radius: 4px;
                                    position: relative;
                                "
                            >
                                <div
                                    style="
                                        width: 65%;
                                        height: 100%;
                                        background: #5b6cf8;
                                        border-radius: 4px;
                                    "
                                ></div>
                            </div>
                            <span class="el-label">Progress</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="toggle switch">
                            <div
                                style="
                                    width: 30px;
                                    height: 16px;
                                    background: #5b6cf8;
                                    border-radius: 8px;
                                    position: relative;
                                    flex-shrink: 0;
                                "
                            >
                                <div
                                    style="
                                        width: 12px;
                                        height: 12px;
                                        background: #fff;
                                        border-radius: 50%;
                                        position: absolute;
                                        right: 2px;
                                        top: 2px;
                                    "
                                ></div>
                            </div>
                            <span class="el-label">Toggle</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="checkbox check">
                            <div
                                style="
                                    width: 16px;
                                    height: 16px;
                                    border: 2px solid #5b6cf8;
                                    border-radius: 4px;
                                    si
                                    background: #5b6cf8;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <svg width="15" height="15" viewBox="0 0 15 15">
                                    <polyline
                                        points="3,8 6.5,11.5 13,4"
                                        fill="none"
                                        stroke="#fff"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </div>
                            <span class="el-label">Checkbox</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="radio button">
                            <div
                                style="
                                    width: 16px;
                                    height: 16px;
                                    border: 2px solid #5b6cf8;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                "
                            >
                                <div
                                    style="
                                        width: 7px;
                                        height: 7px;
                                        background: #5b6cf8;
                                        border-radius: 50%;
                                    "
                                ></div>
                            </div>
                            <span class="el-label">Radio</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="slider range input">
                            <div
                                style="
                                    flex: 1;
                                    height: 5px;
                                    background: #e5e5e5;
                                    border-radius: 3px;
                                    position: relative;
                                "
                            >
                                <div
                                    style="
                                        width: 55%;
                                        height: 100%;
                                        background: #5b6cf8;
                                        border-radius: 3px;
                                    "
                                ></div>
                                <div
                                    style="
                                        width: 14px;
                                        height: 14px;
                                        background: #5b6cf8;
                                        border-radius: 50%;
                                        position: absolute;
                                        left: calc(55% - 7px);
                                        top: -4.5px;
                                        border: 2px solid #fff;
                                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
                                    "
                                ></div>
                            </div>
                            <span class="el-label">Slider</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="button cta">
                            <div
                                style="
                                    background: #5b6cf8;
                                    color: #fff;
                                    font-size: 5px;
                                    padding: 0px 0px;
                                    border-radius: 5px;
                                    font-weight: 600;
                                    flex-shrink: 0;
                                "
                            >
                                Click me
                            </div>
                            <span class="el-label">Button</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="text input field">
                            <div
                                style="
                                    flex: 1;
                                    border: 1px solid #ccc;
                                    border-radius: 5px;
                                    padding: 4px 7px;
                                    font-size: 10px;
                                    color: #999;
                                "
                            >
                                Type here...
                            </div>
                            <span class="el-label">Input</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="dropdown select menu">
                            <div
                                style="
                                    flex: 1;
                                    border: 1px solid #ccc;
                                    border-radius: 5px;
                                    padding: 4px 7px;
                                    font-size: 10px;
                                    color: #555;
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                "
                            >
                                Select<svg
                                    width="8"
                                    height="8"
                                    viewBox="0 0 10 6"
                                >
                                    <polyline
                                        points="1,1 5,5 9,1"
                                        fill="none"
                                        stroke="#555"
                                        stroke-width="1.5"
                                    />
                                </svg>
                            </div>
                            <span class="el-label">Dropdown</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- BADGES & TAGS -->
                <div class="section" data-cat="deco">
                    <div class="section-header">
                        <span class="section-title">Badges &amp; tags</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="badges">
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #eef0ff; color: #534ab7"
                            >New</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #e1f5ee; color: #0f6e56"
                            >Sale</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #faece7; color: #993c1d"
                            >Hot 🔥</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #faeeda; color: #854f0b"
                            >Pro ⭐</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #fcebeb; color: #a32d2d"
                            >Live</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #e6f1fb; color: #185fa5"
                            >Beta</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #fbeaf0; color: #993556"
                            >Trending</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #eaf3de; color: #3b6d11"
                            >Free</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="background: #1a1a1a; color: #fff"
                            >Dark</span
                        >
                        <span
                            class="badge" onclick="handleElClick(event)"
                            style="
                                background: #fff;
                                color: #1a1a1a;
                                border: 1px solid #ccc;
                            "
                            >Light</span
                        >
                    </div>
                </div>

                <div class="divider"></div>

                <!-- DECORATIONS -->
                <div class="section" data-cat="deco">
                    <div class="section-header">
                        <span class="section-title">Decorations</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-2">
                        <div class="el-row" onclick="handleElClick(event)" data-name="search bar decoration">
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="2"
                            >
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            <span class="el-label">Search bar</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="star rating">
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                stroke="#555"
                                fill="#555"
                                stroke-width="1"
                            >
                                <polygon
                                    points="12,2 15.1,8.3 22,9.3 17,14.1 18.2,21 12,17.8 5.8,21 7,14.1 2,9.3 8.9,8.3"
                                />
                            </svg>
                            <span class="el-label">Star rating</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="social media icons">
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="2"
                                    y="2"
                                    width="20"
                                    height="20"
                                    rx="5"
                                />
                                <path
                                    d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"
                                />
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                            </svg>
                            <span class="el-label">Social icons</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="divider separator line">
                            <svg width="14" height="14" viewBox="0 0 24 14">
                                <line
                                    x1="2"
                                    y1="7"
                                    x2="22"
                                    y2="7"
                                    stroke="#555"
                                    stroke-width="1.5"
                                />
                            </svg>
                            <span class="el-label">Divider</span>
                        </div>
                        <div
                            class="el-row" onclick="handleElClick(event)"
                            data-name="quote marks text decoration"
                        >
                            <svg
                                width="16"
                                height="14"
                                viewBox="0 0 24 20"
                                fill="#555"
                            >
                                <path
                                    d="M10,2 Q10,9 4,9 Q7,9 7,14 L10,14 L10,20 L4,20 Q0,20 0,14 L0,5 Q0,2 4,2Z"
                                />
                                <path
                                    d="M24,2 Q24,9 18,9 Q21,9 21,14 L24,14 L24,20 L18,20 Q14,20 14,14 L14,5 Q14,2 18,2Z"
                                />
                            </svg>
                            <span class="el-label">Quote</span>
                        </div>
                        <div class="el-row" onclick="handleElClick(event)" data-name="music audio wave">
                            <svg
                                width="16"
                                height="14"
                                viewBox="0 0 24 14"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <line x1="2" y1="7" x2="2" y2="7" />
                                <line x1="5" y1="4" x2="5" y2="10" />
                                <line x1="8" y1="2" x2="8" y2="12" />
                                <line x1="11" y1="5" x2="11" y2="9" />
                                <line x1="14" y1="1" x2="14" y2="13" />
                                <line x1="17" y1="4" x2="17" y2="10" />
                                <line x1="20" y1="6" x2="20" y2="8" />
                            </svg>
                            <span class="el-label">Wave</span>
                        </div>
                        <div
                            class="el-row" onclick="handleElClick(event)"
                            data-name="confetti celebration decoration"
                        >
                            <svg
                                width="16"
                                height="14"
                                viewBox="0 0 24 20"
                                fill="none"
                                stroke="#555"
                                stroke-width="1.8"
                            >
                                <circle cx="5" cy="5" r="1.5" fill="#5b6cf8" />
                                <circle cx="14" cy="3" r="1.5" fill="#e55" />
                                <rect
                                    x="18"
                                    y="8"
                                    width="3"
                                    height="3"
                                    rx="1"
                                    fill="#f90"
                                    transform="rotate(30 19.5 9.5)"
                                />
                                <circle cx="8" cy="15" r="1.5" fill="#0a6640" />
                                <rect
                                    x="2"
                                    y="13"
                                    width="3"
                                    height="3"
                                    rx="1"
                                    fill="#f06"
                                    transform="rotate(20 3.5 14.5)"
                                />
                                <circle
                                    cx="20"
                                    cy="15"
                                    r="1.5"
                                    fill="#185fa5"
                                />
                            </svg>
                            <span class="el-label">Confetti</span>
                        </div>
                        <div
                            class="el-row" onclick="handleElClick(event)"
                            data-name="gradient background color"
                        >
                            <div
                                style="
                                    width: 16px;
                                    height: 14px;
                                    border-radius: 4px;
                                    background: linear-gradient(
                                        135deg,
                                        #5b6cf8,
                                        #e55ba0
                                    );
                                    flex-shrink: 0;
                                "
                            ></div>
                            <span class="el-label">Gradient</span>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- TABLES & LISTS -->
                <div class="section" data-cat="ui">
                    <div class="section-header">
                        <span class="section-title">Tables &amp; lists</span>
                        <span class="see-all">See all</span>
                    </div>
                    <div class="grid-2">
                        <div class="el" onclick="handleElClick(event)" data-name="data table">
                            <div
                                style="
                                    width: 100%;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 2px;
                                "
                            >
                                <div
                                    style="
                                        height: 7px;
                                        background: #555;
                                        border-radius: 2px;
                                    "
                                ></div>
                                <div
                                    style="
                                        height: 4px;
                                        background: #ccc;
                                        border-radius: 2px;
                                        width: 95%;
                                    "
                                ></div>
                                <div
                                    style="
                                        height: 4px;
                                        background: #ccc;
                                        border-radius: 2px;
                                        width: 90%;
                                    "
                                ></div>
                                <div
                                    style="
                                        height: 4px;
                                        background: #ccc;
                                        border-radius: 2px;
                                        width: 97%;
                                    "
                                ></div>
                            </div>
                            <span class="el-label">Table</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="bullet list">
                            <div
                                style="
                                    width: 100%;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 4px;
                                "
                            >
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            width: 5px;
                                            height: 5px;
                                            border-radius: 50%;
                                            background: #555;
                                            flex-shrink: 0;
                                        "
                                    ></div>
                                    <div
                                        style="
                                            height: 3px;
                                            background: #ccc;
                                            border-radius: 2px;
                                            flex: 1;
                                        "
                                    ></div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            width: 5px;
                                            height: 5px;
                                            border-radius: 50%;
                                            background: #555;
                                            flex-shrink: 0;
                                        "
                                    ></div>
                                    <div
                                        style="
                                            height: 3px;
                                            background: #ccc;
                                            border-radius: 2px;
                                            flex: 1;
                                        "
                                    ></div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            width: 5px;
                                            height: 5px;
                                            border-radius: 50%;
                                            background: #555;
                                            flex-shrink: 0;
                                        "
                                    ></div>
                                    <div
                                        style="
                                            height: 3px;
                                            background: #ccc;
                                            border-radius: 2px;
                                            flex: 1;
                                        "
                                    ></div>
                                </div>
                            </div>
                            <span class="el-label">List</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="numbered list steps">
                            <div
                                style="
                                    width: 100%;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 4px;
                                "
                            >
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 50%;
                                            background: #5b6cf8;
                                            flex-shrink: 0;
                                            font-size: 7px;
                                            color: #fff;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-weight: 700;
                                        "
                                    >
                                        1
                                    </div>
                                    <div
                                        style="
                                            height: 3px;
                                            background: #ccc;
                                            border-radius: 2px;
                                            flex: 1;
                                        "
                                    ></div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 50%;
                                            background: #5b6cf8;
                                            flex-shrink: 0;
                                            font-size: 7px;
                                            color: #fff;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-weight: 700;
                                        "
                                    >
                                        2
                                    </div>
                                    <div
                                        style="
                                            height: 3px;
                                            background: #ccc;
                                            border-radius: 2px;
                                            flex: 1;
                                        "
                                    ></div>
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 50%;
                                            background: #5b6cf8;
                                            flex-shrink: 0;
                                            font-size: 7px;
                                            color: #fff;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-weight: 700;
                                        "
                                    >
                                        3
                                    </div>
                                    <div
                                        style="
                                            height: 3px;
                                            background: #ccc;
                                            border-radius: 2px;
                                            flex: 1;
                                        "
                                    ></div>
                                </div>
                            </div>
                            <span class="el-label">Numbered</span>
                        </div>
                        <div class="el" onclick="handleElClick(event)" data-name="timeline steps">
                            <div
                                style="
                                    position: relative;
                                    padding-left: 10px;
                                    width: 100%;
                                "
                            >
                                <div
                                    style="
                                        position: absolute;
                                        left: 4px;
                                        top: 0;
                                        bottom: 0;
                                        width: 1.5px;
                                        background: #ccc;
                                    "
                                ></div>
                                <div
                                    style="
                                        display: flex;
                                        flex-direction: column;
                                        gap: 5px;
                                    "
                                >
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 5px;
                                            position: relative;
                                        "
                                    >
                                        <div
                                            style="
                                                width: 7px;
                                                height: 7px;
                                                border-radius: 50%;
                                                background: #5b6cf8;
                                                position: absolute;
                                                left: -9px;
                                            "
                                        ></div>
                                        <div
                                            style="
                                                height: 3px;
                                                background: #ccc;
                                                border-radius: 2px;
                                                flex: 1;
                                            "
                                        ></div>
                                    </div>
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 5px;
                                            position: relative;
                                        "
                                    >
                                        <div
                                            style="
                                                width: 7px;
                                                height: 7px;
                                                border-radius: 50%;
                                                background: #5b6cf8;
                                                position: absolute;
                                                left: -9px;
                                            "
                                        ></div>
                                        <div
                                            style="
                                                height: 3px;
                                                background: #ccc;
                                                border-radius: 2px;
                                                flex: 1;
                                            "
                                        ></div>
                                    </div>
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 5px;
                                            position: relative;
                                        "
                                    >
                                        <div
                                            style="
                                                width: 7px;
                                                height: 7px;
                                                border-radius: 50%;
                                                background: #5b6cf8;
                                                position: absolute;
                                                left: -9px;
                                            "
                                        ></div>
                                        <div
                                            style="
                                                height: 3px;
                                                background: #ccc;
                                                border-radius: 2px;
                                                flex: 1;
                                            "
                                        ></div>
                                    </div>
                                </div>
                            </div>
                            <span class="el-label">Timeline</span>
                        </div>
                    </div>
                </div>

                <div style="height: 12px"></div>
            </div>
            <!-- /panel-body -->
</div> <!-- CLOSE ELEMENTS TAB -->
            
            <!-- TEXT TAB -->
            <div id="tab-text" class="panel-content">
                <div class="tb-section">
                    <div class="search-bar"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search fonts and combinations"></div>
                    <button class="generate-btn" style="width:100%;margin-bottom:24px;padding:12px;font-size:15px;border-radius:8px;">Add a text box</button>
                    
                    <h4>Default text styles</h4>
                    <button class="tb-btn" style="padding: 20px 16px; justify-content:flex-start; font-size: 24px; font-weight: 800; color:#111; font-family:'Outfit',sans-serif;" onclick="addText('heading')">Add a heading</button>
                    <button class="tb-btn" style="padding: 16px 16px; justify-content:flex-start; font-size: 18px; font-weight: 600; color:#111; font-family:'Outfit',sans-serif;" onclick="addText('sub')">Add a subheading</button>
                    <button class="tb-btn" style="padding: 12px 16px; justify-content:flex-start; font-size: 13px; font-weight: 400; color:#333; font-family:'Outfit',sans-serif;" onclick="addText('body')">Add a little bit of body text</button>
                    
                    <h4 style="margin-top: 24px;">Recently used</h4>
                    <div class="template-grid" style="grid-template-columns: 1fr 1fr; gap: 8px;">
                        <div class="tpl-card" onclick="addText('family_time')" style="aspect-ratio: 1; display:flex; align-items:center; justify-content:center; background:#f5f6f8; border:none;">
                            <span style="font-family: 'Playfair Display', serif; font-size: 18px; color: #cfaf72;">Family Time</span>
                        </div>
                        <div class="tpl-card" onclick="addText('featured')" style="aspect-ratio: 1; display:flex; align-items:center; justify-content:center; background:#f5f6f8; border:none;">
                            <span style="font-family: 'Pacifico', cursive; font-size: 24px; color: #9c27b0; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">Featured</span>
                        </div>
                    </div>

                    <h4 style="margin-top: 4px;">Font combinations</h4>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:8px;">

                        <!-- Happy Birthday -->
                        <div onclick="addText('happy_birthday')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f5f6f8;border-radius:8px;cursor:pointer;overflow:hidden;padding:8px;">
                            <span style="font-family:'Pacifico',cursive;font-size:14px;color:#e91e63;transform:rotate(-5deg);display:block;">Happy</span>
                            <span style="font-family:'Anton',sans-serif;font-size:18px;color:#111;line-height:1;">BIRTHDAY</span>
                        </div>

                        <!-- Like & Subscribe -->
                        <div onclick="addText('like_subscribe')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#111;border-radius:8px;cursor:pointer;padding:8px;">
                            <span style="font-family:'Sigmar One',cursive;font-size:11px;color:#fff;text-shadow:-1px -1px 0 #f4b400,1px 1px 0 #f4b400;">LIKE &amp;</span>
                            <span style="font-family:'Sigmar One',cursive;font-size:11px;color:#fff;text-shadow:-1px -1px 0 #e53935,1px 1px 0 #e53935;">SUBSCRIBE</span>
                        </div>

                        <!-- Thank You -->
                        <div onclick="addText('thank_you_retro')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#fff3e0;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Lobster',cursive;font-size:22px;color:#ff8a65;">Thank you!</span>
                        </div>

                        <!-- Golden Hour -->
                        <div onclick="addText('golden_hour')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#1a1105;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Cinzel',serif;font-size:14px;font-weight:700;color:#d4af37;letter-spacing:3px;">GOLDEN</span>
                            <span style="font-family:'Cinzel',serif;font-size:14px;font-weight:700;color:#d4af37;letter-spacing:3px;">HOUR</span>
                        </div>

                        <!-- Fire Away -->
                        <div onclick="addText('fire_away')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#1a0a00;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Bebas Neue',sans-serif;font-size:22px;color:#ff6a00;letter-spacing:2px;">FIRE</span>
                            <span style="font-family:'Dancing Script',cursive;font-size:18px;color:#ff9800;">away</span>
                        </div>

                        <!-- A Day in My Life -->
                        <div onclick="addText('day_in_life')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f3e8ff;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Raleway',sans-serif;font-size:12px;font-weight:300;color:#7c3aed;letter-spacing:2px;">A day in</span>
                            <span style="font-family:'Dancing Script',cursive;font-size:22px;color:#9c27b0;">my life</span>
                        </div>

                        <!-- Order Now -->
                        <div onclick="addText('order_now')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#e8f5e9;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Fredoka One',cursive;font-size:18px;color:#2e7d32;letter-spacing:1px;">Order Now!</span>
                        </div>

                        <!-- Coffee Break -->
                        <div onclick="addText('coffee_break')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#efebe9;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Abril Fatface',cursive;font-size:16px;color:#4e342e;letter-spacing:1px;">Coffee Break</span>
                        </div>

                        <!-- Glow -->
                        <div onclick="addText('glow')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#0d0d0d;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Monoton',cursive;font-size:20px;color:#ff00ff;text-shadow:0 0 10px #ff00ff,0 0 20px #ff00ff;">GLOW</span>
                        </div>

                        <!-- Play -->
                        <div onclick="addText('play_retro')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#1a1a2e,#16213e);border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Bangers',cursive;font-size:32px;letter-spacing:4px;background:linear-gradient(90deg,#f953c6,#b91d73);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">PLAY</span>
                        </div>

                        <!-- Now Open -->
                        <div onclick="addText('now_open')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#4361ee,#7209b7);border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Pacifico',cursive;font-size:16px;color:#fff;text-shadow:0 0 12px rgba(255,255,255,0.5);">Now Open!</span>
                        </div>

                        <!-- Coming Soon -->
                        <div onclick="addText('coming_soon')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#fff;border-radius:8px;cursor:pointer;border:1px solid #eee;">
                            <span style="font-family:'Bebas Neue',sans-serif;font-size:24px;color:#c0392b;letter-spacing:3px;">COMING</span>
                            <span style="font-family:'Bebas Neue',sans-serif;font-size:24px;color:#c0392b;letter-spacing:3px;">SOON</span>
                        </div>

                        <!-- Title / Heading -->
                        <div onclick="addText('title_bold')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#fff;border-radius:8px;cursor:pointer;border:1px solid #eee;">
                            <span style="font-family:'Raleway',sans-serif;font-size:22px;font-weight:900;color:#111;">Title</span>
                            <span style="font-family:'Raleway',sans-serif;font-size:11px;font-weight:300;color:#555;letter-spacing:3px;">HEADING</span>
                        </div>

                        <!-- Shop Now -->
                        <div onclick="addText('shop_now')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#fff8e1;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Righteous',cursive;font-size:16px;color:#e65100;letter-spacing:1px;">SHOP NOW!</span>
                        </div>

                        <!-- Bride & Groom -->
                        <div onclick="addText('bride_groom')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#fce4ec;border-radius:8px;cursor:pointer;">
                            <div style="text-align:center;">
                                <span style="font-family:'Satisfy',cursive;font-size:13px;color:#880e4f;display:block;line-height:1.2;">Bride &amp;</span>
                                <span style="font-family:'Satisfy',cursive;font-size:13px;color:#880e4f;display:block;">Groom</span>
                            </div>
                        </div>

                        <!-- Engaged -->
                        <div onclick="addText('engaged')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#fff;border-radius:8px;cursor:pointer;border:1px solid #eee;">
                            <span style="font-family:'Dancing Script',cursive;font-size:18px;color:#333;">engaged!</span>
                        </div>

                        <!-- Player One -->
                        <div onclick="addText('player_one')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#0d0d0d;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Russo One',sans-serif;font-size:12px;color:#ff6b6b;letter-spacing:1px;">player</span>
                            <span style="font-family:'Russo One',sans-serif;font-size:18px;color:#ffd93d;letter-spacing:2px;">ONE</span>
                        </div>

                        <!-- Cute as a Button -->
                        <div onclick="addText('cute_button')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#fce4ff;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Fredoka One',cursive;font-size:13px;color:#ce93d8;">CUTE as a</span>
                            <span style="font-family:'Fredoka One',cursive;font-size:13px;color:#ab47bc;">BUTTON</span>
                        </div>

                        <!-- Family Time -->
                        <div onclick="addText('family_time')" style="aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:#f5f6f8;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Playfair Display',serif;font-size:16px;color:#cfaf72;">Family Time</span>
                        </div>

                        <!-- Creating Magic -->
                        <div onclick="addText('creating_magic')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f3e5f5;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Dancing Script',cursive;font-size:14px;color:#9c27b0;">creating</span>
                            <span style="font-family:'Bangers',cursive;font-size:22px;letter-spacing:2px;color:#7b1fa2;">MAGIC</span>
                        </div>

                        <!-- 30% Off -->
                        <div onclick="addText('discount_30')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#fff;border-radius:8px;cursor:pointer;border:1px solid #eee;">
                            <span style="font-family:'Bebas Neue',sans-serif;font-size:28px;color:#888;line-height:1;">30%</span>
                            <span style="font-family:'Bebas Neue',sans-serif;font-size:16px;color:#2e7d32;letter-spacing:2px;">OFF</span>
                        </div>

                        <!-- Custom Paint -->
                        <div onclick="addText('custom_paint')" style="aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f5f6f8;border-radius:8px;cursor:pointer;">
                            <span style="font-family:'Josefin Sans',sans-serif;font-size:11px;font-weight:100;color:#555;letter-spacing:4px;">CUSTOM</span>
                            <span style="font-family:'Bangers',cursive;font-size:24px;color:#ff6f00;letter-spacing:3px;">PAINT</span>
                        </div>

                    </div>
                </div>
                <div class="tb-section" id="textPropsPanel" style="display:none; background:#f9f9f9; border: 1px solid #e1e3e5; margin: 0 16px 16px 16px; border-radius: 8px;">
                    <h4>Text Properties</h4>
                    <div class="props-row"><label>Font</label>
                        <select class="props-input" id="propFont" onchange="setTP('fontFamily',this.value)">
                            <optgroup label="Sans-serif">
                                <option value="'Outfit', sans-serif">Outfit</option>
                                <option value="'Raleway', sans-serif">Raleway</option>
                                <option value="'Josefin Sans', sans-serif">Josefin Sans</option>
                                <option value="'Nunito', sans-serif">Nunito</option>
                                <option value="'Space Grotesk', sans-serif">Space Grotesk</option>
                                <option value="'Russo One', sans-serif">Russo One</option>
                                <option value="'Anton', sans-serif">Anton</option>
                                <option value="'Bebas Neue', sans-serif">Bebas Neue</option>
                                <option value="'Bangers', cursive">Bangers</option>
                                <option value="'Boogaloo', cursive">Boogaloo</option>
                                <option value="'Righteous', cursive">Righteous</option>
                                <option value="'Fredoka One', cursive">Fredoka One</option>
                            </optgroup>
                            <optgroup label="Serif">
                                <option value="'Playfair Display', serif">Playfair Display</option>
                                <option value="'Merriweather', serif">Merriweather</option>
                                <option value="'Cinzel', serif">Cinzel</option>
                                <option value="'Abril Fatface', cursive">Abril Fatface</option>
                                <option value="'Poiret One', cursive">Poiret One</option>
                                <option value="'Georgia', serif">Georgia</option>
                            </optgroup>
                            <optgroup label="Handwriting / Script">
                                <option value="'Pacifico', cursive">Pacifico</option>
                                <option value="'Dancing Script', cursive">Dancing Script</option>
                                <option value="'Lobster', cursive">Lobster</option>
                                <option value="'Satisfy', cursive">Satisfy</option>
                                <option value="'Permanent Marker', cursive">Permanent Marker</option>
                                <option value="'Sigmar One', cursive">Sigmar One</option>
                            </optgroup>
                            <optgroup label="Display / Decorative">
                                <option value="'Monoton', cursive">Monoton</option>
                                <option value="'Arial Black', sans-serif">Arial Black</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="props-row"><label>Size</label><input type="range" class="props-input" id="propSize" min="14" max="160" value="48" oninput="setTP('fontSize',this.value+'px')" style="padding:2px;"></div>
                    <div class="props-row"><label>Color</label><input type="color" class="props-input" id="propColor" value="#ffffff" onchange="setTP('color',this.value)" style="padding:2px;height:28px;"></div>
                    <div class="props-row"><label>Bold</label>
                        <select class="props-input" id="propWeight" onchange="setTP('fontWeight',this.value)">
                            <option value="300">Light</option><option value="400">Regular</option>
                            <option value="700" selected>Bold</option><option value="900">Black</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- UPLOADS TAB -->
            <div id="tab-uploads" class="panel-content">    
                <div class="tb-section" style="padding-bottom: 0; border-bottom: none;">
                    <div class="search-bar"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search backgrounds"></div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 20px; border-bottom: 1px solid #f0f2f5; padding-bottom: 16px;">
                        <div class="swatch" style="border: 2px dashed #ccc; display:flex; align-items:center; justify-content:center; background:#f9f9f9; color:#888; width: 32px; height: 32px;"><i class="fa-solid fa-droplet"></i></div>
                        <div class="swatch" onclick="setBg('ocean')" style="background:#00a388; width: 32px; height: 32px; border-radius:50%;"></div>
                        <div class="swatch" onclick="setBg('dark')" style="background:#111; width: 32px; height: 32px; border-radius:50%;"></div>
                        <div class="swatch" onclick="setBg('emerald')" style="background:#ff3b30; width: 32px; height: 32px; border-radius:50%;"></div>
                        <div class="swatch" onclick="setBg('warm')" style="background:#ff2d55; width: 32px; height: 32px; border-radius:50%;"></div>
                        <div class="swatch" style="background:#f0f2f5; width: 32px; height: 32px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#555;"><i class="fa-solid fa-chevron-right" style="font-size:12px;"></i></div>
                    </div>
                </div>

                <div class="tb-section">
                    <h4>Upload Image</h4>
                    <p style="font-size:11px; color:#888; margin-bottom:12px;">Upload a custom image.</p>
                    <button class="tb-btn" style="justify-content:center;" onclick="document.getElementById('bgUpload').click()">
                        <i class="fa-solid fa-image"></i> Upload Background Image
                    </button>
                    <input type="file" id="bgUpload" class="hidden" accept="image/*" />
                    
                    <h4 style="margin-top: 24px;">All results</h4>
                    <div class="swatch-grid">
                        <div class="swatch" onclick="setBg('warm')" style="background:linear-gradient(160deg,#e8d5c4,#b8956a);"></div>
                        <div class="swatch" onclick="setBg('dark')" style="background:linear-gradient(160deg,#2c2c2e,#111);"></div>
                        <div class="swatch" onclick="setBg('cream')" style="background:linear-gradient(160deg,#fdf6ee,#e8d5c4);"></div>
                        <div class="swatch" onclick="setBg('terracotta')" style="background:linear-gradient(160deg,#D1A392,#7E635A);"></div>
                        <div class="swatch" onclick="setBg('ocean')" style="background:linear-gradient(160deg,#667eea,#764ba2);"></div>
                        <div class="swatch" onclick="setBg('emerald')" style="background:linear-gradient(160deg,#11998e,#38ef7d);"></div>
                        <div class="swatch" onclick="setBg('midnight')" style="background:linear-gradient(160deg,#0f0c29,#302b63 50%,#24243e);"></div>
                        <div class="swatch" onclick="setBg('blush')" style="background:linear-gradient(160deg,#ffecd2,#fcb69f);"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CANVAS CONTAINER --}}
        <div class="studio-canvas-container">
            <div class="top-bar">
                <div style="font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #555;">
                    <i class="fa-solid fa-paintbrush" style="color: #8b3dff;"></i> Mockup Pro Canvas
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="generate-btn" style="width: auto; margin: 0; padding: 10px 20px; font-size: 13px;" onclick="exportDesign()">
                        <i class="fa-solid fa-download"></i> Share & Export
                    </button>
                </div>
            </div>
            
            <div class="context-toolbar" id="contextToolbar">
                <button class="ct-btn" id="ctInteract" style="color:#22c55e;" onclick="toggleSelectedInteract()">
                    <i class="fa-solid fa-bolt"></i> Interact
                </button>
                <div class="ct-divider"></div>
                <input type="color" class="ct-color-picker" id="ctColor" value="#ffffff">
                <div class="ct-divider"></div>
                <button class="ct-btn" title="Border" onclick="promptLine()"><i class="fa-solid fa-bars"></i></button>
                <button class="ct-btn" title="Corner Radius" onclick="promptRadius()"><i class="fa-solid fa-bezier-curve"></i></button>
                <div class="ct-divider"></div>
                <button class="ct-btn" title="Flip" onclick="flipSelected()"><i class="fa-solid fa-object-ungroup"></i> Flip</button>
                <button class="ct-btn" title="Bring to Front" onclick="bringToFront()"><i class="fa-solid fa-layer-group"></i> Position</button>
                <div class="ct-divider"></div>
                <button class="ct-btn" title="Duplicate" onclick="duplicateSelected()"><i class="fa-regular fa-copy"></i></button>
                <button class="ct-btn" title="Delete" onclick="deleteSelected()" style="color: #e55;"><i class="fa-solid fa-trash"></i></button>
            </div>
            
            <div class="studio-canvas-area" id="canvasArea">
                <div class="artboard" id="artboard">
                    <div class="artboard-inner" id="artboardInner">
                        <div class="bg-image-layer" id="bgImageLayer"></div>
                        <div class="bg-overlay-layer" id="bgOverlayLayer" style="background: linear-gradient(160deg, rgba(232,213,196,0.9) 0%, rgba(160,128,104,0.95) 100%);"></div>
                        <div class="empty-state" id="emptyHint">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            <p>Click "Upload & Auto-Generate" to start</p>
                        </div>
                        <div id="guide-v" style="position:absolute; top:0; bottom:0; left:50%; width:1px; background:#8b3dff; z-index:999999; pointer-events:none; display:none;"></div>
                        <div id="guide-h" style="position:absolute; left:0; right:0; top:50%; height:1px; background:#8b3dff; z-index:999999; pointer-events:none; display:none;"></div>
                    </div>
                </div>
            </div>

            <!-- CANVAS FOOTER -->
            <div class="studio-footer">
                <div class="footer-left">
                    <div class="footer-btn" onclick="toggleNotes()"><i class="fa-solid fa-note-sticky"></i> Notes</div>
                </div>
                <div class="footer-center">
                    <div class="footer-btn" onclick="prevPage()"><i class="fa-solid fa-chevron-left"></i></div>
                    <div class="page-badge" id="pageLabel">1 / 1</div>
                    <div class="footer-btn" onclick="nextPage()"><i class="fa-solid fa-chevron-right"></i></div>
                    <div class="footer-btn" title="Add Page" onclick="addPage()"><i class="fa-solid fa-plus"></i></div>
                </div>
                <div class="footer-right">
                    <div class="zoom-wrap">
                        <span id="zoomVal">50%</span>
                        <input type="range" class="zoom-slider" id="zoomSlider" min="10" max="200" value="50" oninput="setManualZoom(this.value)">
                    </div>
                    <div class="footer-btn" title="Grid View"><i class="fa-solid fa-table-cells-large"></i></div>
                    <div class="footer-btn" title="Presenter View"><i class="fa-solid fa-maximize"></i></div>
                    <div class="footer-btn" title="Help"><i class="fa-regular fa-circle-question"></i></div>
                </div>
            </div>
        </div>
    </div>

    <input type="file" id="deviceChangeInput" class="hidden" accept="image/*" />

    @push('scripts')
    <script>
    (function() {
        const artboard = document.getElementById('artboard');
        const inner = document.getElementById('artboardInner');
        const bgImageLayer = document.getElementById('bgImageLayer');
        const bgOverlayLayer = document.getElementById('bgOverlayLayer');
        const emptyHint = document.getElementById('emptyHint');
        const deviceChangeInput = document.getElementById('deviceChangeInput');

        let elements = [];
        let selectedEl = null;
        let artW = 1080, artH = 1920; // Story default
        let scale = 0.5;
        let devicePendingChange = null;
        let zoom = 50;
        let isFitMode = true;

        let isPanning = false;
        let startX, startY, scrollL, scrollT;

        const canvasArea = document.getElementById('canvasArea');
        canvasArea.addEventListener('mousedown', function(e) {
            // Only pan if clicking the dotted background area itself
            if (e.target !== canvasArea && e.target.id !== 'canvasArea') return;
            isPanning = true;
            startX = e.pageX - canvasArea.offsetLeft;
            startY = e.pageY - canvasArea.offsetTop;
            scrollL = canvasArea.scrollLeft;
            scrollT = canvasArea.scrollTop;
        });
        window.addEventListener('mouseup', () => { isPanning = false; });
        window.addEventListener('mouseleave', () => { isPanning = false; });
        canvasArea.addEventListener('mousemove', function(e) {
            if (!isPanning) return;
            e.preventDefault();
            const x = e.pageX - canvasArea.offsetLeft;
            const y = e.pageY - canvasArea.offsetTop;
            const walkX = (x - startX) * 1.5;
            const walkY = (y - startY) * 1.5;
            canvasArea.scrollLeft = scrollL - walkX;
            canvasArea.scrollTop = scrollT - walkY;
        });

        window.addPage = function() {
            // Save current page state
            savePageState(currentPageIdx);
            
            // Increment UI and pages data
            pagesData.push({
                elements: [],
                bg: 'linear-gradient(160deg, rgba(232,213,196,0.9) 0%, rgba(160,128,104,0.95) 100%)',
                bgImg: '',
                format: { w: 1080, h: 1920 }
            });
            
            currentPageIdx = pagesData.length - 1;
            loadPageState(currentPageIdx);
            updatePageUI();
            
            Swal.fire({ title:'Page Added!', text:'Created page ' + (currentPageIdx + 1), icon:'success', timer: 1000, showConfirmButton: false });
        };

        window.prevPage = function() {
            if (currentPageIdx > 0) {
                savePageState(currentPageIdx);
                currentPageIdx--;
                loadPageState(currentPageIdx);
                updatePageUI();
            }
        };

        window.nextPage = function() {
            if (currentPageIdx < pagesData.length - 1) {
                savePageState(currentPageIdx);
                currentPageIdx++;
                loadPageState(currentPageIdx);
                updatePageUI();
            }
        };

        function updatePageUI() {
            document.getElementById('pageLabel').innerText = (currentPageIdx + 1) + ' / ' + pagesData.length;
        }

        let pagesData = [{
            elements: [],
            bg: 'linear-gradient(160deg, rgba(232,213,196,0.9) 0%, rgba(160,128,104,0.95) 100%)',
            bgImg: '',
            format: { w: 1080, h: 1920 }
        }];
        let currentPageIdx = 0;

        function savePageState(idx) {
            pagesData[idx] = {
                elements: elements.map(el => {
                    // Extract content (everything except handles/badges)
                    const content = Array.from(el.children).find(c => {
                        const cls = (typeof c.className === 'string' ? c.className : (c.className.baseVal || ''));
                        return !cls.includes('resize-handle') && 
                               !cls.includes('delete-handle') &&
                               !cls.includes('interact-badge') &&
                               !cls.includes('screen-overlay');
                    });
                    return {
                        html: content ? content.outerHTML : '',
                        type: el.dataset.elType,
                        style: el.getAttribute('style')
                    };
                }),
                bg: bgOverlayLayer.style.background,
                bgImg: bgImageLayer.style.backgroundImage,
                format: { w: artW, h: artH }
            };
        }

        function loadPageState(idx) {
            const data = pagesData[idx];
            
            // Clean artboard
            elements.forEach(el => el.remove());
            elements = [];
            selectedEl = null;
            hideTP();
            hideContextToolbar();
            
            // Restore Settings
            artW = data.format.w; artH = data.format.h;
            doResize();
            
            bgOverlayLayer.style.background = data.bg;
            bgImageLayer.style.backgroundImage = data.bgImg;
            
            emptyHint.style.display = data.elements.length === 0 ? 'flex' : 'none';

            // Re-create elements
            data.elements.forEach(item => {
                const el = makeDrag(0, 0, 0, 0, item.type);
                el.style.cssText = item.style;
                // Replace everything in el with handles + the stored content
                const oldContent = el.querySelector(`.drag-el > *:not(.resize-handle):not(.delete-handle)`);
                if(oldContent) oldContent.remove();
                
                const temp = document.createElement('div');
                temp.innerHTML = item.html;
                if(temp.firstElementChild) el.appendChild(temp.firstElementChild);
            });
        }

        const formats = {
            story:  { w: 1080, h: 1920 },
            insta:  { w: 1080, h: 1350 },
            square: { w: 1080, h: 1080 },
            wide:   { w: 1920, h: 1080 }
        };

        const bgGradients = {
            warm:       'linear-gradient(160deg, rgba(232,213,196,0.9), rgba(160,128,104,0.95))',
            dark:       'linear-gradient(160deg, rgba(30,30,30,0.92), rgba(10,10,10,0.95))',
            cream:      'linear-gradient(160deg, rgba(253,246,238,0.9), rgba(232,213,196,0.95))',
            terracotta: 'linear-gradient(160deg, rgba(209,163,146,0.9), rgba(126,99,90,0.95))',
            ocean:      'linear-gradient(160deg, rgba(102,126,234,0.9), rgba(118,75,162,0.95))',
            emerald:    'linear-gradient(160deg, rgba(17,153,142,0.9), rgba(56,239,125,0.95))',
            midnight:   'linear-gradient(160deg, rgba(15,12,41,0.92), rgba(48,43,99,0.95))',
            blush:      'linear-gradient(160deg, rgba(255,236,210,0.9), rgba(252,182,159,0.95))'
        };

        // ===== FORMAT =====
        window.setFormat = function(f) {
            artW = formats[f].w; artH = formats[f].h;
            doResize();
            document.querySelectorAll('.format-pill').forEach(b => b.classList.remove('active'));
            let pill = document.querySelector(`.format-pill[data-format="${f}"]`);
            if (pill) pill.classList.add('active');
        };

        function doResize() {
            if (!isFitMode) return;
            const area = document.getElementById('canvasArea');
            const maxW = area.clientWidth - 80;
            const maxH = area.clientHeight - 80;
            scale = Math.min(maxW / artW, maxH / artH, 1);
            applyScale();
            
            // Sync slider (visually)
            const pct = Math.round(scale * 100);
            const slider = document.getElementById('zoomSlider');
            if (slider) { slider.value = pct; }
            const zv = document.getElementById('zoomVal');
            if (zv) { zv.innerText = pct + '%'; }
        }

        window.setManualZoom = function(val) {
            isFitMode = val === 'fit'; 
            if (val === 'fit') { 
                doResize(); 
                return; 
            }
            zoom = parseInt(val);
            scale = zoom / 100;
            applyScale();
            document.getElementById('zoomVal').innerText = val + '%';
        };

        function applyScale() {
            artboard.style.width = (artW * scale) + 'px';
            artboard.style.height = (artH * scale) + 'px';
            inner.style.width = artW + 'px';
            inner.style.height = artH + 'px';
            inner.style.transform = `scale(${scale})`;
            inner.style.transformOrigin = 'top left';
        }

        // ===== BACKGROUND =====
        window.setBg = function(name) {
            bgOverlayLayer.style.background = bgGradients[name];
            document.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
            if (event && event.currentTarget) event.currentTarget.classList.add('active');
        };

        document.getElementById('bgUpload').addEventListener('change', function(e) {
            const file = e.target.files[0]; if (!file) return;
            const r = new FileReader();
            r.onload = ev => {
                bgImageLayer.style.backgroundImage = `url('${ev.target.result}')`;
                bgImageLayer.style.backgroundSize = 'cover';
                bgImageLayer.style.backgroundPosition = 'center top';
                document.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
            };
            r.readAsDataURL(file); this.value = '';
        });

        // ===== MAIN: UPLOAD & AUTO-GENERATE =====
        let pendingImgSrc = null;
        let selectedTemplate = 'website_launch';

        document.getElementById('mainUpload').addEventListener('change', function(e) {
            const file = e.target.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                pendingImgSrc = ev.target.result;
                applyTemplate(selectedTemplate, pendingImgSrc);
            };
            reader.readAsDataURL(file);
            this.value = '';
        });

        window.pickTemplate = function(name) {
            selectedTemplate = name;
            // Highlight selected template
            document.querySelectorAll('.tpl-card').forEach(c => c.classList.remove('selected'));
            const target = (window.event && window.event.currentTarget) ? window.event.currentTarget : [...document.querySelectorAll('.tpl-card')].find(c => c.onclick && c.onclick.toString().includes(name));
            if (target) target.classList.add('selected');

            if (pendingImgSrc) {
                applyTemplate(name, pendingImgSrc);
            } else {
                pendingImgSrc = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop';
                applyTemplate(name, pendingImgSrc);
            }
        };

        function setBlurBg(imgSrc, overlay) {
            bgImageLayer.style.backgroundImage = `url('${imgSrc}')`;
            bgImageLayer.style.backgroundSize = 'cover';
            bgImageLayer.style.backgroundPosition = 'center top';
            bgImageLayer.style.filter = 'blur(8px) brightness(0.7)';
            bgImageLayer.style.transform = 'scale(1.1)';
            bgOverlayLayer.style.background = overlay;
        }

        function setGradientBg(gradient) {
            bgImageLayer.style.backgroundImage = '';
            bgImageLayer.style.filter = '';
            bgImageLayer.style.transform = '';
            bgOverlayLayer.style.background = gradient;
        }

        function applyTemplate(name, imgSrc) {
            clearAllSilent();
            emptyHint.style.display = 'none';

            if (name === 'website_launch') tplWebsiteLaunch(imgSrc);
            else if (name === 'dark_premium') tplDarkPremium(imgSrc);
            else if (name === 'minimal_phone') tplMinimalPhone(imgSrc);
            else if (name === 'side_by_side') tplSideBySide(imgSrc);
            else if (name === 'elegant_portfolio') tplElegantSingle(imgSrc);
            else if (name === 'app_promo') tplAppPromo(imgSrc);
            else if (name === 'cascade_stack') tplCascadeStack(imgSrc);
            else if (name === 'floating_devices') tplFloatingDevices(imgSrc);
            else if (name === 'cinema_wide') tplCinemaWide(imgSrc);
            else if (name === 'neon_glow') tplNeonGlow(imgSrc);
            else if (name === 'editorial_grid') tplEditorialGrid(imgSrc);
            else if (name === 'earth_tone_focus') tplEarthToneFocus(imgSrc);
            else if (name === 'dynamic_burst') tplDynamicBurst(imgSrc);
            else if (name === 'soft_canvas') tplSoftCanvas(imgSrc);
        }

        // ===== TEMPLATE 1: WEBSITE LAUNCH =====
        function tplWebsiteLaunch(img) {
            setFormat('story');
            setBlurBg(img, 'linear-gradient(180deg, rgba(200,170,140,0.55) 0%, rgba(180,150,120,0.7) 40%, rgba(140,110,85,0.85) 100%)');
            placeDeviceAt('imac', img, 90, 520, 900, 720);
            placeDeviceAt('macbook', img, -30, 1200, 520, 350);
            placeDeviceAt('ipad', img, 560, 1100, 420, 560);
            placeDeviceAt('iphone', img, 20, 980, 200, 400);
            makeText("We're live now!", 0, 80, 1080, { fontSize:'52px', fontWeight:'600', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', textShadow:'0 3px 15px rgba(0,0,0,0.3)' });
            makeText("NEW WEBSITE", 0, 150, 1080, { fontSize:'120px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', textShadow:'0 4px 25px rgba(0,0,0,0.25)', letterSpacing:'6px', lineHeight:'1.0' });
            makeText("Explore hand-painted artistry", 0, 420, 1080, { fontSize:'40px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#ffffffdd', textAlign:'center', textShadow:'0 2px 10px rgba(0,0,0,0.2)' });
            makeText("Behind the Art of\nVastraकला", 0, 1700, 1080, { fontSize:'68px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center', textShadow:'0 3px 20px rgba(0,0,0,0.3)', lineHeight:'1.15' });
            makeSearchBar(240, 330, 600, 65);
        }

        // ===== TEMPLATE 2: DARK PREMIUM =====
        function tplDarkPremium(img) {
            setFormat('story');
            setGradientBg('linear-gradient(180deg, #1a1a1e 0%, #0d0d0f 100%)');
            placeDeviceAt('imac', img, 90, 440, 900, 720);
            placeDeviceAt('macbook', img, -20, 1100, 500, 340);
            placeDeviceAt('ipad', img, 580, 1020, 400, 540);
            placeDeviceAt('iphone', img, 40, 900, 190, 380);
            makeText("ARTFUL\nMASTERPIECES", 0, 60, 1080, { fontSize:'100px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', textShadow:'0 0 40px rgba(209,163,146,0.3)', letterSpacing:'5px', lineHeight:'1.05' });
            makeText("Hand-painted with precision", 0, 320, 1080, { fontSize:'32px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#D1A392', textAlign:'center', letterSpacing:'3px', textTransform:'uppercase' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1780, 1080, { fontSize:'28px', fontWeight:'400', fontFamily:"'Outfit',sans-serif", color:'#666', textAlign:'center', letterSpacing:'2px' });
            makeText("Vastraकला", 0, 1840, 1080, { fontSize:'52px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#D1A392', textAlign:'center' });
        }

        // ===== TEMPLATE 3: PHONE FOCUS =====
        function tplMinimalPhone(img) {
            setFormat('insta');
            setGradientBg('linear-gradient(160deg, #fdf6ee 0%, #e8d5c4 100%)');
            placeDeviceAt('iphone', img, 340, 300, 400, 800);
            makeText("Vastraकला", 0, 60, 1080, { fontSize:'72px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#4A3F35', textAlign:'center' });
            makeText("Now on Mobile", 0, 160, 1080, { fontSize:'36px', fontWeight:'700', fontFamily:"'Outfit',sans-serif", color:'#7E635A', textAlign:'center', letterSpacing:'4px', textTransform:'uppercase' });
            makeText("Shop unique hand-painted\nkurtis & dupattas", 0, 1160, 1080, { fontSize:'28px', fontWeight:'400', fontFamily:"'Outfit',sans-serif", color:'#7E635A', textAlign:'center', lineHeight:'1.5' });
        }

        // ===== TEMPLATE 4: SIDE BY SIDE =====
        function tplSideBySide(img) {
            setFormat('insta');
            setGradientBg('linear-gradient(160deg, #667eea 0%, #764ba2 100%)');
            placeDeviceAt('macbook', img, 40, 360, 620, 420);
            placeDeviceAt('iphone', img, 720, 340, 280, 560);
            makeText("DESKTOP\n& MOBILE", 0, 40, 1080, { fontSize:'80px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', lineHeight:'1.0', letterSpacing:'3px' });
            makeText("Browse our gallery on any screen", 0, 260, 1080, { fontSize:'28px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffffcc', textAlign:'center' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1020, 1080, { fontSize:'24px', fontWeight:'500', fontFamily:"'Outfit',sans-serif", color:'#ffffffaa', textAlign:'center', letterSpacing:'1px' });
            makeText("Vastraकला", 0, 1080, 1080, { fontSize:'56px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center' });
        }

        // ===== TEMPLATE 5: ELEGANT SINGLE =====
        function tplElegantSingle(img) {
            setFormat('insta');
            setBlurBg(img, 'linear-gradient(180deg, rgba(209,163,146,0.75) 0%, rgba(126,99,90,0.9) 100%)');
            placeDeviceAt('imac', img, 90, 320, 900, 720);
            makeText("HANDCRAFTED\nELEGANCE", 0, 40, 1080, { fontSize:'72px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', lineHeight:'1.0', letterSpacing:'4px' });
            makeText("Custom hand-painted kurtis & dupattas", 0, 230, 1080, { fontSize:'26px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffffcc', textAlign:'center' });
            makeText("Behind the Art of Vastraकला", 0, 1100, 1080, { fontSize:'52px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center', textShadow:'0 2px 15px rgba(0,0,0,0.2)' });
            makeSearchBar(240, 1200, 600, 55);
        }

        // ===== TEMPLATE 6: 3-PHONE PROMO =====
        function tplAppPromo(img) {
            setFormat('story');
            setGradientBg('linear-gradient(180deg, #0f0c29 0%, #302b63 50%, #24243e 100%)');
            placeDeviceAt('iphone', img, 80, 550, 260, 520);
            placeDeviceAt('iphone', img, 400, 450, 300, 600);
            placeDeviceAt('iphone', img, 740, 550, 260, 520);
            makeText("SHOP ON\nMOBILE", 0, 60, 1080, { fontSize:'100px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', lineHeight:'1.0', letterSpacing:'5px' });
            makeText("Hand-painted fashion at your fingertips", 0, 330, 1080, { fontSize:'30px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffff99', textAlign:'center', letterSpacing:'2px' });
            makeText("Vastraकला", 0, 1680, 1080, { fontSize:'64px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#D1A392', textAlign:'center' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1790, 1080, { fontSize:'22px', fontWeight:'400', fontFamily:"'Outfit',sans-serif", color:'#ffffff55', textAlign:'center', letterSpacing:'2px' });
        }

        // ===== TEMPLATE 7: CASCADE STACK =====
        function tplCascadeStack(img) {
            setFormat('story');
            setBlurBg(img, 'linear-gradient(180deg, rgba(255,236,210,0.6) 0%, rgba(252,182,159,0.75) 100%)');
            placeDeviceAt('imac', img, 40, 380, 800, 640);
            placeDeviceAt('macbook', img, 280, 900, 560, 380);
            placeDeviceAt('ipad', img, 560, 1200, 440, 580);
            placeDeviceAt('iphone', img, 60, 1150, 220, 440);
            makeText("EXPLORE", 0, 60, 1080, { fontSize:'90px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#4A3F35', textAlign:'center', letterSpacing:'8px' });
            makeText("Our Artisan Gallery", 0, 190, 1080, { fontSize:'40px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#7E635A', textAlign:'center' });
            makeText("Unique designs, crafted with love.", 0, 280, 1080, { fontSize:'26px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#7E635Aaa', textAlign:'center' });
            makeText("Vastraकला", 0, 1740, 1080, { fontSize:'72px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#4A3F35', textAlign:'center' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1850, 1080, { fontSize:'22px', fontWeight:'500', fontFamily:"'Outfit',sans-serif", color:'#7E635A', textAlign:'center', letterSpacing:'2px' });
        }

        // ===== TEMPLATE 8: FLOATING DEVICES =====
        function tplFloatingDevices(img) {
            setFormat('story');
            setGradientBg('linear-gradient(160deg, #11998e 0%, #38ef7d 100%)');
            placeDeviceAt('imac', img, 120, 480, 840, 670);
            placeDeviceAt('macbook', img, -40, 1080, 520, 350);
            placeDeviceAt('ipad', img, 600, 1000, 420, 560);
            placeDeviceAt('iphone', img, 820, 480, 220, 440);
            makeText("NOW LIVE", 0, 50, 1080, { fontSize:'110px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', letterSpacing:'6px', textShadow:'0 4px 30px rgba(0,0,0,0.15)' });
            makeText("Your artisan fashion destination", 0, 220, 1080, { fontSize:'34px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffffcc', textAlign:'center', letterSpacing:'3px' });
            makeText("Explore hand-painted kurtis,\ndupattas & custom designs.", 0, 300, 1080, { fontSize:'24px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffff88', textAlign:'center', lineHeight:'1.6' });
            makeText("Vastraकला", 0, 1720, 1080, { fontSize:'72px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center', textShadow:'0 2px 20px rgba(0,0,0,0.15)' });
            makeSearchBar(240, 1830, 600, 55);
        }

        // ===== TEMPLATE 9: CINEMA WIDE =====
        function tplCinemaWide(img) {
            setFormat('insta');
            setGradientBg('linear-gradient(180deg, #232526 0%, #414345 50%, #232526 100%)');
            placeDeviceAt('iphone', img, 30, 340, 200, 400);
            placeDeviceAt('macbook', img, 250, 420, 540, 360);
            placeDeviceAt('imac', img, 140, 200, 800, 640);
            placeDeviceAt('ipad', img, 800, 360, 260, 350);
            makeText("ALL DEVICES", 0, 30, 1080, { fontSize:'72px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', letterSpacing:'6px' });
            makeText("ONE EXPERIENCE", 0, 120, 1080, { fontSize:'42px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#D1A392', textAlign:'center', letterSpacing:'8px' });
            makeText("Vastraकला", 0, 1060, 1080, { fontSize:'56px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1150, 1080, { fontSize:'20px', fontWeight:'400', fontFamily:"'Outfit',sans-serif", color:'#ffffff55', textAlign:'center', letterSpacing:'3px' });
        }

        // ===== TEMPLATE 10: NEON GLOW =====
        function tplNeonGlow(img) {
            setFormat('story');
            setGradientBg('linear-gradient(180deg, #0a0a0f 0%, #1a1030 50%, #0a0a0f 100%)');
            placeDeviceAt('imac', img, 100, 500, 880, 700);
            placeDeviceAt('macbook', img, -20, 1120, 500, 340);
            placeDeviceAt('ipad', img, 580, 1060, 420, 560);
            placeDeviceAt('iphone', img, 30, 900, 200, 400);
            makeText("LAUNCHING", 0, 60, 1080, { fontSize:'100px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#ff64c8', textAlign:'center', letterSpacing:'6px', textShadow:'0 0 40px rgba(255,100,200,0.4), 0 0 80px rgba(255,100,200,0.2)' });
            makeText("VASTRAकला ONLINE", 0, 200, 1080, { fontSize:'56px', fontWeight:'700', fontFamily:"'Outfit',sans-serif", color:'#64c8ff', textAlign:'center', letterSpacing:'4px', textShadow:'0 0 30px rgba(100,200,255,0.4)' });
            makeText("Where tradition meets modern art", 0, 310, 1080, { fontSize:'28px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffff66', textAlign:'center', letterSpacing:'2px' });
            makeText("Vastraकला", 0, 1720, 1080, { fontSize:'68px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#ff64c8', textAlign:'center', textShadow:'0 0 30px rgba(255,100,200,0.3)' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1830, 1080, { fontSize:'22px', fontWeight:'400', fontFamily:"'Outfit',sans-serif", color:'#64c8ff88', textAlign:'center', letterSpacing:'3px' });
        }

        // ===== TEMPLATE 11: EDITORIAL GRID =====
        function tplEditorialGrid(img) {
            setFormat('square');
            setGradientBg('linear-gradient(160deg, #e8d5c4 0%, #b8956a 100%)');
            placeDeviceAt('imac', img, 60, 200, 500, 400);
            placeDeviceAt('ipad', img, 580, 200, 440, 580);
            placeDeviceAt('macbook', img, 60, 620, 500, 340);
            placeDeviceAt('iphone', img, 820, 500, 200, 400);
            makeText("THE VASTRAकला", 0, 40, 1080, { fontSize:'64px', fontWeight:'900', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center', letterSpacing:'4px' });
            makeText("COLLECTION", 0, 110, 1080, { fontSize:'36px', fontWeight:'400', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', letterSpacing:'8px' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 980, 1080, { fontSize:'22px', fontWeight:'500', fontFamily:"'Outfit',sans-serif", color:'#ffffffcc', textAlign:'center', letterSpacing:'2px' });
        }

        // ===== TEMPLATE 12: EARTH TONE FOCUS =====
        function tplEarthToneFocus(img) {
            setFormat('story');
            setBlurBg(img, 'linear-gradient(180deg, rgba(209,163,146,0.85) 0%, rgba(126,99,90,0.95) 100%)');
            placeDeviceAt('imac', img, 90, 700, 900, 720);
            placeDeviceAt('ipad', img, 120, 1080, 420, 560);
            placeDeviceAt('macbook', img, 480, 1200, 520, 350);
            placeDeviceAt('iphone', img, 20, 1250, 200, 400);
            makeText("HAND-PAINTED", 0, 120, 1080, { fontSize:'80px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', letterSpacing:'6px' });
            makeText("ELEGANCE", 0, 220, 1080, { fontSize:'80px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffffaa', textAlign:'center', letterSpacing:'6px' });
            makeText("Behind the Art of Vastraकला", 0, 360, 1080, { fontSize:'48px', fontWeight:'400', fontFamily:"'Playfair Display',serif",  color:'#fff', textAlign:'center' });
            makeText("Our handcrafted masterpieces\nare now available online.", 0, 480, 1080, { fontSize:'26px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffffffcc', textAlign:'center', lineHeight:'1.5' });
            makeSearchBar(240, 1750, 600, 55);
        }

        // ===== TEMPLATE 13: DYNAMIC BURST =====
        function tplDynamicBurst(img) {
            setFormat('story');
            setGradientBg('linear-gradient(135deg, #8b4513 0%, #cd853f 100%)');
            placeDeviceAt('imac', img, 150, 600, 800, 640);
            placeDeviceAt('macbook', img, -100, 950, 600, 400);
            placeDeviceAt('ipad', img, 550, 900, 460, 600);
            placeDeviceAt('iphone', img, 800, 1150, 240, 480);
            makeText("MODERN", 0, 150, 1080, { fontSize:'100px', fontWeight:'900', fontFamily:"'Outfit',sans-serif", color:'#fff', textAlign:'center', letterSpacing:'5px' });
            makeText("TRADITION", 0, 260, 1080, { fontSize:'100px', fontWeight:'300', fontFamily:"'Outfit',sans-serif", color:'#ffe4c4', textAlign:'center', letterSpacing:'5px' });
            makeText("Unique pieces by Vastraकला", 0, 420, 1080, { fontSize:'36px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center' });
            makeSearchBar(240, 1750, 600, 55);
        }

        // ===== TEMPLATE 14: SOFT CANVAS =====
        function tplSoftCanvas(img) {
            setFormat('insta');
            setGradientBg('linear-gradient(160deg, #fcf4e8 0%, #f5e6ce 100%)');
            placeDeviceAt('imac', img, 140, 300, 800, 640);
            placeDeviceAt('ipad', img, -40, 380, 340, 460);
            placeDeviceAt('macbook', img, 650, 700, 440, 300);
            placeDeviceAt('iphone', img, 900, 250, 180, 360);
            makeText("Vastraकला", 0, 60, 1080, { fontSize:'80px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#5c4033', textAlign:'center' });
            makeText("A NEW EXPERIENCE", 0, 180, 1080, { fontSize:'28px', fontWeight:'700', fontFamily:"'Outfit',sans-serif", color:'#8b4513', textAlign:'center', letterSpacing:'6px' });
            makeText("vastrakala.ayushzalavadiya.me", 0, 1150, 1080, { fontSize:'20px', fontWeight:'500', fontFamily:"'Outfit',sans-serif", color:'#a0522d', textAlign:'center', letterSpacing:'2px' });
        }

        // ===== SEARCH BAR DECORATION =====
        function makeSearchBar(x, y, w, h) {
            const el = makeDrag(x, y, w, h, 'decor');
            const bar = document.createElement('div');
            Object.assign(bar.style, {
                width: '100%', height: '100%', borderRadius: '50px',
                border: '2px solid rgba(255,255,255,0.5)',
                background: 'rgba(255,255,255,0.12)',
                backdropFilter: 'blur(10px)', containerType: 'size',
                display: 'flex', alignItems: 'center', paddingLeft: '4cqw', gap: '2cqw',
                pointerEvents: 'none'
            });
            bar.innerHTML = '<i class="fa-solid fa-magnifying-glass" style="color:#fff; font-size:46cqh;"></i><div style="width:2px;height:60%;background:rgba(255,255,255,0.5);"></div><span class="edit-text" style="color:#ffffff; font-size:37cqh; font-family:Outfit,sans-serif; font-weight:500; letter-spacing:0.5px; outline:none; white-space:nowrap;">vastrakala.ayushzalavadiya.me</span>';
            el.appendChild(bar);
        }

        // ===== ELEMENT MAKERS =====
        window.addElement = function(type) {
            emptyHint.style.display = 'none';
            const cx = artW/2, cy = artH/2;

            if (type === 'search_bar') {
                makeSearchBar(cx-300, cy-30, 600, 65);
            }
            else if (type === 'circle') {
                const el = makeDrag(cx-75, cy-75, 150, 150, 'decor');
                const circ = document.createElement('div');
                Object.assign(circ.style, { width:'100%', height:'100%', borderRadius:'50%', background:'rgba(255,255,255,0.2)', pointerEvents:'none', border: '2px solid rgba(255,255,255,0.5)', backdropFilter:'blur(4px)' });
                el.appendChild(circ);
            }
            else if (type === 'square') {
                const el = makeDrag(cx-75, cy-75, 150, 150, 'decor');
                const sq = document.createElement('div');
                Object.assign(sq.style, { width:'100%', height:'100%', borderRadius:'8px', background:'rgba(255,255,255,0.2)', pointerEvents:'none', border: '2px solid rgba(255,255,255,0.5)', backdropFilter:'blur(4px)' });
                el.appendChild(sq);
            }
            else if (type === 'blob') {
                const el = makeDrag(cx-100, cy-100, 200, 200, 'decor');
                const blob = document.createElement('div');
                Object.assign(blob.style, { width:'100%', height:'100%', background:'linear-gradient(135deg,#D1A392,#e8d5c4)', pointerEvents:'none', opacity:'0.7' });
                blob.style.borderRadius = '40% 60% 70% 30% / 40% 50% 60% 50%';
                blob.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
                el.appendChild(blob);
            }
            else if (type === 'visit_btn') {
                const el = makeDrag(cx-160, cy-25, 320, 56, 'decor');
                const btn = document.createElement('div');
                Object.assign(btn.style, { width:'100%', height:'100%', borderRadius:'30px', background:'linear-gradient(135deg,#D1A392,#7E635A)', display:'flex', alignItems:'center', justifyContent:'center', gap:'10px', pointerEvents:'none', containerType:'size' });
                btn.innerHTML = '<span style="color:#fff;font-size:39cqh;font-family:Outfit,sans-serif;font-weight:700;letter-spacing:1px;">Visit Now</span><i class="fa-solid fa-arrow-right" style="color:#fff;font-size:32cqh;"></i>';
                el.appendChild(btn);
            }
            else if (type === 'star_rating') {
                const el = makeDrag(cx-140, cy-20, 280, 44, 'decor');
                const stars = document.createElement('div');
                Object.assign(stars.style, { width:'100%', height:'100%', display:'flex', alignItems:'center', justifyContent:'center', gap:'8px', pointerEvents:'none', containerType:'size' });
                stars.innerHTML = '<i class="fa-solid fa-star" style="color:#f5a623;font-size:63cqh;"></i>'.repeat(5) + '<span style="color:#fff;font-size:41cqh;font-family:Outfit,sans-serif;margin-left:8px;font-weight:600;">5.0</span>';
                el.appendChild(stars);
            }
            else if (type === 'social_strip') {
                const el = makeDrag(cx-180, cy-22, 360, 48, 'decor');
                const strip = document.createElement('div');
                Object.assign(strip.style, { width:'100%', height:'100%', display:'flex', alignItems:'center', justifyContent:'center', gap:'24px', pointerEvents:'none', containerType:'size' });
                strip.innerHTML = ['fa-instagram','fa-facebook-f'].map(i => '<i class="fa-brands '+i+'" style="color:#fff;font-size:54cqh;"></i>').join('');
                el.appendChild(strip);
            }
            else if (type === 'badge') {
                const el = makeDrag(cx-120, cy-60, 240, 120, 'decor');
                const badge = document.createElement('div');
                Object.assign(badge.style, { width:'100%', height:'100%', borderRadius:'50%', border:'3px solid rgba(255,255,255,0.6)', display:'flex', flexDirection:'column', alignItems:'center', justifyContent:'center', pointerEvents:'none', background:'rgba(255,255,255,0.08)', backdropFilter:'blur(6px)', containerType:'size' });
                badge.innerHTML = '<i class="fa-solid fa-hand-sparkles" style="color:#D1A392;font-size:23cqh;margin-bottom:4cqh;"></i><span style="color:#fff;font-size:12cqh;font-family:Outfit,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:2px;">Handcrafted</span><span style="color:#ffffffaa;font-size:8cqh;font-family:Outfit,sans-serif;">with love</span>';
                el.appendChild(badge);
            }
            else if (type === 'arrow') {
                const el = makeDrag(cx-30, cy, 60, 80, 'decor');
                const arrow = document.createElement('div');
                Object.assign(arrow.style, { width:'100%', height:'100%', display:'flex', alignItems:'center', justifyContent:'center', pointerEvents:'none', containerType:'size' });
                arrow.innerHTML = '<i class="fa-solid fa-arrow-down" style="color:#fff;font-size:60cqh;filter:drop-shadow(0 2px 8px rgba(0,0,0,0.3));"></i>';
                el.appendChild(arrow);
            }
            else if (type === 'url_pill') {
                const el = makeDrag(cx-200, cy-20, 400, 44, 'decor');
                const pill = document.createElement('div');
                Object.assign(pill.style, { width:'100%', height:'100%', borderRadius:'30px', background:'rgba(255,255,255,0.15)', border:'1px solid rgba(255,255,255,0.3)', display:'flex', alignItems:'center', justifyContent:'center', gap:'8px', pointerEvents:'none', backdropFilter:'blur(6px)', containerType:'size' });
                pill.innerHTML = '<i class="fa-solid fa-globe" style="color:#D1A392;font-size:41cqh;"></i><span style="color:#fff;font-size:41cqh;font-family:Outfit,sans-serif;font-weight:500;">vastrakala.ayushzalavadiya.me</span>';
                el.appendChild(pill);
            }
            else if (type === 'divider') {
                const el = makeDrag(cx-200, cy, 400, 20, 'decor');
                const line = document.createElement('div');
                Object.assign(line.style, { width:'100%', height:'100%', display:'flex', alignItems:'center', justifyContent:'center', gap:'16px', pointerEvents:'none', containerType:'size' });
                line.innerHTML = '<div style="flex:1;height:1px;background:linear-gradient(to right,transparent,rgba(255,255,255,0.5),transparent);"></div><i class="fa-solid fa-diamond" style="color:#D1A392;font-size:50cqh;"></i><div style="flex:1;height:1px;background:linear-gradient(to right,transparent,rgba(255,255,255,0.5),transparent);"></div>';
                el.appendChild(line);
            }
            else if (type === 'logo_text') {
                makeText("Vastraकला", cx-200, cy-40, 400, { fontSize:'64px', fontWeight:'400', fontFamily:"'Playfair Display',serif", color:'#fff', textAlign:'center', textShadow:'0 2px 15px rgba(0,0,0,0.2)' });
            }
            else if (type === 'new_tag') {
                const el = makeDrag(cx-50, cy-18, 100, 38, 'decor');
                const tag = document.createElement('div');
                Object.assign(tag.style, { width:'100%', height:'100%', borderRadius:'6px', background:'linear-gradient(135deg,#e74c3c,#c0392b)', display:'flex', alignItems:'center', justifyContent:'center', pointerEvents:'none', containerType:'size' });
                tag.innerHTML = '<span style="color:#fff;font-size:42cqh;font-family:Outfit,sans-serif;font-weight:800;letter-spacing:3px;">NEW</span>';
                el.appendChild(tag);
            }
        };

        // ===== PLACE DEVICE AT POSITION =====
        function placeDeviceAt(type, imgSrc, x, y, w, h) {
            const el = makeDrag(x, y, w, h, 'device');
            let html = '';
            if (type === 'imac') {
                html = `<div class="device-frame device-imac"><div class="screen"><img src="${imgSrc}" draggable="false"/></div><div class="stand-area"><div class="chin"><div class="chin-dot"></div></div><div class="stand-foot"></div></div></div>`;
            } else if (type === 'macbook') {
                html = `<div class="device-frame device-macbook"><div class="screen"><img src="${imgSrc}" draggable="false"/></div><div class="base"></div><div class="notch"></div></div>`;
            } else if (type === 'ipad') {
                html = `<div class="device-frame device-ipad"><div class="screen"><img src="${imgSrc}" draggable="false"/></div></div>`;
            } else if (type === 'iphone') {
                html = `<div class="device-frame device-iphone"><div class="screen"><div class="notch-pill"></div><img src="${imgSrc}" draggable="false"/></div></div>`;
            }
            el.insertAdjacentHTML('afterbegin', html);
            addScreenOverlay(el);
        }

        // ===== ADD SINGLE DEVICE (manual) =====
        window.addSingleDevice = function(type) {
            emptyHint.style.display = 'none';
            const sz = { imac: [680,540], macbook: [540,360], ipad: [360,480], iphone: [200,400] };
            const s = sz[type];
            let demoImg = pendingImgSrc || 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop';
            placeDeviceAt(type, demoImg, (artW-s[0])/2, (artH-s[1])/2, s[0], s[1]);
        };

        // Screen overlay for changing individual images
        function addScreenOverlay(el) {
            const scr = el.querySelector('.screen');
            if (!scr) return;
            const ov = document.createElement('div');
            ov.className = 'screen-overlay';
            ov.innerHTML = '<div class="cam-icon"><i class="fa-solid fa-camera"></i></div>';
            ov.style.pointerEvents = 'auto';
            ov.addEventListener('mousedown', e => e.stopPropagation());
            ov.addEventListener('click', e => {
                e.stopPropagation();
                devicePendingChange = scr;
                deviceChangeInput.click();
            });
            scr.appendChild(ov);
        }

        deviceChangeInput.addEventListener('change', function() {
            if (!devicePendingChange || !this.files[0]) return;
            const r = new FileReader();
            r.onload = ev => {
                const img = devicePendingChange.querySelector('img');
                if (img) img.src = ev.target.result;
                devicePendingChange = null;
            };
            r.readAsDataURL(this.files[0]); this.value = '';
        });

        window.switchTab = function(tabName) {
            document.querySelectorAll('.panel-content').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
            
            document.getElementById('tab-' + tabName).classList.add('active');
            document.getElementById('nav-' + tabName).classList.add('active');
        };

        // ===== INIT =====
        function makeText(txt, x, y, w, styles) {
            const el = makeDrag(x, y, w, null, 'text');
            const td = document.createElement('div');
            td.className = 'text-element';
            td.contentEditable = 'false';
            td.innerText = txt;
            Object.assign(td.style, styles);

            // Double-click to edit text
            td.addEventListener('dblclick', function(e) {
                e.stopPropagation();
                td.contentEditable = 'true';
                td.focus();
                td.style.cursor = 'text';
                // Select all text for easy replacement
                const range = document.createRange();
                range.selectNodeContents(td);
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            });

            // Stop editing on blur
            td.addEventListener('blur', function() {
                td.contentEditable = 'false';
                td.style.cursor = '';
            });

            // When editing, stop mousedown from triggering drag
            td.addEventListener('mousedown', function(e) {
                if (td.contentEditable === 'true') {
                    e.stopPropagation();
                }
            });

            el.appendChild(td);
            el.dataset.elType = 'text';
        }

        const textCfg = {
            heading: { t: "NEW WEBSITE", s: { fontSize:'100px', fontWeight:'900', fontFamily:"'Outfit', sans-serif", color:'#fff', textAlign:'center', textShadow:'0 4px 20px rgba(0,0,0,0.2)', letterSpacing:'4px' }},
            sub:     { t: "Check out our new website", s: { fontSize:'38px', fontWeight:'600', fontFamily:"'Outfit', sans-serif", color:'#fff', textAlign:'center', textShadow:'0 2px 12px rgba(0,0,0,0.2)' }},
            body:    { t: "Unique hand-painted artistry.", s: { fontSize:'26px', fontWeight:'400', fontFamily:"'Outfit', sans-serif", color:'#ffffffcc', textAlign:'center' }},
script:  { t: "Behind the Art of Vastraकला", s: { fontSize:'52px', fontWeight:'400', fontFamily:"'Playfair Display', serif", color:'#fff', textAlign:'center', textShadow:'0 2px 12px rgba(0,0,0,0.2)' }}
        };

        // ===== TEMPLATE RENDERER =====
        function renderTemplates() {
            const grid = document.getElementById('templateGrid');
            if (!grid) {
                console.error("Template Grid not found!");
                return;
            }
            grid.innerHTML = '';
            
            const gallery = [
                { id: 'website_launch', name: 'Website Launch', bg: 'linear-gradient(180deg, #c8aa8c, #b49678)', html: `
                    <div style="color:#fff;font-size:5px;font-weight:600;text-align:center;margin-top:5px;">We're live now!</div>
                    <div style="color:#fff;font-size:10px;font-weight:900;text-align:center;margin-top:0px;line-height:1;letter-spacing:0.5px;">NEW<br>WEBSITE</div>
                    <div style="position:relative;width:100%;height:100%;margin-top:2px;">
                        <div style="position:absolute;top:5px;left:15%;width:70%;height:45px;background:#222;border-radius:2px;padding:1.5px;box-shadow:0 10px 25px rgba(0,0,0,0.4);z-index:2;">
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:1px;"></div>
                            <div style="position:absolute;bottom:-8px;left:40%;width:20%;height:8px;background:#333;clip-path:polygon(20% 0, 80% 0, 100% 100%, 0% 100%);"></div>
                        </div>
                        <div style="position:absolute;top:38px;left:5%;width:42%;height:25px;background:#2c2c2e;border-radius:2px;z-index:10;padding:1px;box-shadow:0 10px 25px rgba(0,0,0,0.4);">
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#ff9966,#ff5e62);border-radius:1px;"></div>
                        </div>
                        <div style="position:absolute;top:42px;right:10%;width:30%;height:40px;background:#1a1a22;border-radius:4px;z-index:11;padding:2px;box-shadow:0 10px 25px rgba(0,0,0,0.4);">
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#8e2de2,#4a00e0);border-radius:2px;"></div>
                        </div>
                        <div style="position:absolute;top:52px;left:8%;width:14%;height:30px;background:#000;border-radius:7px;z-index:20;padding:1px;box-shadow:0 10px 25px rgba(0,0,0,0.4);border:0.5px solid #333;">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#00b09b,#96c93d);border-radius:6px;"></div>
                        </div>
                        <div style="position:absolute;top:25px;left:25%;width:50%;height:5px;background:rgba(255,255,255,0.4);border-radius:10px;z-index:15;border:0.5px solid rgba(255,255,255,0.6);"></div>
                        <div style="position:absolute;bottom:10px;width:100%;text-align:center;color:#fff;font-size:5px;font-family:serif;line-height:1.2;">Behind the Art of<br>Vastraकला</div>
                    </div>`
                },
                { id: 'dark_premium', name: 'Dark Premium', bg: 'linear-gradient(180deg, #1a1a1e, #0d0d0f)', html: `
                    <div style="color:#fff;font-size:8px;font-weight:900;text-align:center;margin-top:8px;line-height:1;letter-spacing:1px;">ARTFUL<br>MASTERPIECES</div>
                    <div style="position:relative;width:100%;height:100%;">
                        <div style="position:absolute;top:15px;left:15%;width:70%;height:40px;background:#222;border-radius:3px;padding:2px;border:1px solid #444;box-shadow:0 8px 20px rgba(0,0,0,0.5);">
                            <div style="width:100%;height:100%;background:#111;border-radius:1px;"></div>
                        </div>
                        <div style="position:absolute;top:45px;left:10%;width:40%;height:22px;background:#2c2c2e;border-radius:2px;z-index:10;padding:1px;box-shadow:0 8px 20px rgba(0,0,0,0.5);">
                            <div style="width:100%;height:100%;background:#0d0d0f;border-radius:1px;"></div>
                        </div>
                        <div style="position:absolute;top:38px;right:12%;width:18%;height:34px;background:#000;border-radius:7px;z-index:15;padding:2px;box-shadow:0 8px 20px rgba(0,0,0,0.5);">
                            <div style="width:100%;height:100%;background:#0a0a0c;border-radius:5px;"></div>
                        </div>
                        <div style="position:absolute;bottom:15px;width:100%;text-align:center;color:#D1A392;font-size:8px;font-family:serif;">Vastraकला</div>
                    </div>`
                },
                { id: 'minimal_phone', name: 'Phone Focus', bg: 'linear-gradient(160deg, #fdf6ee, #e8d5c4)', html: `
                    <div style="color:#4A3F35;font-size:9px;font-family:serif;margin-top:15px;text-align:center;width:100%;">Vastraकला</div>
                    <div style="position:relative;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;">
                        <div style="width:38%;height:60%;background:#000;border-radius:18px;padding:2.5px;box-shadow:0 10px 25px rgba(0,0,0,0.2);margin-top:8px;">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#8e2de2,#4a00e0);border-radius:16px;"></div>
                        </div>
                        <div style="color:#7E635A;font-size:4.5px;font-weight:800;margin-top:8px;letter-spacing:1px;text-transform:uppercase;">NOW ON MOBILE</div>
                    </div>`
                },
                { id: 'side_by_side', name: 'Side by Side', bg: 'linear-gradient(135deg,#667eea,#764ba2)', html: `
                    <div style="color:#fff;font-size:8px;font-weight:900;text-align:center;margin-top:10px;line-height:1;letter-spacing:1px;">DESKTOP &<br>MOBILE</div>
                    <div style="display:flex;gap:5px;justify-content:center;align-items:flex-end;height:45%;margin-top:15px;width:100%;">
                        <div style="width:48%;height:75%;background:#fff;border-radius:3px;padding:1.5px;box-shadow:0 8px 20px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:linear-gradient(45deg,#f3f4f6,#fff);border-radius:1px;"></div>
                        </div>
                        <div style="width:20%;height:95%;background:#000;border-radius:8px;padding:2px;box-shadow:0 8px 20px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#f3f4f6,#fff);border-radius:6px;"></div>
                        </div>
                    </div>
                    <div style="color:#fff;font-size:6px;font-family:serif;margin-top:8px;text-align:center;width:100%;">Vastraकला</div>`
                },
                { id: 'elegant_portfolio', name: 'Elegant Single', bg: 'linear-gradient(180deg,rgba(209,163,146,0.95),rgba(126,99,90,0.98))', html: `
                    <div style="color:#fff;font-size:7px;font-weight:900;text-align:center;margin-top:12px;line-height:1.1;letter-spacing:1px;">ELEGANT<br>SINGLE</div>
                    <div style="position:relative;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;margin-top:10px;">
                        <div style="width:80%;height:44%;background:#fff;border-radius:2px;padding:2px;box-shadow:0 12px 35px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#2193b0,#6dd5ed);border-radius:1px;"></div>
                        </div>
                        <div style="color:#fff;font-size:6px;font-family:serif;margin-top:18px;">Vastraकला</div>
                        <div style="width:45%;height:4px;background:rgba(255,255,255,0.4);border-radius:10px;margin-top:4px;"></div>
                    </div>`
                },
                { id: 'app_promo', name: '3-Phone Promo', bg: 'linear-gradient(180deg,#0f0c29,#302b63 60%,#24243e)', html: `
                    <div style="color:#fff;font-size:9px;font-weight:900;text-align:center;margin-top:10px;line-height:1;letter-spacing:1px;">SHOP ON MOBILE</div>
                    <div style="display:flex;gap:4px;justify-content:center;align-items:flex-end;height:45%;margin-top:15px;padding:0 5px;width:100%;">
                        <div style="width:26%;height:82%;background:#000;border-radius:12px;padding:2px;opacity:0.7;transform:translateY(5px);">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#ff9966,#ff5e62);border-radius:11px;"></div>
                        </div>
                        <div style="width:32%;height:95%;background:#000;border-radius:15px;padding:2.5px;z-index:5;">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#00b09b,#96c93d);border-radius:14px;"></div>
                        </div>
                        <div style="width:26%;height:82%;background:#000;border-radius:12px;padding:2px;opacity:0.7;transform:translateY(5px);">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#2193b0,#6dd5ed);border-radius:11px;"></div>
                        </div>
                    </div>
                    <div style="color:#D1A392;font-size:8px;font-family:serif;margin-top:12px;text-align:center;width:100%;">Vastraकला</div>`
                },
                { id: 'cascade_stack', name: 'Cascade Stack', bg: 'linear-gradient(180deg,rgba(255,236,210,0.7),rgba(252,182,159,0.85))', html: `
                    <div style="color:#4A3F35;font-size:10px;font-weight:900;margin-top:10px;letter-spacing:2px;text-align:center;width:100%;">EXPLORE</div>
                    <div style="position:relative;width:100%;height:100%;">
                        <div style="position:absolute;top:5px;left:10%;width:65%;height:45px;background:#222;border-radius:3px;padding:2px;box-shadow:0 10px 25px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:#000;border-radius:1px;"></div>
                        </div>
                        <div style="position:absolute;top:32px;left:40%;width:52%;height:30px;background:#2c2c2e;border-radius:2px;z-index:10;padding:1.5px;box-shadow:0 10px 25px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:#111;border-radius:1px;"></div>
                        </div>
                        <div style="position:absolute;top:55px;right:6%;width:38%;height:48px;background:#1a1a22;border-radius:4px;z-index:5;padding:2px;box-shadow:0 10px 25px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:#000;border-radius:3px;"></div>
                        </div>
                        <div style="position:absolute;top:52px;left:8%;width:18%;height:34px;background:#000;border-radius:8px;z-index:15;padding:1.5px;box-shadow:0 10px 25px rgba(0,0,0,0.3);">
                            <div style="width:100%;height:100%;background:#111;border-radius:7px;"></div>
                        </div>
                    </div>`
                },
                { id: 'floating_devices', name: 'Floating Devices', bg: 'linear-gradient(160deg,#11998e,#38ef7d)', html: `
                    <div style="color:#fff;font-size:9px;font-weight:900;text-align:center;margin-top:12px;letter-spacing:1px;line-height:1;">NOW LIVE</div>
                    <div style="position:relative;width:100%;height:100%;">
                        <div style="position:absolute;top:10%;left:25%;width:62%;height:45px;background:rgba(0,0,0,0.15);backdrop-filter:blur(3px);border-radius:4px;transform:rotate(-3deg);border:1px solid rgba(255,255,255,0.3);"></div>
                        <div style="position:absolute;top:38%;left:4%;width:48%;height:28px;background:rgba(0,0,0,0.1);backdrop-filter:blur(3px);border-radius:3px;transform:rotate(5deg);border:1px solid rgba(255,255,255,0.2);"></div>
                        <div style="position:absolute;bottom:25%;right:4%;width:38%;height:50px;background:rgba(0,0,0,0.1);backdrop-filter:blur(3px);border-radius:6px;transform:rotate(-3deg);border:1px solid rgba(255,255,255,0.2);"></div>
                        <div style="position:absolute;top:12%;right:8%;width:18%;height:32px;background:rgba(0,0,0,0.15);backdrop-filter:blur(3px);border-radius:9px;transform:rotate(6deg);border:1px solid rgba(255,255,255,0.3);"></div>
                    </div>`
                },
                { id: 'cinema_wide', name: 'Cinema Line', bg: 'linear-gradient(180deg,#1a1a1e,#2c2c30,#1a1a1e)', html: `
                    <div style="color:#888;font-size:7px;font-weight:700;letter-spacing:3px;margin-top:10px;text-align:center;">CINEMA</div>
                    <div style="display:flex;gap:3px;align-items:flex-end;justify-content:center;height:45%;margin-top:15px;width:100%;">
                        <div style="width:14%;height:80%;background:#000;border-radius:7px;padding:2px;opacity:0.65;box-shadow:0 5px 15px rgba(0,0,0,0.4);">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#8e2de2,#4a00e0);border-radius:6px;"></div>
                        </div>
                        <div style="width:42%;height:100%;background:#000;border-radius:2.5px;padding:2px;box-shadow:0 8px 25px rgba(0,0,0,0.5);">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#ff9966,#ff5e62);border-radius:1.5px;"></div>
                        </div>
                        <div style="width:26%;height:75%;background:#000;border-radius:5px;padding:2px;opacity:0.85;box-shadow:0 5px 15px rgba(0,0,0,0.4);">
                            <div style="width:100%;height:100%;background:linear-gradient(180deg,#00b09b,#96c93d);border-radius:4px;"></div>
                        </div>
                    </div>
                    <div style="background:#555;width:65%;height:1.5px;border-radius:1px;margin-top:10px;margin-left:auto;margin-right:auto;"></div>`
                },
                { id: 'neon_glow', name: 'Neon Glow', bg: 'linear-gradient(180deg,#050510,#0d0820)', html: `
                    <div style="color:#ff64c8;font-size:9px;font-weight:900;text-align:center;margin-top:12px;text-shadow:0 0 8px #ff64c8;letter-spacing:1px;">LAUNCHING</div>
                    <div style="position:relative;width:100%;height:100%;">
                        <div style="position:absolute;top:10%;left:20%;width:62%;height:42px;border:1.2px solid #ff64c8;box-shadow:0 0 15px rgba(255,100,200,0.6);border-radius:3px;"></div>
                        <div style="position:absolute;top:42%;left:4%;width:42%;height:26px;border:1.2px solid #64c8ff;box-shadow:0 0 15px rgba(100,200,255,0.6);border-radius:2px;"></div>
                        <div style="position:absolute;bottom:25%;right:5%;width:38%;height:48px;border:1.2px solid #ff64c8;box-shadow:0 0 8px rgba(255,100,200,0.4);border-radius:6px;"></div>
                    </div>`
                },
                { id: 'editorial_grid', name: 'Editorial Grid', bg: 'linear-gradient(160deg,#e8d5c4,#b8956a)', html: `
                    <div style="color:#fff;font-size:7px;font-weight:700;margin-top:12px;text-align:center;width:100%;letter-spacing:2px;">THE COLLECTION</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5px;width:80%;margin-top:12px;margin-left:auto;margin-right:auto;">
                        <div style="background:#4A3F35;aspect-ratio:1;border-radius:2px;"></div>
                        <div style="background:#6b4f3a;aspect-ratio:1;border-radius:2px;"></div>
                        <div style="background:#5c4534;aspect-ratio:1;border-radius:2px;"></div>
                        <div style="background:#3d3228;aspect-ratio:1;border-radius:2px;"></div>
                    </div>`
                },
                { id: 'earth_tone_focus', name: 'Earth Focus', bg: 'linear-gradient(180deg,rgba(209,163,146,0.95),rgba(126,99,90,0.98))', html: `
                    <div style="color:#fff;font-size:8px;font-weight:900;text-align:center;margin-top:12px;line-height:1;letter-spacing:1px;">EARTH<br>FOCUS</div>
                    <div style="position:relative;width:100%;height:100%;">
                        <div style="position:absolute;top:10%;left:15%;width:72%;height:42px;background:#222;border-radius:3px;padding:2px;box-shadow:0 10px 25px rgba(0,0,0,0.4);">
                            <div style="width:100%;height:100%;background:#000;border-radius:1px;"></div>
                        </div>
                        <div style="position:absolute;top:42%;left:4%;width:48%;height:28px;background:#2c2c2e;border-radius:2.5px;z-index:10;padding:1.5px;box-shadow:0 10px 25px rgba(0,0,0,0.3);"></div>
                        <div style="position:absolute;bottom:25%;right:5%;width:32%;height:42px;background:#1a1a22;border-radius:6px;z-index:5;padding:2px;box-shadow:0 10px 25px rgba(0,0,0,0.3);"></div>
                    </div>`
                },
                { id: 'dynamic_burst', name: 'Dynamic Burst', bg: 'linear-gradient(135deg,#8b4513,#cd853f)', html: `
                    <div style="color:#ffe4c4;font-size:8px;font-weight:900;text-align:center;margin-top:12px;line-height:1.1;letter-spacing:1px;">DYNAMIC<br>BURST</div>
                    <div style="position:relative;width:100%;height:100%;">
                        <div style="position:absolute;top:12%;left:5%;width:58%;height:40px;background:rgba(255,255,255,0.25);border-radius:4px;transform:rotate(-6deg);"></div>
                        <div style="position:absolute;top:10%;right:6%;width:45%;height:30px;background:rgba(255,255,255,0.2);border-radius:3px;transform:rotate(8deg);"></div>
                        <div style="position:absolute;bottom:22%;left:12%;width:42%;height:38px;background:rgba(255,255,255,0.32);border-radius:6px;transform:rotate(4deg);"></div>
                    </div>`
                },
                { id: 'soft_canvas', name: 'Soft Canvas', bg: 'linear-gradient(160deg,#fcf4e8,#f5e6ce)', html: `
                    <div style="color:#5c4033;font-size:9px;font-family:serif;margin-top:15px;text-align:center;width:100%;">Vastraकला</div>
                    <div style="position:relative;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;margin-top:10px;">
                        <div style="width:78%;height:48%;background:#4A3F35;border-radius:3px;padding:2px;box-shadow:0 12px 30px rgba(0,0,0,0.15);">
                            <div style="width:100%;height:100%;background:#111;border-radius:1px;"></div>
                        </div>
                        <div style="display:flex;gap:4px;margin-top:8px;justify-content:center;width:100%;">
                            <div style="width:28%;height:20px;background:#6b4f3a;border-radius:3px;"></div>
                            <div style="width:15%;height:26px;background:#000;border-radius:9px;"></div>
                        </div>
                    </div>`
                }
            ];

            gallery.forEach(t => {
                try {
                    const card = document.createElement('div');
                    card.className = 'tpl-card';
                    card.onclick = () => window.pickTemplate(t.id);
                    card.innerHTML = `
                        <div class="tpl-preview" style="background:${t.bg}">
                            ${t.html}
                        </div>
                        <p>${t.name}</p>
                    `;
                    grid.appendChild(card);
                } catch(e) { console.error("Template Error:", t.id, e); }
            });
        }
        
        // Wait for DOM
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", renderTemplates);
        } else {
            renderTemplates();
        }

        window.addText = function(type) {

            emptyHint.style.display = 'none';
            const cx = artW/2, cy = artH/2;
            
            if (type === 'happy_birthday') {
                makeText("Happy", cx-100, cy-70, 200, { fontSize:'64px', fontFamily:"'Pacifico', cursive", color:'#111', textAlign:'center', lineHeight:'1', transform:'rotate(-5deg)' });
                makeText("BIRTHDAY", cx-200, cy-10, 400, { fontSize:'90px', fontWeight:'400', fontFamily:"'Anton', sans-serif", color:'#111', textAlign:'center', lineHeight:'1' });
                return;
            }
            if (type === 'golden_hour') {
                makeText("GOLDEN\nHOUR", cx-200, cy-70, 400, { fontSize:'80px', fontWeight:'700', fontFamily:"'Cinzel', serif", color:'#d4af37', textAlign:'center', lineHeight:'1.1' });
                return;
            }
            if (type === 'thank_you_retro') {
                makeText("THANK\nYOU", cx-200, cy-70, 400, { fontSize:'72px', fontWeight:'900', fontFamily:"'Outfit', sans-serif", color:'#ff8a65', textAlign:'center', textShadow:'-3px -3px 0 #ffe082, 3px -3px 0 #ffe082, -3px 3px 0 #ffe082, 3px 3px 0 #ffe082', letterSpacing:'4px', transform:'rotate(-5deg)', lineHeight:'1' });
                return;
            }
            if (type === 'like_subscribe') {
                makeText("LIKE &", cx-150, cy-60, 300, { fontSize:'52px', fontFamily:"'Sigmar One', cursive", color:'#fff', textAlign:'center', textShadow:'-2px -2px 0 #f4b400, 2px -2px 0 #f4b400, -2px 2px 0 #f4b400, 2px 2px 0 #f4b400', lineHeight:'1' });
                makeText("SUBSCRIBE", cx-250, cy-10, 500, { fontSize:'64px', fontFamily:"'Sigmar One', cursive", color:'#fff', textAlign:'center', textShadow:'-2px -2px 0 #e53935, 2px -2px 0 #e53935, -2px 2px 0 #e53935, 2px 2px 0 #e53935', lineHeight:'1' });
                return;
            }
            if (type === 'family_time') {
                makeText("Family Time", cx-250, cy-40, 500, { fontSize:'80px', fontWeight:'400', fontFamily:"'Playfair Display', serif", color:'#cfaf72', textAlign:'center' });
                return;
            }
            if (type === 'featured') {
                makeText("Featured", cx-200, cy-40, 400, { fontSize:'90px', fontFamily:"'Pacifico', cursive", color:'#9c27b0', textAlign:'center', textShadow:'3px 3px 8px rgba(0,0,0,0.2)' });
                return;
            }

            if (type === 'fire_away') {
                makeText("FIRE", cx-200, cy-80, 400, { fontSize:'100px', fontFamily:"'Bebas Neue', sans-serif", color:'#ff6a00', textAlign:'center', letterSpacing:'4px', lineHeight:'1' });
                makeText("away", cx-200, cy+30, 400, { fontSize:'80px', fontFamily:"'Dancing Script', cursive", color:'#ff9800', textAlign:'center', lineHeight:'1' });
                return;
            }
            if (type === 'day_in_life') {
                makeText("A day in", cx-200, cy-60, 400, { fontSize:'48px', fontWeight:'300', fontFamily:"'Raleway', sans-serif", color:'#7c3aed', textAlign:'center', letterSpacing:'4px' });
                makeText("my life", cx-200, cy, 400, { fontSize:'96px', fontFamily:"'Dancing Script', cursive", color:'#9c27b0', textAlign:'center' });
                return;
            }
            if (type === 'order_now') {
                makeText("Order Now!", cx-250, cy-40, 500, { fontSize:'96px', fontFamily:"'Fredoka One', cursive", color:'#2e7d32', textAlign:'center', letterSpacing:'2px' });
                return;
            }
            if (type === 'coffee_break') {
                makeText("Coffee Break", cx-250, cy-40, 500, { fontSize:'80px', fontFamily:"'Abril Fatface', cursive", color:'#4e342e', textAlign:'center' });
                return;
            }
            if (type === 'glow') {
                makeText("GLOW", cx-250, cy-50, 500, { fontSize:'120px', fontFamily:"'Monoton', cursive", color:'#ff00ff', textAlign:'center', textShadow:'0 0 20px #ff00ff, 0 0 40px #ff00ff, 0 0 80px #ff00ff' });
                return;
            }
            if (type === 'play_retro') {
                makeText("PLAY", cx-250, cy-60, 500, { fontSize:'140px', fontFamily:"'Bangers', cursive", color:'#f953c6', textAlign:'center', letterSpacing:'8px' });
                return;
            }
            if (type === 'now_open') {
                makeText("Now Open!", cx-250, cy-50, 500, { fontSize:'96px', fontFamily:"'Pacifico', cursive", color:'#fff', textAlign:'center', textShadow:'0 0 20px rgba(255,255,255,0.5)' });
                return;
            }
            if (type === 'coming_soon') {
                makeText("COMING\nSOON", cx-250, cy-80, 500, { fontSize:'100px', fontFamily:"'Bebas Neue', sans-serif", color:'#c0392b', textAlign:'center', letterSpacing:'6px', lineHeight:'1' });
                return;
            }
            if (type === 'title_bold') {
                makeText("Title", cx-250, cy-60, 500, { fontSize:'120px', fontWeight:'900', fontFamily:"'Raleway', sans-serif", color:'#111', textAlign:'center' });
                makeText("HEADING", cx-250, cy+60, 500, { fontSize:'36px', fontWeight:'300', fontFamily:"'Raleway', sans-serif", color:'#555', textAlign:'center', letterSpacing:'10px' });
                return;
            }
            if (type === 'shop_now') {
                makeText("SHOP NOW!", cx-250, cy-50, 500, { fontSize:'96px', fontFamily:"'Righteous', cursive", color:'#e65100', textAlign:'center', letterSpacing:'2px' });
                return;
            }
            if (type === 'bride_groom') {
                makeText("Bride &\nGroom", cx-250, cy-70, 500, { fontSize:'90px', fontFamily:"'Satisfy', cursive", color:'#880e4f', textAlign:'center', lineHeight:'1.1' });
                return;
            }
            if (type === 'engaged') {
                makeText("engaged!", cx-300, cy-50, 600, { fontSize:'110px', fontFamily:"'Dancing Script', cursive", color:'#333', textAlign:'center' });
                return;
            }
            if (type === 'player_one') {
                makeText("player", cx-200, cy-60, 400, { fontSize:'64px', fontFamily:"'Russo One', sans-serif", color:'#ff6b6b', textAlign:'center', letterSpacing:'2px' });
                makeText("ONE", cx-200, cy, 400, { fontSize:'100px', fontFamily:"'Russo One', sans-serif", color:'#ffd93d', textAlign:'center', letterSpacing:'6px' });
                return;
            }
            if (type === 'cute_button') {
                makeText("CUTE as a\nBUTTON", cx-250, cy-60, 500, { fontSize:'80px', fontFamily:"'Fredoka One', cursive", color:'#ab47bc', textAlign:'center', lineHeight:'1.1' });
                return;
            }
            if (type === 'creating_magic') {
                makeText("creating", cx-250, cy-60, 500, { fontSize:'64px', fontFamily:"'Dancing Script', cursive", color:'#9c27b0', textAlign:'center' });
                makeText("MAGIC", cx-250, cy, 500, { fontSize:'100px', fontFamily:"'Bangers', cursive", color:'#7b1fa2', textAlign:'center', letterSpacing:'6px' });
                return;
            }
            if (type === 'discount_30') {
                makeText("30%", cx-200, cy-70, 400, { fontSize:'130px', fontFamily:"'Bebas Neue', sans-serif", color:'#888', textAlign:'center', lineHeight:'1' });
                makeText("OFF ALL PRODUCTS", cx-250, cy+50, 500, { fontSize:'40px', fontFamily:"'Bebas Neue', sans-serif", color:'#2e7d32', textAlign:'center', letterSpacing:'4px' });
                return;
            }
            if (type === 'custom_paint') {
                makeText("CUSTOM", cx-250, cy-60, 500, { fontSize:'56px', fontWeight:'100', fontFamily:"'Josefin Sans', sans-serif", color:'#555', textAlign:'center', letterSpacing:'10px' });
                makeText("PAINT", cx-250, cy, 500, { fontSize:'110px', fontFamily:"'Bangers', cursive", color:'#ff6f00', textAlign:'center', letterSpacing:'8px' });
                return;
            }

            const c = textCfg[type];
            if (c) makeText(c.t, cx-300, cy-40, 600, c.s);

        };

        // Text props
        window.setTP = function(p,v) {
            if (!selectedEl || selectedEl.dataset.elType !== 'text') return;
            const td = selectedEl.querySelector('.text-element');
            if (td) td.style[p] = v;
        };
        function showTP(el) {
            const p = document.getElementById('textPropsPanel');
            const td = el.querySelector('.text-element'); if (!td) return;
            p.style.display = 'block';
            try {
                document.getElementById('propFont').value = td.style.fontFamily || "'Outfit', sans-serif";
                document.getElementById('propSize').value = parseInt(td.style.fontSize) || 48;
                document.getElementById('propColor').value = rgb2hex(td.style.color);
                document.getElementById('propWeight').value = td.style.fontWeight || '400';
            } catch(e){}
        }
        function hideTP() { document.getElementById('textPropsPanel').style.display = 'none'; }
        function rgb2hex(c) {
            if (!c || c.startsWith('#')) return c||'#ffffff';
            const m = c.match(/(\d+)/g);
            return m && m.length >= 3 ? '#'+m.slice(0,3).map(x=>(+x).toString(16).padStart(2,'0')).join('') : '#ffffff';
        }

        // ===== DRAG ENGINE =====
        // Safe class check helper (SVG elements have SVGAnimatedString, not string)
        function hasClass(el, name) {
            if (!el || !el.className) return false;
            const cls = typeof el.className === 'string' ? el.className : (el.className.baseVal || '');
            return cls.includes(name);
        }

        function makeDrag(x, y, w, h, type) {
            const el = document.createElement('div');
            el.className = 'drag-el';
            el.style.left = x+'px'; el.style.top = y+'px'; el.style.width = w+'px';
            if (h) el.style.height = h+'px';
            el.dataset.elType = type;
            el.dataset.interactMode = 'false';

            const rh = document.createElement('div'); rh.className = 'resize-handle'; el.appendChild(rh);
            const rhr = document.createElement('div'); rhr.className = 'resize-handle-r';
            const rhb = document.createElement('div'); rhb.className = 'resize-handle-b';
            el.appendChild(rhr); el.appendChild(rhb);
            rhr.addEventListener('mousedown', (e) => { e.stopPropagation(); selectEl(el); resizeSideStart(e, el, 'w'); });
            rhb.addEventListener('mousedown', (e) => { e.stopPropagation(); selectEl(el); resizeSideStart(e, el, 'h'); });
            const dh = document.createElement('div'); dh.className = 'delete-handle'; dh.textContent = '×';
            dh.addEventListener('mousedown', e => { e.stopPropagation(); el.remove(); elements = elements.filter(x=>x!==el); if(selectedEl===el){selectedEl=null;hideTP();hideContextToolbar();} });
            el.appendChild(dh);

            el.addEventListener('mousedown', function(e) {
                // In interact mode, let child element handle events
                if (el.dataset.interactMode === 'true') return;
                // Skip handle clicks
                if (hasClass(e.target, 'resize-handle') || hasClass(e.target, 'delete-handle')) return;
                if (e.target.closest && e.target.closest('.screen-overlay')) return;
                selectEl(el); dragStart(e, el);
            });
            rh.addEventListener('mousedown', function(e) { e.stopPropagation(); selectEl(el); resizeStart(e, el); });

            // Double-click to toggle interact mode (only for div-based UI elements, not SVGs)
            el.addEventListener('dblclick', function(e) {
                e.stopPropagation();
                window.toggleInteract(el);
            });

            inner.appendChild(el); elements.push(el); selectEl(el);
            return el;
        }

        window.toggleInteract = function(el) {
            if (!el || el.dataset.elType !== 'decor') return;
            const child = Array.from(el.children).find(c => 
                !hasClass(c, 'resize-handle') && 
                !hasClass(c, 'resize-handle-r') && 
                !hasClass(c, 'resize-handle-b') && 
                !hasClass(c, 'delete-handle') && 
                !hasClass(c, 'interact-badge') &&
                !hasClass(c, 'screen-overlay')
            );
            if (!child) return;
            // Don't enable interact mode for simple SVGs
            const tag = child.tagName ? child.tagName.toLowerCase() : '';
            if (tag === 'svg') return;

            const isInteract = el.dataset.interactMode === 'true';
            const nextMode = !isInteract;
            el.dataset.interactMode = nextMode ? 'true' : 'false';
            el.classList.toggle('interact-mode', nextMode);

            if (nextMode) {
                child.style.removeProperty('pointer-events');
                child.querySelectorAll('*').forEach(c => {
                    c.style.removeProperty('pointer-events');
                    if (c.classList.contains('edit-text')) {
                        c.contentEditable = 'true';
                        c.style.cursor = 'text';
                    }
                });
                
                // --- TOGGLEABLE STATE LOGIC ---
                const uiType = child.dataset.uiType || '';
                if (uiType.includes('toggle') || uiType.includes('checkbox') || uiType.includes('radio')) {
                    child.style.cursor = 'pointer';
                    child.onclick = function(e) { e.stopPropagation();
                        if (uiType.includes('toggle')) {
                            const bar = child; const ball = bar.firstElementChild;
                            const isOn = child.dataset.toggleState !== 'off';
                            if (isOn) {
                                child.dataset.toggleState = 'off';
                                ball.style.setProperty('left', '2px', 'important');
                                ball.style.setProperty('right', 'auto', 'important');
                                bar.style.setProperty('background', '#ccc', 'important');
                                bar.style.setProperty('background-color', '#ccc', 'important');
                            } else {
                                child.dataset.toggleState = 'on';
                                ball.style.setProperty('left', 'auto', 'important');
                                ball.style.setProperty('right', '2px', 'important');
                                bar.style.setProperty('background', '#5b6cf8', 'important');
                                bar.style.setProperty('background-color', '#5b6cf8', 'important');
                            }
                        } else if (uiType.includes('checkbox')) {
                            const box = child; const check = box.firstElementChild;
                            const isChecked = child.dataset.checkState !== 'off';
                            if(isChecked) {
                                child.dataset.checkState = 'off';
                                check.style.display = 'none';
                                box.style.background = 'transparent';
                            } else {
                                child.dataset.checkState = 'on';
                                check.style.display = 'block';
                                box.style.background = '#5b6cf8';
                            }
                        } else if (uiType.includes('radio')) {
                            const circle = child; const dot = circle.firstElementChild;
                            dot.style.display = (dot.style.display === 'none' || dot.style.display === '') ? 'block' : 'none';
                        }
                    };
                }

                let badge = el.querySelector('.interact-badge');
                if (!badge) { badge = document.createElement('div'); badge.className = 'interact-badge'; el.appendChild(badge); }
                badge.textContent = '⚡ Interact Mode — Dbl-click to exit';
            } else {
                child.style.pointerEvents = 'none';
                child.onclick = null;
                child.style.cursor = '';
                child.querySelectorAll('.edit-text').forEach(c => {
                    c.contentEditable = 'false';
                    c.style.cursor = '';
                });
                const badge = el.querySelector('.interact-badge');
                if (badge) badge.remove();
            }
            updateContextToolbar(el);
        };

        window.toggleSelectedInteract = function() {
            if (selectedEl) window.toggleInteract(selectedEl);
        };

        // ===== CONTEXT TOOLBAR LOGIC =====
        const ctBar = document.getElementById('contextToolbar');
        const ctColor = document.getElementById('ctColor');
        
        window.hideContextToolbar = function() { if (ctBar) ctBar.classList.remove('active'); };
        window.updateContextToolbar = function(el) {
            if (!ctBar) return;
            ctBar.classList.add('active');
            
            // Interact button logic
            const btn = document.getElementById('ctInteract');
            const isDecor = el.dataset.elType === 'decor';
            if (btn) {
                btn.style.display = isDecor ? 'flex' : 'none';
                if (isDecor) {
                    const isOn = el.dataset.interactMode === 'true';
                    btn.innerHTML = isOn ? '<i class="fa-solid fa-xmark"></i> Stop Interact' : '<i class="fa-solid fa-bolt"></i> Interact';
                    btn.style.color = isOn ? '#e55' : '#22c55e';
                }
            }

            let child = Array.from(el.children).find(c => !hasClass(c,'resize-handle') && !hasClass(c,'delete-handle') && !hasClass(c,'screen-overlay') && !hasClass(c,'interact-badge'));
            if (el.dataset.elType === 'text') {
                if(child) ctColor.value = rgb2hex(child.style.color);
            } else if (child) {
                ctColor.value = rgb2hex(child.style.backgroundColor || child.style.background);
            }
        };

        if(ctColor) ctColor.addEventListener('input', function() {
            if (!selectedEl) return;
            let child = Array.from(selectedEl.children).find(c => !hasClass(c,'resize-handle') && !hasClass(c,'delete-handle') && !hasClass(c,'screen-overlay') && !hasClass(c,'interact-badge'));
            if (selectedEl.dataset.elType === 'text') {
                if (child) child.style.color = this.value;
                document.getElementById('propColor').value = this.value; 
            } else if (child) {
                if (child.tagName && child.tagName.toLowerCase() === 'svg') {
                    Array.from(child.querySelectorAll('*')).forEach(el => {
                        if (el.hasAttribute('fill') && el.getAttribute('fill') !== 'none' && el.getAttribute('fill') !== '#fff' && el.getAttribute('fill') !== '#ffffff') el.setAttribute('fill', this.value);
                        if (el.style.fill && el.style.fill !== 'none' && el.style.fill !== '#fff' && el.style.fill !== '#ffffff') el.style.fill = this.value;
                        if (el.hasAttribute('stroke') && el.getAttribute('stroke') !== 'none') el.setAttribute('stroke', this.value);
                        if (el.style.stroke && el.style.stroke !== 'none') el.style.stroke = this.value;
                    });
                } else {
                    child.style.background = this.value;
                    child.style.backgroundColor = this.value;
                }
            }
        });

        window.deleteSelected = function() {
            if (selectedEl) { selectedEl.remove(); elements = elements.filter(x=>x!==selectedEl); selectedEl=null; hideTP(); hideContextToolbar(); }
        };
        window.bringToFront = function() {
            if (selectedEl) selectedEl.style.zIndex = maxZ()+1;
        };
        window.flipSelected = function() {
            if (!selectedEl) return;
            let child = Array.from(selectedEl.children).find(c => !hasClass(c,'resize-handle') && !hasClass(c,'delete-handle') && !hasClass(c,'screen-overlay') && !hasClass(c,'interact-badge'));
            if (child) {
                let currentScale = child.style.transform || '';
                if(currentScale.includes('scaleX(-1)')) child.style.transform = currentScale.replace('scaleX(-1)', '');
                else child.style.transform = currentScale + ' scaleX(-1)';
            }
        };
        window.promptRadius = function() {
            if (!selectedEl) return;
            let child = Array.from(selectedEl.children).find(c => !hasClass(c,'resize-handle') && !hasClass(c,'delete-handle') && !hasClass(c,'screen-overlay') && !hasClass(c,'interact-badge'));
            if(child) {
                let r = prompt("Enter border radius (e.g. 50% or 10px):", child.style.borderRadius);
                if(r) child.style.borderRadius = r;
            }
        };
        window.promptLine = function() {
            if (!selectedEl) return;
            let child = Array.from(selectedEl.children).find(c => !hasClass(c,'resize-handle') && !hasClass(c,'delete-handle') && !hasClass(c,'screen-overlay') && !hasClass(c,'interact-badge'));
            if(child) {
                let current = child.style.border || '';
                let border = prompt("Enter border style (e.g. 2px solid #fff):", current);
                if(border !== null) child.style.border = border;
            }
        };
        window.duplicateSelected = function() {
            if (!selectedEl) return;
            const x = parseInt(selectedEl.style.left) + 40;
            const y = parseInt(selectedEl.style.top) + 40;
            const w = parseInt(selectedEl.style.width);
            const h = selectedEl.style.height ? parseInt(selectedEl.style.height) : null;
            const type = selectedEl.dataset.elType;
            
            const newEl = makeDrag(x, y, w, h, type);
            
            // Clone content children (excluding handles)
            Array.from(selectedEl.children).forEach(child => {
                if (!hasClass(child, 'resize-handle') && 
                    !hasClass(child, 'resize-handle-r') && 
                    !hasClass(child, 'resize-handle-b') && 
                    !hasClass(child, 'delete-handle') &&
                    !hasClass(child, 'interact-badge')) {
                    
                    const clone = child.cloneNode(true);
                    newEl.appendChild(clone);
                    
                    // If it's text, we need to re-attach the dblclick if needed, 
                    // but since makeText handles it, and we are cloning the inner div...
                    // actually makeDrag/makeText are factory functions. 
                    // Cloning a node doesn't copy event listeners.
                    // But for our Studio, text editing is handled via dblclick on the .text-element.
                    // Let's re-apply text-specific logic if it's a text element.
                }
            });

            if (type === 'text') {
                const td = newEl.querySelector('.text-element');
                if (td) {
                    td.addEventListener('dblclick', function(e) {
                        e.stopPropagation();
                        td.contentEditable = 'true';
                        td.focus();
                        const range = document.createRange();
                        range.selectNodeContents(td);
                        const sel = window.getSelection();
                        sel.removeAllRanges();
                        sel.addRange(range);
                    });
                    td.addEventListener('blur', () => { td.contentEditable = 'false'; });
                    td.addEventListener('mousedown', (e) => { if (td.contentEditable === 'true') e.stopPropagation(); });
                }
            } else if (newEl.querySelector('.screen-overlay')) {
                // Re-bind device camera click
                const scr = newEl.querySelector('.screen');
                const ov = newEl.querySelector('.screen-overlay');
                if (scr && ov) {
                    ov.addEventListener('mousedown', e => e.stopPropagation());
                    ov.addEventListener('click', e => {
                        e.stopPropagation();
                        devicePendingChange = scr;
                        deviceChangeInput.click();
                    });
                }
            }
            
            selectEl(newEl);
        };

        function selectEl(el) {
            if (selectedEl) selectedEl.classList.remove('selected');
            selectedEl = el; el.classList.add('selected');
            el.style.zIndex = maxZ()+1;
            if (el.dataset.elType==='text') showTP(el); else hideTP();
            updateContextToolbar(el);
        }
        function maxZ() { let m=1; elements.forEach(e=>{const z=parseInt(e.style.zIndex||1);if(z>m)m=z;}); return m; }

        inner.addEventListener('mousedown', function(e) {
            if (e.target === inner || e.target.closest('.empty-state') || e.target.closest('.bg-image-layer') || e.target.closest('.bg-overlay-layer')) {
                if (selectedEl) { selectedEl.classList.remove('selected'); selectedEl=null; hideTP(); hideContextToolbar(); }
            }
        });

        function dragStart(e, el) {
            e.preventDefault();
            const sx=e.clientX, sy=e.clientY, ol=parseInt(el.style.left), ot=parseInt(el.style.top);
            const gv = document.getElementById('guide-v');
            const gh = document.getElementById('guide-h');
            
            function mv(ev) {
                let nl = ol + (ev.clientX - sx) / scale;
                let nt = ot + (ev.clientY - sy) / scale;
                
                const ew = el.offsetWidth, eh = el.offsetHeight;
                const ecx = nl + ew / 2;
                const ecy = nt + eh / 2;
                const acx = artW / 2;
                const acy = artH / 2;
                const snap = 10;

                // Vertical Center Snap/Guide
                if (Math.abs(ecx - acx) < snap) {
                    nl = acx - ew / 2;
                    if (gv) gv.style.display = 'block';
                } else { if (gv) gv.style.display = 'none'; }

                // Horizontal Center Snap/Guide
                if (Math.abs(ecy - acy) < snap) {
                    nt = acy - eh / 2;
                    if (gh) gh.style.display = 'block';
                } else { if (gh) gh.style.display = 'none'; }

                el.style.left = nl + 'px'; el.style.top = nt + 'px';
            }
            function up() { 
                if (gv) gv.style.display = 'none';
                if (gh) gh.style.display = 'none';
                document.removeEventListener('mousemove',mv); document.removeEventListener('mouseup',up); 
            }
            document.addEventListener('mousemove',mv); document.addEventListener('mouseup',up);
        }
        
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
        function resizeStart(e, el) {
            e.preventDefault();
            const sx=e.clientX, ow=el.offsetWidth, oh=el.offsetHeight, ratio=ow/(oh||1);
            function mv(ev) {
                const dx=(ev.clientX-sx)/scale;
                if (el.dataset.elType==='device'||el.dataset.elType==='decor') {
                    const nw=Math.max(100,ow+dx); el.style.width=nw+'px'; el.style.height=(nw/ratio)+'px';
                } else { el.style.width=Math.max(80,ow+dx)+'px'; }
            }
            function up() { document.removeEventListener('mousemove',mv); document.removeEventListener('mouseup',up); }
            document.addEventListener('mousemove',mv); document.addEventListener('mouseup',up);
        }

        // ===== CLEAR =====
        window.clearAll = function() {
            Swal.fire({ title:'Clear everything?', icon:'warning', showCancelButton:true, confirmButtonColor:'#e55', confirmButtonText:'Clear' })
            .then(r=>{ if(r.isConfirmed) clearAllSilent(); });
        };
        function clearAllSilent() {
            elements.forEach(e=>e.remove()); elements=[]; selectedEl=null; hideTP();
            bgImageLayer.style.backgroundImage=''; bgImageLayer.style.filter=''; bgImageLayer.style.transform='';
            bgOverlayLayer.style.background='linear-gradient(160deg, rgba(232,213,196,0.9), rgba(160,128,104,0.95))';
            emptyHint.style.display='flex';
        }

        
        window.addCustomElement = function(domNode, typeName) {
            const cx = artW/2, cy = artH/2;
            let clone = null;
            Array.from(domNode.children).forEach(c => {
                if(!c.classList.contains('el-label')) clone = c.cloneNode(true);
            });
            if(!clone) clone = domNode.cloneNode(true);

            const name = (domNode.dataset.name || '').toLowerCase();
            clone.dataset.uiType = name;

            if (clone.tagName && clone.tagName.toLowerCase() === 'svg') {
                clone.style.width = '100%';
                clone.style.height = '100%';
                clone.style.display = 'block';
                clone.style.overflow = 'visible';
                clone.style.pointerEvents = 'none';
                if (!clone.getAttribute('preserveAspectRatio')) {
                    clone.setAttribute('preserveAspectRatio', 'xMidYMid meet');
                }
                const el = makeDrag(cx-80, cy-80, 160, 160, 'decor');
                el.style.overflow = 'visible';
                el.appendChild(clone);
            } else {
                let canvasW = 300, canvasH = 48;

                if (name.includes('progress'))        { canvasW = 380; canvasH = 24; }
                else if (name.includes('toggle'))     { canvasW = 86;  canvasH = 48; }
                else if (name.includes('checkbox'))   { canvasW = 48;  canvasH = 48; }
                else if (name.includes('radio'))      { canvasW = 48;  canvasH = 48; }
                else if (name.includes('slider'))     { canvasW = 360; canvasH = 40; }
                else if (name.includes('button'))     { canvasW = 200; canvasH = 60; }
                else if (name.includes('input') || name.includes('field')) { canvasW = 340; canvasH = 60; }
                else if (name.includes('dropdown') || name.includes('select')) { canvasW = 240; canvasH = 54; }
                else if (name.includes('card'))       { canvasW = 360; canvasH = 240; }
                else if (name.includes('badge') || name.includes('tag')) { canvasW = 140; canvasH = 48; }
                else if (name.includes('avatar'))     { canvasW = 100; canvasH = 100; }
                else if (name.includes('search bar')) { canvasW = 400; canvasH = 64; }
                else if (name.includes('nav') || name.includes('bar')) { canvasW = 460; canvasH = 60; }
                else if (name.includes('notification')) { canvasW = 380; canvasH = 90; }
                else if (name.includes('rating'))     { canvasW = 240; canvasH = 48; }
                else if (name.includes('chart'))      { canvasW = 400; canvasH = 300; }

                const origNode = Array.from(domNode.children).find(c => !c.classList.contains('el-label')) || domNode;
                let naturalW = origNode.offsetWidth, naturalH = origNode.offsetHeight;
                if (!naturalW || !naturalH) {
                    const rect = origNode.getBoundingClientRect();
                    naturalW = rect.width || 100; naturalH = rect.height || 40;
                }
                
                const scaleX = canvasW / naturalW, scaleY = canvasH / naturalH;
                const scaleFactor = Math.min(scaleX, scaleY);
                const allEls = [clone, ...clone.querySelectorAll('*')];
                const pxProps = ['fontSize','padding','paddingTop','paddingBottom','paddingLeft','paddingRight','borderRadius','borderWidth','gap','lineHeight','letterSpacing','top','bottom','left','right'];

                allEls.forEach(c => {
                    if (!c.style) return;
                    pxProps.forEach(p => {
                        if (c.style[p] && typeof c.style[p] === 'string' && c.style[p].includes('px')) {
                            c.style[p] = c.style[p].split(' ').map(part => part.includes('px') ? (parseFloat(part) * scaleFactor) + 'px' : part).join(' ');
                        }
                    });
                    if (c !== clone) {
                        if (c.style.width && c.style.width.includes('px')) c.style.width = (parseFloat(c.style.width) * scaleFactor) + 'px';
                        if (c.style.height && c.style.height.includes('px')) c.style.height = (parseFloat(c.style.height) * scaleFactor) + 'px';
                    }
                });

                clone.style.width = '100%'; clone.style.height = '100%';
                clone.style.pointerEvents = 'none';
                clone.style.display = 'flex'; clone.style.alignItems = 'center'; clone.style.justifyContent = 'center';
                clone.style.boxSizing = 'border-box';

                const el = makeDrag(cx - canvasW/2, cy - canvasH/2, canvasW, canvasH, 'decor');
                el.appendChild(clone);
                el.dataset.hasInteractiveContent = 'true';

                // --- INJECT INTERACTIVE LOGIC ---
                // Progress Bar Interaction
                if (name.includes('progress')) {
                    clone.addEventListener('click', () => {
                        const val = prompt("Enter progress percentage (0-100):", "65");
                        if (val !== null) {
                            const bar = clone.querySelector('div > div');
                            if (bar) bar.style.width = Math.min(100, Math.max(0, parseInt(val))) + '%';
                        }
                    });
                }
                // Toggle Switch Interaction
                else if (name.includes('toggle')) {
                    clone.addEventListener('click', () => {
                        const bg = clone.querySelector('div');
                        const knob = bg ? bg.querySelector('div') : null;
                        if (bg && knob) {
                            const isOn = bg.style.backgroundColor === 'rgb(91, 108, 248)' || bg.style.background === 'rgb(91, 108, 248)';
                            bg.style.background = isOn ? '#ccc' : '#5b6cf8';
                            bg.style.backgroundColor = isOn ? '#ccc' : '#5b6cf8';
                            knob.style.left = isOn ? '2px' : 'auto';
                            knob.style.right = isOn ? 'auto' : '2px';
                        }
                    });
                }
                // Checkbox Interaction
                else if (name.includes('checkbox')) {
                    clone.addEventListener('click', () => {
                        const box = clone.querySelector('div');
                        const svg = box ? box.querySelector('svg') : null;
                        if (box && svg) {
                            const isChecked = box.style.background === 'rgb(91, 108, 248)' || box.style.backgroundColor === 'rgb(91, 108, 248)';
                            box.style.background = isChecked ? 'transparent' : '#5b6cf8';
                            box.style.backgroundColor = isChecked ? 'transparent' : '#5b6cf8';
                            svg.style.display = isChecked ? 'none' : 'block';
                        }
                    });
                }
                // Chart Interaction (Simple proof of concept)
                else if (name.includes('chart')) {
                    clone.addEventListener('click', (e) => {
                        const bar = e.target.closest('div');
                        if (bar && bar !== clone && bar.style.height.includes('%')) {
                            const val = prompt("Enter new height percentage (0-100):", parseInt(bar.style.height));
                            if (val !== null) bar.style.height = Math.min(100, Math.max(10, parseInt(val))) + '%';
                        }
                    });
                }
                // Radio Interaction
                else if (name.includes('radio')) {
                    clone.addEventListener('click', () => {
                        const box = clone.querySelector('div');
                        const dot = box ? box.querySelector('div') : null;
                        if (box && dot) {
                            const isOn = box.style.background === 'rgb(91, 108, 248)' || box.style.backgroundColor === 'rgb(91, 108, 248)';
                            box.style.borderColor = isOn ? '#ccc' : '#5b6cf8';
                            dot.style.display = isOn ? 'none' : 'block';
                            // Just a visual toggle for now
                        }
                    });
                }
                // Slider Interaction
                else if (name.includes('slider')) {
                    clone.addEventListener('click', () => {
                        const val = prompt("Enter slider percentage (0-100):", "55");
                        if (val !== null) {
                            const pct = Math.min(100, Math.max(0, parseInt(val)));
                            const fill = clone.querySelector('div > div:first-child');
                            const thumb = clone.querySelector('div > div:last-child');
                            if (fill) fill.style.width = pct + '%';
                            if (thumb) thumb.style.left = `calc(${pct}% - ${thumb.offsetWidth/2}px)`;
                        }
                    });
                }
                // Generic Text Input / Button content editing
                else if (name.includes('button') || name.includes('input') || name.includes('label')) {
                    clone.addEventListener('click', () => {
                        const val = prompt("Edit content:", clone.innerText.trim());
                        if (val !== null) {
                           const target = Array.from(clone.querySelectorAll('*')).find(c => c.innerText.trim() === clone.innerText.trim()) || clone;
                           target.innerText = val;
                        }
                    });
                }
            }
            emptyHint.style.display = 'none';
        };

        window.handleElClick = function(e) {
            const el = e.currentTarget;
            let name = el.dataset.name || el.innerText.trim().toLowerCase();
            
            if (name.includes('imac') && name.includes('frame')) { window.addSingleDevice('imac'); return; }
            if (name.includes('laptop') && name.includes('frame')) { window.addSingleDevice('macbook'); return; }
            if (name.includes('ipad') && name.includes('frame')) { window.addSingleDevice('ipad'); return; }
            if (name.includes('phone') && name.includes('frame')) { window.addSingleDevice('iphone'); return; }
            
            if (name === 'circle') { window.addElement('circle'); return; }
            if (name === 'square') { window.addElement('square'); return; }
            if (name.includes('blob')) { window.addElement('blob'); return; }
            if (name.includes('search bar')) { window.addElement('search_bar'); return; }
            
            addCustomElement(el, name);
        };
        
        window.switchElTab = function(el, cat) {
            document.querySelectorAll("#tab-elements .tab").forEach(t => t.classList.remove("active"));
            el.classList.add("active");
            const sections = document.querySelectorAll("#panel-body .section, #panel-body .divider");
            if (cat === "all") {
                sections.forEach(s => s.style.display = "");
            } else {
                document.querySelectorAll("#panel-body .section").forEach(s => { s.style.display = s.dataset.cat === cat ? "" : "none"; });
                document.querySelectorAll("#panel-body .divider").forEach(d => d.style.display = "none");
            }
        };

        window.filterElements = function(q) {
            const term = q.toLowerCase().trim();
            const clearBtn = document.getElementById("el-clear-btn");
            if(clearBtn) clearBtn.style.display = q ? "block" : "none";
            
            document.querySelectorAll("#tab-elements .el, #tab-elements .el-row").forEach(el => {
                const name = (el.dataset.name || "").toLowerCase();
                el.style.display = name.includes(term) ? "" : "none";
            });
            document.querySelectorAll("#tab-elements .badge").forEach(b => {
                const text = b.innerText.toLowerCase();
                b.style.display = text.includes(term) ? "" : "none";
            });
        };
        window.clearElSearch = function() {
            const s = document.getElementById("searchElementsInput");
            if(s) { s.value = ""; filterElements(""); }
        };

        // ===== EXPORT =====
        window.exportDesign = function() {
            if (selectedEl) { selectedEl.classList.remove('selected'); selectedEl=null; }
            hideTP(); emptyHint.style.display='none';
            inner.querySelectorAll('.screen-overlay').forEach(o=>o.style.display='none');
            inner.querySelectorAll('.resize-handle,.delete-handle').forEach(h=>h.style.display='none');
            // Remove selection outlines
            inner.querySelectorAll('.drag-el').forEach(el => el.style.outline = 'none');

            const ot=inner.style.transform, ow=artboard.style.width, oh=artboard.style.height;
            inner.style.transform='none'; artboard.style.width=artW+'px'; artboard.style.height=artH+'px';

            html2canvas(inner, { width:artW, height:artH, scale:2, useCORS:true, backgroundColor:null })
            .then(c => {
                inner.style.transform=ot; artboard.style.width=ow; artboard.style.height=oh;
                inner.querySelectorAll('.screen-overlay').forEach(o=>o.style.display='');
                inner.querySelectorAll('.resize-handle,.delete-handle').forEach(h=>h.style.display='');
                inner.querySelectorAll('.drag-el').forEach(el => el.style.outline = '');

                const link=document.createElement('a');
                link.download=`VastraKala-Post-${Date.now()}.png`;
                link.href=c.toDataURL('image/png',1.0); link.click();
                Swal.fire({icon:'success',title:'Exported!',text:'Your professional post is ready.',confirmButtonColor:'#7E635A'});
            }).catch(err => {
                inner.style.transform=ot; artboard.style.width=ow; artboard.style.height=oh;
                inner.querySelectorAll('.screen-overlay').forEach(o=>o.style.display='');
                inner.querySelectorAll('.resize-handle,.delete-handle').forEach(h=>h.style.display='');
                inner.querySelectorAll('.drag-el').forEach(el => el.style.outline = '');
                Swal.fire({icon:'error',title:'Export Failed',text:err.message,confirmButtonColor:'#7E635A'});
            });
        };

        // Keyboard
        document.addEventListener('keydown', function(e) {
            if (!selectedEl || e.target.contentEditable==='true') return;
            if (e.key==='Delete'||e.key==='Backspace') {
                selectedEl.remove(); elements=elements.filter(el=>el!==selectedEl);
                selectedEl=null; hideTP();
            }
        });

        window.addEventListener('resize', doResize);
        doResize();
    })();
    </script>
    @endpush
</x-app-layout>
