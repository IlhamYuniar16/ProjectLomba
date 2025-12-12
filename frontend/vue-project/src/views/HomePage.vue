<template>
    <section class="bg-secondary">
        <main class="bg-secondary mt-5">
            <main class="flex md:flex-row flex-col justify-center md:gap-20 px-5 md:px-0 items-center ">
                <div class="">
                    <h1 class="text-primary font-light md:text-left text-center md:text-2xl">Anda membutuhkan darah?</h1>
                    <span class="text-xs">Silakan kirim informasi kebutuhannya di sini</span>
                </div>
                <div class="mt-5 md:mt-0">
                    <routerLink to="/permohonan" class="bg-primary md:py-3 py-2 px-6  text-bgColor rounded-full">Isi Formulir</routerLink>
                </div>
            </main>
            <main class="mt-5 md:mx-0 mx-2">
            <div class="w-full flex justify-center items-center py-8 bg-secondary">
              <div class="relative w-full max-w-7xl h-130 bg-white rounded-xl shadow overflow-hidden">
                <div class="flex h-full transition-transform duration-500" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
                  <div
                    v-for="(slide, i) in slides"
                    :key="i"
                    class="min-w-full h-full flex items-center justify-center"
                  >
                    <img
                      :src="slide"
                      class="w-full h-full object-cover"
                    />
                  </div>
                </div>
                <button
                  @click="prev"
                  class="absolute cursor-pointer top-1/2 left-3 -translate-y-1/2 bg-white w-10 h-10 rounded-full shadow flex items-center justify-center"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
</svg>

                </button>
                <button
                  @click="next"
                  class="absolute top-1/2 right-3 cursor-pointer -translate-y-1/2 bg-white w-10 h-10 rounded-full shadow flex items-center justify-center"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
</svg>

                </button>
                
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                  <span
                    v-for="(dot, i) in slides"
                    :key="'dot-' + i"
                    class="w-3 h-3 rounded-full cursor-pointer"
                    :class="i === currentIndex ? 'bg-primary' : 'bg-bgColor'"
                    @click="currentIndex = i"
                  ></span>
                </div>
            </div>
        </div>
            </main>
        </main>

<main class="bg-bgColor mt-5 pb-20">
    <section class="pt-10 container mx-auto px-4 md:px-0 text-center">
        <h1 class="text-3xl text-primary mb-4">Apa itu Yogyalife?</h1>
        <p class="text-center max-w-2xl mx-auto">
            Yogyalife Indonesia sejak 2025 menjadi penghubung antara orang yang membutuhkan transfusi darah,
            dengan para pendonor darah sukarela. Kami tidak memungut biaya untuk itu, dan para pendonor darah sukarela juga ikhlas membantu.
        </p>
    </section>

    <section class="flex flex-col md:flex-row gap-6 md:gap-10 justify-center items-center mt-20 px-4 md:px-0">
        <routerLink to="/permohonan" class="bg-primary opacity-80 shadow-md rounded-lg min-w-[200px] md:min-w-[250px] flex flex-col py-5 justify-center items-center hover:opacity-100 transition">
            <img src="../assets/img/icondarah.png" class="w-20 mb-4" alt="">
            <span class="text-bgColor text-2xl mb-2">Donorkan</span>
            <p class="text-bgColor text-center text-sm px-4">Cari info pendonor sekarang yuk, sebelum terlambat mendonorkan</p>
        </routerLink>
        <routerLink to="/permohonan" class="bg-primary opacity-80 shadow-md rounded-lg min-w-[200px] md:min-w-[250px] flex flex-col py-5 justify-center items-center hover:opacity-100 transition">
            <img src="../assets/img/icondarah.png" class="w-20 mb-4" alt="">
            <span class="text-bgColor text-2xl mb-2">Permohonan</span>
            <p class="text-bgColor text-center text-sm px-4">Cari info pendonor sekarang yuk, sebelum terlambat mendonorkan</p>
        </routerLink>
        <routerLink to="#" class="bg-primary opacity-80 shadow-md rounded-lg min-w-[200px] md:min-w-[250px] flex flex-col py-5 justify-center items-center hover:opacity-100 transition">
            <img src="../assets/img/icontelepon.png" class="w-20 mb-4" alt="">
            <span class="text-bgColor text-2xl mb-2">Hubungi</span>
            <p class="text-bgColor text-center text-sm px-4">Cari info pendonor sekarang yuk, sebelum terlambat mendonorkan</p>
        </routerLink>
    </section>
