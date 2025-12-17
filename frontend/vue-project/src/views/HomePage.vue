<script setup>
import { ref, onMounted, onBeforeUnmount, computed, watch } from 'vue';
import { store, logout } from '../stores/stores'
import { RouterLink, useRouter } from 'vue-router'
import axios from 'axios'
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

const permohonan = ref([])

const fetchHistoryPermohonan = async () => {
  try {
    const res = await axios.get(
      'http://localhost/ProjectLomba/backend/history_permohonan.php',
      { withCredentials: true }
    )
    permohonan.value = res.data.data
    isLogin.value = true
console.log(permohonan.value)
  } catch (err) {
    if (err.response?.status === 401) {
      isLogin.value = false
      permohonan.value = []
    }
  }
}

const permohonan_batal = async (id) => {
  try {
    const formData = new FormData()
    formData.append('status_pengajuan', 'batal')

    const res = await axios.post(
      `http://localhost/ProjectLomba/backend/batal_permohonan.php?id=${id}`,
      formData,
      { withCredentials: true }
    )
    alert(res.data.message)
    fetchHistoryPermohonan()
  } catch (err) {
    console.error(err)
    alert('Terjadi kesalahan')
  }
}

const donorData = ref([])
const fetchHistoryDonor = async () => {
  try {
    const res = await axios.get(
      'http://localhost/ProjectLomba/backend/history_donor.php',
      {
        withCredentials: true
      }
    )  
    donorData.value = res.data.data
    isLogin.value = true

  } catch (err) {
    if (err.response?.status === 401) {
      isLogin.value = false
      donorData.value = []  
    }
  }
}

onMounted(()=>{
  setInterval(() => {
    fetchHistoryDonor()
    fetchHistoryPermohonan()
  }, 1000)
})

const urgent = ref([])
const searchQuery = ref('')
const fetchUrgent = async()=> {
    try{
        const res = await axios.get(`http://localhost/ProjectLomba/backend/home_kebutuhan_urgent.php?search=${searchQuery.value}`)
        urgent.value = res.data.data
    }catch(err){
        console.log(err)
    }
}

