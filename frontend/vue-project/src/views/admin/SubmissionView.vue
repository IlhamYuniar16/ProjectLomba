<script setup>
import { ChevronLeftIcon, ChevronRightIcon, FunnelIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios'
import {alertSuccess, alertError, alertConfirm} from "../../services/alert.js"

const permohonan = ref([])
// PAGGINATION
const currentPage = ref(1)       
const perPage = ref(12)            
const totalPages = computed(() => Math.ceil(permohonan.value.length / perPage.value))

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    const end = start + perPage.value
    return permohonan.value.slice(start, end)
})

const goToPage = (page) => {
    if(page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}

const nextPage = () => {
    if(currentPage.value < totalPages.value) currentPage.value++
}

const prevPage = () => {
    if(currentPage.value > 1) currentPage.value--
}

// READ DATA
const fetchAdminPermohonan = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/admin_permohonan.php')
        permohonan.value = res.data.data
    } catch(err) {
        console.log(err)
    }
}


// EDIT
const submitForm = async (id, status) => {
    const formData = new FormData();
    formData.append("status_pengajuan", status);
    try {
        const res = await axios.post(
            `http://localhost/ProjectLomba/backend/admin_permohonan_status.php?id=${id}`,
            formData,
            {
                headers: { "Content-Type": "multipart/form-data" },
                withCredentials: true
            }
        );

        if (res.data.status === "success") {
            alertSuccess("Status berhasil diperbarui!");
            fetchAdminPermohonan();
        } else {
            alert(res.data.message);
        }
    } catch (err) {
        console.error("AXIOS ERROR:", err);
    }
};



onMounted(()=>{
    fetchAdminPermohonan()

})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Permohonan</h1>
        <div class="mt-5">
            <!-- <div class="xl:flex xl:flex-row  flex-col items-center justify-between">
                <input v-model="searchQuery" type="text" class="px-4 py-2 rounded-full bg-secondary outline-none md:max-w-sm w-full" placeholder="Cari nama pasien">
                <div class="flex xl:flex-row flex-row-reverse items-center mt-5 lg:mt-0 gap-3 relative">
                    <FunnelIcon @click="openFilter" class="size-6 text-gray-300 cursor-pointer"/>
                    <button @click="openModal" class="px-6 py-2 bg-primary hover:bg-red-700 rounded text-white cursor-pointer">+ Tambah Data</button>
                    <div v-if="showFilter" class="absolute xl:right-30 top-10 bg-white w-72 rounded-xl border-neutral-300 shadow-lg border p-4 z-50">
                        <div class="flex items-center gap-3 mb-4 border-b border-neutral-300 pb-3">
                            <FunnelIcon class="size-5 text-gray-300"/>
                            <h1 class="font-semibold">Filter Data</h1>
                        </div>

                        <div class="mb-3">
                            <label for="">Status Permohonan</label>
                            <select v-model="filterStatus" class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Status--</option>
                                <option value="diterima">Diterima</option>
                                <option value="pending">Pending</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Kabupaten</label>
                            <select v-model="filterLokasiPasien" class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Kabupaten--</option>
                                <option v-for="item in kabupaten_list" :key="item.id_kabupaten" :value="item.nama_kabupaten">{{ item.nama_kabupaten }}</option>
                            </select>
                        </div>
                        <div class="mb-3 pb-3">
                            <label for="">Gol Darah</label>
                            <select v-model="filterGolDarah" class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Gol Darah--</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-5 border-t border-neutral-300 pt-4">
                            <button @click="resetFilter" class="w-full px-3 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition cursor-pointer">Reset</button>
                            <button @click="applyFilter" class="w-full px-3 py-2 text-sm rounded-lg bg-primary hover:bg-red-700 text-white transition cursor-pointer">Apply</button>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                <table class="w-full mt-5 min-w-max ">
                    <thead>
                        <tr class="border-b border-neutral-300">
                            <!-- <th class="px-4 py-3 text-left ">Aksi</th> -->
                            <th class="px-4 py-3 text-left ">No</th>
                            <th class="px-4 py-3 text-left ">Status</th>
                            <th class="px-4 py-3 text-left ">Nama Pasien</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Kabupaten</th>
                            <th class="px-4 py-3 text-left ">Gol Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Jumlah Pendonor</th>
                            <th class="px-4 py-3 text-left ">Jenis Pendonor</th>
                            <th class="px-4 py-3 text-left ">Status Urgent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in paginatedData" :key="item.id" class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <!-- <td class="px-4 py-3 text-left">
                                <div class="flex items-center gap-2">
                                    <div @click="openEdit(item)" class="w-6 h-6 bg-blue-50 flex items-center justify-center rounded cursor-pointer">
                                        <PencilSquareIcon class="size-5 text-blue-500"/>
                                    </div>
                                    <div @click="handleDelete(item.id)" class="w-6 h-6 bg-red-50 flex items-center justify-center rounded cursor-pointer">
                                        <TrashIcon class="size-5 text-red-500"/>
                                    </div>
                                </div>
                            </td> -->
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ (currentPage - 1) * perPage + index + 1 }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">
                                <select
                                    v-model="item.status_pengajuan"
                                    @change="submitForm(item.id, item.status_pengajuan)"
                                    class="w-fit px-4 rounded-full outline-none"
                                    :class="{
                                        'text-blue-500 bg-blue-50': item.status_pengajuan === 'diterima',
                                        'text-green-500 bg-green-50': item.status_pengajuan === 'selesai',
                                        'text-yellow-500 bg-yellow-50': item.status_pengajuan === 'pending',
                                        'text-red-500 bg-red-50': item.status_pengajuan === 'batal',
                                    }">
                                    <option value="pending">pending</option>
                                    <option value="diterima">diterima</option>
                                    <option value="selesai">selesai</option>
                                    <option value="selesai" disabled select>batal</option>
                                </select>

                                <!-- <p class=" w-fit px-4 rounded-full" :class="{
                                'text-green-500 bg-green-50': item.status_pengajuan === 'diterima' || item.status_pengajuan === 'selesai',
                                'text-yellow-500 bg-yellow-50': item.status_pengajuan === 'pending',
                                 'text-red-500 bg-red-50': item.status_pengajuan === 'batal'}">{{ item.status_pengajuan }}
                                </p> -->
                            </td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_rumah_sakit }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.lokasi_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.golongan_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.rhesus }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jumlah_pendonor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jenis_donor_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.status_urgent }}</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-center gap-2 mt-5">
                <button @click="prevPage" class="p-2 bg-black rounded text-white cursor-pointer">
                    <ChevronLeftIcon class="size-5"/>
                </button>

                <div class="flex items-center cursor-pointer gap-2">
                    <button 
                    v-for="page in totalPages" :key="page"
                    @click="goToPage(page)"
                    :class="{'bg-black text-white px-3 cursor-pointer py-1 rounded': currentPage === page, 'px-3 py-1 rounded bg-gray-200 cursor-pointer': currentPage !== page}"
                    >
                    {{ page }}
                    </button>
                </div>

                <button @click="nextPage" class="p-2 bg-black rounded text-white cursor-pointer">
                    <ChevronRightIcon class="size-5"/>
                </button>
            </div>
        </div>
    </section>
</template>