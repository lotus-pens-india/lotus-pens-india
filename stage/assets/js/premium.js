(function () {
  const ready = (fn) => {
    if (document.readyState !== "loading") {
      fn();
      return;
    }
    document.addEventListener("DOMContentLoaded", fn);
  };

  ready(() => {
    document.querySelectorAll(".lp-section, .lp-product-card, .lp-category-card, .lp-featured-card, .testimonials-slide, .lp-checkout-card, .lp-cart-card, .lp-luxe-product-card, .lp-luxe-feature-product, .lp-luxe-category-tile, .lp-luxe-story-media, .lp-luxe-cabinet-card").forEach((node) => {
      node.classList.add("lp-reveal");
    });

    if ("IntersectionObserver" in window) {
      const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            revealObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12 });

      document.querySelectorAll(".lp-reveal").forEach((node) => revealObserver.observe(node));
    } else {
      document.querySelectorAll(".lp-reveal").forEach((node) => node.classList.add("is-visible"));
    }

    initSliders();
    initListingControls();
    initMobileFilters();
    initQuantityControls();
    initHeaderSearch();
    initPremiumHeader();
    initPremiumTestimonials();
    initPremiumSliderArrows();
    initNewsletter();
  });

  function initSliders() {
    if (!window.jQuery || !jQuery.fn || !jQuery.fn.slick) {
      return;
    }

    const baseUrlInput = document.getElementById("base_url_input");
    const baseUrl = baseUrlInput ? baseUrlInput.value : "";
    const prevArrow = `<button type="button" class="slick-prev" aria-label="Previous"><i class="fa fa-angle-left"></i></button>`;
    const nextArrow = `<button type="button" class="slick-next" aria-label="Next"><i class="fa fa-angle-right"></i></button>`;

    jQuery(".lp-hero-slider").not(".slick-initialized").slick({
      dots: true,
      infinite: true,
      speed: 700,
      autoplay: true,
      autoplaySpeed: 5200,
      fade: true,
      cssEase: "ease",
      arrows: true,
      prevArrow,
      nextArrow
    });

    jQuery(".lp-featured-slider").not(".slick-initialized").slick({
      dots: false,
      infinite: true,
      speed: 500,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3800,
      arrows: true,
      prevArrow,
      nextArrow,
      responsive: [
        { breakpoint: 1100, settings: { slidesToShow: 3 } },
        { breakpoint: 720, settings: { slidesToShow: 2 } },
        { breakpoint: 520, settings: { slidesToShow: 1 } }
      ]
    });

    jQuery(".related-products-slider").not(".slick-initialized").slick({
      dots: false,
      infinite: true,
      speed: 450,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 4200,
      arrows: true,
      prevArrow,
      nextArrow,
      responsive: [
        { breakpoint: 1100, settings: { slidesToShow: 3 } },
        { breakpoint: 720, settings: { slidesToShow: 2 } },
        { breakpoint: 520, settings: { slidesToShow: 1 } }
      ]
    });

    jQuery(".lp-product-grid").on("layout-changed", function () {
      window.setTimeout(() => {
        jQuery(".related-products-slider.slick-initialized").slick("setPosition");
      }, 220);
    });

    if (baseUrl) {
      document.documentElement.style.setProperty("--lp-base-url", `"${baseUrl}"`);
    }
  }

  function initListingControls() {
    const grid = document.querySelector("[data-product-grid]");
    if (!grid) {
      return;
    }

    const searchInput = document.getElementById("lp_product_search");
    const categoryInput = document.getElementById("lp_category_filter");
    const materialInput = document.getElementById("lp_material_filter");
    const availabilityInput = document.getElementById("lp_availability_filter");
    const minInput = document.getElementById("lp_price_min");
    const maxInput = document.getElementById("lp_price_max");
    const sortInput = document.getElementById("lp_sort");
    const resultCount = document.getElementById("lp_result_count");
    const emptyState = document.getElementById("lp_empty_state");

    const cards = Array.from(grid.querySelectorAll(".lp-product-card"));
    const normalize = (value) => String(value || "").toLowerCase().trim();

    const applyFilters = () => {
      const query = normalize(searchInput && searchInput.value);
      const category = normalize(categoryInput && categoryInput.value);
      const material = normalize(materialInput && materialInput.value);
      const availability = normalize(availabilityInput && availabilityInput.value);
      const min = minInput && minInput.value !== "" ? parseFloat(minInput.value) : null;
      const max = maxInput && maxInput.value !== "" ? parseFloat(maxInput.value) : null;
      let visible = 0;

      cards.forEach((card) => {
        const name = normalize(card.dataset.name);
        const cardCategory = normalize(card.dataset.category);
        const cardMaterial = normalize(card.dataset.material);
        const cardAvailability = normalize(card.dataset.availability);
        const price = parseFloat(card.dataset.price || "0");

        const matchesQuery = !query || name.includes(query);
        const matchesCategory = !category || cardCategory === category;
        const matchesMaterial = !material || cardMaterial.includes(material);
        const matchesAvailability = !availability || cardAvailability === availability;
        const matchesMin = min === null || price >= min;
        const matchesMax = max === null || price <= max;
        const isVisible = matchesQuery && matchesCategory && matchesMaterial && matchesAvailability && matchesMin && matchesMax;

        card.hidden = !isVisible;
        if (isVisible) {
          visible += 1;
        }
      });

      if (resultCount) {
        resultCount.textContent = `${visible} item${visible === 1 ? "" : "s"}`;
      }

      if (emptyState) {
        emptyState.hidden = visible !== 0;
      }
    };

    const applySort = () => {
      const sortValue = sortInput ? sortInput.value : "popular";
      const sortedCards = Array.from(cards).sort((a, b) => {
        const priceA = parseFloat(a.dataset.price || "0");
        const priceB = parseFloat(b.dataset.price || "0");
        const idA = parseInt(a.dataset.id || "0", 10);
        const idB = parseInt(b.dataset.id || "0", 10);
        const posA = parseInt(a.dataset.position || "0", 10);
        const posB = parseInt(b.dataset.position || "0", 10);

        if (sortValue === "latest") {
          return idB - idA;
        }

        if (sortValue === "price_asc") {
          return priceA - priceB;
        }

        if (sortValue === "price_desc") {
          return priceB - priceA;
        }

        return posA - posB || idA - idB;
      });

      sortedCards.forEach((card) => grid.appendChild(card));
      applyFilters();
    };

    [searchInput, categoryInput, materialInput, availabilityInput, minInput, maxInput].forEach((control) => {
      if (control) {
        control.addEventListener("input", applyFilters);
        control.addEventListener("change", applyFilters);
      }
    });

    if (sortInput) {
      sortInput.addEventListener("change", applySort);
    }

    document.querySelectorAll("[data-grid-layout]").forEach((button) => {
      button.addEventListener("click", () => {
        document.querySelectorAll("[data-grid-layout]").forEach((item) => item.classList.remove("active"));
        button.classList.add("active");
        grid.dataset.layout = button.dataset.gridLayout;
        if (window.jQuery) {
          jQuery(grid).trigger("layout-changed");
        }
      });
    });

    applySort();
  }

  function initMobileFilters() {
    const panel = document.getElementById("lp_filter_panel");
    const toggle = document.querySelector("[data-filter-toggle]");
    const close = document.querySelector("[data-filter-close]");
    const backdrop = document.querySelector("[data-filter-backdrop]");

    if (!panel || !toggle) {
      return;
    }

    const setOpen = (isOpen) => {
      panel.classList.toggle("is-open", isOpen);
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
      document.body.classList.toggle("lp-filter-open", isOpen);

      if (backdrop) {
        backdrop.hidden = !isOpen;
        backdrop.classList.toggle("is-visible", isOpen);
      }
    };

    toggle.addEventListener("click", () => setOpen(!panel.classList.contains("is-open")));

    if (close) {
      close.addEventListener("click", () => setOpen(false));
    }

    if (backdrop) {
      backdrop.addEventListener("click", () => setOpen(false));
    }

    panel.querySelectorAll("input, select").forEach((control) => {
      control.addEventListener("change", () => {
        if (window.matchMedia("(max-width: 991px)").matches) {
          window.setTimeout(() => setOpen(false), 180);
        }
      });
    });

    window.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        setOpen(false);
      }
    });
  }

  function initQuantityControls() {
    document.querySelectorAll("[data-qty-action]").forEach((button) => {
      button.addEventListener("click", () => {
        const input = document.getElementById(button.dataset.qtyTarget || "product_qty");
        if (!input) {
          return;
        }

        const current = parseInt(input.value || "1", 10);
        const next = button.dataset.qtyAction === "increase" ? current + 1 : Math.max(1, current - 1);
        input.value = next;
      });
    });
  }

  function initHeaderSearch() {
    document.querySelectorAll("[data-search-submit]").forEach((button) => {
      button.addEventListener("click", () => {
        if (typeof window.searchProducts === "function") {
          window.searchProducts();
        }
      });
    });

    document.querySelectorAll(".lp-search input").forEach((input) => {
      input.addEventListener("keydown", (event) => {
        if (event.key === "Enter" && typeof window.searchProducts === "function") {
          event.preventDefault();
          window.searchProducts();
        }
      });
    });
  }

  function initPremiumHeader() {
    const header = document.querySelector(".lp-header");

    if (!header) {
      return;
    }

    const updateHeaderState = () => {
      header.classList.toggle("lp-header-scrolled", window.scrollY > 42);
    };

    updateHeaderState();
    window.addEventListener("scroll", updateHeaderState, { passive: true });
  }

  function initPremiumTestimonials() {
    const maxLength = 260;
    const slides = document.querySelectorAll(".testimonials-slide");

    slides.forEach((slide, index) => {
      if (slide.dataset.testimonialReady === "true") {
        return;
      }

      const review = slide.querySelector(".review");
      const wrapper = slide.querySelector(".review-text-wrapper");

      if (!review || !wrapper) {
        return;
      }

      const fullText = review.textContent.replace(/\s+/g, " ").trim();
      slide.dataset.testimonialReady = "true";
      wrapper.classList.add("lp-testimonial-copy");

      if (fullText.length <= maxLength) {
        return;
      }

      const previewText = `${fullText.slice(0, maxLength).trim()}...`;
      const button = document.createElement("button");
      button.type = "button";
      button.className = "lp-testimonial-toggle";
      button.textContent = "Read More";
      button.setAttribute("aria-expanded", "false");
      button.setAttribute("aria-controls", `lp_testimonial_text_${index}`);
      review.id = review.id || `lp_testimonial_text_${index}`;

      review.textContent = previewText;
      slide.classList.add("is-collapsed");
      wrapper.style.maxHeight = `${wrapper.scrollHeight}px`;
      wrapper.insertAdjacentElement("afterend", button);

      button.addEventListener("click", () => {
        const isExpanded = slide.classList.toggle("is-expanded");
        slide.classList.toggle("is-collapsed", !isExpanded);
        button.setAttribute("aria-expanded", isExpanded ? "true" : "false");
        button.textContent = isExpanded ? "View Less" : "Read More";

        wrapper.style.maxHeight = `${wrapper.scrollHeight}px`;
        review.textContent = isExpanded ? fullText : previewText;

        window.requestAnimationFrame(() => {
          wrapper.style.maxHeight = `${wrapper.scrollHeight}px`;
          if (window.jQuery && jQuery.fn && jQuery.fn.slick) {
            window.setTimeout(() => {
              jQuery(".testimonials-slider.slick-initialized").slick("setPosition");
            }, 260);
          }
        });
      });
    });
  }

  function initPremiumSliderArrows() {
    const makeArrow = (direction) => {
      const path = direction === "prev" ? "M14.5 5.5 8 12l6.5 6.5" : "M9.5 5.5 16 12l-6.5 6.5";
      return `data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'%3E%3Cpath d='${path}' stroke='%23fff8ed' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E`;
    };

    document.querySelectorAll(".testimonials-slider .slick-prev, .testimonials-slider .slick-next").forEach((arrow) => {
      const isPrev = arrow.classList.contains("slick-prev");
      arrow.classList.add("lp-testimonial-arrow", isPrev ? "lp-testimonial-arrow-prev" : "lp-testimonial-arrow-next");
      arrow.setAttribute("aria-label", isPrev ? "Previous testimonial" : "Next testimonial");

      if (arrow.tagName.toLowerCase() === "img") {
        arrow.setAttribute("src", makeArrow(isPrev ? "prev" : "next"));
        arrow.setAttribute("alt", isPrev ? "Previous testimonial" : "Next testimonial");
      }
    });
  }

  function initNewsletter() {
    document.querySelectorAll("[data-newsletter-form]").forEach((form) => {
      form.addEventListener("submit", (event) => {
        event.preventDefault();
        const input = form.querySelector("input");
        if (input) {
          input.value = "";
          input.placeholder = "Thank you for joining";
        }
      });
    });
  }
})();
