<template>
    <section class="bg-secondary">

        <main class="relative w-full h-[450px] md:h-[550px] bg-primary overflow-hidden">
            <img 
                src="../assets/img/bgiklan.png" 
                class="absolute inset-0 w-full h-full object-cover opacity-60"
                alt="">
            <div class="absolute inset-0 bg-primary/60"></div>  
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-5">
                <h1 class="text-white text-3xl md:text-5xl font-bold leading-tight">
                    Selamat Datang di Yogyalife
                </h1>
            
                <h2 class="text-white text-xl md:text-3xl mt-2 ">
                    Penghubung <span class="font-bold text-bgColor">Donor Darah</span>
                </h2>
            
                <button @click="routes('/permohonan')" class="mt-6 bg-white cursor-pointer text-primary font-semibold px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
                    Donorkan
                </button>
            </div>
        </main>
        <main class="bg-secondary pb-8">
            <main class="container m-auto max-w-7xl bg-bgColor mt-10 pb-10 mb-10 shadow">
                <h1 class="py-5 px-4 text-3xl">APA ITU <span class="text-primary">YOGYALIFE</span> INDONESIA?</h1>
                <hr class="text-gray-400">
                <p class="py-5 px-6 font-light">YogyaLife Indonesia merupakan sebuah komunitas sosial, yang dengan sukarela membantu orang lain yang sedang membutuhkan darah secara GRATIS. Menjadi jaringan penghubung antara orang yang membutuhkan darah tadi, dengan orang yang bisa dan mau mendonorkan darahnya. Didirikan oleh 3 Orang atau yang lebih dikenal Tim Izin Serius, pada tanggal 16 Desember 2025.</p>
                <h1 class="py-5 px-4 text-3xl">APA YANG MENGINSPIRASI TERBENTUKNYA <span class="text-primary">YOGYALIFE</span> INDONESIA?</h1>
                <hr class="text-gray-400">
                <p class="py-5 px-6 font-light mb-2">Yogyalife Indonesia terinspirasi dari banyaknya cerita masyarakat yang kesulitan mendapatkan pendonor darah tepat waktu. Dalam situasi darurat, informasi mengenai ketersediaan darah sering kali terlambat, tersebar di berbagai platform, atau bahkan tidak terakses sama sekali. Kondisi ini membuat banyak keluarga harus berjuang sendiri mencari bantuan, padahal sebenarnya ada banyak pendonor sukarela yang ingin membantu tetapi tidak tahu harus menolong siapa.</p>
                <p class="py-5 px-6 font-light">Melihat kenyataan tersebut, kami merasa ada kebutuhan besar untuk menghadirkan sebuah platform yang mampu mempertemukan pendonor dan penerima darah dengan lebih cepat, terorganisir, dan mudah dijangkau siapa pun. Dari sinilah Yogyalife Indonesia lahir—sebagai jembatan harapan antara mereka yang membutuhkan bantuan dan para pendonor yang siap berbagi kehidupan.</p>
                <p class="py-5 px-6 font-light">Dengan memanfaatkan teknologi, Yogyalife Indonesia berkomitmen menciptakan sistem informasi donor darah yang transparan, responsif, dan berdampak nyata. Kami percaya bahwa setetes darah bukan hanya menyelamatkan nyawa, tetapi juga memperkuat rasa kemanusiaan dan kepedulian antar sesama. Kami hadir bukan sekadar sebagai platform, tetapi sebagai gerakan sosial yang mengajak lebih banyak orang untuk peduli, berbagi, dan menjadi bagian dari perubahan yang menyelamatkan banyak kehidupan.</p>
                <h1 class="py-5 px-4 text-3xl">BAGAIMANA SEJARAH AWALNYA <span class="text-primary">YOGYALIFE</span> INDONESIA BERDIRI?</h1>
                <hr class="text-gray-400">
                <p class="py-5 px-6 font-light">Yogyalife Indonesia berawal dari keprihatinan tiga orang teman yang kerap menyaksikan keluarga atau kerabat kesulitan mencari pendonor darah dalam keadaan darurat. Mereka melihat bahwa meski banyak orang ingin membantu, proses menemukan pendonor yang cocok sering kali lambat, tidak terkoordinasi, dan bergantung pada informasi yang tersebar di berbagai grup atau media sosial.</p>
                <p class="py-5 px-6 font-light">Berangkat dari pengalaman pribadi tersebut, ketiga pendiri ini mulai memikirkan bagaimana cara menghadirkan sebuah sistem yang lebih cepat, mudah diakses, dan bisa mempertemukan pendonor dengan mereka yang membutuhkan secara langsung. Dari obrolan kecil di sebuah kafe, berkembanglah sebuah gagasan besar: membuat platform digital yang mempermudah proses pencarian dan pendonoran darah di seluruh Indonesia.</p>
                <p class="py-5 px-6 font-light">Kini, Yogyalife Indonesia berdiri sebagai wujud nyata dari kolaborasi tiga orang yang ingin menjadikan kepedulian sosial lebih terorganisir, lebih cepat, dan lebih mudah diakses oleh siapa pun yang membutuhkan.</p>
            </main>
            <main class="container m-auto max-w-4xl text-center mb-20">
                <h1 class="text-3xl">TIM <span class="text-primary">KAMI</span></h1>
                <p class="">Yogyalife Indonesia berawal dari keprihatinan tiga orang teman yang kerap menyaksikan keluarga atau kerabat kesulitan mencari pendonor darah dalam keadaan darurat. Mereka melihat bahwa meski banyak orang ingin membantu, proses menemukan pendonor yang cocok sering kali lambat, tidak terkoordinasi, dan bergantung pada informasi yang tersebar di berbagai grup atau media sosial.</p>
                <div class="flex md:flex-row flex-col px-5 md:px-0 gap-10 mt-20">
                    <div class="bg-bgColor pb-4">
                        <img src="../assets/img/chandra.jpg" class="md:w-70 w-full" alt="">
                        <h1 class="font-bold pt-5">Chandra</h1>
                        <span>Informatika</span>
                    </div>
                    <div class="bg-bgColor">
                        <img src="../assets/img/" class="w-70" alt="">
                        <h1 class="font-bold pt-5">Zaki</h1>
                        <span>Informatika</span>
                    </div>
                    <div class="bg-bgColor">
                        <img src="../assets/img/profilgithub.png" class="md:w-70 w-full md:h-45 object-cover" alt="">
                        <h1 class="font-bold pt-5">Ilham</h1>
                        <span>Informatika</span>
                    </div>
                </div>
            </main>
        </main>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { store, logout } from '../stores/stores'
import { useRouter } from 'vue-router'
import img1 from '../assets/img/iklan.png'
import img2 from '../assets/img/iklan2.png'
import img3 from '../assets/img/iklan3.png'
import Footer from '@/components/Footer.vue'
import Navbar from '@/components/Navbar.vue'

const openNavbar = ref(false)
const slides = [
  img1,
  img2,
  img3
]

const routes = (nama) => {
    router.push(`${nama}`)
}

const currentIndex = ref(0)

function next() {
  currentIndex.value = (currentIndex.value + 1) % slides.length
}

function prev() {
  currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length
}

const router = useRouter()
const logoutUser = () => {
  logout(router)
}
</script>