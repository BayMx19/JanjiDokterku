<template>
    <Head title="Edit Pasien" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Pasien
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
                                disabled
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

                        <!-- Tanggal Lahir -->
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
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors['alamat.kode_pos']"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors["alamat.kode_pos"] }}
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex justify-end">
                            <Link
                                href="/master/pasien"
                                class="mr-4 rounded px-4 py-2 text-sm text-gray-600 hover:underline"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="bg-white p-6 shadow-md sm:rounded-lg mt-3">
                <h3 class="mb-2 font-bold text-lg">Audit Trail</h3>
                <table
                    class="table-auto border-collapse border border-gray-300 w-full"
                >
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1">
                                Tanggal
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Aksi
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Oleh User
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="audit in audits" :key="audit.id">
                            <td class="border border-gray-300 px-2 py-1">
                                {{
                                    new Date(audit.created_at).toLocaleString()
                                }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{ audit.event }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{ audit.user?.name ?? "System" }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    pasien: Object,
    users: Array,
    audits: Array,
});

const form = useForm({
    user_id: props.pasien.user_id,
    NIK: props.pasien.NIK,
    jenis_kelamin: props.pasien.jenis_kelamin,
    tanggal_lahir: props.pasien.tanggal_lahir,
    alamat: {
        jalan: props.pasien.alamat.jalan,
        kelurahan: props.pasien.alamat.kelurahan,
        kecamatan: props.pasien.alamat.kecamatan,
        kota: props.pasien.alamat.kota,
        provinsi: props.pasien.alamat.provinsi,
        kode_pos: props.pasien.alamat.kode_pos,
    },
});

function submit() {
    form.put(route("pasien.update", props.pasien.id));
}
</script>
