<template>
  <section class="flex items-center justify-center h-screen">
    <main class="flex flex-col min-w-sm">
      <div class="flex items-center gap-3">
        <img src="../assets/img/logoyogyalife.png" class="w-6" alt="">
        <span class="text-primary">Yogyalife</span>
      </div>
      <div class="pb-3">
        <h1 class="font-bold text-3xl">Daftar Sekarang</h1>
      </div>
      <hr class="text-primary">
      <main class="flex flex-col py-5">
        <label class="font-medium pb-2">Nama Lengkap</label>
        <input class="outline-none border rounded px-2 py-2 w-full" type="text" v-model="name" placeholder="Nama Lengkap">

        <label class="font-medium pb-2 pt-5">Email</label>
        <input class="outline-none border rounded px-2 py-2 w-full" type="email" v-model="email" placeholder="Email">

        <label class="pt-5 pb-2">Password</label>
        <input class="outline-none border rounded px-2 py-2 w-full" type="password" v-model="password" placeholder="Password">

        <label class="pt-5 pb-2">Konfirmasi Password</label>
        <input class="outline-none border rounded px-2 py-2 w-full" type="password" v-model="konfirmasipassword" placeholder="Konfirmasi Password">

        <button @click="register" class="my-5 bg-primary rounded-full py-2 text-bgColor cursor-pointer hover:bg-red-700 transition-all 0.25s">Daftar</button>
        <div>
          <span class="text-xs">Sudah jadi anggota? <a href="/masuk" class="underline text-primary">Masuk Sekarang</a></span>
        </div>
      </main>
    </main>
  </section>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'

const name = ref('')
const email = ref('')
const password = ref('')
const konfirmasipassword = ref('')

const register = async () => {
  if(!name.value || !email.value || !password.value || !konfirmasipassword.value){
    alert("Semua field wajib diisi!")
    return
  }

  if(password.value !== konfirmasipassword.value){
    alert("Password tidak sama!")
    return
  }

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

    if(res.data.status === "success"){
      alert(res.data.message)
      window.location.href = `http://localhost/ProjectLomba/backend/verify_page.php`
    } else {
      alert(res.data.message)
    }

  } catch (err) {
    console.error(err)
    alert("Gagal terhubung server!")
  }
}
</script>
