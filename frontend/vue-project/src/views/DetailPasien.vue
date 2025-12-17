<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const showForm = ref(false);
const route = useRoute()
const detailPasien = ref([])

const openForm = () => {
    showForm.value = true;
}

const closeForm = () => {
    showForm.value = false;
    resetForm()
}

const resetForm = ()=> {
    
}

const getPasien = async () => {
    try {
        const id = route.params.id
        
        const res = await axios.get(`http://localhost/ProjectLomba/backend/krisis_pasien_detail.php?id=${id}`,
      { withCredentials: true })
        detailPasien.value = res.data.data[0]
        console.log(detailPasien.value)
    } catch(err) {
        console.error(err)
    }
    
}

onMounted(()=>{
    getPasien()
})

</script>

<template>
    <div class="py-14 px-6 md:px-16 lg:px-24 xl:px-32">
        <h1 class="text-2xl font-semibold">{{ showForm ? 'Donorkan Darah' : 'Detail Kebutuhan Pasien' }}</h1>
        <div v-if="showForm" class="bg-white mt-5 p-8 rounded-2xl">
            <div class="bg-gray-50 border border-gray-300 mb-10 p-10 rounded-2xl">
                <h2 class="text-xl font-semibold mb-5">Informasi Kebutuhan Pasien</h2>
                <div  class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-2 items-center">
                    <div class="flex">
                        <h1 for="" class="mr-1 font-semibold text-sm">Nama Pasien</h1>
                    </div>
                    <div class="flex items-center col-span-2 mb-5 lg:mb-0 gap-2">
                        <span>:</span>
                        <span type="text" class="flex w-full text-sm rounded-lg outline-none">{{detailPasien.nama_pasien}}</span>
                    </div>

                    <div class="flex">
                        <h1 for="" class="mr-1 font-semibold text-sm">Lokasi Pasien</h1>
                    </div>
                    <div class="flex items-center col-span-2 mb-5 lg:mb-0 gap-2">
                        <span>:</span>
                        <span type="text" class="flex w-full text-sm rounded-lg outline-none">{{ detailPasien.lokasi_pasien }}</span>
                    </div>

                    <div class="flex">
                        <h1 for="" class="mr-1 font-semibold text-sm">Rumah Sakit</h1>
                    </div>
                    <div class="flex items-center col-span-2 mb-5 lg:mb-0 gap-2">
                        <span>:</span>
                        <span type="text" class="flex w-full text-sm rounded-lg outline-none">{{detailPasien.nama_rumah_sakit}}</span>
                    </div>

                    <div class="flex">
                        <h1 for="" class="mr-1 font-semibold text-sm">Jumlah donor yang dibutuhkan</h1>
                    </div>
                    <div class="flex items-center col-span-2 mb-5 lg:mb-0 gap-2">
                        <span>:</span>
                        <span type="text" class="flex w-full text-sm rounded-lg outline-none">{{ detailPasien.jumlah_pendonor }}</span>
                    </div>

                    <div class="flex">
                        <h1 for="" class="mr-1 font-semibold text-sm">Gol Darah</h1>
                    </div>
                    <div class="flex items-center col-span-2 mb-5 lg:mb-0 gap-2">
                        <span>:</span>
                        <span type="text" class="flex w-full text-sm rounded-lg outline-none">{{detailPasien.golongan_darah}} {{ detailPasien.rhesus }}</span>
                    </div>

                    <div class="flex">
                        <h1 for="" class="mr-1 font-semibold text-sm">Jenis Donor</h1>
                    </div>
                    <div class="flex items-center col-span-2 mb-5 lg:mb-0 gap-2">
                        <span>:</span>
                        <span type="text" class="flex w-full text-sm rounded-lg outline-none">{{ detailPasien.jenis_donor_darah }}</span>
                    </div>

                </div>
            </div>

            <h2 class="text-xl font-semibold mb-5">Form Pendonor</h2>

            <form action="">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-7">

                    <div class="flex">
                        <label for="" class="mr-1">Nama Pendonor</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <input v-model="nama_pendonor" type="text" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Tanggal Lahir</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <input v-model="tanggal_lahir" type="date" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Jenis Kelamin</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select v-model="jenis_kelamin" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
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
                        <select  v-model="tipe_darah" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih ABO--</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Rhesus</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select  v-model="rhesus_donor" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih Rhesus--</option>
                                <option value="+">+</option>
                                <option value="-">-</option>
                        </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Unit PMI</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select v-model="unit_pmi" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none">
                            <option value="">--Unit PMI Lokasi Donor Darah--</option>
                            <option v-for="item in pmi_list" :key="item.id" :value="item.unit_pmi">{{ item.unit_pmi }}</option>
                        </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Jenis Donor</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select v-model="jenis_donor" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih Jenis Donor--</option>
                            <option value="Darah Penuh">Darah Penuh</option>
                            <option value="Plasma">Plasma</option>
                            <option value="Trombosit">Trombosit</option>
                        </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Catatan Kesehatan</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <textarea v-model="catatan_kesehatan" rows="5" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" placeholder="Catatan Kesehatan"></textarea>
                    </div>
                    
                    <p class="col-span-3 mb-5 lg:mt-10 font-semibold">Pertanyaan Singkat</p>

                    <div class="flex">
                        <label for="" class="mr-1">Merokok?</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih--</option>
                            <option value="Perokok">Ya</option>
                            <option value="Tidak Perokok">Tidak</option>
                        </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Alkohol?</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih--</option>
                            <option value="Alkohol">Ya</option>
                            <option value="Tidak Alkohol">Tidak</option>
                        </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Olahraga?</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <select class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                            <option value="">--Pilih--</option>
                            <option value="Sering">Sering</option>
                            <option value="Jarang">Jarang</option>
                            <option value="Tidak Pernah">TIdak Pernah</option>
                        </select>
                    </div>

                    <div class="flex">
                        <label for="" class="mr-1">Berat Badan?</label>
                        <span class="text-primary">*</span>
                    </div>
                    <div class="col-span-2 mb-5 lg:mb-0">
                        <input type="number" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" placeholder="Berat Badan">
                    </div>

                    

                </div>
                
                <div class="flex items-center gap-3 justify-center mt-8">
                    <button @click="closeForm" type="button" class="bg-gray-300 px-8 py-4 text-black rounded-full cursor-pointer hover:scale-90 transition-all duration-300">Batal</button>
                    <button type="button" @click="submitDonor" class="bg-primary px-8 py-4 text-white rounded-full cursor-pointer hover:scale-90 transition-all duration-300">Kirim Sekarang</button>
                </div>
            </form>
        </div>

        <div v-else class="bg-white p-10 mt-5 rounded-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 lg:gap-7">
    
                <div class="flex">
                    <h1 for="" class="mr-1 font-semibold">Nama Pasien</h1>
                </div>
                <div class="flex items-center gap-3 col-span-2 mb-5 lg:mb-0">
                    <span>:</span>
                    <span type="text" class="flex w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">{{detailPasien.nama_pasien}}</span>
                </div>

                <div class="flex">
                    <h1 for="" class="mr-1 font-semibold">Lokasi Pasien</h1>
                </div>
                <div class="flex items-center gap-3 col-span-2 mb-5 lg:mb-0">
                    <span>:</span>
                    <span type="text" class="flex w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">{{detailPasien.lokasi_pasien}}</span>
                </div>

                <div class="flex">
                    <h1 for="" class="mr-1 font-semibold">Rumah Sakit</h1>
                </div>
                <div class="flex items-center gap-3 col-span-2 mb-5 lg:mb-0">
                    <span>:</span>
                    <span type="text" class="flex w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">{{detailPasien.nama_rumah_sakit}}</span>
                </div>

                <div class="flex">
                    <h1 for="" class="mr-1 font-semibold">Jumlah donor yang dibutuhkan</h1>
                </div>
                <div class="flex items-center gap-3 col-span-2 mb-5 lg:mb-0">
                    <span>:</span>
                    <span type="text" class="flex w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">{{ detailPasien.jumlah_pendonor }}</span>
                </div>

                <div class="flex">
                    <h1 for="" class="mr-1 font-semibold">Gol Darah</h1>
                </div>
                <div class="flex items-center gap-3 col-span-2 mb-5 lg:mb-0">
                    <span>:</span>
                    <span type="text" class="flex w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">{{detailPasien.golongan_darah}} {{ detailPasien.rhesus }}</span>
                </div>

                <div class="flex">
                    <h1 for="" class="mr-1 font-semibold">Jenis Donor</h1>
                </div>
                <div class="flex items-center gap-3 col-span-2 mb-5 lg:mb-0">
                    <span>:</span>
                    <span type="text" class="flex w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">{{ detailPasien.jenis_donor_darah }}</span>
                </div>
                
            </div>
            <div class="flex items-center justify-center mt-8">
              <button @click="openForm" type="button" class="bg-primary px-8 py-4 text-white rounded-full cursor-pointer hover:scale-110 transition-all duration-300">Donorkan</button>
          </div>
        </div>

        
    </div>
</template>