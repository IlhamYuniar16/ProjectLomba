<template>
  <div class="register-card">
    <h2>Buat Akun</h2>
    <input v-model="email" placeholder="Email" type="email" />
    <input v-model="password" placeholder="Password" type="password" />
    <input v-model="passwordConfirmation" placeholder="Konfirmasi Password" type="password" />
    <button @click="registerUser">Daftar</button>

    <p v-if="message" :class="status">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const message = ref('')
const status = ref('')

const registerUser = async () => {
  if(password.value !== passwordConfirmation.value){
    message.value = 'Password dan konfirmasi harus sama!'
    status.value = 'error'
    return
  }

  try {
    const res = await axios.post('http://localhost:8000/backend/register.php', {
      email: email.value,
      password: password.value
    })

    message.value = res.data.message
    status.value = res.data.status

  } catch (err) {
    console.error(err)
    message.value = 'Terjadi kesalahan saat registrasi'
    status.value = 'error'
  }
}
</script>

<style scoped>
.register-card {
  width: 320px;
  padding: 30px;
  margin: 50px auto;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  text-align: center;
  background: white;
}
input {
  width: 100%;
  margin-top: 12px;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ddd;
}
button {
  width: 100%;
  padding: 12px;
  margin-top: 18px;
  background: #4CAF50;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}
button:hover { background: #388e3c; }

.success { color: #4CAF50; margin-top: 12px; }
.error { color: #f44336; margin-top: 12px; }
</style>
