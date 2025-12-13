<script setup>
import { ChevronLeftIcon, ChevronRightIcon, CloudArrowDownIcon, FunnelIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios'

const permohonan = ref([])
const searchQuery = ref('')
const showFilter = ref(false)

const openFilter = () => {
    showFilter.value = !showFilter.value
}

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
            <div class="xl:flex xl:flex-row flex-col items-center justify-between">
                <input v-model="searchQuery" type="text" class="px-4 py-2 rounded-full bg-secondary outline-none md:max-w-sm w-full" placeholder="Cari...">
                <div class="flex xl:flex-row flex-row-reverse items-center mt-5 gap-3 relative">
                    <FunnelIcon @click="openFilter" class="size-6 text-gray-300 cursor-pointer"/>
                    <button @click="exportFile('permohonan')" class="flex items-center gap-3 px-6 py-2 bg-green-500 rounded text-white cursor-pointer"><CloudArrowDownIcon class="size-5"/>Excel</button>

                    <!-- MODAL FILTER -->
                    <div v-if="showFilter" class="absolute xl:right-30 top-12 md:top-12 xl:top-10 bg-white w-72 rounded-xl border-neutral-300 shadow-lg border p-4 z-50">
                        <div class="flex items-center gap-3 mb-4 border-b border-neutral-300 pb-3">
                            <FunnelIcon class="size-5 text-gray-300"/>
                            <h1 class="font-semibold">Filter Data</h1>
                        </div>

                        <div class="mb-3">
                            <label for="">Status</label>
                            <select class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Status--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Status Urgent</label>
                            <select class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Status Urgent--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Gol Darah</label>
                            <select class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Gol Darah--</option>
                            </select>
                        </div>
                        <div class="mb-3 pb-3">
                            <label for="">Jenis Donor</label>
                            <select class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Jenis Donor--</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-5 border-t border-neutral-300 pt-4">
                            <button class="w-full px-3 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition cursor-pointer">Reset</button>
                            <button class="w-full px-3 py-2 text-sm rounded-lg bg-primary hover:bg-red-700 text-white transition cursor-pointer">Apply</button>
                        </div>
                    </div>
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