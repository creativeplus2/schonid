---
layout: default
cms: page
title: Home
banners:
    - image: /assets/images/Banner-Caliper.jpg
      url: /products/caliper/
    - image: /assets/images/Banner-Hybrid.jpg
      url: /products/hi-bird/
    - image: /assets/images/Banner-Vision.jpg
      url: /products/vision/
    - image: /assets/images/Banner-Form.jpg
      url: /products/form/
---

<section class="banner">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
            {% for banner in page.banners %}
                <a href="{{ banner.url | relative_url}}" class="swiper-slide">
                    <img
                        src="{{ banner.image | relative_url }}"
                        alt="{{ banner.alt }}"
                        class="w-full "
                    >
                </a>
            {% endfor %}
            </div>
        </div>
</section>

<section class=" grid grid-cols-3 md:grid-cols-3 py-4">
  <div class="border border-gray-300">
  <a href="{{ '/products/' | relative_url}}" >
    <img src="assets/images/Chairs.jpg" >
    </a>
  </div>

  <div class="border border-gray-300">
    <a href="{{ '/products/' | relative_url}}" >

    <img src="assets/images/Desking Storage.jpg" >
    </a>

  </div>

  <div class="border border-gray-300">
    <a href="{{ '/products/' | relative_url}}" >

    <img src="assets/images/Workstations.jpg" >
    </a>

  </div>
</section>
