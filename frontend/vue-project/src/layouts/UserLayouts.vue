<script setup>
import Footer from '@/components/Footer.vue';
import { store, logout } from '@/stores/stores';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const openNavbar = ref(false)
const route = useRoute()

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
                <h1 class="text-3xl text-primary">Yogyalife</h1>
            </div>
            <main class="gap-10 hidden md:flex items-center ">
                <a href="/masuk" v-if="!store.isLoggedIn" class="bg-primary px-5 py-2 rounded-full text-bgColor">Masuk</a>
                <a href="/daftarakun" v-if="!store.isLoggedIn" class="bg-bgColor px-5 py-2 rounded-full text-primary">Daftar</a>
                <a v-if="store.isLoggedIn" class="text-danger">Hi, {{ store.user.name }} </a>
                <button @click="logoutUser" v-if="store.isLoggedIn" class="ml-3 text-red-600">Logout</button>
            </main>
            <button @click="openNavbar = !openNavbar" class="md:hidden block"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg></button>
        </main>
        <main class="bg-bgColor md:block hidden">
            <main class="bg-bgColor flex justify-evenly container m-auto">
                <a href="/" :class="isActiveMenu('/') " class=" py-5 px-5  font-light ">Beranda</a>
                <a href="/tentang" :class="isActiveMenu('/tentang') " class="py-5 px-5 font-light">Tentang</a>
                <a href="/permohonan" :class="isActiveMenu('/permohonan')" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">Permohonan</a>
                <a href="" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">History</a>
            </main>
        </main>
        <main v-if="openNavbar" class="bg-bgColor md:hidden">
            <main class="bg-bgColor pb-5 flex-col pr-2 flex items-end justify-end">
                <a href="/" :class="isActiveMenuMobile('/')" class="py-5 px-5 font-light">Beranda</a>
                <a href="/tentang" :class="isActiveMenuMobile('/tentang')" class="py-5 px-5 font-light">Tentang</a>
                <a href="/permohonan" :class="isActiveMenuMobile('/permohonan')" class=" py-5 px-5 font-light">Permohonan</a>
                <a href="" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">History</a>
                <div class="flex gap-5">
                  <a href="/masuk" v-if="!store.isLoggedIn" class="bg-primary px-5 py-2 rounded-full text-bgColor">Masuk</a>
                  <a href="/daftarakun" v-if="!store.isLoggedIn" class="bg-secondary px-5 py-2 rounded-full text-primary">Daftar</a>
                </div>
            </main>
        </main>
        <router-view/>
        <Footer/>
    </section>
</template>