<template>
  <section class="flex items-center justify-center min-h-screen px-4">
    <section
      class="bg-secondary  flex flex-col md:flex-row rounded-2xl w-full max-w-5xl py-8 px-6 md:px-20 gap-10"
    >
      <main
        class="hidden md:flex relative flex-col min-w-sm bg-secondary/80 backdrop-blur-xl p-8 rounded-2xl border border-white/10 shadow-xl justify-center"
      >
        <span class="inline-block mb-3 px-4 py-1 text-xs font-semibold rounded-full bg-primary/20 text-primary">
          Customer Support
        </span>

        <h2 class="text-3xl font-bold mb-4">Hubungi Kami</h2>

        <p class="text-sm opacity-80 mb-6 leading-relaxed">
          Punya pertanyaan seputar layanan Yogyalife?
          Tim kami siap membantu kamu kapan saja.
        </p>

        <div class="w-12 h-1 bg-primary rounded-full mb-8"></div>

        <div class="flex flex-col gap-5 ">
            <div class="flex items-center gap-4"> <div class="bg-primary/20 p-3 rounded-full"> <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0L12 13.5 2.25 6.75" /> </svg> </div> <div> <p class="text-sm font-medium">Email</p> <p class="text-xs opacity-70">support@yogyalife.com</p> </div> </div>
            <div class="flex items-center gap-4"> <div class="bg-primary/20 p-3 rounded-full"> <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75h6.75m-6.75 3h6.75m-3 3a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /> </svg> </div> <div> <p class="text-sm font-medium">WhatsApp</p> <p class="text-xs opacity-70">+62 812-3456-7890</p> </div> </div>
            <div class="flex items-center gap-4"> <div class="bg-primary/20 p-3 rounded-full"> <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6.75-6.75 6.75-11.25A6.75 6.75 0 1 0 5.25 9.75C5.25 14.25 12 21 12 21Z" /> </svg> </div> <div> <p class="text-sm font-medium">Lokasi</p> <p class="text-xs opacity-70">Yogyakarta, Indonesia</p> </div> </div>
        </div>

        <div class="absolute -top-10 -left-10 w-32 h-32 bg-primary/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
      </main>
      <main class="flex flex-col w-full md:min-w-sm">
        <div class="flex items-center gap-3 mb-4">
          <router-link to="/">
            <img src="../assets/img/logoyogyalife.png" class="w-6 cursor-pointer" />
          </router-link>
          <router-link to="/" class="text-primary font-medium">Yogyalife</router-link>
        </div>

        <h1 class="font-bold text-3xl mb-2">Hubungi Yogyalife</h1>
        <hr class="text-primary mb-6" />

        <div class="md:hidden bg-primary/10 p-4 rounded-xl mb-6">
          <p class="text-sm font-semibold text-primary">Butuh bantuan?</p>
          <p class="text-xs opacity-70">Kami siap membantu via WhatsApp</p>
        </div>

        <div class="flex flex-col gap-4">
          <label for="">Nama Lengkap</label>
          <input label="Nama Lengkap" v-model="name" placeholder="Nama Lengkap" class="outline-none py-2 px-3 border rounded-md"/>
          <label for="">Email</label>
          <input label="Email" type="email" v-model="email" placeholder="Email" class="outline-none py-2 px-3 border rounded-md"/>

          <div>
            <label class="font-medium text-sm">Pesan</label>
            <textarea
              v-model="message"
              rows="5"
              placeholder="Tuliskan pesan anda..."
              class="mt-1 w-full border rounded px-3 py-2 outline-none text-sm resize-none"
            ></textarea>
          </div>

          <button @click="sendToWhatsApp" class="mt-4 bg-primary text-bgColor py-3 rounded-full font-medium hover:opacity-90 transition">
            Hubungi via WhatsApp
          </button>
          <router-link to="/" class="mt-1 bg-gray-400 w-full text-center text-bgColor py-3 rounded-full font-medium hover:opacity-90 transition">
            Kembali
          </router-link>           
        </div>
      </main>
    </section>
  </section>
</template>

<script setup>
import { ref } from "vue";

const name = ref("");
const email = ref("");
const message = ref("");
const phoneNumber = "62899181829";

const sendToWhatsApp = () => {
  if (!name.value || !email.value || !message.value) {
    alert("Mohon lengkapi semua data");
    return;
  }

  const text = `
Halo Yogyalife 👋

Nama: ${name.value}
Email: ${email.value}

Pesan:
${message.value}
  `;

  const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(text)}`;
  window.open(url, "_blank");
};
</script>
