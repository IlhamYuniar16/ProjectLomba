<template>
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
          <h1 class="font-bold text-3xl">Daftar Sekarang</h1>
        </div>
        <hr class="text-primary">
        <main class="flex flex-col py-5">
          <label class="font-medium pb-2">Nama Lengkap</label>
          <div class="flex items-center border rounded px-2 py-2 ">
            <input class="outline-none w-full" type="text" v-model="name" placeholder="Nama Lengkap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
          </div>
  
          <label class="font-medium pb-2 pt-5">Email</label>
          <div class="border rounded px-2 py-2 flex items-center">
            <input class="outline-none  w-full" type="email" v-model="email" placeholder="Email">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
          </div>
          
          <label class="pt-5 pb-2">Password</label>
          <div class="border rounded px-2 py-2 flex items-center">
            <input class="outline-none  w-full" type="password" v-model="password" placeholder="Password">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
          </div>
  
          <label class="pt-5 pb-2">Konfirmasi Password</label>
          <div class="border rounded px-2 py-2 flex items-center">
            <input class="outline-none  w-full" type="password" v-model="konfirmasipassword" placeholder="Password">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
          </div>
          <div class="my-5 bg-primary flex items-center justify-center rounded-full py-2 text-bgColor cursor-pointer" @click="register">
            <svg v-if="loading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-spin size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
            <button v-else class="">Daftar</button>
          </div>
          <div>
            <span class="text-xs">Sudah jadi anggota? <routerLink to="/masuk" class="underline text-primary">Masuk Sekarang</routerLink></span>
          </div>
        </main>
      </main>
    </div>
  </section>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'
import {alertSuccess, alertError} from "../services/alert.js"
import { useRouter } from 'vue-router'
import { ArrowLeftIcon } from '@heroicons/vue/24/solid'

const name = ref('')
const email = ref('')
const password = ref('')
const konfirmasipassword = ref('')
const router = useRouter()
const loading = ref(false)

const register = async () => {
  if(!name.value || !email.value || !password.value || !konfirmasipassword.value){
    alert("Semua field wajib diisi!")
    return
  }

  if(password.value !== konfirmasipassword.value){
    alert("Password tidak sama!")
    return
  }
  if (loading.value) return
  
  loading.value = true 

  try {
    const res = await axios.post(
      "http://localhost/ProjectLomba/backend/register.php",
      {
        name: name.value,
        email: email.value,
        password: password.value,
        konfirmasipassword: konfirmasipassword.value
      },
      { headers: { "Content-Type": "application/json" } }
    )

    name.value = ""
    email.value = ""
    password.value = ""
    konfirmasipassword.value = ""

    if(res.data.status === "success"){
      await alertSuccess("Berhasil Registrasi, Cek email untuk verifikasi")
      loading.value = false
      router.push({path: '/masuk'})
    } else {
      await alertError(res.data.status)
    }

    loading.value = false

  } catch (err) {
    console.error(err)
    alert("Gagal terhubung server!")
  } finally {
    loading.value = false
  }
}
</script>
