<script setup>
import { ChevronLeftIcon, ChevronRightIcon, FunnelIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios'
import {alertSuccess, alertError, alertConfirm} from "../../services/alert.js"

const showModal = ref(false);
const darurat = ref([])
const searchQuery = ref('')
const showFilter = ref(false)
const filterStatus = ref('')
const filterGolDarah = ref('')
const filterLokasiPasien = ref('')

// PAGGINATION
const currentPage = ref(1)       
const perPage = ref(12)            
const totalPages = computed(() => Math.ceil(darurat.value.length / perPage.value))

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    const end = start + perPage.value
    return darurat.value.slice(start, end)
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
const fetchDarahDarurat = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/admin_darurat.php', {
            params: {
                search: searchQuery.value,
                status_pengajuan: filterStatus.value,
                gol_darah: filterGolDarah.value,
                lokasi_pasien: filterLokasiPasien.value
            }
        })
        darurat.value = res.data.data
    } catch(err) {
        console.log(err)
    }
}

const openFilter = () => {
    showFilter.value = !showFilter.value
}
const applyFilter = () => {
    fetchDarahDarurat()
    showFilter.value = false
}

const resetFilter = () => {
    filterStatus.value = ''
    filterGolDarah.value = ''
    filterLokasiPasien.value = ''
    fetchDarahDarurat()
}

const openModal = () => {
    showModal.value = true;
}

const closeModal = () => {
    showModal.value = false;
    isEdit.value = false
    editId.value = null
    resetForm()
}

const resetForm = ()=> {
    nama_pasien.value = ""
    nama_rs.value = ""
    lokasi_pasien.value = ""
    golongan_darah.value = ""
    rhesus.value = ""
    jumlah_pendonor.value = ""
    jenis_donor_darah.value = ""
}

// GET NAMA RS
const rs_list = ref([])
const selectedRS = ref('')
const getRS = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/get_rs.php')
        rs_list.value = res.data
    } catch(err) {
        console.error(err)
    }
    
}

// GET NAMA KABUPATEN
const kabupaten_list = ref([])
const selectedKab = ref('')
const getKab = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/get_kabupaten.php')
        kabupaten_list.value = res.data
    } catch(err) {
        console.error(err)
    }
    
}

// EDIT
const nama_pasien = ref('')
const nama_rs = ref('')
const golongan_darah = ref('')
const rhesus = ref('')
const lokasi_pasien = ref('')
const jumlah_pendonor = ref('')
const jenis_donor_darah = ref('')

const editId = ref(null)
const isEdit = ref(false)

const openEdit = (item)=> {
    isEdit.value = true
    editId.value = item.id
    nama_pasien.value = item.nama_pasien
    nama_rs.value = item.nama_rumah_sakit
    lokasi_pasien.value = item.lokasi_pasien
    golongan_darah.value = item.golongan_darah
    rhesus.value = item.rhesus
    jumlah_pendonor.value = item.jumlah_pendonor
    jenis_donor_darah.value = item.jenis_donor_darah
    openModal()
}

const submitForm = async () => {
    if(isEdit.value) {
        const formData = new FormData();
        formData.append("nama_pasien", nama_pasien.value);
        formData.append("nama_rumah_sakit", nama_rs.value);
        formData.append("lokasi_pasien", lokasi_pasien.value);
        formData.append("golongan_darah", golongan_darah.value);
        formData.append("rhesus", rhesus.value);
        formData.append("jumlah_pendonor", jumlah_pendonor.value);
        formData.append("jenis_donor_darah", jenis_donor_darah.value);
        try {
            const res = await axios.post(
                `http://localhost/ProjectLomba/backend/donor_urgent_edit.php?id=${editId.value}`,
                formData,
                {
                    headers: { "Content-Type": "multipart/form-data" },
                    withCredentials: true
                }
            );

            if(res.data.status === "success"){
                alert(res.data.message);
                closeModal()
                fetchDarahDarurat()
            } else {
                alert(res.data.message);
            }
        } catch (err) {
            console.error("AXIOS ERROR:", err);
        }
    } else {
        const formData = new FormData();
        formData.append("nama_pasien", nama_pasien.value);
        formData.append("nama_rumah_sakit", nama_rs.value);
        formData.append("lokasi_pasien", lokasi_pasien.value);
        formData.append("golongan_darah", golongan_darah.value);
        formData.append("rhesus", rhesus.value);
        formData.append("jumlah_pendonor", jumlah_pendonor.value);
        formData.append("jenis_donor_darah", jenis_donor_darah.value);
        formData.append("status_pengajuan", "diterima");

        try {
            const res = await axios.post(
                "http://localhost/ProjectLomba/backend/donor_urgent_add.php",
                formData,
                {
                    headers: { "Content-Type": "multipart/form-data" },
                    withCredentials: true
                }
            );

            if(res.data.status === "success"){
                alert(res.data.message);
                closeModal()
                fetchDarahDarurat()
            } else {
                alert(res.data.message);
            }
        } catch (err) {
            console.error("AXIOS ERROR:", err);
        }
    }
    
};

