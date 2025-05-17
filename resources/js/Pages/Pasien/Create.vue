<template>
    <Head title="Tambah Pasien" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Pasien
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-md sm:rounded-lg">
                    <form @submit.prevent="submit">
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

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Tanggal Lahir</label
                            >
                            <input
                                v-model="form.tanggal_lahir"
                                type="date"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.tanggal_lahir"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.tanggal_lahir }}
                            </div>
                        </div>

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

                        <div class="mt-6 flex justify-end">
                            <Link
                                href="/pasien"
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
    tanggal_lahir: "",
    alamat: {
        jalan: "",
        kelurahan: "",
        kecamatan: "",
        kota: "",
        provinsi: "",
        kode_pos: "",
    },
    no_hp: "",
});
const props = defineProps({
    users: Array,
});
function submit() {
    form.post(route("pasien.store"));
}
</script>
