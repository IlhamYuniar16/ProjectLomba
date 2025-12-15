<script setup>
import Footer from '@/components/Footer.vue';
import { store, logout } from '@/stores/stores';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const openNavbar = ref(false)
const route = useRoute()
const isVisible = ref(false)

const closeNavbar = ()=> {
  openNavbar.value = false
}

function checkScroll() {
  isVisible.value = window.scrollY > 1300
}

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}

onMounted(() => {
  window.addEventListener("scroll", checkScroll)
})

onBeforeUnmount(() => {
  window.removeEventListener("scroll", checkScroll)
})

const isActiveMenu = (path)=> {
    return route.path === path ? 'bg-primary text-white' : 'hover:bg-primary hover:text-bgColor'
}

const isActiveMenuMobile = (path)=> {
    return route.path === path ? 'text-primary' : 'hover:text-primary '
}


const router = useRouter()

const logoutUser = () => {
  logout(router)
}

</script>

<template>
    <section class="bg-secondary">
        <main class="flex justify-between px-5 md:px-0 md:justify-around items-center">
            <div class="flex items-center gap-4">
                <img class="md:w-13 w-9 md:py-0 py-5" src="../assets/img/logoyogyalife.png" alt="">
                <h1 class="md:text-3xl text-2xl text-primary">Yogyalife</h1>
            </div>
            <main class="gap-3 hidden md:flex items-center ">
                <router-link to="/masuk" v-if="!store.isLoggedIn" class="bg-primary px-5 py-2 rounded-full text-bgColor">Masuk</router-link>
                <router-link to="/daftarakun" v-if="!store.isLoggedIn" class="bg-bgColor px-5 py-2 rounded-full text-primary">Daftar</router-link>
                <a v-if="store.isLoggedIn" class="text-danger">Hi, {{ store.user.name }} </a>
                <button @click="logoutUser" v-if="store.isLoggedIn" class="ml-3 text-red-600 rounded-lg px-5 py-2 hover:bg-red-600 hover:text-white transition-all 0.25s cursor-pointer">Logout</button>
            </main>
            <div class="flex md:hidden">
              <button v-if="openNavbar" @click="openNavbar = !openNavbar" class="md:hidden block"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg></button>
              <button v-else @click="openNavbar = !openNavbar" class="md:hidden block"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg></button>
            </div>
        </main>
        <main class="bg-bgColor md:block hidden">
            <main class="bg-bgColor flex gap-20 justify-center container m-auto">
                <router-link to="/" :class="isActiveMenu('/') " class=" py-5 px-5  font-light ">Beranda</router-link>
                <router-link to="/tentang" :class="isActiveMenu('/tentang') " class="py-5 px-5 font-light">Tentang</router-link>
                <router-link to="/permohonan" :class="isActiveMenu('/permohonan')" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">Permohonan</router-link>
                <router-link to="/history" :class="isActiveMenu('/history')" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">History</router-link>
            </main>
        </main>
        <main v-if="openNavbar" class="bg-bgColor md:hidden">
            <main class="bg-bgColor pb-5 flex-col pr-2 flex items-end justify-end">
                <router-link @click="closeNavbar" to="/" :class="isActiveMenuMobile('/')" class="py-5 px-5 font-light">Beranda</router-link>
                <router-link @click="closeNavbar" to="/tentang" :class="isActiveMenuMobile('/tentang')" class="py-5 px-5 font-light">Tentang</router-link>
                <router-link @click="closeNavbar" to="/permohonan" :class="isActiveMenuMobile('/permohonan')" class=" py-5 px-5 font-light">Permohonan</router-link>
                <router-link @click="closeNavbar" to="/history" :class="isActiveMenuMobile('/history')" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">History</router-link>
                <div class="flex gap-5">
                  <router-link to="/masuk" v-if="!store.isLoggedIn" class="bg-primary px-5 py-2 rounded-full text-bgColor">Masuk</router-link>
                  <router-link to="/daftarakun" v-if="!store.isLoggedIn" class="bg-secondary px-5 py-2 rounded-full text-primary">Daftar</router-link>
                </div>
            </main>
        </main>
        <router-view/>
        <button v-if="isVisible" @click="scrollToTop" class="fixed bottom-6 animate-bounce right-6 bg-primary text-white px-4 py-4 rounded-full cursor-pointer shadow-xl transition-all duration-300 hover:scale-110"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
</svg>
</button>
        <Footer/>
    </section>
</template>