// DELETE
const handleDelete = async(id)=> {
    const confirm = await alertConfirm("Apakah anda yakin ingin menghapus data ini?")

    if(confirm) {
        const res = await axios.delete(`http://localhost/ProjectLomba/backend/donor_urgent_delete.php?id=${id}`)
        if(res.data.status === "success"){
                fetchDarahDarurat()
        }
        
    }

}

watch(searchQuery, () => {
  fetchDarahDarurat()
})

onMounted(()=>{
    fetchDarahDarurat()
    getRS()
    getKab()
})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Permohonan</h1>

        <!-- MODAL -->
        <div v-if="showModal" class="fixed inset-0 bg-black/35 flex items-center justify-center z-50 overflow-y-auto">
            <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg ">
                <h2 class="text-xl font-semibold mb-4">{{ isEdit ? 'Edit Permohonan Darurat' : 'Tambah Permohonan Darurat' }}</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Nama Pasien</label>
                        <input v-model="nama_pasien" type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Masukkan nama pasien">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Rumah Sakit</label>
                        <select v-model="nama_rs" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih Rumah Sakit--</option>
                            <option v-for="item in rs_list" :key="item.id" :value="item.nama_rs">{{ item.nama_rs }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Kabupaten</label>
                        <select v-model="lokasi_pasien" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih Kabupaten--</option>
                            <option v-for="item in kabupaten_list" :key="item.id_kabupaten" :value="item.nama_kabupaten">{{ item.nama_kabupaten }}</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Golongan Darah</label>
                            <select v-model="golongan_darah" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Gol Darah--</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
    
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Rhesus</label>
                            <select  v-model="rhesus" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                    <option value="">--Pilih Rhesus--</option>
                                    <option value="+">+</option>
                                    <option value="-">-</option>
                                </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-5">
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Jumlah Pendonor</label>
                            <input v-model="jumlah_pendonor" type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Jumlah Pendonor">
                        </div>
    
                        <div class="w-full">
                            <label class="block mb-1 font-medium">Jenis Donor</label>
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Jenis Donor--</option>
                                <option value="Darah Penuh">Darah Penuh</option>
                                <option value="Plasma">Plasma</option>
                                <option value="Trombosit">Trombosit</option>
                            </select>
                        </div>
                    </div>
                    
                </div>

                <div class="flex justify-end mt-5 gap-3">
                    <button 
                        class="px-4 py-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400"
                        @click="closeModal"
                    >
                        Batal
                    </button>

                    <button 
                        type="submit" @click="submitForm" class="px-4 py-2 bg-primary text-white rounded-lg cursor-pointer hover:bg-red-700"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </div>

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
                            <th class="px-4 py-3 text-left ">Nama Pasien</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Kabupaten</th>
                            <th class="px-4 py-3 text-left ">Gol Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Jumlah Pendonor</th>
                            <th class="px-4 py-3 text-left ">Jenis Pendonor</th>
                            <th class="px-4 py-3 text-left ">Status Urgent</th>
                            <th class="px-4 py-3 text-left ">Status Permohonan</th>
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
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.nama_rumah_sakit }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.lokasi_pasien }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.golongan_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.rhesus }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jumlah_pendonor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.jenis_donor_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">{{ item.status_urgent }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600 ">
                                <p class=" w-fit px-4 rounded-full" :class="{
                                'text-green-500 bg-green-50': item.status_pengajuan === 'diterima' || item.status_pengajuan === 'selesai',
                                'text-yellow-500 bg-yellow-50': item.status_pengajuan === 'pending',
                                 'text-red-500 bg-red-50': item.status_pengajuan === 'batal'}">{{ item.status_pengajuan }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-center gap-2 mt-5">
                <button @click="prevPage" class="p-2 bg-black rounded text-white cursor-pointer">
                    <ChevronLeftIcon class="size-5"/>
                </button>

                <div class="flex items-center gap-2">
                    <button 
                    v-for="page in totalPages" :key="page"
                    @click="goToPage(page)"
                    :class="{'bg-black text-white px-3 py-1 rounded': currentPage === page, 'px-3 py-1 rounded bg-gray-200': currentPage !== page}"
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