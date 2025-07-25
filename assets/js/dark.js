(function ($) {
    class DarkModeManager {
        constructor() {
            this.storageKey = 'preferred-color-scheme';
            this.attrName = 'data-theme';
            this.rootElement = document.documentElement;
            this.debounceTimer = null;
            this.init();
        }
        init() {
            this.initMenuPosition();
            this.bindEvents();
            this.applyStoredMode();
            this.watchSystemTheme();
        }
        initMenuPosition() {
            const $toggle = $('.dark-adjust');
            const $menu = $('#darkModeMenu');
            if ($toggle.length && $menu.length) {
                const toggleRect = $toggle[0].getBoundingClientRect();
                const menuWidth = $menu.outerWidth();
                $menu.css({
                    top: toggleRect.bottom + 5, 
                    left: toggleRect.right - menuWidth,
                    right: 'auto' 
                });
            }
        }
        bindEvents() {
            const $toggle = $('.dark-adjust');
            const $menu = $('#darkModeMenu');
            const $items = $('.dark-mode-menu-item');
            $toggle.on('click.darkMode', (e) => {
                e.preventDefault();
                e.stopPropagation();
                $menu.toggleClass('is-active');
                this.initMenuPosition();
            });
            $items.on('click.darkMode', (e) => {
                e.preventDefault();
                const mode = $(e.currentTarget).attr('data-mode');
                if (mode === this.getCurrentMode()) {
                    this.hideMenu();
                    return;
                }
                this.applyMode(mode);
                this.hideMenu();
            });
            $(document).on('click.darkMode', (e) => {
                if (!$menu[0]?.contains(e.target) && !$toggle[0]?.contains(e.target)) {
                    this.hideMenu();
                }
            });
            $(document).on('keydown.darkMode', (e) => {
                if (e.key === 'Escape') {
                    this.hideMenu();
                }
            });
            $(window).on('resize.darkMode', () => {
                if (this.debounceTimer) clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => {
                    if (!$('#darkModeMenu').hasClass('is-active')) {
                        this.initMenuPosition();
                    }
                }, 100);
            });
        }
        updateMenuActiveState() {
            const currentMode = this.getCurrentMode();
            const $items = $('.dark-mode-menu-item');

            $items.removeClass('is-active');
            $items.filter(`[data-mode="${currentMode}"]`).addClass('is-active');
        }
        hideMenu() {
            $('#darkModeMenu').removeClass('is-active');
            this.updateMenuActiveState();
        }
        getCurrentMode() {
            const saved = localStorage.getItem(this.storageKey);
            return ['dark', 'light'].includes(saved) ? saved : 'auto';
        }
        switchMode(mode) {
            this.simulateColorScheme(mode);
            this.switchHighlightTheme(mode);
            this.switchNavbarImages(mode);
            this.reloadTurnstile();
        }
        applyMode(mode) {
            if (mode === 'auto') {
                localStorage.removeItem(this.storageKey);
                this.applySystemMode();
            } else {
                this.rootElement.setAttribute(this.attrName, mode);
                localStorage.setItem(this.storageKey, mode);
                this.switchMode(mode);
            }
            this.updateMenuActiveState();
        }
        applyStoredMode() {
            const saved = this.getCurrentMode();
            if (saved === 'dark' || saved === 'light') {
                this.rootElement.setAttribute(this.attrName, saved);
                this.switchMode(saved);
            } else {
                this.applySystemMode();
            }
            this.updateMenuActiveState();
        }
        applySystemMode() {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const mode = prefersDark ? 'dark' : 'light';
            this.rootElement.setAttribute(this.attrName, mode);
            this.switchMode(mode);
            this.updateMenuActiveState();
        }
        switchHighlightTheme(mode) {
            let href;
            if (mode === "auto") {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    mode = 'dark';
                } else {
                    mode = 'light';
                }
            }
            if (mode === 'dark') href = window.DARK_MODE_CONFIG?.highlightDarkTheme;
            else if (mode === 'light') href = window.DARK_MODE_CONFIG?.highlightLightTheme;
            if (!href) return;
            const $link = $('link[rel="stylesheet"][href*="highlight.js"][href*="styles"]');
            if ($link.length) $link.attr('href', href);
        }
        switchNavbarImages(mode) {
            if (!window.DARK_MODE_CONFIG?.hasLogos) {
                return;
            }
            const { lightSrc, darkSrc } = window.DARK_MODE_CONFIG;
            if (!lightSrc || !darkSrc) return;
            $('img').each((index, img) => {
                const $img = $(img);
                const currentSrc = $img.attr('src');
                if (mode === 'dark' && currentSrc === lightSrc) {
                    $img.attr('src', darkSrc);
                } else if (mode !== 'dark' && currentSrc === darkSrc) {
                    $img.attr('src', lightSrc);
                }
            });
        }
        reloadTurnstile() {
            if (typeof window.onloadTurnstileCallback === 'function') {
                window.onloadTurnstileCallback();
            }
        }
        getDarkModeCSS() {
            return `
:root {
  --dm-bg-surface-deep: #1a1d23; 
  --dm-bg-code: #1e222a;   
  --dm-bg-menu: #1f232c;  
  --dm-bg-primary: #23272f;   
  --dm-bg-inset: #303540;     
  --dm-bg-interactive: #414854;     
  --dm-bg-interactive-hover: #525966; 
  --dm-bg-scrollbar-track: #121212;   
  --dm-text-bright: #f0f0f0;   
  --dm-text-primary: #e0e0e0;    
  --dm-text-secondary: #b8b8b8;  
  --dm-text-tertiary: #8a919e;   
  --dm-text-menu: #e8e8e8;       
  --dm-text-menu-item: #d8d8d8;   
  --dm-border-medium: #4f5663;  
  --dm-border-menu: #4f5663;    
  --dm-border-strong: #4f5663;  
  --dm-border-strong-hover: #606875;
  --dm-accent-primary: #66b3ff;
  --dm-accent-primary-hover: #99ccff;
  --dm-accent-primary-active: #5599dd;
  --dm-accent-secondary-hover: #38bdf8;
  --dm-accent-link-bg: #005bbb;
  --dm-accent-link-bg-hover: #004a99;
  --dm-accent-link-bg-active: #003d7a;
  --dm-accent-el-primary-bg: #0066cc;
  --dm-accent-el-primary-bg-hover: #005bb5;
  --dm-semantic-info-border: #4c6faf;
  --dm-semantic-primary-bg: #1a2a44;
  --dm-semantic-primary-border: #4d90fe;
  --dm-semantic-primary-text: #aaccff;
  --dm-semantic-danger-bg: #3a1f1f;
  --dm-semantic-danger-border: #ff5c5c;
  --dm-semantic-danger-text: #ffcccc;
  --dm-semantic-warning-bg: #3a311f; 
  --dm-semantic-warning-border: #ffd36e;
  --dm-semantic-warning-text: #ffe6aa;
  --dm-semantic-error-bg: #4d2d2d;
  --dm-semantic-error-text: #ff6666;
  --dm-syntax-code: #ffb86c;
  --dm-shadow-card: rgba(0, 0, 0, 0.4); 
  --dm-shadow-focus: rgba(102, 179, 255, 0.25);
  --dm-overlay-heavy: rgba(20, 22, 28, 0.95); 
  --dm-overlay-light: rgba(20, 22, 28, 0.8); 
  --dm-overlay-white-light: rgba(255, 255, 255, 0.05);
  --dm-overlay-white-medium: rgba(255, 255, 255, 0.08);
  --dm-button-white-bg: #2a2a2a;
  --dm-button-white-border: #1d1d1d;
  --dm-scrollbar-thumb: #888888;
  --dm-scrollbar-thumb-hover: #aaaaaa;
  --dm-kbd-bg: var(--dm-bg-inset); 
  --dm-kbd-border: var(--dm-border-medium); 
  --dm-scrollbar-track: #121212;
}
body{background-color:var(--dm-bg-primary) !important;color:var(--dm-text-primary) !important}
.section{background-color:var(--dm-bg-primary) !important}
.card{background-color:var(--dm-bg-surface-deep) !important;border-color:var(--dm-border-medium) !important;box-shadow:0 2px 8px var(--dm-shadow-card) !important}
.card-content{background-color:var(--dm-bg-surface-deep) !important;color:var(--dm-text-primary) !important}
.navbar{background-color:var(--dm-bg-surface-deep) !important;border-bottom-color:var(--dm-border-medium) !important}
.navbar-item{color:var(--dm-text-primary) !important;background-color:transparent !important}
.navbar-item:hover{background-color:var(--dm-bg-interactive) !important;color:var(--dm-text-bright) !important}
.navbar-item:focus{background-color:var(--dm-bg-interactive) !important;color:var(--dm-text-bright) !important;outline:none !important}
.navbar-item:active{background-color:var(--dm-bg-inset) !important;color:var(--dm-text-bright) !important}
.navbar-item:not(:hover):not(:focus):not(:active){background-color:transparent !important;color:var(--dm-text-primary) !important}
.navbar-brand a.navbar-item:focus,.navbar-brand a.navbar-item:hover{background-color:transparent !important}
.title{color:var(--dm-text-bright) !important}
.subtitle{color:var(--dm-text-secondary) !important}
.content{color:var(--dm-text-primary) !important}
.content h1,.content h2,.content h3,.content h4,.content h5,.content h6{color:var(--dm-text-bright) !important}
.content p,.content strong,.content table thead td,.content table thead th{color:var(--dm-text-primary) !important}
a{color:var(--dm-accent-primary)}
a:hover{color:var(--dm-accent-primary-hover)}
.has-link-grey{color:var(--dm-text-secondary) !important}
.has-link-black-ter{color:var(--dm-text-primary) !important}
.has-link-grey:hover,.has-link-black-ter:hover{color:var(--dm-accent-secondary-hover) !important}
.highlight,.highlight-body,.hljs{background-color:var(--dm-bg-code) !important;color:var(--dm-text-primary) !important;border-color:var(--dm-border-medium) !important}
.gutter{background-color:var(--dm-bg-inset) !important;border-right-color:var(--dm-border-medium) !important}
.gutter .line{color:var(--dm-text-tertiary) !important}
blockquote{background-color:var(--dm-bg-inset) !important;border-left:3px solid var(--dm-semantic-info-border) !important;color:var(--dm-text-primary) !important;position:relative}
blockquote::before{content:"“";position:absolute;top:0.3em;left:0.1em;font-size:3em;color:var(--dm-text-tertiary);pointer-events:none}
blockquote::after{content:"”";position:absolute;bottom:-0.2em;right:0.1em;font-size:3em;color:var(--dm-text-tertiary);pointer-events:none}
.el-input__inner,.el-textarea__inner,input,textarea{background-color:var(--dm-bg-inset) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.el-input__inner:focus,.el-textarea__inner:focus,input:focus,textarea:focus{border-color:var(--dm-accent-primary) !important;box-shadow:0 0 0 2px var(--dm-shadow-focus) !important}
.el-input-group__prepend{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.button{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.button:hover{background-color:var(--dm-bg-interactive-hover) !important;border-color:#666666 !important}
.button.is-primary{background-color:var(--dm-accent-primary) !important;border-color:var(--dm-accent-primary) !important;color:var(--dm-text-bright) !important}
.button.is-primary:hover{background-color:var(--dm-accent-primary-active) !important;border-color:var(--dm-accent-primary-active) !important}
.button.is-link{background-color:var(--dm-accent-link-bg) !important;border-color:var(--dm-accent-link-bg-hover) !important;color:var(--dm-text-bright) !important}
.button.is-link:hover{background-color:var(--dm-accent-link-bg-hover) !important;border-color:var(--dm-accent-link-bg-active) !important;color:var(--dm-text-bright) !important}
.button.is-white{background-color:var(--dm-button-white-bg) !important;border-color:#1d1d1d !important;color:var(--dm-text-primary) !important}
.tag{background-color:var(--dm-bg-interactive) !important;color:var(--dm-text-primary) !important}
.widget .tags .tag:first-child{background:var(--dm-accent-link-bg) !important;color:var(--dm-text-bright) !important}
.menu-label{color:var(--dm-text-secondary) !important}
.menu-list a{color:var(--dm-text-primary) !important}
.menu-list a:hover{background-color:var(--dm-bg-interactive) !important;color:var(--dm-text-bright) !important}
.menu-list li ul{border-left-color:var(--dm-border-medium) !important}
.media{border-color:var(--dm-border-medium) !important}
.footer{background-color:var(--dm-bg-surface-deep) !important;border-top-color:var(--dm-border-medium) !important;color:var(--dm-text-secondary) !important}
.searchbox{background-color:rgba(26,26,26,0.95) !important}
.searchbox-container{background-color:var(--dm-bg-surface-deep) !important;border-color:var(--dm-border-medium) !important}
.searchbox-header{background-color:var(--dm-bg-inset) !important;border-bottom-color:var(--dm-border-medium) !important}
.searchbox-input{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.searchbox-input::placeholder{color: var(--dm-text-secondary) !important;opacity: 0.8 !important}
.searchbox-close{color:var(--dm-text-primary) !important}
.searchbox .searchbox-close:hover{background-color:var(--dm-bg-surface-deep) !important}
.searchbox-result-item{color:var(--dm-text-primary) !important;border-bottom-color:var(--dm-border-medium) !important}
.searchbox-result-item:hover{background-color:var(--dm-bg-interactive) !important}
.searchbox-result-title{color:var(--dm-text-bright) !important}
.searchbox-result-preview{color:var(--dm-text-secondary) !important}
.searchbox .searchbox-result-section{border-bottom: 1px solid var(--dm-border-medium) !important}
.searchbox .searchbox-body{border-top: 1px solid var(--dm-border-medium) !important}
.avatar,.profile-avatar{border-color:var(--dm-border-medium) !important;filter:brightness(0.8) saturate(1.25) !important}
img.lazyload{filter:brightness(0.8) saturate(1.25) !important}
.has-text-grey{color:var(--dm-text-secondary) !important}
.has-text-centered,.level,.level-item{color:var(--dm-text-primary) !important}
.donate{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.donate:hover{background-color:var(--dm-bg-interactive-hover) !important;transform:translateY(-2px) !important}
#back-to-top{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
#back-to-top:hover{background-color:var(--dm-bg-interactive-hover) !important}
.MJXp-math{color:var(--dm-text-primary) !important}
.MJXp-merror{background-color:#4d2d2d !important;color:#ff6666 !important;border-color:#ff6666 !important}
#toc-mask{background-color:rgba(26,26,26,0.8) !important}
.article-licensing{background-color:var(--dm-bg-inset) !important;border-color:var(--dm-border-medium) !important;z-index:0 !important}
.article-licensing:after{color:var(--dm-text-bright) !important}
.licensing-title{color:var(--dm-text-bright) !important}
.licensing-meta,time{color:var(--dm-text-secondary) !important}
@media (max-width:768px){.navbar-menu{background-color:var(--dm-bg-surface-deep) !important}
}.el-button{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.el-button:hover{background-color:var(--dm-bg-interactive-hover) !important;border-color:#666666 !important}
.el-button--primary{background-color:#0066cc !important;border-color:#005bb5 !important;color:var(--dm-text-bright) !important}
.el-button--primary:hover{background-color:#005bb5 !important;border-color:#004d99 !important;color:var(--dm-text-bright) !important}
.navbar-menu{background-color:var(--dm-bg-surface-deep) !important}
.dark-mode-menu{background:#1f1f1f;border-color:#444;color:#eee;box-shadow:0 2px 6px rgba(0,0,0,0.4)}
.dark-mode-menu-item{color:#ddd}
.dark-mode-menu-item:hover:not(.is-active){background:rgba(255,255,255,0.05);color: var(--dm-text-bright);}
.dark-mode-menu-item.is-active{background:rgba(255,255,255,0.09);font-weight:600}
.dark-mode-menu-item.is-active .icon{background:transparent;font-weight:600}
.media:last-child:after{background:var(--dm-bg-surface-deep) !important}
code{color:#ffb86c}
.has-text-grey,.article-licensing .licensing-title a{color:var(--dm-text-secondary)}
kbd{background-color:hsl(0deg,0%,20%);border:1px solid hsl(0deg,0%,40%);color:var(--dm-text-primary)}
.message.is-primary{background-color:#1a2a44}
.message.is-primary .message-body{border-color:#4d90fe;color:#aaccff}
.message.message-immersive.is-danger{background-color:#3a1a1a}
.message.message-immersive.is-danger .message-body{border-color:#ff5c5c;color:#ffcccc}
.message.message-immersive.is-warning{background-color:#3a2f1a}
.message.message-immersive.is-warning .message-body{border-color:#ffd36e;color:#ffe6aa}
.pagination{color:var(--dm-text-primary) !important}
.pagination-link{background-color:var(--dm-bg-interactive) !important;border-color:var(--dm-border-strong) !important;color:var(--dm-text-primary) !important}
.pagination-link:hover{background-color:var(--dm-bg-interactive-hover) !important;border-color:#666666 !important;color:var(--dm-text-bright) !important}
.pagination-link.is-current{background-color:var(--dm-accent-link-bg) !important;border-color:var(--dm-accent-link-bg-hover) !important;color:var(--dm-text-bright) !important}
.pagination-link.is-current:hover{background-color:var(--dm-accent-link-bg-hover) !important;border-color:var(--dm-accent-link-bg-active) !important}
.pagination-ellipsis{color:var(--dm-text-secondary) !important}
.pagination-ellipsis.has-text-black-ter{color:var(--dm-text-secondary) !important}
.pagination-link.has-text-black-ter{color:var(--dm-text-primary) !important}
.pagination-link.has-text-black-ter:hover{color:var(--dm-text-bright) !important}
.card-transparent{background-color:transparent !important;box-shadow:none !important}
::-webkit-scrollbar{width:12px;height:12px}
::-webkit-scrollbar-track{background:var(--dm-scrollbar-track)}
::-webkit-scrollbar-thumb{background-color:var(--dm-scrollbar-thumb);border-radius:6px;border:3px solid var(--dm-scrollbar-track)}
::-webkit-scrollbar-thumb:hover{background-color:var(--dm-scrollbar-thumb)}
html{scrollbar-color:var(--dm-scrollbar-thumb) var(--dm-scrollbar-track)}
hr{background-color: var(--dm-border-medium) !important;height:1px !important}
.breadcrumb li a {color: var(--dm-text-secondary) !important}
.breadcrumb li a:hover {color: var(--dm-text-primary) !important}
.breadcrumb li.is-active a {color: var(--dm-text-primary) !important}
`;
        }
        simulateColorScheme(scheme) {
            $('#color-scheme-override').remove();
            if (scheme === 'dark') {
                const $style = $('<style>', {
                    id: 'color-scheme-override',
                    text: this.getDarkModeCSS()
                });
                $('head').append($style);
            }
        }
        watchSystemTheme() {
            this.systemThemeListener = () => {
                if (this.getCurrentMode() === 'auto') {
                    this.applySystemMode();
                }
            };
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', this.systemThemeListener);
        }

        destroy() {
            if (this.debounceTimer) {
                clearTimeout(this.debounceTimer);
                this.debounceTimer = null;
            }
            $('.dark-adjust').off('click');
            $('.dark-mode-menu-item').off('click');
            $(document).off('click.darkMode keydown.darkMode');
            $(window).off('resize.darkMode');
            if (this.systemThemeListener) {
                window.matchMedia('(prefers-color-scheme: dark)').removeEventListener('change', this.systemThemeListener);
            }
            $('#darkModeMenu').removeClass('is-active');
        }
    }
    let darkModeManager = null;
    function initDarkMode() {
        if (darkModeManager) {
            darkModeManager.destroy();
        }
        darkModeManager = new DarkModeManager();
    }
    window.initDarkMode = initDarkMode;
    document.addEventListener('DOMContentLoaded', initDarkMode);
}(jQuery));