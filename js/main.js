/**
 * ملف JavaScript الرئيسي لقالب muhtawaa
 * يحتوي على جميع التفاعلات والوظائف المطلوبة
 */

(function() {
    'use strict';

    // متغيرات عامة
    let darkModeEnabled = false;
    let readingProgressBar = null;
    let filterButtons = null;
    let articlesGrid = null;

    // تهيئة القالب عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        initDarkMode();
        var settings = window.muhtawaa_settings || {};
        if (settings.showReadingProgress !== false) {
            initReadingProgress();
        }
        if (settings.showAudioButton !== false) {
            initAudioPlayer(settings);
        }
        initArticleFilters();
        initSmoothScrolling();
        initShareButtons();
        if (settings.showBackToTop !== false) {
            initBackToTop();
        }
        initLazyLoading();
    });

    /**
     * تهيئة الوضع الليلي
     */
    function initDarkMode() {
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const body = document.body;

        // التحقق من الإعداد المحفوظ
        const savedMode = localStorage.getItem('muhtawaa-dark-mode');
        if (savedMode === 'enabled') {
            enableDarkMode();
        }

        // إضافة مستمع الحدث لزر التبديل
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', function() {
                if (darkModeEnabled) {
                    disableDarkMode();
                } else {
                    enableDarkMode();
                }
            });
        }

        function enableDarkMode() {
            body.classList.add('dark-mode');
            darkModeEnabled = true;
            localStorage.setItem('muhtawaa-dark-mode', 'enabled');
        }

        function disableDarkMode() {
            body.classList.remove('dark-mode');
            darkModeEnabled = false;
            localStorage.setItem('muhtawaa-dark-mode', 'disabled');
        }
    }

    /**
     * تهيئة مؤشر تقدم القراءة
     */
    function initReadingProgress() {
        // إنشاء مؤشر التقدم إذا لم يكن موجوداً
        if (!document.querySelector('.reading-progress')) {
            const progressContainer = document.createElement('div');
            progressContainer.className = 'reading-progress';
            
            const progressBar = document.createElement('div');
            progressBar.className = 'reading-progress-bar';
            
            progressContainer.appendChild(progressBar);
            document.body.insertBefore(progressContainer, document.body.firstChild);
            
            readingProgressBar = progressBar;
        } else {
            readingProgressBar = document.querySelector('.reading-progress-bar');
        }

        // تحديث مؤشر التقدم عند التمرير
        window.addEventListener('scroll', updateReadingProgress);
        window.addEventListener('resize', updateReadingProgress);
    }

    /**
     * تحديث مؤشر تقدم القراءة
     */
    function updateReadingProgress() {
        if (!readingProgressBar) return;

        const article = document.querySelector('.article-content');
        if (!article) {
            readingProgressBar.style.width = '0%';
            return;
        }

        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset;

        const articleStart = articleTop - windowHeight / 3;
        const articleEnd = articleTop + articleHeight - windowHeight / 3;
        const totalDistance = articleEnd - articleStart;

        let progress = 0;
        if (scrollTop >= articleStart && scrollTop <= articleEnd) {
            progress = ((scrollTop - articleStart) / totalDistance) * 100;
        } else if (scrollTop > articleEnd) {
            progress = 100;
        }

        progress = Math.max(0, Math.min(100, progress));
        readingProgressBar.style.width = progress + '%';
    }

    /**
     * تهيئة زر الاستماع للمقال
     */
    function initAudioPlayer(settings) {
        const btn = document.getElementById('play-pause-btn');
        if (!btn) return;

        const text = btn.getAttribute('data-content') || '';
        const voice = settings.audioVoice || 'Arabic Female';
        const rate = parseFloat(settings.audioSpeed || 1);

        let playing = false;
        let paused = false;
        let utterance = null;

        function onEnd() {
            playing = false;
            paused = false;
            btn.textContent = 'استمع للمقال';
        }

        function startSpeech() {
            if (window.responsiveVoice) {
                responsiveVoice.speak(text, voice, { rate: rate, onend: onEnd });
            } else if (window.speechSynthesis) {
                utterance = new SpeechSynthesisUtterance(text);
                utterance.rate = rate;
                utterance.lang = 'ar-SA';
                utterance.onend = onEnd;
                speechSynthesis.speak(utterance);
            }
        }

        function pauseSpeech() {
            if (window.responsiveVoice) {
                responsiveVoice.pause();
            } else if (window.speechSynthesis) {
                speechSynthesis.pause();
            }
        }

        function resumeSpeech() {
            if (window.responsiveVoice) {
                responsiveVoice.resume();
            } else if (window.speechSynthesis) {
                speechSynthesis.resume();
            }
        }

        btn.addEventListener('click', function() {
            if (!playing) {
                startSpeech();
                playing = true;
                btn.textContent = 'إيقاف مؤقت';
            } else if (paused) {
                resumeSpeech();
                paused = false;
                btn.textContent = 'إيقاف مؤقت';
            } else {
                pauseSpeech();
                paused = true;
                btn.textContent = 'متابعة';
            }
        });
    }

    /**
     * تهيئة نظام فلترة المقالات
     */
    function initArticleFilters() {
        filterButtons = document.querySelectorAll('.filter-btn');
        articlesGrid = document.querySelector('.articles-grid');

        if (!filterButtons.length || !articlesGrid) return;

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                filterArticles(category);
                updateActiveFilter(this);
            });
        });
    }

    /**
     * فلترة المقالات حسب التصنيف
     */
    function filterArticles(category) {
        const articles = articlesGrid.querySelectorAll('.article-card');
        
        articles.forEach(article => {
            const articleCategories = article.getAttribute('data-categories');
            
            if (category === 'all' || !category) {
                showArticle(article);
            } else if (articleCategories && articleCategories.includes(category)) {
                showArticle(article);
            } else {
                hideArticle(article);
            }
        });
    }

    /**
     * إظهار المقال مع تأثير
     */
    function showArticle(article) {
        article.style.display = 'block';
        setTimeout(() => {
            article.style.opacity = '1';
            article.style.transform = 'translateY(0)';
        }, 10);
    }

    /**
     * إخفاء المقال مع تأثير
     */
    function hideArticle(article) {
        article.style.opacity = '0';
        article.style.transform = 'translateY(20px)';
        setTimeout(() => {
            article.style.display = 'none';
        }, 300);
    }

    /**
     * تحديث الزر النشط في الفلترة
     */
    function updateActiveFilter(activeButton) {
        filterButtons.forEach(button => {
            button.classList.remove('active');
        });
        activeButton.classList.add('active');
    }

    /**
     * تهيئة التمرير السلس
     */
    function initSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * تهيئة أزرار المشاركة
     */
    function initShareButtons() {
        const shareButtons = document.querySelectorAll('.share-btn');
        
        shareButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const action = this.getAttribute('data-action');
                
                if (action === 'copy-link') {
                    e.preventDefault();
                    copyToClipboard(window.location.href);
                    showNotification('تم نسخ الرابط بنجاح!');
                } else if (action === 'share') {
                    e.preventDefault();
                    if (navigator.share) {
                        navigator.share({
                            title: document.title,
                            url: window.location.href
                        });
                    } else {
                        // فتح نافذة مشاركة بديلة
                        const shareUrl = `https://wa.me/?text=${encodeURIComponent(document.title + ' ' + window.location.href)}`;
                        window.open(shareUrl, '_blank', 'width=600,height=400');
                    }
                }
            });
        });
    }

    /**
     * نسخ النص إلى الحافظة
     */
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text);
        } else {
            // طريقة بديلة للمتصفحات القديمة
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        }
    }

    /**
     * عرض إشعار
     */
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    /**
     * تهيئة زر العودة للأعلى
     */
    function initBackToTop() {
        const backToTopBtn = document.createElement('button');
        backToTopBtn.className = 'back-to-top';
        backToTopBtn.innerHTML = '↑';
        backToTopBtn.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            font-size: 20px;
            font-weight: bold;
        `;
        
        document.body.appendChild(backToTopBtn);
        
        // إظهار/إخفاء الزر حسب موضع التمرير
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.opacity = '1';
                backToTopBtn.style.visibility = 'visible';
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.visibility = 'hidden';
            }
        });
        
        // العودة للأعلى عند النقر
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * تهيئة التحميل التدريجي للصور
     */
    function initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            images.forEach(img => imageObserver.observe(img));
        } else {
            // بديل للمتصفحات التي لا تدعم IntersectionObserver
            const lazyLoadFallback = () => {
                images.forEach(img => {
                    if (img.dataset.src && img.getBoundingClientRect().top < window.innerHeight + 100) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
            };

            lazyLoadFallback();
            window.addEventListener('scroll', lazyLoadFallback);
            window.addEventListener('resize', lazyLoadFallback);
        }
    }

    /**
     * تحسين الأداء - تأخير تنفيذ الوظائف
     */
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

    // تحسين أداء مؤشر التقدم
    const debouncedUpdateProgress = debounce(updateReadingProgress, 10);
    window.removeEventListener('scroll', updateReadingProgress);
    window.addEventListener('scroll', debouncedUpdateProgress);

    /**
     * تهيئة تأثيرات الحركة عند التمرير
     */
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll('.article-card, .related-card');
        
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                animationObserver.observe(element);
            });
        }
    }

    // تهيئة تأثيرات الحركة
    initScrollAnimations();

    /**
     * تحسين تجربة المستخدم على الأجهزة المحمولة
     */
    function initMobileOptimizations() {
        // تحسين اللمس للأزرار
        const buttons = document.querySelectorAll('button, .btn, .read-more-btn');
        buttons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
            });
            
            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // منع التكبير المزدوج على iOS
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    }

    // تهيئة تحسينات الأجهزة المحمولة
    if ('ontouchstart' in window) {
        initMobileOptimizations();
    }

})();
