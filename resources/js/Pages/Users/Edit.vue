<template>
    <Head title="Edit User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit User
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
                            <input
                                v-model="form.name"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.email"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Role</label
                            >
                            <select
                                v-model="form.role_id"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            >
                                <option value="">Pilih Role</option>
                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.role_id"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.role_id }}
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <Link
                                href="/master/users"
                                class="mr-4 rounded px-4 py-2 text-sm text-gray-600 hover:underline"
                                >Batal</Link
                            >
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
                <div>
                    <h3 class="mb-2"><b>Audit Trail</b></h3>
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
                                        new Date(
                                            audit.created_at
                                        ).toLocaleString()
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
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    user: Object,
    roles: Array,
    audits: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role_id: props.user.role_id,
});

function submit() {
    form.put(route("users.update", props.user.id));
}
</script>
