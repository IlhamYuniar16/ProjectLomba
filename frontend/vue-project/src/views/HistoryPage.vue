<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const isLogin = ref(false)
const historyTab = ref('permohonanTab')
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
    fetchHistoryPermohonan()
    fetchHistoryDonor()
  }, 1000)
})
</script>

<template>
    <section class="bg-secondary">
        <main class="relative w-full h-[450px] md:h-[550px] bg-primary overflow-hidden">
            <img 
                src="../assets/img/bgiklan2.png" 
                class="absolute inset-0 w-full h-full object-cover opacity-60"
                alt="">
            <div class="absolute inset-0 bg-primary/60"></div>  
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-5">
                <h1 class="text-white text-3xl md:text-5xl font-bold leading-tight">HISTORY</h1>
                <h2 class="text-white text-xl md:text-3xl mt-2 ">
                    Penghubung <span class="font-bold text-bgColor">Donor Darah</span>
                </h2>
            </div>
        </main>
        <!-- Content -->
        <main class="mt-10">
            <div class="flex justify-center gap-1 bg-red-100 w-fit mx-auto rounded-full">
                <button @click="historyTab = 'permohonanTab'" :class="historyTab === 'permohonanTab' ? 'cursor-pointer font-semibold bg-primary text-white px-12 py-2 rounded-full transition-all duration-200' : 'cursor-pointer font-semibold text-primary px-12 py-2 transition-all duration-200'" >Permohonan</button>
                <button @click="historyTab = 'donor'" :class="historyTab === 'donor' ? 'cursor-pointer font-semibold bg-primary text-white px-12 py-2 rounded-full transition-all duration-200' : 'cursor-pointer font-semibold text-primary px-12 py-2 transition-all duration-200'">Donor</button>
            </div>
        </main>
        <main v-if="historyTab === 'permohonanTab'"  class="my-20 md:mx-0 mx-5">
          <div v-if="!isLogin" class="text-center text-gray-500">Silahkan login untuk melihat riwayat permohonan</div>
          <div v-else-if="permohonan.length === 0" class="text-center text-gray-500">Belum ada permohonan</div>
          <div v-else class="container max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <div v-for="(item, index) in permohonan" :key="index"
            class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
            <span class="hidden">{{ item.id }}</span>
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
                <span class="font-medium">
                  {{ item.created_at }}
                </span>
              </div>
            </div>

            <!-- ACTION -->
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

            
          </div>
          
        </main>
        <main v-if="historyTab === 'donor'" class="my-20 md:mx-0 mx-5">
          <div v-if="!isLogin" class="text-center text-gray-500">Silahkan login untuk melihat riwayat donor darah</div>
          <div v-else-if="donorData.length === 0" class="text-center text-gray-500">Belum ada donor</div>
          <div v-else class="container max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <div v-for="(item, index) in donorData" :key="index" class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
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
              </div>
              <div class="space-y-2 text-sm text-gray-700">
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
              </div>
              <!-- <div class="mt-6">
                <button class="min-w-2xs cursor-pointer border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div> -->
            </div>
          </div>
        </main>
    </section>
</template>