</main>


    <main class="bg-secondary mt-10 pb-20">
    <section class="pt-10 container mx-auto px-4 text-center">
        <h1 class="text-3xl text-primary mb-2">Krisis Akan Bantuan</h1>
        <p>Sebaran permintaan donor darah di Indonesia</p>
    </section>

    <section class="flex flex-col md:flex-row justify-center items-center mt-8 gap-4 px-4 md:px-0">
        <div 
            @click="active = 'Kebutuhan'" 
            :class="active === 'Kebutuhan' ? 'border-2 border-primary' : 'border'" 
            class="bg-bgColor py-4 px-6 rounded cursor-pointer text-center w-full md:w-auto"
        >
            <span>Kebutuhan</span>
        </div>
        <div 
            @click="active = 'Pencarian'" 
            :class="active === 'Pencarian' ? 'border-2 border-primary' : 'border'" 
            class="bg-bgColor py-4 px-6 rounded cursor-pointer text-center w-full md:w-auto"
        >
            <span>Pencarian</span>
        </div>
        <div 
            @click="active = 'History'" 
            :class="active === 'History' ? 'border-2 border-primary' : 'border'" 
            class="bg-bgColor py-4 px-6 rounded cursor-pointer text-center w-full md:w-auto"
        >
            <span>History</span>
        </div>
    </section>

    <section class="container mx-auto mt-6 px-4 md:px-0 flex flex-col gap-2">
        <div v-if="active === 'Kebutuhan'" class="flex flex-col gap-3 w-full max-w-md mx-auto">
            <div class="bg-bgColor flex justify-between items-center p-4 border rounded">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-primary font-semibold">#B2HSY_UU111</span>
                        <span>Steve Alonso - Bantul</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-red-500 font-semibold">URGENT</span>
                    <span class="bg-primary text-bgColor py-1 px-3 rounded-full font-bold">A</span>
                </div>
            </div>
        
            <div class="bg-bgColor flex justify-between items-center p-4 border rounded">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-primary font-semibold">#B2HSY_UU112</span>
                        <span>Jane Doe - Sleman</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-red-500 font-semibold">URGENT</span>
                    <span class="bg-primary text-bgColor py-1 px-3 rounded-full font-bold">B</span>
                </div>
            </div>
        </div>


        <div v-if="active === 'Pencarian'" class="flex flex-col gap-3 w-full max-w-md mx-auto">
          <div class="flex border max-w-md px-3 py-3 rounded-2xl">
            <input type="text" v-model="search" class="outline-none w-full" placeholder="Cari">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
          </div>
            <div class="bg-bgColor flex justify-between items-center p-4 border rounded">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-primary font-semibold">#B2HSY_UU111</span>
                        <span>Steve Alonso - Bantul</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-red-500 font-semibold">URGENT</span>
                    <span class="bg-primary text-bgColor py-1 px-3 rounded-full font-bold">A</span>
                </div>
            </div>
        
            <div class="bg-bgColor flex justify-between items-center p-4 border rounded">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-primary font-semibold">#B2HSY_UU112</span>
                        <span>Jane Doe - Sleman</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-red-500 font-semibold">URGENT</span>
                    <span class="bg-primary text-bgColor py-1 px-3 rounded-full font-bold">B</span>
                </div>
            </div>
        </div>

        <div v-if="active === 'History'" class="text-center">
            <h1>History</h1>
        </div>
    </section>
</main>

    </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { store, logout } from '../stores/stores'
import { useRouter } from 'vue-router'
import img1 from '../assets/img/iklan.png'
import img2 from '../assets/img/iklan2.png'
import img3 from '../assets/img/iklan3.png'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const active = ref('Kebutuhan')
const intervalTime = 3000
let autoSlide
const slides = [
  img1,
  img2,
  img3
]

const currentIndex = ref(0)

function next() {
  currentIndex.value = (currentIndex.value + 1) % slides.length
}

function prev() {
  currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length
}

onMounted(() => {
  autoSlide = setInterval(() => {
    next()
  }, intervalTime)
})

onBeforeUnmount(() => {
  clearInterval(autoSlide)
})

</script>