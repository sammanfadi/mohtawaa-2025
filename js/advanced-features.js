/**
 * ميزات متقدمة وتفاعلية للقالب الاحترافي
 */

(function() {
    'use strict';

    // متغيرات عامة
    let isInitialized = false;
    let scrollTimeout = null;
    let resizeTimeout = null;

    // تهيئة الميزات المتقدمة
    document.addEventListener('DOMContentLoaded', function() {
        if (isInitialized) return;
        
        initAdvancedFeatures();
        initCounterAnimation();
        initParallaxEffects();
        initAdvancedSearch();
        initBookmarkSystem();
        initReadingProgress();
        initSocialShare();
        initThemeCustomizer();
        
        isInitialized = true;
    });

    /**
     * تهيئة الميزات المتقدمة
     */
    function initAdvancedFeatures() {
        // تأثير الكتابة المتحركة
        initTypewriterEffect();
        
        // تأثيرات التمرير المتقدمة
        initAdvancedScrollEffects();
        
        // تحسين الأداء للصور
        initAdvancedImageOptimization();
        
        // نظام التقييم
        initRatingSystem();
        
        // اختصارات لوحة المفاتيح
        initKeyboardShortcuts();
    }

    /**
     * تأثير الكتابة المتحركة
     */
    function initTypewriterEffect() {
        const typewriterElements = document.querySelectorAll('.typewriter');
        
        typewriterElements.forEach(element => {
            const text = element.textContent;
            element.textContent = '';
            element.style.borderLeft = '2px solid var(--primary-color)';
            
            let i = 0;
            function typeChar() {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeChar, 100);
                } else {
                    // وميض المؤشر
                    setInterval(() => {
                        element.style.borderLeft = element.style.borderLeft === 'none' ? 
                            '2px solid var(--primary-color)' : 'none';
                    }, 530);
                }
            }
            
            // بدء الكتابة بعد تأخير قصير
            setTimeout(typeChar, 500);
        });
    }

    /**
     * تحريك العدادات
     */
    function initCounterAnimation() {
        const counters = document.querySelectorAll('[data-count]');
        
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-count'));
            const increment = target / 50;
            let current = 0;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            
            updateCounter();
        };

        // تحريك العدادات عند ظهورها في الشاشة
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.hasAttribute('data-animated')) {
                        entry.target.setAttribute('data-animated', 'true');
                        animateCounter(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => observer.observe(counter));
        }
    }

    /**
     * تأثيرات Parallax
     */
    function initParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.parallax');
        
        if (parallaxElements.length === 0) return;

        function updateParallax() {
            const scrollTop = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const speed = element.getAttribute('data-speed') || 0.5;
                const yPos = -(scrollTop * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        }

        // تحديث Parallax مع تحسين الأداء
        window.addEventListener('scroll', () => {
            if (scrollTimeout) {
                cancelAnimationFrame(scrollTimeout);
            }
            scrollTimeout = requestAnimationFrame(updateParallax);
        });
    }

    /**
     * البحث المتقدم
     */
    function initAdvancedSearch() {
        const searchForm = document.querySelector('.search-form');
        const searchInput = document.querySelector('.search-form input[type="search"]');
        const searchResults = document.createElement('div');
        
        if (!searchForm || !searchInput) return;

        searchResults.className = 'search-results';
        searchResults.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--background-color);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-lg);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        `;

        searchForm.style.position = 'relative';
        searchForm.appendChild(searchResults);

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                performSearch(query, searchResults);
            }, 300);
        });

        // إخفاء النتائج عند النقر خارجها
        document.addEventListener('click', function(e) {
            if (!searchForm.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
    }

    /**
     * تنفيذ البحث
     */
    function performSearch(query, resultsContainer) {
        const searchUrl = `${window.location.origin}/wp-json/wp/v2/posts?search=${encodeURIComponent(query)}&per_page=5`;
        
        fetch(searchUrl)
            .then(response => response.json())
            .then(posts => {
                if (posts.length === 0) {
                    resultsContainer.innerHTML = '<div class="search-no-results">لا توجد نتائج</div>';
                } else {
                    const resultsHTML = posts.map(post => `
                        <div class="search-result-item">
                            <a href="${post.link}" class="search-result-link">
                                <h4>${post.title.rendered}</h4>
                                <p>${post.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 100)}...</p>
                            </a>
                        </div>
                    `).join('');
                    
                    resultsContainer.innerHTML = resultsHTML;
                }
                
                resultsContainer.style.display = 'block';
            })
            .catch(error => {
                console.error('خطأ في البحث:', error);
                resultsContainer.innerHTML = '<div class="search-error">حدث خطأ في البحث</div>';
                resultsContainer.style.display = 'block';
            });
    }

    /**
     * نظام الإشارات المرجعية
     */
    function initBookmarkSystem() {
        const bookmarkButtons = document.querySelectorAll('.bookmark-btn');
        
        bookmarkButtons.forEach(button => {
            const postId = button.getAttribute('data-post-id');
            const bookmarks = getBookmarks();
            
            if (bookmarks.includes(postId)) {
                button.classList.add('bookmarked');
                button.innerHTML = '🔖 محفوظ';
            }
            
            button.addEventListener('click', function(e) {
                e.preventDefault();
                toggleBookmark(postId, this);
            });
        });
    }

    function getBookmarks() {
        return JSON.parse(localStorage.getItem('muhtawaa_bookmarks') || '[]');
    }

    function saveBookmarks(bookmarks) {
        localStorage.setItem('muhtawaa_bookmarks', JSON.stringify(bookmarks));
    }

    function toggleBookmark(postId, button) {
        let bookmarks = getBookmarks();
        
        if (bookmarks.includes(postId)) {
            bookmarks = bookmarks.filter(id => id !== postId);
            button.classList.remove('bookmarked');
            button.innerHTML = '🔖 حفظ';
            showNotification('تم إلغاء الحفظ', 'info');
        } else {
            bookmarks.push(postId);
            button.classList.add('bookmarked');
            button.innerHTML = '🔖 محفوظ';
            showNotification('تم حفظ المقال', 'success');
        }
        
        saveBookmarks(bookmarks);
    }

    /**
     * عرض الإشعارات
     */
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `toast toast-${type} show`;
        notification.innerHTML = `
            <div class="toast-content">
                <span class="toast-message">${message}</span>
                <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;
        
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                display: flex;
                flex-direction: column;
                gap: 10px;
            `;
            document.body.appendChild(container);
        }
        
        container.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    /**
     * تحسين الأداء - debounce
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

})();