const filteredUrgent = computed(() => {
  if (!searchQuery.value) return urgent.value
  return urgent.value.filter(item =>
    item.nama_pasien.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})
onMounted(()=>{
    setInterval(() => {
        fetchUrgent()
    }, 1000)
})

</script>

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

    <section class="flex flex-col md:flex-row gap-6 md:gap-10 justify-center items-center mt-20 px-6 md:px-16 lg:px-24 xl:px-32">
        <a href="/permohonan" class="bg-primary opacity-80 shadow-md rounded-lg min-w-[200px] md:min-w-[250px] flex flex-col py-5 justify-center items-center hover:opacity-100 transition">
            <img src="../assets/img/icondarah.png" class="w-20 mb-4" alt="">
            <span class="text-bgColor text-2xl mb-2">Donorkan</span>
            <p class="text-bgColor text-center text-sm px-4">Cari info pendonor sekarang yuk, sebelum terlambat mendonorkan</p>
        </a>
        <a href="/permohonan" class="bg-primary opacity-80 shadow-md rounded-lg min-w-[200px] md:min-w-[250px] flex flex-col py-5 justify-center items-center hover:opacity-100 transition">
            <img src="../assets/img/icondarah.png" class="w-20 mb-4" alt="">
            <span class="text-bgColor text-2xl mb-2">Permohonan</span>
            <p class="text-bgColor text-center text-sm px-4">Cari info pendonor sekarang yuk, sebelum terlambat mendonorkan</p>
        </a>
        <routerLink to="/hubungi" class="bg-primary opacity-80 shadow-md rounded-lg min-w-[200px] md:min-w-[250px] flex flex-col py-5 justify-center items-center hover:opacity-100 transition">
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
        <div  class="flex flex-col gap-3 w-full max-w-md mx-auto overflow-y-scroll h-100 no-scrollbar">
            <RouterLink v-if="active === 'Kebutuhan'" v-for="(item) in urgent" :key="item.id" :to="`/detail-kebutuhan/${item.id}`" class="bg-bgColor  flex justify-between items-center p-4 border rounded">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-primary font-semibold">#YL-U{{ item.id }}</span>
                        <span>{{ item.nama_pasien }}- {{ item.lokasi_pasien }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-red-500 font-semibold">URGENT</span>
                    <span class="bg-primary text-bgColor py-1 px-3 rounded-full font-bold">{{ item.golongan_darah }}</span>
                </div>
            </RouterLink>
            <div v-if="active === 'Pencarian'"  class="flex flex-col gap-3 w-full max-w-md mx-auto overflow-y-scroll h-100 no-scrollbar">
                <div  class="flex border max-w-md px-3 py-3 rounded-2xl">
                <input type="text" v-model="searchQuery" class="outline-none w-full" placeholder="Cari nama pasien">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </div>
                <RouterLink v-for="(item) in filteredUrgent" :key="item.id" :to="`/detail-kebutuhan/${item.id}`" class="bg-bgColor flex justify-between items-center p-4 border rounded">
                    <div class="flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-primary font-semibold">#YL-U{{ item.id }}</span>
                            <span>{{ item.nama_pasien }} - {{ item.lokasi_pasien }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-red-500 font-semibold">URGENT</span>
                        <span class="bg-primary text-bgColor py-1 px-3 rounded-full font-bold">{{ item.golongan_darah }}</span>
                    </div>
                </RouterLink>
            </div>
            <div v-if="active === 'History'" class="container max-w-4xl mx-auto grid grid-cols-1 gap-5">
              <div v-for="(item, index) in permohonan.slice(0, 5)" :key="index" class="bg-white w-full rounded-2xl mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span
                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full"
                :class="{
                  'bg-green-100 text-green-600': item.status_pengajuan === 'diterima' || item.status_pengajuan === 'selesai',
                  'bg-yellow-100 text-yellow-600': item.status_pengajuan === 'pending',
                  'bg-red-100 text-red-600': item.status_pengajuan === 'batal'
                }">
                {{ item.status_pengajuan }}
              </span>
              </div>
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pasien</span>
                  <span class="font-medium">{{ item.nama_pasien }}</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Rumah Sakit</span>
                  <span class="font-medium">{{ item.nama_rumah_sakit }}</span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">{{ item.golongan_darah }}</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">{{ item.created_at }}</span>
                </div>
              </div>
              <div class="mt-6">
                <button
              v-if="item.status_pengajuan === 'pending' || item.status_pengajuan === 'batal'"
              @click="item.status_pengajuan === 'pending' && permohonan_batal(item.id)"
              :disabled="item.status_pengajuan === 'batal'"
              :class="[
                'w-full text-sm py-2 rounded-xl transition',
                item.status_pengajuan === 'pending'
                  ? 'border border-red-500 text-red-500 bg-white hover:bg-red-500 hover:text-white cursor-pointer'
                  : 'bg-red-500 text-white cursor-not-allowed'
              ]"
            >
              {{ item.status_pengajuan === 'pending' ? 'Batalkan Permohonan' : 'Pengajuan Dibatalkan' }}
            </button>
              </div>
            </div>
            <!-- <div v-for="(item, index) in donorData.slice(0, 5)" :key="index" class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span
                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full"
                :class="{
                  'bg-green-100 text-green-600': item.status_pengajuan === 'eligible' || item.status_pengajuan === 'selesai',
                  'bg-yellow-100 text-yellow-600': item.status_pengajuan === 'pending',
                  'bg-red-100 text-red-600': item.status_pengajuan === 'not eligible'
                }">
                {{ item.status_pengajuan }}
              </span>
            </div> -->
            <!-- <div class="space-y-2 text-sm text-gray-700">
              <div class="flex justify-between">
                <span class="text-gray-500">Nama Pendonor</span>
                <span class="font-medium">{{ item.nama_pendonor}}</span>
              </div>
              
              <div class="flex justify-between">
                <span class="text-gray-500">Golongan Darah</span>
                <span class="font-medium">{{ item.tipe_darah }}</span>
              </div>
              
              <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>
                <span class="font-medium">{{ item.tanggal }}</span>
              </div>
              
              <div class="flex justify-between">
                <span class="text-gray-500">Jenis Donor</span>
                <span class="font-medium">{{ item.jenis_donor }}</span>
              </div>
            </div> -->
            <!-- <div class="mt-6">
              <button class="min-w-2xs cursor-pointer border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                Batalkan Permohonan
              </button>
            </div> -->
          <!-- </div> -->
          <a href="/history" class="text-primary underline">Lihat Semua</a>
        </div>
        </div>
    </section>
</main>
</section>
</template>