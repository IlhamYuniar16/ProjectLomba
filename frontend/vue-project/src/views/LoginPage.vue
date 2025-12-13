<template>
  <div>
    <section class="flex items-center justify-center h-screen">
      <div class="flex flex-col">
        <RouterLink to="/" class="flex items-center gap-2 bg-red-50 text-red-500 w-fit text-sm cursor-pointer px-4 py-1 rounded-full mb-3">
          <ArrowLeftIcon class="size-5"/>
          <p>Kembali</p>
        </RouterLink>
        <main class="flex flex-col min-w-sm">
          <div class="flex items-center gap-3">
            <router-link to="/">
              <img src="../assets/img/logoyogyalife.png" class="w-6 cursor-pointer" alt="">
            </router-link>
            <span class="text-primary">Yogyalife</span>
          </div>
          <div class="pb-3">
            <h1 class="font-bold text-3xl">Masuk Sekarang</h1>
          </div>
          <hr class="text-primary">
          <main class="flex flex-col py-5">
            <label for="" class="font-medium pb-2">Email</label>
            <div class="flex items-center border opacity-45 rounded px-2 py-2 w-full">
              <input class="outline-none w-full text-black" type="text" v-model="email" placeholder="Email">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-55"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
            </div>
            <label for="" class="pt-5 pb-2">Password</label>
            <div class="flex items-center border opacity-45 rounded px-2 py-2 ">
              <input class="outline-none w-full" type="password" v-model="password" placeholder="Password">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-55"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
            </div>
            
              <button @click="login" class="my-5 bg-primary rounded-full py-2 text-bgColor cursor-pointer hover:bg-red-700 transition-all 0.25s">Masuk</button>
            <div>
              <span class="text-xs">Belum jadi anggota? <routerLink to="/daftarakun" class="underline text-primary">Daftar Sekarang</routerLink></span>
            </div>
          </main>
        </main>
      </div>
    </section>
  </div>


</template>

<script setup>
import { ref } from 'vue'
import { store } from '../stores/stores'
import { RouterLink, useRouter } from 'vue-router'
import axios from 'axios'
import { ArrowLeftIcon } from '@heroicons/vue/24/solid'

const email = ref('')
const password = ref('')
const router = useRouter()

const login = async () => {
  if (!email.value || !password.value) {
    alert("Email dan password wajib diisi")
    return
  }

  try {
    const res = await axios.post("http://localhost/ProjectLomba/backend/login.php", {
      email: email.value,
      password: password.value
    }, {
      headers: { "Content-Type": "application/json" },
      withCredentials: true
    })

    if(res.data.status === "success"){
      // Update store dan localStorage
      store.isLoggedIn = true
      store.user = res.data.user
      localStorage.setItem('user', JSON.stringify(res.data.user))

      // Redirect berdasarkan role
      if(res.data.user.role === "admin"){
        router.push("/admin/dashboard")
      } else {
        router.push("/")
      }
    } else {
      alert(res.data.message)
    }

  } catch (err) {
    console.error(err)
    alert("Gagal terhubung server!")
  }
}
</script>

