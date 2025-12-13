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
                <button @click="historyTab = 'permohonan'" :class="historyTab === 'permohonan' ? 'cursor-pointer font-semibold bg-primary text-white px-12 py-2 rounded-full transition-all duration-200' : 'cursor-pointer font-semibold text-primary px-12 py-2 transition-all duration-200'" >Permohonan</button>
                <button @click="historyTab = 'donor'" :class="historyTab === 'donor' ? 'cursor-pointer font-semibold bg-primary text-white px-12 py-2 rounded-full transition-all duration-200' : 'cursor-pointer font-semibold text-primary px-12 py-2 transition-all duration-200'">Donor</button>
            </div>
        </main>
        <main v-if="historyTab === 'permohonan'" class="my-20 md:mx-0 mx-5">
          <div class="container max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                  Diterima
                </span>
              </div>
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pasien</span>
                  <span class="font-medium">Ilham Yuniar</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Rumah Sakit</span>
                  <span class="font-medium">Rs Kumalasiwi</span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">A</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">01 Jan 2025</span>
                </div>
              </div>
              <div class="mt-6">
                <button class="min-w-2xs cursor-pointer border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div>
            </div>
            <div class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                 Batal
                </span>
              </div>
          
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pasien</span>
                  <span class="font-medium">Siti Aisyah</span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Rumah Sakit</span>
                  <span class="font-medium">Rs Kumalasiwi</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">O</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">05 Jan 2025</span>
                </div>
                
              </div>
              <div class="mt-6">
                <button class="min-w-2xs border cursor-pointer border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div>
            </div>
            <div class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                 Batal
                </span>
              </div>
          
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pasien</span>
                  <span class="font-medium">Siti Aisyah</span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Rumah Sakit</span>
                  <span class="font-medium">Rs Kumalasiwi</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">O</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">05 Jan 2025</span>
                </div>
                
              </div>
              <div class="mt-6">
                <button class="min-w-2xs border cursor-pointer border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div>
            </div>
          </div>
        </main>
        <main v-if="historyTab === 'donor'" class="my-20 md:mx-0 mx-5">
          <div class="container max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                  Not eligibl
                </span>
              </div>
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pendonor</span>
                  <span class="font-medium">Ilham Yuniar</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">A</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">01 Jan 2025</span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Jenis Donor</span>
                  <span class="font-medium">Darah Penuh</span>
                </div>
              </div>
              <!-- <div class="mt-6">
                <button class="min-w-2xs cursor-pointer border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div> -->
            </div>
            <div class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                  eligible
                </span>
              </div>
          
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pasien</span>
                  <span class="font-medium">Siti Aisyah</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">O</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">05 Jan 2025</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-500">Jenis Donor</span>
                  <span class="font-medium">Darah Penuh</span>
                </div>
              </div>
              <!-- <div class="mt-6">
                <button class="min-w-2xs border cursor-pointer border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div> -->
            </div>
            <div class="bg-white w-full rounded-2xl max-w-md mx-auto shadow-md p-6 flex flex-col justify-between">
              <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                  eligible
                </span>
              </div>
          
              <div class="space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                  <span class="text-gray-500">Nama Pasien</span>
                  <span class="font-medium">Siti Aisyah</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Golongan Darah</span>
                  <span class="font-medium">O</span>
                </div>
            
                <div class="flex justify-between">
                  <span class="text-gray-500">Tanggal</span>
                  <span class="font-medium">05 Jan 2025</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-500">Jenis Donor</span>
                  <span class="font-medium">Darah Penuh</span>
                </div>
              </div>
              <!-- <div class="mt-6">
                <button class="min-w-2xs border cursor-pointer border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-sm py-2 rounded-xl">
                  Batalkan Permohonan
                </button>
              </div> -->
            </div>
          </div>
        </main>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const historyTab = ref('permohonan')
</script>