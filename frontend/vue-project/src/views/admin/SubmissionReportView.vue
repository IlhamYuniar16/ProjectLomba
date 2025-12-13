<script setup>
import { ChevronLeftIcon, ChevronRightIcon, CloudArrowDownIcon, FunnelIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios'

const permohonan = ref([])

const searchQuery = ref('')

const fetchLaporanPermohonan = async()=> {
    try{
        const res = await axios.get(`http://localhost/ProjectLomba/backend/laporan_permohonan.php?search=${searchQuery.value}`)
        permohonan.value = res.data.data
    }catch(err){
        console.log(err)
    }
}

const filteredPermohonan = computed(() => {
  if (!searchQuery.value) return permohonan.value
  return permohonan.value.filter(item =>
    item.nama_pasien.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const exportFile = (type) => {
  // Gunakan window.open agar browser langsung request ke PHP
  window.open(`http://localhost/ProjectLomba/backend/laporan_donor_export.php?laporan=${type}`, '_blank');
}

watch(searchQuery, () => {
  fetchLaporanPermohonan()
})

onMounted(()=>{
    fetchLaporanPermohonan()
})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Laporan Permohonan</h1>

        <div class="mt-5">
            <div class="flex items-center justify-between">
                <input v-model="searchQuery" type="text" class="px-4 py-2 rounded-full bg-secondary outline-none max-w-sm w-full" placeholder="Cari...">
                <div class="flex items-center gap-3">
                    <button @click="exportFile('permohonan')" class="flex items-center gap-3 px-6 py-2 bg-green-500 rounded text-white cursor-pointer"><CloudArrowDownIcon class="size-5"/>Excel</button>
                    <FunnelIcon class="size-6 text-gray-300 cursor-pointer"/>
                </div>
            </div>

            <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                <table class="w-full mt-5 min-w-max ">
                    <thead>
                        <tr class="border-b border-neutral-300">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left ">Tanggal</th>
                            <th class="px-4 py-3 text-left ">Lokasi Pasien</th>
                            <th class="px-4 py-3 text-left ">Nama Pasien</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Tipe Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Jumlah Pendonor</th>
                            <th class="px-4 py-3 text-left ">Jenis Donor</th>
                            <th class="px-4 py-3 text-left ">Foto Formulir</th>
                            <th class="px-4 py-3 text-left ">Status</th>
                            <th class="px-4 py-3 text-left ">Status Urgent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in filteredPermohonan" :key="item.id"  class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ index+1 }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.created_at }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_rumah_sakit }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.lokasi_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.golongan_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.rhesus }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jumlah_pendonor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jenis_donor_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 "  v-if="item.foto_formulir_rs && item.foto_formulir_rs !== ''"><a :href="`http://localhost/ProjectLomba/backend/${item.foto_formulir_rs}`" Download class="px-3 py-1 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600">Lihat</a></td>
                            <td class="px-4 py-3 text-left text-neutral-600 "  v-else></td>
                            <td class="px-4 py-3 text-left text-neutral-600 "><p class="w-fit px-4 rounded-full"
                                                                                :class="{
                                                                                'text-green-500 bg-green-50': item.status_pengajuan === 'diterima' || 'selesai',
                                                                                'text-yellow-500 bg-yellow-50': item.status_pengajuan === 'pending',
                                                                                'text-red-500 bg-red-50': item.status_pengajuan === 'batal'}">
                                                                                {{ item.status_pengajuan }}</p></td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.status_urgent }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-center gap-2 mt-5">
                <button class="p-2 bg-black rounded text-white cursor-pointer"><ChevronLeftIcon class="size-5"/></button>
                <div class="mx-5 flex items-center gap-2">
                    <div class="cursor-pointer">
                        <p class="px-4 py-2  text-black rounded ">1</p>
                        <div class="h-[2px] bg-black"></div>
                    </div>
                    <div class="cursor-pointer">
                        <p class="px-4 py-2  text-gray-400 rounded ">2</p>
                        <div class="h-[2px] bg-gray-300"></div>
                    </div>
                </div>
                <button class="p-2 bg-black rounded text-white cursor-pointer"><ChevronRightIcon class="size-5"/></button>
            </div>
        </div>
    </section>
</template>