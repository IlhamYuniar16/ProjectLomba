<template>
    <section class="bg-secondary">
        <main class="flex justify-around items-center">
            <div class="flex items-center gap-4">
                <img class="w-13" src="../assets/img/logoyogyalife.png" alt="">
                <h1 class="text-3xl text-primary">Yogyalife</h1>
            </div>
            <main class="gap-10 flex items-center">
                <a href="/masuk" v-if="!store.isLoggedIn" class="bg-primary px-5 py-2 rounded-full text-bgColor">Masuk</a>
                <a href="/daftarakun" v-if="!store.isLoggedIn" class="bg-bgColor px-5 py-2 rounded-full text-primary">Daftar</a>
                <a v-if="store.isLoggedIn" class="text-danger">Hi, {{ store.user.name }} </a>
                <button @click="logoutUser" v-if="store.isLoggedIn" class="ml-3 px-4 py-2 rounded-md text-red-600 cursor-pointer hover:bg-red-500 hover:text-white transition-all 0.5s">Logout</button>
            </main>
        </main>
        <main class="bg-bgColor">
            <main class="bg-bgColor flex justify-evenly container m-auto">
                <a href="" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">Beranda</a>
                <a href="/about" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">Tentang</a>
                <a href="" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">Permohonan</a>
                <a href="" class="hover:bg-primary py-5 px-5 hover:text-bgColor font-light">History</a>
            </main>
        </main>
        <main class="bg-secondary">
            <main class="">
                <div class="">
                    <h1 class="text-primary font-light">Anda membutuhkan darah?</h1>
                    <span class="">Silakan kirim informasi kebutuhannya di sini</span>
                </div>
                <div class="">
                    <button></button>
                </div>
            </main>
        </main>
    </section>
</template>

<script setup>
import { store, logout } from '../stores/stores'
import { useRouter } from 'vue-router'

const router = useRouter()
const logoutUser = () => {
  logout(router)
}
</script>