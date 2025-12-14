<script setup>
import { ChevronLeftIcon, ChevronRightIcon, CloudArrowDownIcon, FunnelIcon, PencilSquareIcon } from '@heroicons/vue/24/solid';
import { ref, onMounted, watch, computed } from 'vue';
import axios from 'axios'

const donor = ref([])
const pilihStatus = ref('pending')
// PAGGINATION
const currentPage = ref(1)       
const perPage = ref(12)            
const totalPages = computed(() => Math.ceil(donor.value.length / perPage.value))
const showModal = ref(false)
const editId = ref(null)
const isEdit = ref(false)
const eligible = ref(false)

const openEdit = (item)=> {
    isEdit.value = true
    editId.value = item.id
    openModal()
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

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    const end = start + perPage.value
    return donor.value.slice(start, end)
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

const fetchDonor = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/admin_donor.php')
        donor.value = res.data.data
    }catch(err){
        console.log(err)
    }
}

const status_eligible = ref('')



const submitForm = async () => {
        const formData = new FormData();
        formData.append("status_eligible", status_eligible.value);
        try {
            const res = await axios.post(
                `http://localhost/ProjectLomba/backend/admin_permohonan_status.php?id=${editId.value}`,
                formData,
                {
                    headers: { "Content-Type": "multipart/form-data" },
                    withCredentials: true
                }
            );

            if(res.data.status === "success"){
                alert(res.data.message);
                fetchAdminPermohonan()
            } else {
                alert(res.data.message);
            }
        } catch (err) {
            console.error("AXIOS ERROR:", err);
        }
    
};


onMounted(()=>{
    fetchDonor()
})
</script>

