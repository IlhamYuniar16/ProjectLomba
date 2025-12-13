<script setup>
import { ChevronLeftIcon, ChevronRightIcon, CloudArrowDownIcon, FunnelIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted } from 'vue';
import axios from 'axios'

const laporan_donor = ref([])
const showFilter = ref(false)

const openFilter = () => {
    showFilter.value = !showFilter.value
}

const fetchLaporanDonor = async()=> {
    try{
        const res = await axios.get(`http://localhost/ProjectLomba/backend/laporan_donor.php`)
        laporan_donor.value = res.data.data
    }catch(err){
        console.log(err)
    }
}

const exportFile = (type) => {
  // Gunakan window.open agar browser langsung request ke PHP
  window.open(`http://localhost/ProjectLomba/backend/laporan_donor_export.php?laporan=${type}`, '_blank');
}

onMounted(()=>{
    fetchLaporanDonor()
})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Laporan Donor</h1>

        <div class="mt-5">
            <div class="flex items-center justify-between">
                <input type="search" class="px-4 py-2 rounded-full bg-secondary outline-none max-w-sm w-full" placeholder="Cari...">
                <div class="flex items-center gap-3 relative">
                    <FunnelIcon @click="openFilter" class="size-6 text-gray-300 cursor-pointer"/>
                    <a @click="exportFile('donor')" class="flex items-center gap-3 px-6 py-2 bg-green-500 rounded text-white cursor-pointer"><CloudArrowDownIcon class="size-5"/>Excel</a>

                    <!-- MODAL FILTER -->
                    <div v-if="showFilter" class="absolute right-30 top-10 bg-white w-72 rounded-xl border-neutral-300 shadow-lg border p-4 z-50">
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
                            <th class="px-4 py-3 text-left ">No</th>
                            <th class="px-4 py-3 text-left ">Tanggal</th>
                            <th class="px-4 py-3 text-left ">Nama Pendonor</th>
                            <th class="px-4 py-3 text-left ">Tanggal Lahir</th>
                            <th class="px-4 py-3 text-left ">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left ">Tipe Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Jenis Donor</th>
                            <th class="px-4 py-3 text-left ">Status</th>
                            <th class="px-4 py-3 text-left ">Catatan Kesehatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in laporan_donor" :key="item.id_laporan_donor" class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <td class="px-4 py-3 text-left text-neutral-600">{{ index + 1 }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.created_at }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.nama_pendonor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.tanggal_lahir }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.jenis_kelamin }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.tipe_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.rhesus }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.rumah_sakit }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.jenis_donor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.status_pengajuan }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 max-w-md">{{ item.catatan_kesehatan }}</td>
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