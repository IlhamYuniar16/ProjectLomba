<script setup>

import { store } from '@/stores/stores';
import { ref, onMounted } from 'vue'
import axios from 'axios'

const activeTab = ref('permohonan')

const tabs = [
    {id: "permohonan"},
    {id: "donor"},
]

const rs_list = ref([])
const selectedRS = ref('')

// Ambil data tipe darah dari backend
const getRS = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/get_rs.php')
        rs_list.value = res.data
    } catch(err) {
        console.error(err)
    }
    
}

const kabupaten_list = ref([])
const lokasi_pasien = ref('')

// Ambil data tipe darah dari backend
const getKab = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/get_kabupaten.php')
        kabupaten_list.value = res.data
    } catch(err) {
        console.error(err)
    }
    
}
onMounted(() => {
    getRS()
    getKab()
})

const nama_pasien = ref('')
const nama_rumah_sakit = ref('')
const golongan_darah = ref('')
const rhesus = ref('')
const jumlah_pendonor = ref('')
const jenis_donor_darah = ref('')
const foto_formulir_rs = ref(null)

const handleFileUpload = (e) => {
  const file = e.target.files[0]
  if(file){
    foto_formulir_rs.value = file
  }
}
const narhub_nama = ref('')
const narhub_notel = ref('')
const narhub_email = ref('')

const submitForm = async () => {
    const formData = new FormData();
    formData.append("nama_pasien", nama_pasien.value);
    formData.append("nama_rumah_sakit", nama_rumah_sakit.value);
    formData.append("lokasi_pasien", lokasi_pasien.value);
    formData.append("golongan_darah", golongan_darah.value);
    formData.append("rhesus", rhesus.value);
    formData.append("jumlah_pendonor", jumlah_pendonor.value);
    formData.append("jenis_donor_darah", jenis_donor_darah.value);
    formData.append("narhub_nama", narhub_nama.value);
    formData.append("narhub_notel", narhub_notel.value);
    formData.append("narhub_email", narhub_email.value);

    // Jika ada file
    if (foto_formulir_rs.value) {
        formData.append("foto_formulir_rs", foto_formulir_rs.value);
    }

    try {
        const res = await axios.post(
            "http://localhost/ProjectLomba/backend/permohonan.php",
            formData,
            {
                headers: { "Content-Type": "multipart/form-data" },
                withCredentials: true // WAJIB
            }
        );

        console.log("Response:", res.data);
    } catch (err) {
        console.error("AXIOS ERROR:", err);
    }
};


</script>

<template>
    <section class="bg-secondary">
        
        
        <div class="py-10 px-6 md:px-16 lg:px-24 xl:px-32">
            <div class="flex justify-center gap-1 bg-red-100 w-fit mx-auto rounded-full">
                <button @click="activeTab = 'permohonan'" :class="activeTab === 'permohonan' ? 'cursor-pointer font-semibold bg-primary text-white px-9 md:px-12 py-2 rounded-full transition-all duration-200 text-xs md:text-sm' : 'cursor-pointer font-semibold text-primary px-9 md:px-12 py-2 transition-all duration-200 text-xs md:text-sm'" >
                    Permohonan
                </button>

                <button @click="activeTab = 'donor'" :class="activeTab === 'donor' ? 'cursor-pointer font-semibold bg-primary text-white px-9 md:px-12 py-2 rounded-full transition-all duration-200 text-xs md:text-sm' : 'cursor-pointer font-semibold text-primary px-9 md:px-12 py-2 transition-all duration-200 text-xs md:text-sm'">
                    Donor
                </button>
            </div>

            <!-- FORM PERMOHONAN -->
            <div v-if="activeTab === 'permohonan'" class="bg-white mt-10 p-8 rounded">
                <h2 class="text-xl font-semibold mb-5">Informasi Pasien</h2>

                <form action="">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-7">
    
                        <div class="flex">
                            <label for="" class="mr-1">Nama Pasien</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" v-model="nama_pasien" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Rumah Sakit</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select v-model="nama_rumah_sakit" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Rumah Sakit--</option>
                                <option v-for="item in rs_list" :key="item.id_rs" :value="item.nama_rs">{{ item.nama_rs }}</option>
                            </select>
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Kabupaten</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select v-model="lokasi_pasien" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Kabupaten--</option>
                                <option v-for="item in kabupaten_list" :key="item.id_kabupaten" :value="item.nama_kabupaten">{{ item.nama_kabupaten }}</option>
                            </select>
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Golongan Darah</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="flex gap-5 col-span-2 mb-5 lg:mb-0">
                            <div class="w-full">
                                <select  v-model="golongan_darah" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                    <option value="">--Pilih ABO--</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <select  v-model="rhesus" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                    <option value="">--Pilih Rhesus--</option>
                                    <option value="+">+</option>
                                    <option value="-">-</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Jumlah Pendonor</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" v-model="jumlah_pendonor" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Jumlah Pendonor">
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Jenis Donor</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select v-model="jenis_donor_darah" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Jenis Donor--</option>
                                <option value="Darah Penuh">Darah Penuh</option>
                                <option value="Plasma">Plasma</option>
                                <option value="Trombosit">Trombosit</option>
                            </select>
                        </div>
    
                        <div class="flex flex-col">
                            <label class="font-medium">Foto Formulir Permintaan Donor Darah dari Rumah Sakit (opsional) </label>
                            <span class="text-xs text-gray-500">Maksimal 2MB</span>
                        </div>
                        <div>
                            <input id="uploadFoto" type="file" class="hidden" @change="handleFileUpload" accept="image/*">
                            <label  for="uploadFoto" class="bg-red-500 text-white px-4 py-2 rounded-lg cursor-pointer" >Pilih Foto</label>
                        </div>
    
                    </div>
    
                    <div class="border border-neutral-200 my-10"></div>
                    
                    <h2 class="text-xl font-semibold mb-5">Informasi Narahubung</h2>
    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-7">
    
                        <div class="flex">
                            <label for="" class="mr-1">Nama Lengkap</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" v-model="narhub_nama" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Nomor Telepon/WA Aktif</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" v-model="narhub_notel" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Contoh: 08xxxxxxxx">
                        </div>
    
                        <div class="flex">
                            <label for="" class="mr-1">Surel/Email (Untuk Mendapatkan Update)</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" v-model="narhub_email" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Alamat Surel/Email">
                        </div>
    
                    </div>

                    <div class="flex items-center justify-center mt-8">
                        <button type="button" @click="submitForm"  class="bg-primary px-8 py-4 text-white rounded-full cursor-pointer hover:scale-110 transition-all duration-300">Kirim Sekarang</button>
                    </div>
                </form>
            </div>

            <!-- FORM DONOR -->
            <div v-if="activeTab === 'donor'" class="bg-white mt-10 p-8 rounded">
                <h2 class="text-xl font-semibold mb-5">Informasi Pendonor</h2>

                <form action="">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-7">
    
                        <div class="flex">
                            <label for="" class="mr-1">Nama Pasien</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Tanggal Lahir</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="date" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Jenis Kelamin</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Tipe Darah</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Tipe Darah--</option>
                            </select>
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Rhesus</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Rhesus--</option>
                            </select>
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Rumah Sakit</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Rumah Sakit Lokasi Donor Darah">
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Catatan Kesehatan</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <textarea rows="5" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Catatan Kesehatan"></textarea>
                        </div>
    
                    </div>
    
                    
                    <div class="flex items-center justify-center mt-8">
                        <button class="bg-primary px-8 py-4 text-white rounded-full cursor-pointer hover:scale-110 transition-all duration-300">Kirim Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>