---
layout: default
title: Products
permalink: /products/
---

<div class="grid grid-cols-3 gap-4">
<div class="border border-gray-300 mt-6 p-3">
<h4 class="uppercase font-bold">Workstation</h4>
<hr class="border-t border-gray-300 mt-3 mb-1.5"/>
{% assign products = site.products | where: "category", "workstation" %}

{% for product in products %} <a class="border border-white flex p-1.5 hover:border-[#9fc646] hover:border" href="{{ product.url | relative_url }}">
<img src="{{ product.thumb | relative_url }}" class="w-full"/> </a> <hr class="border-t border-gray-300 my-1.5"/> {% endfor %}

</div>
<div class="border border-gray-300 mt-6 p-3">
<h4 class="uppercase font-bold">chairs</h4>
<hr class="border-t border-gray-300 mt-3 mb-1.5"/>
{% assign products = site.products | where: "category", "chairs" %}

{% for product in products %} <a class="border border-white flex p-1.5 hover:border-[#9fc646] hover:border" href="{{ product.url | relative_url }}">
<img src="{{ product.thumb | relative_url }}" class="w-full"/> </a> <hr class="border-t border-gray-300 my-1.5"/> {% endfor %}

</div>
<div class="border border-gray-300 mt-6 p-3">
<h4 class="uppercase font-bold">Desking & Storage</h4>
<hr class="border-t border-gray-300 mt-3 mb-1.5"/>
{% assign products = site.products | where: "category", "desking-storage" %}

{% for product in products %} <a class="border border-white flex p-1.5 hover:border-[#9fc646] hover:border" href="{{ product.url | relative_url }}">
<img src="{{ product.thumb | relative_url }}" class="w-full"/> </a> <hr class="border-t border-gray-300 my-1.5"/> {% endfor %}

</div>
</div>
