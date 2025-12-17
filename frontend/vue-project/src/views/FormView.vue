<script setup>
import { store } from '@/stores/stores';
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router';
import { alertError, alertSuccess } from '@/services/alert';
const router = useRouter()

const isLogin = ref(true)
const checkLogin = async () => {
    try {
        const res = await axios.get(
            "http://localhost/ProjectLomba/backend/check_login.php",
            { withCredentials: true }
        );

        if (!res.data.isLogin) {
            localStorage.removeItem('user')
            store.isLoggedIn = false
            store.user = {}
            router.push('/masuk');
        }

        isLogin.value = res.data.isLogin;
    } catch (err) {
        localStorage.removeItem('user')
        store.isLoggedIn = false
        store.user = {}
        router.push('/masuk');
    }

};


const activeTab = ref('permohonan')

const tabs = [
    {id: "permohonan"},
    {id: "donor"},
]

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

const pmi_list = ref([])

const getPMI = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/get_pmi.php')
        pmi_list.value = res.data
    } catch(err) {
        console.error(err)
    }
    
}

const kabupaten_list = ref([])
const lokasi_pasien = ref('')

const getKab = async () => {
    try {
        const res = await axios.get('http://localhost/ProjectLomba/backend/get_kabupaten.php')
        kabupaten_list.value = res.data
    } catch(err) {
        console.error(err)
    }
    
}

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
                withCredentials: true
            }
        )
        if(res.data.status === "success"){
            nama_pasien.value = ''
            nama_rumah_sakit.value = ''
            lokasi_pasien.value = ''
            golongan_darah.value = ''
            rhesus.value = ''
            jumlah_pendonor.value = ''
            jenis_donor_darah.value = ''
            narhub_nama.value = ''
            narhub_notel.value = ''
            narhub_email.value = ''
            alertSuccess(res.data.message)
            } else {
                alertError(res.data.message)
            }
        } catch (err) {
            console.error("AXIOS ERROR:", err);
        }
};

const nama_pendonor = ref('');
const tanggal_lahir = ref('')
const jenis_kelamin = ref('')
const tipe_darah = ref('')
const rhesus_donor = ref('')
const jenis_donor = ref('')
const catatan_kesehatan = ref('')
const unit_pmi = ref('')
const merokok = ref('')
const alkohol = ref('')
const olahraga = ref('')
const berat_badan = ref('')

const submitDonor = async () => {
    const formDonor = new FormData();
    formDonor.append("nama_pendonor", nama_pendonor.value);
    formDonor.append("tanggal_lahir", tanggal_lahir.value);
    formDonor.append("jenis_kelamin", jenis_kelamin.value);
    formDonor.append("tipe_darah", tipe_darah.value);
    formDonor.append("rhesus", rhesus_donor.value);
    formDonor.append("unit_pmi", unit_pmi.value);
    formDonor.append("jenis_donor", jenis_donor.value);
    formDonor.append("catatan_kesehatan", catatan_kesehatan.value);
    formDonor.append("merokok", merokok.value);
    formDonor.append("alkohol", alkohol.value);
    formDonor.append("olahraga", olahraga.value);
    formDonor.append("berat_badan", berat_badan.value);
    try {
        const res = await axios.post(
            "http://localhost/ProjectLomba/backend/home_donor.php",
            formDonor,
            {
                headers: { "Content-Type": "multipart/form-data" },
                withCredentials: true
            }
        );
        if(res.data.status === "success"){
            nama_pendonor.value = ''
            tanggal_lahir.value = ''
            jenis_kelamin.value = ''
            tipe_darah.value = ''
            rhesus_donor.value = ''
            jenis_donor.value = ''
            catatan_kesehatan.value = ''
            unit_pmi.value = ''
            merokok.value = ''
            alkohol.value = ''
            olahraga.value = ''
            berat_badan.value = ''
            alertSuccess(res.data.message);
        } else {
            alertError(res.data.message);
        }
        
    } catch (err) {
        console.error("AXIOS ERROR:", err);
    }
};

onMounted(async () => {
    await checkLogin()
    getRS()
    getKab()
    getPMI()
});

</script>

<template>
    <section class="bg-secondary">
        
        <div class="py-10 px-6 md:px-16 lg:px-24 xl:px-32">
            <div class="flex justify-center gap-1 bg-red-100 w-fit mx-auto rounded-full">
                <button @click="activeTab = 'permohonan'" :class="activeTab === 'permohonan' ? 'cursor-pointer font-semibold bg-primary text-white px-12 py-2 rounded-full transition-all duration-200' : 'cursor-pointer font-semibold text-primary px-12 py-2 transition-all duration-200'" >
                    Permohonan
                </button>

                <button @click="activeTab = 'donor'" :class="activeTab === 'donor' ? 'cursor-pointer font-semibold bg-primary text-white px-12 py-2 rounded-full transition-all duration-200' : 'cursor-pointer font-semibold text-primary px-12 py-2 transition-all duration-200'">
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
                                <option v-for="item in rs_list" :key="item.id" :value="item.nama_rs">{{ item.nama_rs }}</option>
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
                            <input type="number" v-model="jumlah_pendonor" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Jumlah Pendonor">
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
                            <input type="email" v-model="narhub_email" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Alamat Surel/Email">
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
                            <label for="" class="mr-1">Nama Pendonor</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input v-model="nama_pendonor" type="text" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Tanggal Lahir</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input v-model="tanggal_lahir" type="date" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Nama Lengkap">
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Jenis Kelamin</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select v-model="jenis_kelamin" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
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
                            <select  v-model="tipe_darah" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
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
                            <select  v-model="rhesus_donor" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
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
                            <select v-model="unit_pmi" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none">
                                <option value="">--Unit PMI Lokasi Donor Darah--</option>
                                <option v-for="item in pmi_list" :key="item.id" :value="item.unit_pmi">{{ item.unit_pmi }}</option>
                            </select>
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Jenis Donor</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select v-model="jenis_donor" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" >
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
                            <textarea v-model="catatan_kesehatan" rows="5" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-lg outline-none" placeholder="Catatan Kesehatan"></textarea>
                        </div>

                        <p class="col-span-3 mb-5 lg:mt-10 font-semibold">Pertanyaan Singkat</p>

                        <div class="flex">
                            <label for="" class="mr-1">Merokok?</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <select v-model="merokok" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
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
                            <select v-model="alkohol" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
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
                            <select v-model="olahraga" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" >
                                <option value="">--Pilih--</option>
                                <option value="Sering">Sering</option>
                                <option value="Jarang">Jarang</option>
                                <option value="Tidak Pernah">Tidak Pernah</option>
                            </select>
                        </div>

                        <div class="flex">
                            <label for="" class="mr-1">Berat Badan?</label>
                            <span class="text-primary">*</span>
                        </div>
                        <div class="col-span-2 mb-5 lg:mb-0">
                            <input v-model="berat_badan" type="number" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg outline-none" placeholder="Berat Badan">
                        </div>
    
                    </div>
    
                    
                    <div class="flex items-center justify-center mt-8">
                        <button type="button" @click="submitDonor" class="bg-primary px-8 py-4 text-white rounded-full cursor-pointer hover:scale-110 transition-all duration-300">Kirim Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>