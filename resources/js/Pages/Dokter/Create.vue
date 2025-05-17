<template>
    <Head title="Tambah Dokter" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Dokter
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-md sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <!-- Nama -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Nama</label
                            >
                            <select
                                v-model="form.user_id"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            >
                                <option value="">Pilih Nama</option>
                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.user_id"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.user_id }}
                            </div>
                        </div>

                        <!-- NIK -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >NIK</label
                            >
                            <input
                                v-model="form.NIK"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.NIK"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.NIK }}
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Jenis Kelamin</label
                            >
                            <select
                                v-model="form.jenis_kelamin"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            >
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <div
                                v-if="form.errors.jenis_kelamin"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.jenis_kelamin }}
                            </div>
                        </div>

                        <!-- Spesialisasi -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Spesialisasi</label
                            >
                            <input
                                v-model="form.spesialisasi"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.spesialisasi"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.spesialisasi }}
                            </div>
                        </div>

                        <!-- Jadwal -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Jadwal</label
                            >

                            <div
                                v-for="(item, index) in form.jadwal"
                                :key="index"
                                class="mb-2 grid grid-cols-3 gap-2"
                            >
                                <div>
                                    <select
                                        v-model="item.hari"
                                        class="w-full rounded border-gray-300 shadow-sm"
                                    >
                                        <option value="">Hari</option>
                                        <option
                                            v-for="hari in [
                                                'Senin',
                                                'Selasa',
                                                'Rabu',
                                                'Kamis',
                                                'Jumat',
                                                'Sabtu',
                                                'Minggu',
                                            ]"
                                            :key="hari"
                                            :value="hari"
                                        >
                                            {{ hari }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <input
                                        type="time"
                                        v-model="item.jam_mulai"
                                        class="w-full rounded border-gray-300 shadow-sm"
                                    />
                                </div>
                                <div>
                                    <input
                                        type="time"
                                        v-model="item.jam_akhir"
                                        class="w-full rounded border-gray-300 shadow-sm"
                                    />
                                </div>
                            </div>

                            <button
                                type="button"
                                @click="tambahJadwal"
                                class="mt-2 rounded bg-green-600 px-3 py-1 text-sm text-white hover:bg-green-700"
                            >
                                + Tambah Jadwal
                            </button>

                            <div
                                v-if="form.errors.jadwal"
                                class="text-sm text-red-600 mt-2"
                            >
                                {{ form.errors.jadwal }}
                            </div>
                        </div>
                        <!-- Alamat -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Jalan</label
                            >
                            <input
                                v-model="form.alamat.jalan"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.jalan']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.jalan"] }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Kelurahan</label
                            >
                            <input
                                v-model="form.alamat.kelurahan"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.kelurahan']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.kelurahan"] }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Kecamatan</label
                            >
                            <input
                                v-model="form.alamat.kecamatan"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.kecamatan']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.kecamatan"] }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Kota</label
                            >
                            <input
                                v-model="form.alamat.kota"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.kota']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.kota"] }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Provinsi</label
                            >
                            <input
                                v-model="form.alamat.provinsi"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.provinsi']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.provinsi"] }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Kode Pos</label
                            >
                            <input
                                v-model="form.alamat.kode_pos"
                                type="text"
                                maxlength="5"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.kode_pos']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.kode_pos"] }}
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >No HP</label
                            >
                            <input
                                v-model="form.no_hp"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.no_hp"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.no_hp }}
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Status Aktif</label
                            >
                            <select
                                v-model="form.aktif"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            >
                                <option value="">Pilih Status</option>
                                <option :value="true">Aktif</option>
                                <option :value="false">Nonaktif</option>
                            </select>
                            <div
                                v-if="form.errors.aktif"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.aktif }}
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-6 flex justify-end">
                            <Link
                                href="/dokter"
                                class="mr-4 rounded px-4 py-2 text-sm text-gray-600 hover:underline"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const form = useForm({
    user_id: "",
    NIK: "",
    jenis_kelamin: "",
    spesialisasi: "",
    jadwal: [{ hari: "", jam_mulai: "", jam_akhir: "" }],
    alamat: {
        jalan: "",
        kelurahan: "",
        kecamatan: "",
        kota: "",
        provinsi: "",
        kode_pos: "",
    },

    no_hp: "",
    aktif: "",
});

const props = defineProps({
    users: Array,
    audits: Array,
});

function tambahJadwal() {
    form.jadwal.push({ hari: "", jam_mulai: "", jam_akhir: "" });
}

function submit() {
    form.post(route("dokter.store"));
}
</script>
