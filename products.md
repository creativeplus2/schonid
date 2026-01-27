---
layout: default
cms: page
title: Products
permalink: /products/
---

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

{% for cat in site.data.config.product_categories %}

  <div class="border border-gray-300 mt-6 p-3">

    <h4 class="uppercase font-bold text-sm sm:text-base">
      {{ cat.title }}
    </h4>

    <hr class="border-t border-gray-300 mt-3 mb-1.5"/>

    {% assign products = site.products | where: "category", cat.key | sort: "order" %}

    {% for product in products %}
      <a
        href="{{ product.url | relative_url }}"
        class="border border-white flex p-1.5 hover:border-[#9fc646]
               transition-colors duration-200"
      >
        <img
          src="{{ product.thumb | relative_url }}"
          alt="{{ product.title }}"
          class="w-full object-contain"
        />
      </a>

      {% unless forloop.last %}
        <hr class="border-t border-gray-300 my-1.5"/>
      {% endunless %}
    {% endfor %}

  </div>

{% endfor %}

</div>
