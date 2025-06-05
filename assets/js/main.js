/* 主要JavaScript逻辑 */

// DOM加载完成后执行
document.addEventListener('DOMContentLoaded', function() {
    // 初始化所有功能
    initNavbar();
    initBackToTop();
    initScrollAnimations();
    initMobileMenu();
    initSmoothScroll();
});

// 导航栏滚动效果
function initNavbar() {
    const navbar = document.getElementById('navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
}

// 移动端菜单切换
function initMobileMenu() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // 切换汉堡菜单图标
            const icon = this.querySelector('span');
            if (navMenu.classList.contains('active')) {
                icon.innerHTML = '✕';
            } else {
                icon.innerHTML = '☰';
            }
        });
        
        // 点击菜单项后关闭移动端菜单
        const navLinks = navMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                mobileMenuToggle.querySelector('span').innerHTML = '☰';
            });
        });
        
        // 点击外部区域关闭菜单
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                mobileMenuToggle.querySelector('span').innerHTML = '☰';
            }
        });
    }
}

// 回到顶部按钮
function initBackToTop() {
    const backToTop = document.getElementById('back-to-top');
    
    if (backToTop) {
        // 显示/隐藏回到顶部按钮
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        // 点击回到顶部
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// 平滑滚动
function initSmoothScroll() {
    // 为所有内部链接添加平滑滚动
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 80; // 考虑固定导航栏高度
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// 滚动动画
function initScrollAnimations() {
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    // 创建交叉观察器
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // 观察所有需要动画的元素
    animateElements.forEach(element => {
        observer.observe(element);
    });
    
    // 为所有section添加滚动动画类
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.add('animate-on-scroll');
        observer.observe(section);
    });
}

// 防抖函数
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// 节流函数
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// 工具函数：获取元素距离顶部的偏移量
function getOffset(element) {
    let offsetTop = 0;
    while (element) {
        offsetTop += element.offsetTop;
        element = element.offsetParent;
    }
    return offsetTop;
}

// 工具函数：检查元素是否在视口中
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// 页面加载进度条（可选）
function initLoadingProgress() {
    const progressBar = document.querySelector('.loading-progress');
    
    if (progressBar) {
        window.addEventListener('load', function() {
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressBar.style.opacity = '0';
                setTimeout(() => {
                    progressBar.remove();
                }, 300);
            }, 200);
        });
    }
}

// 错误处理
window.addEventListener('error', function(e) {
    console.error('JavaScript错误:', e.error);
});

// 控制台欢迎信息
console.log(`
%c武汉大学创新发明与技术实践协会
%c欢迎访问我们的官网！
如果你对技术开发感兴趣，欢迎加入我们！
`, 
'color: #8B2635; font-size: 16px; font-weight: bold;',
'color: #D4AF37; font-size: 14px;'
);