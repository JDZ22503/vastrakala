
document.addEventListener('DOMContentLoaded', () => {
    // 0. Create Cursor Glow
    const cursorGlow = document.createElement('div');
    cursorGlow.className = 'cursor-glow';
    document.body.appendChild(cursorGlow);

    document.addEventListener('mousemove', (e) => {
        cursorGlow.style.left = e.clientX + 'px';
        cursorGlow.style.top = e.clientY + 'px';
    });

    // 1. Reveal Elements on Scroll
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const revealOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.01 }); // Very low threshold for mobile reliability

    const animElements = document.querySelectorAll('.section, .card, #order-form, .hero-title, .hero p, .hero .btn-primary, .testimonial-card');
    
    animElements.forEach(el => {
        // Only hide if not already in viewport
        const rect = el.getBoundingClientRect();
        const isInViewport = (rect.top >= 0 && rect.top <= window.innerHeight);
        
        if (!isInViewport) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
        }
        
        el.style.transition = 'all 0.8s cubic-bezier(0.23, 1, 0.32, 1)';
        revealOnScroll.observe(el);
    });

    // Add a helper class for visibility
    const style = document.createElement('style');
    style.innerHTML = `
        .visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        .card { transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease; }
    `;
    document.head.appendChild(style);

    // 2. Parallax Hero Effect
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        
        if (hero) {
            const h1 = hero.querySelector('h1');
            const sparkles = hero.querySelectorAll('.sparkle-icon, .floating');
            
            if (h1 && scrolled < 800) {
                h1.style.transform = `translateY(${scrolled * 0.3}px)`;
                sparkles.forEach((s, i) => {
                    const speed = (i + 1) * 0.1;
                    s.style.transform = `translateY(${scrolled * speed}px)`;
                });
            }
        }
    });

    // 3. Form Handling with Animation
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Subtle button animation
            const btn = orderForm.querySelector('button');
            btn.innerHTML = 'Sending Sparkles... ';
            btn.style.opacity = '0.7';
            
            setTimeout(() => {
                const formData = new FormData(orderForm);
                const data = Object.fromEntries(formData);
                
                orderForm.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                orderForm.style.opacity = '0';
                orderForm.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    orderForm.innerHTML = `
                        <div style="text-align: center; padding: 2rem; animation: fadeIn 1s ease forwards;">
                            <div style="font-size: 5rem; margin-bottom: 1.5rem; animation: float 3s ease-in-out infinite;">🎨</div>
                            <h2 style="margin-bottom: 1rem; color: var(--primary); font-family: var(--font-heading);">Magic is in the air!</h2>
                            <p>Thank you, <b>${data.name}</b>. We've received your request for <b>${data['baby-name']}</b>'s ${data['product-type']}.</p>
                            <p style="margin-top: 1rem; color: var(--text-light);">Talk to you soon on WhatsApp!</p>
                            <button onClick="window.location.reload()" class="btn-primary" style="margin-top: 2.5rem; background: var(--text-dark);">Craft Another One</button>
                        </div>
                    `;
                    orderForm.style.opacity = '1';
                    orderForm.style.transform = 'scale(1)';
                }, 500);
            }, 1000);
        });
    }

    // 4. Smooth Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const navHeight = document.querySelector('nav').offsetHeight;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // 5. Mobile Navigation Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileNav = document.getElementById('mobile-nav');
    const mobileMenuClose = document.getElementById('mobile-menu-close');

    if (mobileMenuBtn && mobileNav) {
        const toggleMenu = () => {
            mobileNav.classList.toggle('active');
        };

        mobileMenuBtn.addEventListener('click', toggleMenu);
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', toggleMenu);
        }

        // Close when clicking any link
        mobileNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('active');
            });
        });
    }

    // 6. Testimonial Swiper Initialization
    if (document.querySelector('.testimonial-swiper')) {
        new Swiper('.testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: false, // Disabling loop for better centering control
            centerInsufficientSlides: true, // This is the key fix
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    }
});
