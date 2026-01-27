---
layout: page
cms: page
title: Contact Us
permalink: /contact-us/
---

<form id="my-form"
      action="https://formspree.io/f/xpqddwzn"
      method="POST"
      class="max-w-full mx-auto space-y-4">

  <!-- Name -->
  <div>
    <label class="block text-sm  mb-1">Name</label>
    <input type="text"
           name="name"
           required
           class="w-full border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-[#9fc646]">
  </div>

  <!-- Email -->
  <div>
    <label class="block text-sm  mb-1">Email</label>
    <input type="email"
           name="email"
           required
           class="w-full border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-[#9fc646]">
  </div>

  <!-- Phone -->
  <div>
    <label class="block text-sm  mb-1">Phone</label>
    <input type="tel"
           name="phone"
           class="w-full border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-[#9fc646]">
  </div>

  <!-- Message -->
  <div>
    <label class="block text-sm  mb-1">Message</label>
    <textarea name="message"
              rows="4"
              required
              class="w-full border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-[#9fc646]"></textarea>
  </div>

  <!-- Button -->

<button id="my-form-button"
          type="submit"
          class="bg-[#9fc646] text-white px-6 py-2  hover:bg-[#86b63b] transition"> Submit </button>

  <!-- Status -->
  <p id="my-form-status" class="text-sm mt-2"></p>

</form>
