<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayush Zalavadiya | Android Developer & Creative Designer</title>
    <meta name="description" content="Ayush Zalavadiya | Android Developer & Creative Designer. Explore a portfolio of mobile applications, UI/UX designs, and hand-painted fabric art.">
    <meta name="keywords" content="Ayush Zalavadiya, Android Developer, Flutter, UI/UX Designer, VastraKala, portfolio">
    
    <!-- Open Graph / LinkedIn -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://ayushzalavadiya.me">
    <meta property="og:title" content="Ayush Zalavadiya | Creative Portfolio">
    <meta property="og:description" content="Android developer and creative artist blending technology with art.">
    <meta property="og:image" content="{{ asset('images/web_img.jpg') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap CSS (Optional but helpful for grid) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #AD8B73; /* Terracotta / Clay */
            --primary-light: rgba(173, 139, 115, 0.1);
            --secondary: #FCF8F3; /* Soft Off-White for headers on dark */
            --accent: #D1A392; /* Rose Gold */
            --bg-dark: #0A0F14; /* Deep Charcoal */
            --bg-card: #141A21; /* Slightly lighter for cards */
            --text-main: #FFFFFF;
            --text-muted: #CBD5E1; /* Slate 300 - High contrast for dark */
            --text-dim: #94A3B8; /* Slate 400 */
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        body, html {
            margin: 0;
            padding: 0;
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- Navbar --- */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 0;
            z-index: 1000;
            transition: var(--transition);
            background: transparent;
        }

        nav.scrolled {
            background: rgba(10, 15, 20, 0.9);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            text-decoration: none;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }

        /* Mobile Menu Toggle */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1001;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            font-size: 0.95rem;
            opacity: 0.8;
        }

        .nav-links a:hover {
            color: var(--primary);
            opacity: 1;
        }

        /* --- Hero --- */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
        }

        .hero-content {
            z-index: 2;
        }

        .hero-tag {
            color: var(--primary);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: block;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }

        /* Mobile overrides moved to the end of style section for correct specificity */

        .typewriter {
            height: 1.5em;
            color: var(--primary);
            font-weight: 600;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
        }

        .btn-custom {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom {
            background-color: var(--primary);
            color: #FFFFFF !important;
        }

        .btn-primary-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(173, 139, 115, 0.2);
            color: #FFFFFF !important;
        }

        .btn-outline-custom {
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-main);
        }

        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(61, 220, 132, 0.05);
        }

        /* --- Hero Image --- */
        .hero-img-container {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-img {
            width: 100%;
            height: auto;
            max-width: 450px;
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }

        .hero-img:hover {
            transform: translateY(-10px) rotate(2deg);
            box-shadow: 0 30px 60px rgba(173, 139, 115, 0.15);
            border-color: var(--primary);
        }

        .hero-img-glow {
            position: absolute;
            width: 120%;
            height: 120%;
            background: radial-gradient(circle, rgba(173, 139, 115, 0.1) 0%, transparent 70%);
            z-index: -1;
            filter: blur(40px);
        }

        /* --- Sections --- */
        .section {
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50%;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* --- Cards --- */
        .card-custom {
            background: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            transition: var(--transition);
        }

        .card-custom:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .card-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        p {
            color: var(--text-muted);
            line-height: 1.8;
            font-weight: 400;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-dim {
            color: var(--text-dim) !important;
        }

        /* --- Skills --- */
        .skill-tag {
            background: rgba(255, 255, 255, 0.03);
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-right: 0.6rem;
            margin-bottom: 0.8rem;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: var(--transition);
            color: var(--text-main);
        }

        .skill-tag:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(173, 139, 115, 0.1);
        }

        /* --- Featured Product --- */
        .featured-product {
            background: linear-gradient(135deg, var(--bg-card) 0%, #1A2221 100%);
            border-radius: 24px;
            padding: 4rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.8rem;
            color: var(--text-main);
        }

        .feature-item i {
            color: var(--primary);
        }

        /* --- Experience --- */
        .timeline-item h5 {
            color: var(--text-main);
            margin-bottom: 0.3rem;
        }

        .timeline-item p {
            font-size: 0.9rem;
            color: var(--text-muted);
            opacity: 0.9;
        }

        .timeline-item {
            padding-left: 2rem;
            border-left: 1px solid rgba(126, 98, 88, 0.2);
            position: relative;
            margin-bottom: 3rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 8px; /* Adjusted to align with text */
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(126, 98, 88, 0.2);
        }

        /* --- Footer --- */
        footer {
            padding: 4rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            background: #070B0F;
        }

        .social-link {
            font-size: 1.5rem;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .social-links-group {
            display: flex;
            gap: 1.5rem;
        }

        .social-link:hover {
            color: var(--primary);
        }

        /* --- Grid & Utils --- */
        .glow-sphere {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(173, 139, 115, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
            filter: blur(80px);
            pointer-events: none; /* Fixed: Don't block interaction */
            max-width: 100vw; /* Fixed: Don't overflow */
        }

        strong {
            color: var(--primary);
            font-weight: 600;
        }

        /* --- Mobile Overrides (End of Stylesheet) --- */
        @media (max-width: 991px) {
            .nav-toggle {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -110%;
                width: 280px;
                height: 100vh;
                background: var(--bg-card);
                flex-direction: column;
                justify-content: flex-start;
                gap: 1.5rem;
                padding: 6rem 2rem 2rem 2rem;
                transition: 0.4s ease-in-out;
                box-shadow: -10px 0 30px rgba(0,0,0,0.5);
                z-index: 1000;
                align-items: flex-start;
            }

            .nav-links.active {
                right: 0;
            }

            .hero-title { font-size: 2.8rem; }
            .section { padding: 30px 0 !important; } /* Further reduced and forced symmetric */
            #hero { padding-top: 100px; }
            .featured-product { padding: 1.5rem; } /* Further reduced padding */
            .hero-subtitle { font-size: 1rem; margin-bottom: 1.5rem; }
            .card-custom { padding: 1.25rem; }
        }
    </style>
</head>
<body>

    <!-- Nav -->
    <nav id="navbar">
        <div class="container nav-container">
            <a href="#" class="nav-logo">Ayush.</a>
            
            <button class="nav-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#work">Work</a>
                <a href="#skills">Skills</a>
                <a href="#contact">Contact</a>
            </div>
        </div>
    </nav>

    <main>
        <!-- Hero -->
        <section id="hero">
            <div class="glow-sphere" style="top: -10%; right: -10%;"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="hero-content">
                            <span class="hero-tag">Android Developer & Creative Designer</span>
                            <h1 class="hero-title">Ayush <br>Zalavadiya</h1>
                            <p class="hero-subtitle">
                                I build Android applications and create hand-painted fabric designs under <strong>VastraKala</strong>. 
                                Focused on clean UI, smooth performance, and meaningful creativity.
                            </p>
                            <div class="hero-btns">
                                <a href="#work" class="btn-custom btn-primary-custom">View Work</a>
                                <a href="#contact" class="btn-custom btn-outline-custom">Contact Me</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-5 mt-lg-0">
                        <div class="hero-img-container">
                            <div class="hero-img-glow"></div>
                            <img src="{{ asset('images/web_img.jpg') }}" alt="Ayush Zalavadiya" class="hero-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About -->
        <section id="about" class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="section-title">About Me</h2>
                        <p>
                            Hello, I'm Ayush Zalavadiya. I'm an Android Developer with a passion for creating clean and user-friendly mobile applications. 
                            I enjoy building apps using modern technologies and designing smooth user experiences.
                        </p>
                        <p>
                            Alongside development, I also run <strong>VastraKala</strong>, where I create hand-painted fabric designs. 
                            I like combining creativity with technology — building apps and creating art.
                        </p>
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <div class="card-custom">
                            <h3 class="h4 mb-4">Experience In</h3>
                            <div class="timeline-item">
                                <h5>Android Development</h5>
                                <p class="text-muted small">Modern app architecture & Jetpack Compose</p>
                            </div>
                            <div class="timeline-item">
                                <h5>UI/UX Design</h5>
                                <p class="text-muted small">Creating intuitive user interfaces</p>
                            </div>
                            <div class="timeline-item" style="margin-bottom: 0;">
                                <h5>Hand Painting</h5>
                                <p class="text-muted small">VastraKala creative fabric designs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- What I Do -->
        <section class="section" style="background: rgba(255,255,255,0.02);">
            <div class="container text-center">
                <h2 class="section-title">What I Do</h2>
                <div class="row g-4 mt-4">
                    <div class="col-md-4">
                        <div class="card-custom text-start">
                            <i class="fab fa-android card-icon" aria-hidden="true"></i>
                            <h3 class="h4">App Development</h3>
                            <p class="text-muted">Android & Flutter development with focus on performance and simplicity.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-custom text-start">
                            <i class="fas fa-palette card-icon" aria-hidden="true"></i>
                            <h3 class="h4">Creative Design</h3>
                            <p class="text-muted">Hand-painted fabric designs and visual branding under VastraKala.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-custom text-start">
                            <i class="fas fa-magic card-icon" aria-hidden="true"></i>
                            <h3 class="h4">AI Integration</h3>
                            <p class="text-muted">Leveraging AI-assisted development for faster and smarter results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills -->
        <section id="skills" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <h2 class="section-title">My Skills</h2>
                        <p class="text-muted mb-5">Tools and technologies I use to bring ideas to life.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="skill-group mb-4">
                            <h3 class="h5 mb-3" style="color: var(--primary);">Development</h3>
                            <span class="skill-tag">Android Development</span>
                            <span class="skill-tag">Kotlin</span>
                            <span class="skill-tag">Java</span>
                            <span class="skill-tag">Flutter</span>
                            <span class="skill-tag">Jetpack Compose</span>
                            <span class="skill-tag">Android Compose</span>
                            <span class="skill-tag">Mobile App Development</span>
                        </div>
                        <div class="skill-group mb-4">
                            <h3 class="h5 mb-3" style="color: var(--primary);">Design & Tools</h3>
                            <span class="skill-tag">UI/UX Design</span>
                            <span class="skill-tag">Figma</span>
                            <span class="skill-tag">Material Design</span>
                            <span class="skill-tag">Android Studio</span>
                            <span class="skill-tag">Git</span>
                            <span class="skill-tag">Firebase</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Product -->
        <section id="work" class="section">
            <div class="container">
                <div class="featured-product">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <span class="hero-tag">Creative Project</span>
                            <h2 class="mb-3">VastraKala</h2>
                            <h3 class="h4 mb-4 text-primary">Hand-Painted Fabric Art</h3>
                            <p class="mb-4" style="font-size: 1.1rem; color: var(--text-main);">
                                VastraKala is my personal creative project where I create hand-painted designs on fabric. 
                                Each piece is carefully crafted with attention to detail and creativity.
                            </p>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="feature-item"><i class="fas fa-check" aria-hidden="true"></i> 100% Hand Painted</div>
                                    <div class="feature-item"><i class="fas fa-check" aria-hidden="true"></i> Unique Designs</div>
                                    <div class="feature-item"><i class="fas fa-check" aria-hidden="true"></i> Custom Orders</div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item"><i class="fas fa-check" aria-hidden="true"></i> Premium Colors</div>
                                    <div class="feature-item"><i class="fas fa-check" aria-hidden="true"></i> Long Lasting</div>
                                    <div class="feature-item"><i class="fas fa-check" aria-hidden="true"></i> Traditional Styles</div>
                                </div>
                            </div>
                            <a href="https://vastrakala.ayushzalavadiya.me" class="btn-custom btn-primary-custom" target="_blank" rel="noopener noreferrer">Explore VastraKala →</a>
                        </div>
                        <div class="col-lg-5 offset-lg-1 d-none d-lg-block">
                            <div class="hero-img-container">
                                <div class="hero-img-glow" style="background: radial-gradient(circle, rgba(173, 139, 115, 0.15) 0%, transparent 70%);"></div>
                                <img src="{{ asset('images/image.png') }}" alt="VastraKala Product" class="hero-img" style="border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.3);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="section" style="padding-bottom: 50px;">
            <div class="container text-center">
                <h2 class="section-title">Get In Touch</h2>
                <p class="text-muted mb-5">Let's build something creative together.</p>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card-custom">
                            <div class="row text-center mb-3 mb-md-5">
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <p class="text-uppercase fw-bold mb-2" style="font-size: 0.8rem; letter-spacing: 2px; color: var(--primary);">Email</p>
                                    <p class="mb-0">zalavadiyaayush03@gmail.com</p>
                                </div>
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <p class="text-uppercase fw-bold mb-2" style="font-size: 0.8rem; letter-spacing: 2px; color: var(--primary);">Portfolio</p>
                                    <p class="mb-0">ayushzalavadiya.me</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-uppercase fw-bold mb-2" style="font-size: 0.8rem; letter-spacing: 2px; color: var(--primary);">Location</p>
                                    <p class="mb-0">India</p>
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center text-md-start">
                                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start gap-4">
                                    <a href="mailto:zalavadiyaayush03@gmail.com" class="btn-custom btn-primary-custom">Send Email</a>
                                    <div class="social-links-group">
                                        <a href="https://github.com/AyushZalavadiya01" class="social-link" aria-label="GitHub"><i class="fab fa-github"></i></a>
                                        <a href="https://www.linkedin.com/in/ayush-zalavadiya-588546266/" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                                        <a href="https://www.instagram.com/ayush_zalavadiya_01/" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <h4 class="text-primary">Ayush Zalavadiya</h4>
            <p class="text-muted small mb-4">Android Developer | VastraKala</p>
            <p class="text-dim mb-0" style="font-size: 0.85rem;">
                &copy; {{ date('Y') }} Ayush Zalavadiya. All Rights Reserved. <br>
                Creating apps and hand-painted fabric designs
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        const navToggle = document.querySelector('.nav-toggle');
        const navLinks = document.querySelector('.nav-links');

        navToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            const icon = navToggle.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Close menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                navToggle.querySelector('i').classList.add('fa-bars');
                navToggle.querySelector('i').classList.remove('fa-times');
            });
        });
    </script>
</body>
</html>