<template>
    <section class="bg-white p-6 min-h-screen">
        <h1 class="text-2xl font-semibold">Pengajuan Donor</h1>

        <div class="mt-5">
            <!-- <div class="xl:flex xl:flex-row flex-col items-center justify-between">
                <input type="text" v-model="searchQuery" class="px-4 py-2 rounded-full bg-secondary outline-none md:max-w-sm w-full" placeholder="Cari...">
                <div class="flex xl:flex-row flex-row-reverse items-center mt-5 lg:mt-0 gap-3 relative">
                    <FunnelIcon @click="openFilter" class="size-6 text-gray-300 cursor-pointer"/>
                    <a @click="exportFile('donor')" class="flex items-center gap-3 px-6 py-2 bg-green-500 rounded text-white cursor-pointer"><CloudArrowDownIcon class="size-5"/>Excel</a>
                    <div v-if="showFilter" class="absolute xl:right-30 top-10 bg-white w-72 rounded-xl border-neutral-300 shadow-lg border p-4 z-50">
                        <div class="flex items-center gap-3 mb-4 border-b border-neutral-300 pb-3">
                            <FunnelIcon class="size-5 text-gray-300"/>
                            <h1 class="font-semibold">Filter Data</h1>
                        </div>

                        <div class="mb-3">
                            <label for="">Status</label>
                            <select v-model="filterStatus" class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Status--</option>
                                <option value="Eligible">Eligible</option>
                                <option value="Not Eligible">Not Eligible</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Gol Darah</label>
                            <select v-model="filterGolDarah" class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Gol Darah--</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div class="mb-3 pb-3">
                            <label for="">Jenis Donor</label>
                            <select v-model="filterJenisDonor" class="w-full p-2 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Pilih Jenis Donor--</option>
                                <option value="Darah Penuh">Darah Penuh</option>
                                <option value="Plasma">Plasma</option>
                                <option value="Trombosit">Trombosit</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-5 border-t border-neutral-300 pt-4">
                            <button @click="resetFilter" class="w-full px-3 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition cursor-pointer">Reset</button>
                            <button @click="applyFilter" class="w-full px-3 py-2 text-sm rounded-lg bg-primary hover:bg-red-700 text-white transition cursor-pointer">Apply</button>
                        </div>
                    </div>
                </div>

            </div> -->

            <div v-if="showModal" class="fixed inset-0 bg-black/35 flex items-center justify-center z-50 overflow-y-auto">
                <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg ">
                    <h2 class="text-xl font-semibold mb-4"></h2>

                    <div >
                        <h1 class="text-xl mb-3">Pengajuan Donor</h1>
                        <div class="mb-3">
                            <label for="" class="font-medium mb-1">Status</label>
                            <div class="flex items-center gap-3">
                                <button @click="eligible = true" :class="eligible ? 'bg-green-100 text-green-500' : 'bg-gray-100 text-black '" class="w-full px-4 py-2 rounded cursor-pointer">Eligible</button>
                                <button @click="eligible = false" :class="!eligible ? 'bg-red-100 text-red-500' : 'bg-gray-100 text-black'" class="w-full px-4 py-2 rounded cursor-pointer">Not Eligible</button>
                            </div>
                        </div>
                        <div v-if="eligible">
                            <div class="mb-3">
                                <label class="block mb-1 font-medium">Tanggal</label>
                                <input type="date" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Masukkan nama pasien">
                            </div>
                            <div class="mb-3">
                                <label class="block mb-1 font-medium">Jam</label>
                                <input type="time" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Masukkan nama pasien">
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
                            type="submit" @click="submitForm" :disabled="!eligible" :class="!eligible ? 'cursor-not-allowed' : 'cursor-pointer'" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-red-700"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto bg-secondary rounded-xl mt-5 p-4">
                <table class="w-full mt-5 min-w-max ">
                    <thead>
                        <tr class="border-b border-neutral-300">
                            <th class="px-4 py-3 text-left ">No</th>
                            <th class="px-4 py-3 text-left ">Status</th>
                            <th class="px-4 py-3 text-left ">Tanggal</th>
                            <th class="px-4 py-3 text-left ">Nama Pendonor</th>
                            <th class="px-4 py-3 text-left ">Tanggal Lahir</th>
                            <th class="px-4 py-3 text-left ">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left ">Tipe Darah</th>
                            <th class="px-4 py-3 text-left ">Rhesus</th>
                            <th class="px-4 py-3 text-left ">Rumah Sakit</th>
                            <th class="px-4 py-3 text-left ">Jenis Donor</th>
                            <th class="px-4 py-3 text-left ">Catatan Kesehatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in paginatedData" :key="item.id_donor" class="border-b border-gray-200 text-neutral-800 hover:bg-gray-200 transition">
                            <td class="px-4 py-3 text-left text-neutral-600">{{ (currentPage - 1) * perPage + index + 1 }}</td>
                            <td class="px-4 py-3 text-center text-neutral-600 flex items-center justify-center ">
                                <div @click="openEdit(item)" class="w-6 h-6 bg-blue-50 rounded flex items-center justify-center  cursor-pointer">
                                    <PencilSquareIcon class="size-5 text-blue-500"/>
                                </div>
                                <!-- <select v-model="submitForm" name="" id="" class="w-fit px-4 rounded-full outline-none" :class="{'text-green-500 bg-green-50' : pilihStatus === 'eligible', 'text-yellow-500 bg-yellow-50' : pilihStatus === 'pending', 'text-red-500 bg-red-50' : pilihStatus === 'not_eligible'}">
                                    <option value="pending">pending</option>
                                    <option value="eligible">eligible</option>
                                    <option value="not_eligible">Not eligible</option>
                                </select> -->
                            </td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.created_at }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.nama_pendonor }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.tanggal_lahir }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.jenis_kelamin }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.tipe_darah }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.rhesus }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.rumah_sakit }}</td>
                            <td class="px-4 py-3 text-left text-neutral-600">{{ item.jenis_donor }}</td>
                            
                            <td class="px-4 py-3 text-left text-neutral-600 max-w-md">{{ item.catatan_kesehatan }}</td>
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
                    v-for="page in totalPages" :key="page" @click="goToPage(page)" :class="{'bg-black text-white px-3 cursor-pointer py-1 rounded': currentPage === page, 'px-3 cursor-pointer py-1 rounded bg-gray-200': currentPage !== page}">{{ page }}</button>
                </div>
                <button @click="nextPage" class="p-2 bg-black rounded text-white cursor-pointer">
                    <ChevronRightIcon class="size-5"/>
                </button>
            </div>
        </div>
    </section>
</template>

