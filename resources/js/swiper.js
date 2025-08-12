import Swiper from "swiper/bundle";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM loaded, initializing Swipers...");

    // Initialize Novel Swiper (Main Carousel)
    const swiperContainer = document.querySelector(".novel-swiper");
    if (!swiperContainer) {
        console.error("Novel swiper container not found!");
    } else {
        console.log("Novel swiper container found:", swiperContainer);

        const slides = document.querySelectorAll(".novel-swiper .swiper-slide");
        const slideCount = slides.length;
        console.log("Number of novel slides:", slideCount);

        const swiper = new Swiper(".novel-swiper", {
            slidesPerView: 1,
            spaceBetween: 16,
            loop: slideCount > 1,
            autoplay:
                slideCount > 1
                    ? {
                          delay: 4000,
                          disableOnInteraction: false,
                      }
                    : false,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                bulletClass: "swiper-pagination-bullet",
                bulletActiveClass: "swiper-pagination-bullet-active",
            },
            effect: "slide",
            speed: 800,

            on: {
                init: function () {
                    console.log(
                        "Novel Swiper initialized with",
                        slideCount,
                        "slides"
                    );
                },
                slideChange: function () {
                    console.log("Novel slide changed to:", this.activeIndex);
                },
            },
        });

        console.log("Novel Swiper instance:", swiper);
    }

    // Function untuk initialize recommendation swiper
    function initRecommendationSwiper() {
        const recommendationContainer = document.querySelector(
            ".recommendation-swiper"
        );
        if (!recommendationContainer) {
            console.log("Recommendation swiper container not found");
            return null;
        }

        // Check if already initialized
        if (recommendationContainer.swiper) {
            console.log("Recommendation swiper already initialized");
            return recommendationContainer.swiper;
        }

        console.log("Initializing recommendation swiper...");

        const recSlides = document.querySelectorAll(
            ".recommendation-swiper .swiper-slide"
        );
        const recSlideCount = recSlides.length;
        console.log("Number of recommendation slides:", recSlideCount);

        if (recSlideCount === 0) {
            console.log("No recommendation slides found");
            return null;
        }

        try {
            const recommendationSwiper = new Swiper(".recommendation-swiper", {
                slidesPerView: 2,
                spaceBetween: 16,
                loop: recSlideCount > 1,
                autoplay:
                    recSlideCount > 1
                        ? {
                              delay: 3500,
                              disableOnInteraction: false,
                              pauseOnMouseEnter: true,
                          }
                        : false,

                breakpoints: {
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 16,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 20,
                    },
                    1280: {
                        slidesPerView: 6,
                        spaceBetween: 24,
                    },
                },

                navigation: {
                    nextEl: ".recommendation-next",
                    prevEl: ".recommendation-prev",
                },

                pagination: {
                    el: ".recommendation-pagination",
                    clickable: true,
                    bulletClass: "swiper-pagination-bullet",
                    bulletActiveClass: "swiper-pagination-bullet-active",
                },

                observer: true,
                observeParents: true,
                observeSlideChildren: true,

                on: {
                    init: function () {
                        console.log(
                            "✅ Recommendation Swiper initialized successfully with",
                            recSlideCount,
                            "slides"
                        );
                    },
                    slideChange: function () {
                        console.log(
                            "Recommendation slide changed to:",
                            this.activeIndex
                        );
                    },
                },
            });

            console.log(
                "✅ Recommendation Swiper instance created:",
                recommendationSwiper
            );
            return recommendationSwiper;
        } catch (error) {
            console.error(
                "❌ Error initializing recommendation swiper:",
                error
            );
            return null;
        }
    }

    // Method 1: Try immediate initialization
    initRecommendationSwiper();

    // Method 2: Use MutationObserver to watch for DOM changes
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === "childList") {
                const recommendationContainer = document.querySelector(
                    ".recommendation-swiper"
                );
                if (
                    recommendationContainer &&
                    !recommendationContainer.swiper
                ) {
                    console.log(
                        "🔄 DOM changed, trying to initialize recommendation swiper..."
                    );
                    setTimeout(() => {
                        initRecommendationSwiper();
                    }, 100);
                }
            }
        });
    });

    // Start observing
    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });

    // Method 3: Try after all images are loaded
    window.addEventListener("load", () => {
        console.log("🖼️ All images loaded, trying recommendation swiper...");
        setTimeout(() => {
            initRecommendationSwiper();
        }, 200);
    });

    // Method 4: Fallback dengan interval check
    let attempts = 0;
    const maxAttempts = 20;
    const checkInterval = setInterval(() => {
        attempts++;
        const recommendationContainer = document.querySelector(
            ".recommendation-swiper"
        );

        if (recommendationContainer && !recommendationContainer.swiper) {
            console.log(
                `🔄 Attempt ${attempts}: Trying to initialize recommendation swiper...`
            );
            const result = initRecommendationSwiper();

            if (result) {
                console.log(
                    "✅ Recommendation swiper initialized successfully!"
                );
                clearInterval(checkInterval);
            }
        }

        if (attempts >= maxAttempts) {
            console.log("❌ Max attempts reached, stopping interval check");
            clearInterval(checkInterval);
        }
    }, 500);
});
