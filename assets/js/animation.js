/* 动画效果相关JavaScript */

// 页面加载动画
document.addEventListener('DOMContentLoaded', function() {
    initPageAnimations();
    initTimelineAnimation();
    initCountUpAnimation();
    initParallaxEffects();
    initHoverEffects();
});

// 初始化页面动画
function initPageAnimations() {
    // 淡入动画
    const fadeElements = document.querySelectorAll('.fade-in-up');
    
    fadeElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
    });
    
    // 页面横幅动画
    const banner = document.querySelector('.page-banner');
    if (banner) {
        banner.classList.add('animate-banner');
    }
}

// 时间线动画
function initTimelineAnimation() {
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-timeline');
            }
        });
    }, {
        threshold: 0.3
    });
    
    timelineItems.forEach(item => {
        timelineObserver.observe(item);
    });
}

// 数字计数动画
function initCountUpAnimation() {
    const counters = document.querySelectorAll('.counter');
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    });
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
}

// 计数器动画函数
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000; // 动画持续时间
    const step = target / (duration / 16); // 每帧增长量
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// 视差滚动效果
function initParallaxEffects() {
    const parallaxElements = document.querySelectorAll('.parallax');
    
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', throttle(() => {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const rate = scrolled * -0.5;
                element.style.transform = `translate3d(0, ${rate}px, 0)`;
            });
        }, 10));
    }
}

// 悬停效果
function initHoverEffects() {
    // 卡片悬停效果
    const cards = document.querySelectorAll('.feature-card, .news-card, .advisor-card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        });
    });
    
    // 按钮波纹效果
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

// 文字打字机效果
function typeWriter(element, text, speed = 50) {
    let i = 0;
    element.innerHTML = '';
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// 滚动进度条
function initScrollProgress() {
    const progressBar = document.querySelector('.scroll-progress');
    
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            progressBar.style.width = scrolled + '%';
        });
    }
}

// 粒子背景效果（可选）
function initParticleBackground() {
    const canvas = document.getElementById('particle-canvas');
    
    if (canvas) {
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        
        const particles = [];
        const particleCount = 50;
        
        // 创建粒子
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5) * 2,
                vy: (Math.random() - 0.5) * 2,
                size: Math.random() * 3 + 1
            });
        }
        
        // 动画循环
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            particles.forEach(particle => {
                particle.x += particle.vx;
                particle.y += particle.vy;
                
                // 边界检测
                if (particle.x < 0 || particle.x > canvas.width) particle.vx *= -1;
                if (particle.y < 0 || particle.y > canvas.height) particle.vy *= -1;
                
                // 绘制粒子
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(139, 38, 53, 0.3)';
                ctx.fill();
            });
            
            requestAnimationFrame(animate);
        }
        
        animate();
        
        // 窗口大小改变时重新调整画布
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    }
}

// 图片懒加载
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => {
        imageObserver.observe(img);
    });
}

// 滚动触发的CSS动画类
const scrollAnimationClasses = {
    fadeInUp: 'animate__fadeInUp',
    fadeInLeft: 'animate__fadeInLeft',
    fadeInRight: 'animate__fadeInRight',
    zoomIn: 'animate__zoomIn',
    slideInUp: 'animate__slideInUp'
};

// 为元素添加滚动动画
function addScrollAnimation(element, animationType) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', scrollAnimationClasses[animationType]);
                observer.unobserve(entry.target);
            }
        });
    });
    
    observer.observe(element);
}

// 页面滚动时的导航栏高亮
function initNavHighlight() {
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');
    
    window.addEventListener('scroll', () => {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (window.scrollY >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
}

// 工具函数：缓动函数
const easing = {
    easeInOut: t => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t,
    easeOut: t => t * (2 - t),
    easeIn: t => t * t
};

// 自定义滚动动画
function smoothScrollTo(target, duration = 800) {
    const start = window.pageYOffset;
    const distance = target - start;
    let startTime = null;
    
    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1);
        
        window.scrollTo(0, start + distance * easing.easeInOut(progress));
        
        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }
    
    requestAnimationFrame(animation);
}