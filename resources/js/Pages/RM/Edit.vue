<template>
    <Head title="Edit Rekam Medis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Rekam Medis
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Pencatat -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Pencatat</label
                                >
                                <input
                                    type="text"
                                    v-model="form.pencatat"
                                    readonly
                                    class="mt-1 w-full rounded border-gray-300 bg-gray-100 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                />
                            </div>
                            <!-- Pasien -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Pasien</label
                                >
                                <select
                                    v-model="form.user_id"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                >
                                    <option value="" disabled>
                                        Pilih Pasien
                                    </option>
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
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.user_id }}
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tanggal</label
                                >
                                <input
                                    type="date"
                                    v-model="form.tanggal"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                />
                                <div
                                    v-if="form.errors.tanggal"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.tanggal }}
                                </div>
                            </div>

                            <!-- Diagnosa -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Diagnosa</label
                                >
                                <textarea
                                    v-model="form.diagnosa"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                ></textarea>
                            </div>

                            <!-- Tindakan -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tindakan</label
                                >
                                <textarea
                                    v-model="form.tindakan"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                ></textarea>
                            </div>

                            <!-- Resep -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Resep</label
                                >
                                <textarea
                                    v-model="form.resep"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                ></textarea>
                            </div>

                            <!-- Catatan -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Catatan</label
                                >
                                <textarea
                                    v-model="form.catatan"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                ></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                >
                                    <i class="fas fa-save mr-2"></i>Simpan
                                    Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    rekam_medis: Object,
    users: Array,
    audits: Array,
});

const form = useForm({
    user_id: props.rekam_medis.user_id,
    tanggal: props.rekam_medis.tanggal,
    diagnosa: props.rekam_medis.diagnosa,
    tindakan: props.rekam_medis.tindakan,
    resep: props.rekam_medis.resep,
    catatan: props.rekam_medis.catatan,
    pencatat: props.rekam_medis.pencatat,
});

function submit() {
    form.put(route("rm.update", props.rekam_medis.id), {
        preserveScroll: true,
    });
}
</script>
