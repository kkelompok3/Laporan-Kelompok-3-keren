// Loading Screen
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loading-screen').classList.add('fade-out');
                setTimeout(() => {
                    document.getElementById('loading-screen').style.display = 'none';
                }, 800);
            }, 3000);
        });

        // Typing Animation
        const texts = [
            "Halo, Saya Rangga",
            "Web Designer",
            "Frontend Developer",
            "Creative Coder"
        ];
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        const typingElement = document.getElementById('typing-text');

        function typeText() {
            const currentText = texts[textIndex];
            
            if (!isDeleting) {
                typingElement.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
                
                if (charIndex === currentText.length) {
                    isDeleting = true;
                    setTimeout(typeText, 2000);
                    return;
                }
            } else {
                typingElement.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
                
                if (charIndex === 0) {
                    isDeleting = false;
                    textIndex = (textIndex + 1) % texts.length;
                    setTimeout(typeText, 500);
                    return;
                }
            }
            
            setTimeout(typeText, isDeleting ? 50 : 100);
        }

        // Start typing animation after loading
        setTimeout(() => {
            typeText();
        }, 3500);

        // Floating Tech Icons with Bounce
        const techIcons = [
            { icon: 'fa-solid fa-code', color: '#61DAFB' },
            { icon: 'fa-brands fa-html5', color: '#E34F26' },
            { icon: 'fa-brands fa-css3-alt', color: '#1572B6' },
            { icon: 'fa-brands fa-js', color: '#F7DF1E' },
            { icon: 'fa-brands fa-react', color: '#61DAFB' },
            { icon: 'fa-brands fa-node', color: '#339933' },
            { icon: 'fa-solid fa-database', color: '#4479A1' }
        ];
        const container = document.getElementById('floating-icons');
        const icons = [];

        class FloatingIcon {
            constructor(iconData, index) {
                this.element = document.createElement('i');
                this.element.className = 'tech-icon ' + iconData.icon;
                this.element.style.position = 'absolute';
                this.element.style.fontSize = '40px';
                this.element.style.opacity = '0.3';
                this.element.style.color = iconData.color;
                
                // Random starting position
                this.x = Math.random() * 90 + 5;
                this.y = Math.random() * 90 + 5;
                
                this.element.style.left = this.x + '%';
                this.element.style.top = this.y + '%';
                
                // Random speed
                this.speedX = (Math.random() - 0.5) * 0.3;
                this.speedY = (Math.random() - 0.5) * 0.3;
                
                container.appendChild(this.element);
            }

            update() {
                // Update position
                this.x += this.speedX;
                this.y += this.speedY;

                // Bounce off edges
                if (this.x <= 0 || this.x >= 95) {
                    this.speedX *= -1;
                    this.x = Math.max(0, Math.min(95, this.x));
                }
                if (this.y <= 0 || this.y >= 95) {
                    this.speedY *= -1;
                    this.y = Math.max(0, Math.min(95, this.y));
                }

                // Apply new position
                this.element.style.left = this.x + '%';
                this.element.style.top = this.y + '%';
            }
        }

        // Create floating icons
        techIcons.forEach((iconData, index) => {
            icons.push(new FloatingIcon(iconData, index));
        });

        // Animation loop
        function animate() {
            icons.forEach(icon => icon.update());
            requestAnimationFrame(animate);
        }
        
        // Start animation after page load
        setTimeout(() => {
            animate();
        }, 100);

        // Contact Form
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            alert(`Terima kasih ${name}! Pesan Anda telah diterima.\n\nEmail: ${email}\nPesan: ${message}\n\nSaya akan segera menghubungi Anda!`);
            
            this.reset();
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Skills Progress Bar Animation
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressBars = entry.target.querySelectorAll('.skill-progress');
                    progressBars.forEach(bar => {
                        const progress = bar.getAttribute('data-progress');
                        bar.style.width = progress + '%';
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const skillsSection = document.querySelector('.skills');
        if (skillsSection) {
            observer.observe(skillsSection);
        }